<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Top 5 Customers</title>

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
        .muted{ color: #6c757d; }
        .btn-brand{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: 0;
        }
        .btn-brand:hover{ filter: brightness(.95); }
        .rank-badge{
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 1px solid rgba(0,0,0,.08);
            background: rgba(91,108,255,.10);
        }
        .table > :not(caption) > * > *{
            padding: .85rem .85rem;
        }
        .top-row{
            background: linear-gradient(135deg, rgba(91,108,255,.08), rgba(124,77,255,.08));
        }
        .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .money{
            font-variant-numeric: tabular-nums;
        }
        .pill{
            border: 1px dashed rgba(0,0,0,.14);
            background: rgba(255,255,255,.7);
            border-radius: 999px;
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
            <i class="bi bi-people me-1"></i> Top Customers
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Top 5 Customers (Last 3 Months)</h1>
            <div class="muted">Highest spending customers in the recent period.</div>
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

    {{-- Period --}}
    <div class="card card-soft mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="rounded-3 border bg-light d-inline-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;">
                    <i class="bi bi-calendar3"></i>
                </span>
                <div>
                    <div class="fw-semibold">Period</div>
                    <div class="muted small">Since {{ $three_months_ago }}</div>
                </div>
            </div>

            <span class="pill d-inline-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-graph-up-arrow"></i>
                <span class="small fw-semibold">Last 3 months</span>
            </span>
        </div>
    </div>

    @if(count($customers) > 0)
        <div class="card card-soft">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="fw-bold"><i class="bi bi-list-ol me-2"></i>Ranking</div>
                <div class="muted small mt-1">Top 5 customers by total spending.</div>
            </div>

            <div class="card-body px-4 pb-4 pt-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Rank</th>
                            <th class="text-nowrap">Customer ID</th>
                            <th class="text-nowrap">Name</th>
                            <th>Email</th>
                            <th class="text-nowrap text-end">Total Spent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $index => $customer)
                            <tr class="{{ $index < 3 ? 'top-row' : '' }}">
                                <td class="text-nowrap">
                                    <span class="rank-badge">{{ $index + 1 }}</span>
                                </td>

                                <td class="mono text-nowrap">
                                    {{ $customer->CustomerID }}
                                </td>

                                <td class="fw-semibold text-nowrap">
                                    {{ $customer->FirstName }} {{ $customer->LastName }}
                                    @if($index == 0)
                                        <span class="badge text-bg-warning ms-2">
                                            <i class="bi bi-star-fill me-1"></i>#1
                                        </span>
                                    @endif
                                </td>

                                <td class="text-break">
                                    {{ $customer->Email }}
                                </td>

                                <td class="text-end fw-bold money">
                                    ${{ number_format($customer->total_spent, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">

                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                    <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-clipboard-data me-1"></i> Back to Reports
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
                        <i class="bi bi-speedometer2 me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card card-soft">
            <div class="card-body p-5 text-center">
                <div class="display-6 mb-2"><i class="bi bi-emoji-frown"></i></div>
                <h2 class="h5 fw-bold mb-2">No purchases found</h2>
                <p class="muted mb-4">No customer purchases found in the last 3 months.</p>

                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                    <a href="{{ route('admin.reports.menu') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Reports
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
                        <i class="bi bi-speedometer2 me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif

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
