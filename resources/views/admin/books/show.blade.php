<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $book->Title }}</title>

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
        .card-soft{
            border: 1px solid rgba(0,0,0,.06);
            box-shadow: 0 10px 30px rgba(18, 38, 63, .06);
            border-radius: 16px;
        }
        .btn-brand{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: 0;
        }
        .btn-brand:hover{ filter: brightness(.95); }
        .muted{ color:#6c757d; }
        .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono","Courier New", monospace; }
        .metric{
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(91,108,255,.10), rgba(124,77,255,.10));
            border: 1px solid rgba(0,0,0,.06);
        }
        .kv{
            border: 1px dashed rgba(0,0,0,.12);
            border-radius: 14px;
            background: rgba(255,255,255,.7);
        }
    </style>
</head>

<body>

{{-- Navbar (NO new routes added) --}}
<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </div>

        <span class="badge rounded-pill text-bg-light border py-2 px-3">
            <i class="bi bi-journal-bookmark me-1"></i> Book Details
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">{{ $book->Title }}</h1>
            <div class="muted">View book information and inventory details.</div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Main info --}}
        <div class="col-12 col-lg-7">
            <div class="card card-soft">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;">
                            <i class="bi bi-book-half fs-3"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1">Book Information</div>
                            <div class="muted">Basic details for this book.</div>

                            <div class="kv p-3 mt-3">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-sm-4 muted fw-semibold">ISBN</div>
                                    <div class="col-12 col-sm-8 fw-semibold mono">{{ $book->ISBN }}</div>

                                    <div class="col-12 col-sm-4 muted fw-semibold">Category</div>
                                    <div class="col-12 col-sm-8 fw-semibold">{{ $book->category->CategoryName ?? '-' }}</div>

                                    <div class="col-12 col-sm-4 muted fw-semibold">Publisher</div>
                                    <div class="col-12 col-sm-8 fw-semibold">{{ $book->publisher->Name ?? '-' }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Metrics --}}
        <div class="col-12 col-lg-5">
            <div class="metric card-soft p-4 p-lg-5 h-100">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="muted mb-1">Price</div>
                        <div class="display-6 fw-bold mb-1">${{ number_format($book->Price,2) }}</div>
                        <div class="small muted">Current unit price.</div>
                    </div>

                    <div class="rounded-4 bg-white border d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;">
                        <i class="bi bi-cash-coin fs-3"></i>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="muted mb-1">Stock</div>
                        <div class="h2 fw-bold mb-1">{{ $book->Quantity }}</div>
                        <div class="small muted">Available units in inventory.</div>
                    </div>

                    <div class="rounded-4 bg-white border d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                </div>

                <div class="mt-3">
                    @php $q = $book->Quantity; @endphp
                    @if($q <= 0)
                        <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i>Out of stock</span>
                    @elseif($q <= 5)
                        <span class="badge text-bg-warning"><i class="bi bi-exclamation-triangle me-1"></i>Low stock</span>
                    @else
                        <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i>In stock</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

</main>

<footer class="border-top bg-white">
    <div class="container py-4 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
        <div class="muted small">©️ {{ date('Y') }} BookStore — Admin Panel</div>
        <div class="small muted">
            <i class="bi bi-shield-lock me-1"></i> Secure Admin Access
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
