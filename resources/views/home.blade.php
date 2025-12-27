<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Available Books</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root{
            --brand:#5b6cff;
            --brand2:#7c4dff;
        }
        body{
            min-height: 100vh;
            background: radial-gradient(1200px 600px at 10% 0%, rgba(91,108,255,.14), transparent 55%),
                        radial-gradient(900px 500px at 95% 10%, rgba(124,77,255,.12), transparent 50%),
                        #f6f7fb;
        }
        .brand-badge{ background: linear-gradient(135deg, var(--brand), var(--brand2)); }
        .btn-brand{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: 0;
        }
        .btn-brand:hover{ filter: brightness(.95); }
        .card-soft{
            border: 1px solid rgba(0,0,0,.06) !important;
            box-shadow: 0 10px 30px rgba(18, 38, 63, .06) !important;
            border-radius: 16px !important;
        }
        .form-control:focus, .form-select:focus{
            border-color: rgba(91,108,255,.6);
            box-shadow: 0 0 0 .25rem rgba(91,108,255,.15);
        }
        .list-group-item.active{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border-color: transparent;
        }
        .truncate-1{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .pagination{ margin-bottom: 0; }
    </style>
</head>

<body>

{{-- Navbar (kept same theme) --}}
<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0 text-decoration-none">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </a>

        {{-- Right actions --}}
        <div class="d-flex align-items-center gap-2">

            {{-- Previous Orders --}}
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary d-none d-md-inline-flex align-items-center">
                <i class="bi bi-receipt me-1"></i> Previous Orders
            </a>

            {{-- Profile --}}
            <a href="{{ route('customer.profile') }}" class="btn btn-outline-secondary d-none d-md-inline-flex align-items-center">
                <i class="bi bi-person-circle me-1"></i> Profile
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary d-inline-flex align-items-center">
                <i class="bi bi-cart3 me-1"></i> Cart
                <span class="badge text-bg-primary ms-2">{{ count($items) }}</span>
            </a>

            {{-- Logout (POST form) --}}
            <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger d-none d-md-inline-flex align-items-center">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>

            {{-- Mobile menu --}}
            <div class="dropdown d-md-none">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('orders.index') }}">
                            <i class="bi bi-receipt me-2"></i> Previous Orders
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('customer.profile') }}">
                            <i class="bi bi-person-circle me-2"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('customer.logout') }}" class="px-2">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    <div class="row g-4">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3">

            {{-- Search --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3 card-soft">
                <div class="card-body p-3">
                    <form method="get" action="{{ route('home') }}">
                        <label class="form-label fw-semibold mb-2">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="search"
                                name="q"
                                value="{{ request('q') }}"
                                class="form-control"
                                placeholder="Title, ISBN, or author"
                            >
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <button class="btn btn-brand text-white">
                                Search
                            </button>
                        </div>

                        @if(request('q') || request('category'))
                            <div class="d-flex gap-2 mt-3 flex-wrap">
                                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Clear filters
                                </a>
                                @if(request('category'))
                                    <span class="badge text-bg-light border">
                                        Category: {{ request('category') }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Categories --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3 card-soft">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-semibold">Categories</div>
                        <span class="badge text-bg-light border">{{ count($categories) }}</span>
                    </div>

                    <div class="list-group list-group-flush">
                        <a
                            href="{{ route('home') }}"
                            class="list-group-item list-group-item-action d-flex align-items-center justify-content-between {{ request('category') ? '' : 'active' }}"
                        >
                            <span><i class="bi bi-grid me-2"></i>All</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>

                        @foreach($categories as $cat)
                            <a
                                href="?category={{ $cat->CategoryID }}&q={{ urlencode(request('q')) }}"
                                class="list-group-item list-group-item-action d-flex align-items-center justify-content-between
                                       {{ request('category') == $cat->CategoryID ? 'active' : '' }}"
                            >
                                <span class="text-truncate">
                                    <i class="bi bi-tag me-2"></i>{{ $cat->CategoryName }}
                                </span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Cart Summary --}}
            <div class="card border-0 shadow-sm rounded-4 card-soft">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-semibold">Cart Summary</div>
                        <span class="badge text-bg-primary">
                            {{ count($items) }} item(s)
                        </span>
                    </div>

                    @if (count($items))
                        <ul class="list-group list-group-flush mb-2">
                            @foreach ($items as $it)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <span class="text-truncate me-2">{{ $it['title'] }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $it['qty'] }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-muted">Total</span>
                            <span class="fw-bold">${{ number_format($total,2) }}</span>
                        </div>

                        <a href="{{ route('cart.view') }}" class="btn btn-outline-primary w-100 mt-3">
                            <i class="bi bi-cart3 me-1"></i> View Cart
                        </a>
                    @else
                        <div class="text-center py-3">
                            <div class="mb-2 text-muted">
                                <i class="bi bi-cart-x fs-3"></i>
                            </div>
                            <div class="text-muted">No items in cart.</div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Main Content --}}
        <div class="col-12 col-lg-9">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">Available Books</h1>

                    @if(request('q'))
                        <div class="text-muted">
                            Showing <strong>{{ $books->total() }}</strong> result(s) for
                            <span class="badge text-bg-light border">"{{ request('q') }}"</span>
                        </div>
                    @else
                        <div class="text-muted">Browse the catalog and add items to your cart.</div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <span class="badge text-bg-light border p-2">
                        <i class="bi bi-book me-1"></i> {{ $books->total() }} total
                    </span>
                </div>
            </div>

            {{-- Books Grid --}}
            <div class="row g-3">
                @forelse ($books as $book)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 card-soft">
                            <div class="card-body d-flex flex-column p-3">

                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="card-title mb-0 truncate-1">{{ $book->Title }}</h5>

                                    @if($book->Quantity > 0)
                                        <span class="badge text-bg-success">In stock</span>
                                    @else
                                        <span class="badge text-bg-secondary">Out</span>
                                    @endif
                                </div>

                                <div class="text-muted small mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-upc-scan"></i>
                                        <span class="text-truncate">ISBN: {{ $book->ISBN }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <i class="bi bi-tags"></i>
                                        <span class="text-truncate">
                                            Category: {{ $book->category->CategoryName ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="text-muted small">Price</div>
                                        <div class="fw-bold fs-5">${{ number_format($book->Price, 2) }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-muted small">Stock</div>
                                        <div class="fw-semibold">{{ $book->Quantity }}</div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    @if($book->Quantity > 0)
                                        <a href="{{ route('cart.add', $book->ISBN) }}" class="btn btn-brand text-white w-100">
                                            <i class="bi bi-cart-plus me-1"></i> Add to cart
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary w-100" disabled>
                                            <i class="bi bi-x-circle me-1"></i> Out of stock
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 card-soft">
                            <div class="card-body text-center py-5">
                                <div class="mb-2 text-muted">
                                    <i class="bi bi-search fs-1"></i>
                                </div>
                                <h5 class="mb-1">No books found</h5>
                                <div class="text-muted">Try changing your search or category filter.</div>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary mt-3">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $books->links() }}
            </div>

        </div>
    </div>

</main>

<footer class="border-top bg-white">
    <div class="container py-4 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
        <div class="text-muted small">© {{ date('Y') }} BookStore</div>
        <div class="small text-muted">
            <i class="bi bi-shield-lock me-1"></i> Secure Shopping
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>