@extends('layouts.app')

@section('content')
    <h1>Your Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->count())
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Order #{{ $order->OrderID }} — {{ $order->OrderDate }}</h5>
                    <p><strong>Total:</strong> ${{ number_format($order->TotalPrice,2) }}</p>
                    <table class="table table-sm">
                        <thead><tr><th>ISBN</th><th>Title</th><th>Qty</th></tr></thead>
                        <tbody>
                        @foreach($order->items as $item)
                            @php $book = \App\Models\Book::find($item->ISBN); @endphp
                            <tr>
                                <td>{{ $item->ISBN }}</td>
                                <td>{{ $book ? $book->Title : 'Unknown' }}</td>
                                <td>{{ $item->Quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <p>No past orders found.</p>
    @endif

@endsection
