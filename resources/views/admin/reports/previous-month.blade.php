<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Previous Month Sales</title>

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
        .metric{
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(91,108,255,.10), rgba(124,77,255,.10));
            border: 1px solid rgba(0,0,0,.06);
        }
        .muted{ color: #6c757d; }
        .btn-brand{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: 0;
        }
        .btn-brand:hover{ filter: brightness(.95); }
    </style>
</head>

<body>

{{-- Navbar (no extra routes) --}}
<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </div>

        <span class="badge rounded-pill text-bg-light border py-2 px-3">
            <i class="bi bi-calendar2-month me-1"></i> Previous Month
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Total Sales for Previous Month</h1>
            <div class="muted">Summary of sales for the last completed month.</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Reports
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Period Card --}}
        <div class="col-12 col-lg-6">
            <div class="card card-soft h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;">
                            <i class="bi bi-calendar-range fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold mb-1">Period</div>
                            <div class="muted">From <span class="fw-semibold text-dark">{{ $first_day_previous_month }}</span>
                                to <span class="fw-semibold text-dark">{{ $last_day_previous_month }}</span>
                            </div>
                            <div class="small muted mt-2">
                                This report covers the previous month only.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Sales Metric --}}
        <div class="col-12 col-lg-6">
            <div class="metric p-4 p-lg-5 h-100 card-soft">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="muted mb-1">Total Sales</div>
                        <div class="display-6 fw-bold mb-1">${{ number_format($total_sales, 2) }}</div>
                        <div class="small muted">All confirmed sales within the period.</div>
                    </div>
                    <div class="rounded-4 bg-white border d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;">
                        <i class="bi bi-cash-coin fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom actions --}}
    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
        <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary">
            <i class="bi bi-clipboard-data me-1"></i> Reports Menu
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
            <i class="bi bi-speedometer2 me-1"></i> Back to Dashboard
        </a>
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
