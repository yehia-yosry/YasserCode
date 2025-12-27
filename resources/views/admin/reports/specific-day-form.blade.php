<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sales for Specific Day</title>

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
        .form-control:focus{
            border-color: rgba(91,108,255,.6);
            box-shadow: 0 0 0 .25rem rgba(91,108,255,.15);
        }
        .hint{
            border: 1px dashed rgba(0,0,0,.12);
            border-radius: 14px;
            background: rgba(255,255,255,.7);
        }
    </style>
</head>

<body>

{{-- Navbar (no new routes) --}}
<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </div>

        <span class="badge rounded-pill text-bg-light border py-2 px-3">
            <i class="bi bi-calendar-check me-1"></i> Specific Day Sales
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Total Sales for Specific Day</h1>
            <div class="muted">Choose a date to view total sales for that day.</div>
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

    {{-- Error message (same logic) --}}
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-start gap-2 card-soft">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="row g-4">
        {{-- Form Card --}}
        <div class="col-12 col-lg-7">
            <div class="card card-soft">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;">
                            <i class="bi bi-calendar-event fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold mb-1">Select Date</div>
                            <div class="muted">Pick a date to generate the sales report.</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.reports.specific.day') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" required class="form-control form-control-lg">
                            <div class="form-text muted">Use the calendar to choose a valid date.</div>
                        </div>

                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-brand text-white px-4 py-2 fw-semibold">
                                <i class="bi bi-bar-chart-line me-1"></i> Get Sales Report
                            </button>

                            <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary px-4 py-2">
                                <i class="bi bi-clipboard-data me-1"></i> Reports Menu
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-12 col-lg-5">
            <div class="card card-soft">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;">
                            <i class="bi bi-info-circle fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold mb-1">What you’ll see</div>
                            <div class="muted">
                                A summary of total sales for the selected day, based on recorded orders.
                            </div>
                        </div>
                    </div>

                    <div class="hint p-3 mt-4">
                        <div class="small">
                            <div class="fw-semibold mb-1">Tip</div>
                            <div class="muted">
                                If there were no sales for the selected day, the result may be $0.00.
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Reports
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
                            <i class="bi bi-speedometer2 me-1"></i> Back to Dashboard
                        </a>
                    </div>

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
