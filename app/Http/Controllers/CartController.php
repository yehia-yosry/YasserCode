<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CustomerOrder;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CartController extends Controller
{
    public function add(Request $request, $isbn)
    {
        $book = Book::findOrFail($isbn);

        if ($book->Quantity <= 0) {
            return Redirect::back()->with('error', 'Book is out of stock');
        }

        $cart = session('cart', []);

        if (isset($cart[$isbn])) {
            $cart[$isbn]['qty'] = min($cart[$isbn]['qty'] + 1, $book->Quantity);
        } else {
            $cart[$isbn] = [
                'isbn' => $book->ISBN,
                'title' => $book->Title,
                'price' => (float) $book->Price,
                'qty' => 1,
            ];
        }

        session(['cart' => $cart]);

        return Redirect::back()->with('success', 'Added to cart');
    }

    public function view()
    {
        $cart = session('cart', []);
        $items = array_values($cart);
        $total = 0;
        foreach ($items as $it) {
            $total += $it['price'] * $it['qty'];
        }
        return view('cart', compact('items', 'total'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:0'
        ]);

        $cart = session('cart', []);
        $quantities = $data['qty'] ?? [];

        // validate against actual stock
        $errors = [];
        foreach ($quantities as $isbn => $q) {
            $book = Book::find($isbn);
            if (!$book) {
                $errors[] = "Book $isbn not found";
                continue;
            }
            if ($q < 0) {
                $errors[] = "Quantity for {$book->Title} must be non-negative";
                continue;
            }
            if ($q > $book->Quantity) {
                $errors[] = "Requested quantity for {$book->Title} exceeds stock ({$book->Quantity})";
            }
        }

        if (!empty($errors)) {
            return redirect()->route('cart.view')->with('error', implode('; ', $errors));
        }

        foreach ($quantities as $isbn => $q) {
            if (isset($cart[$isbn])) {
                $cart[$isbn]['qty'] = max(0, (int) $q);
                if ($cart[$isbn]['qty'] === 0) {
                    unset($cart[$isbn]);
                }
            }
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.view')->with('success', 'Cart updated');
    }

    public function remove($isbn)
    {
        $cart = session('cart', []);
        if (isset($cart[$isbn])) {
            unset($cart[$isbn]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.view')->with('success', 'Removed');
    }

    // public function checkout(Request $request)
    // {
    //     $cart = session('cart', []);
    //     if (empty($cart)) {
    //         return redirect()->route('home')->with('error', 'Cart empty');
    //     }
    //     // validate credit card info
    //     $data = $request->validate([
    //         'credit_card_number' => 'required|string',
    //         'expiry_date' => 'required|date_format:Y-m-d'
    //     ]);

    //     $card = preg_replace('/\\s+/', '', $data['credit_card_number']);
    //     $expiry = $data['expiry_date'];

    //     if (!$this->luhnCheck($card)) {
    //         return redirect()->route('cart.view')->with('error', 'Invalid credit card number');
    //     }

    //     if (Carbon::createFromFormat('Y-m-d', $expiry)->endOfMonth()->lt(Carbon::now())) {
    //         return redirect()->route('cart.view')->with('error', 'Credit card expired');
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // re-check stock
    //         foreach ($cart as $isbn => $it) {
    //             $book = Book::find($isbn);
    //             if (!$book) {
    //                 throw new \Exception("Book $isbn not found");
    //             }
    //             if ($book->Quantity < $it['qty']) {
    //                 throw new \Exception("Not enough stock for $book->Title");
    //             }
    //         }

    //         $total = array_reduce($cart, fn($s, $it) => $s + $it['price'] * $it['qty'], 0);

    //         $customerId = session('customer_id', 1);

    //         $order = CustomerOrder::create([
    //             'CustomerID' => $customerId,
    //             'OrderDate' => now(),
    //             'TotalPrice' => $total,
    //             'CreditCardNumber' => substr($card, -4),
    //             'ExpiryDate' => $expiry,
    //         ]);

    //         foreach ($cart as $isbn => $it) {
    //             OrderItem::create([
    //                 'OrderID' => $order->OrderID,
    //                 'ISBN' => $isbn,
    //                 'Quantity' => $it['qty'],
    //             ]);

    //             // Decrement stock
    //             $book = Book::find($isbn);
    //             $book->Quantity = max(0, $book->Quantity - $it['qty']);
    //             $book->save();
    //         }

    //         DB::commit();

    //         // clear session cart
    //         session(['cart' => []]);

    //         return redirect()->route('home')->with('success', 'Order placed');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('cart.view')->with('error', 'Checkout failed: ' . $e->getMessage());
    //     }
    // }


    public function checkout(Request $request)
{
    $cart = session('cart', []);
    if (empty($cart)) {
        return redirect()->route('home')->with('error', 'Cart is empty');
    }

    // 1. Validate Credit Card Info
    $data = $request->validate([
        'credit_card_number' => 'required|string',
        'expiry_date' => 'required|date_format:Y-m-d'
    ]);

    $card = preg_replace('/\s+/', '', $data['credit_card_number']);
    $expiry = $data['expiry_date'];

    // if (!$this->luhnCheck($card)) {
    //     return redirect()->route('cart.view')->with('error', 'Invalid credit card number');
    // }

    if (Carbon::createFromFormat('Y-m-d', $expiry)->endOfMonth()->lt(Carbon::now())) {
        return redirect()->route('cart.view')->with('error', 'Credit card expired');
    }

    try {
        DB::beginTransaction();

        $totalPrice = 0;

        // 2. Pre-check stock for ALL items before starting inserts
        foreach ($cart as $isbn => $item) {
            $book = DB::select("SELECT Title, Quantity FROM BOOK WHERE ISBN = ?", [$isbn]);
            
            if (empty($book)) {
                throw new \Exception("Book with ISBN $isbn no longer exists.");
            }

            if ($book[0]->Quantity < $item['qty']) {
                throw new \Exception("Not enough stock for '{$book[0]->Title}'.");
            }

            $totalPrice += $item['price'] * $item['qty'];
        }

        // 3. Create the Main Order record
        // We use the query builder insertGetId to capture the auto-incremented OrderID
        $customerId = session('customer_id', 1); // Defaulting to 1 for testing
        
        $orderId = DB::table('CUSTOMER_ORDER')->insertGetId([
            'CustomerID'       => $customerId,
            'OrderDate'        => now(),
            'TotalPrice'       => $totalPrice,
            'CreditCardNumber' => substr($card, -4), // Store only last 4 digits for security
            'ExpiryDate'       => $expiry,
        ]);

        // 4. Process each item: Insert into ORDER_ITEM and Update BOOK stock
        foreach ($cart as $isbn => $item) {
            // Insert into ORDER_ITEM
            DB::insert("INSERT INTO ORDER_ITEM (OrderID, ISBN, Quantity) VALUES (?, ?, ?)", [
                $orderId, 
                $isbn, 
                $item['qty']
            ]);

            // DECREASE STOCK: This Raw SQL update triggers your "after_book_update" trigger
            $affected = DB::update("UPDATE BOOK SET Quantity = Quantity - ? WHERE ISBN = ?", [
                $item['qty'], 
                $isbn
            ]);

            if ($affected === 0) {
                throw new \Exception("Critical error: Could not update stock for ISBN $isbn.");
            }
        }

        // 5. Commit all changes if everything succeeded
        DB::commit();

        // Clear the cart session
        session(['cart' => []]);

        return redirect()->route('home')->with('success', 'Order placed successfully! Your stock has been updated.');

    } catch (\Exception $e) {
        // If anything fails (stock check, DB error), undo EVERYTHING
        DB::rollBack();
        return redirect()->route('cart.view')->with('error', 'Checkout failed: ' . $e->getMessage());
    }
}

    // show edit profile form (expects a view to exist)
    public function editProfile()
    {
        $customerId = session('customer_id', 1);
        $customer = Customer::find($customerId);
        return view('profile.edit', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customerId = session('customer_id', 1);
        $customer = Customer::findOrFail($customerId);

        $data = $request->validate([
            'FirstName' => 'nullable|string|max:100',
            'LastName' => 'nullable|string|max:100',
            'Email' => 'nullable|email|max:255',
            'PhoneNumber' => 'nullable|string|max:20',
            'ShippingAddress' => 'nullable|string|max:500',
            'Password' => 'nullable|string|min:6|confirmed'
        ]);

        if (!empty($data['Password'])) {
            $customer->Password = Hash::make($data['Password']);
        }

        foreach (['FirstName','LastName','Email','PhoneNumber','ShippingAddress'] as $f) {
            if (isset($data[$f])) {
                $customer->{$f} = $data[$f];
            }
        }
        $customer->save();

        return redirect()->route('home')->with('success', 'Profile updated');
    }

    public function pastOrders()
    {
        $customerId = session('customer_id', 1);
        $orders = CustomerOrder::where('CustomerID', $customerId)->with('items')->orderBy('OrderDate', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function logout()
    {
        // clear cart and optionally customer session
        session(['cart' => []]);
        session()->forget('customer_id');
        return redirect()->route('home')->with('success', 'Logged out and cart cleared');
    }

    // Luhn algorithm for basic CC validation
    private function luhnCheck(string $number): bool
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        $sum = 0;
        $alt = false;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = (int)$number[$i];
            if ($alt) {
                $n *= 2;
                if ($n > 9) $n -= 9;
            }
            $sum += $n;
            $alt = !$alt;
        }
        return $sum % 10 === 0;
    }
}
