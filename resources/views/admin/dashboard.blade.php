<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root{
            --brand: #5b6cff;
            --brand2:#7c4dff;
        }
        body{
            min-height: 100vh;
            background: radial-gradient(1200px 600px at 10% 0%, rgba(91,108,255,.14), transparent 55%),
                        radial-gradient(900px 500px at 95% 10%, rgba(124,77,255,.12), transparent 50%),
                        #f6f7fb;
        }
        .brand-badge{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
        }
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
        .muted{ color: #6c757d; }
        .tile{
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,.06);
            background: #fff;
            box-shadow: 0 10px 30px rgba(18, 38, 63, .06);
            transition: transform .15s ease, box-shadow .15s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }
        .tile:hover{
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(18, 38, 63, .10);
        }
        .tile-icon{
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(91,108,255,.10);
            border: 1px solid rgba(91,108,255,.18);
        }
    </style>
</head>

<body>

{{-- Navbar (no extra links / no new routes) --}}
<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </div>

        <span class="badge rounded-pill text-bg-light border py-2 px-3">
            <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Admin Dashboard</h1>
            <div class="muted">Manage books, orders, searches, and system reports.</div>
        </div>
        <div class="d-flex gap-2">
            <span class="badge rounded-pill text-bg-light border py-2 px-3">
                <i class="bi bi-shield-lock me-1"></i> Admin Area
            </span>
            <span class="badge rounded-pill text-bg-light border py-2 px-3">
                <i class="bi bi-gear me-1"></i> Control Panel
            </span>
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill text-bg-light border py-2 px-3">
                    <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
                </span>

                <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Alerts (same logic) --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-start gap-2 card-soft">
            <i class="bi bi-check-circle-fill mt-1"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-start gap-2 card-soft">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>{!! session('error') !!}</div>
        </div>
    @endif

    {{-- Menu Section --}}
    <div class="card card-soft">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="fw-bold"><i class="bi bi-grid-1x2-fill me-2"></i>Menu</div>
            <div class="muted small mt-1">Choose an action below.</div>
        </div>

        <div class="card-body px-4 pb-4 pt-3">
            <div class="row g-3">

                <div class="col-12 col-md-6 col-xl-4">
                    <a class="tile p-4" href="{{ route('admin.books.create') }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="tile-icon">
                                <i class="bi bi-plus-circle fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Add New Book</div>
                                <div class="muted small">Create and publish a new book entry.</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <a class="tile p-4" href="{{ route('admin.books.search') }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="tile-icon">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Modify Existing Books</div>
                                <div class="muted small">Search and update book details.</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <a class="tile p-4" href="{{ route('admin.orders.list') }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="tile-icon">
                                <i class="bi bi-bag-check fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Confirm Orders</div>
                                <div class="muted small">Review and confirm customer orders.</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <a class="tile p-4" href="{{ route('admin.books.search.general') }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="tile-icon">
                                <i class="bi bi-search fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Search for Books</div>
                                <div class="muted small">Find books in the system quickly.</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <a class="tile p-4" href="{{ route('admin.reports.menu') }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="tile-icon">
                                <i class="bi bi-clipboard-data fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">System Reports</div>
                                <div class="muted small">View analytics and system summaries.</div>
                            </div>
                        </div>
                    </a>
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
