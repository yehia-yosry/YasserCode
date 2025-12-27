<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Books</title>

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
        .table > :not(caption) > * > *{ padding: .85rem .85rem; }
        .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono","Courier New", monospace; }
        .row-link{ text-decoration: none; }
        .row-link:hover{ text-decoration: underline; }
        .chip{
            display:inline-flex; align-items:center; gap:.4rem;
            border: 1px solid rgba(0,0,0,.08);
            background: rgba(255,255,255,.7);
            padding: .35rem .6rem;
            border-radius: 999px;
            font-size: .875rem;
        }
        .actions form{ display:inline; }
        .pagination{ margin-bottom: 0; }
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
            <i class="bi bi-journal-text me-1"></i> Admin • Books
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Books</h1>
            <div class="muted">Manage inventory, pricing, and book details.</div>
        </div>

        {{-- uses only your existing route --}}
        <a href="{{ route('admin.books.create') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Create Book
        </a>
    </div>

    <div class="card card-soft">
        <div class="card-body p-0">
            <div class="p-4 border-bottom bg-white" style="border-top-left-radius:16px;border-top-right-radius:16px;">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                    <div class="fw-semibold">
                        <i class="bi bi-list-ul me-2"></i>Books List
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="chip"><i class="bi bi-tag"></i> Category</span>
                        <span class="chip"><i class="bi bi-cash-coin"></i> Price</span>
                        <span class="chip"><i class="bi bi-box-seam"></i> Stock</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">ISBN</th>
                            <th>Title</th>
                            <th class="text-nowrap">Category</th>
                            <th class="text-nowrap">Price</th>
                            <th class="text-nowrap">Stock</th>
                            <th class="text-end text-nowrap">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td class="mono text-nowrap">{{ $book->ISBN }}</td>

                            <td class="fw-semibold">
                                <a class="row-link" href="{{ route('admin.books.show', $book->ISBN) }}">
                                    {{ $book->Title }}
                                </a>
                            </td>

                            <td class="text-nowrap">
                                {{ $book->category->CategoryName ?? '-' }}
                            </td>

                            <td class="text-nowrap fw-semibold">
                                ${{ number_format($book->Price,2) }}
                            </td>

                            <td class="text-nowrap">
                                @php $q = $book->Quantity; @endphp
                                @if($q <= 0)
                                    <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i>Out</span>
                                @elseif($q <= 5)
                                    <span class="badge text-bg-warning"><i class="bi bi-exclamation-triangle me-1"></i>Low ({{ $q }})</span>
                                @else
                                    <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i>{{ $q }}</span>
                                @endif
                            </td>

                            <td class="text-end actions text-nowrap">
                                <a href="{{ route('admin.books.edit', $book->ISBN) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>

                                <form method="post" action="{{ route('admin.books.destroy', $book->ISBN) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete?')">
                                        <i class="bi bi-trash3 me-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-4 border-top bg-white" style="border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                    <div class="muted small">
                        Use the pagination to browse more books.
                    </div>
                    <div>
                        {{ $books->links() }}
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
