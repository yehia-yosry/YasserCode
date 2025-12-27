<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search Books</title>

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
        .form-control:focus, .form-select:focus{
            border-color: rgba(91,108,255,.6);
            box-shadow: 0 0 0 .25rem rgba(91,108,255,.15);
        }
        .pill{
            border: 1px dashed rgba(0,0,0,.14);
            background: rgba(255,255,255,.7);
            border-radius: 999px;
        }
        .clamp-2{
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .badge-soft{
            border: 1px solid rgba(0,0,0,.08);
            background: rgba(255,255,255,.7);
            color: #111827;
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
            <i class="bi bi-search me-1"></i> Admin • General Search
        </span>
    </div>
</nav>

<main class="container py-4 py-lg-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Search for Books</h1>
            <div class="muted">Search by ISBN, title, category, author, or publisher.</div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    {{-- Error (same logic) --}}
    @if(isset($error))
        <div class="alert alert-danger d-flex align-items-start gap-2 card-soft">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>{{ $error }}</div>
        </div>
    @endif

    {{-- Search Card --}}
    <div class="card card-soft mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex align-items-start gap-3 mb-3">
                <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;">
                    <i class="bi bi-funnel fs-3"></i>
                </div>
                <div>
                    <div class="fw-bold mb-1">Search Filters</div>
                    <div class="muted">Choose a search type and enter a term.</div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.books.search.general') }}">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Search By</label>
                        <select name="search_type" required class="form-select form-select-lg">
                            <option value="">Select Search Type</option>
                            <option value="isbn" {{ ($search_type ?? '') == 'isbn' ? 'selected' : '' }}>ISBN</option>
                            <option value="title" {{ ($search_type ?? '') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="category" {{ ($search_type ?? '') == 'category' ? 'selected' : '' }}>Category</option>
                            <option value="author" {{ ($search_type ?? '') == 'author' ? 'selected' : '' }}>Author</option>
                            <option value="publisher" {{ ($search_type ?? '') == 'publisher' ? 'selected' : '' }}>Publisher</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-8">
                        <label class="form-label fw-semibold">Search Term</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input
                                type="text"
                                name="search_term"
                                value="{{ $search_term ?? '' }}"
                                required
                                class="form-control"
                                placeholder="Enter search term"
                            >
                            <button type="submit" class="btn btn-brand text-white fw-semibold">
                                <i class="bi bi-arrow-right-circle me-1"></i> Search
                            </button>
                        </div>
                    </div>

                    @if(isset($search_type) && !empty($search_type))
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="pill d-inline-flex align-items-center gap-2 px-3 py-2">
                                    <i class="bi bi-sliders"></i>
                                    <span class="small">Type:</span>
                                    <span class="small fw-semibold">{{ $search_type }}</span>
                                </span>

                                @if(isset($search_term) && !empty($search_term))
                                    <span class="pill d-inline-flex align-items-center gap-2 px-3 py-2">
                                        <i class="bi bi-funnel"></i>
                                        <span class="small">Term:</span>
                                        <span class="small fw-semibold">{{ $search_term }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Results --}}
    @if(isset($books) && count($books) > 0)
        <div class="card card-soft">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="fw-bold"><i class="bi bi-list-ul me-2"></i>Search Results</div>
                <div class="muted small mt-1">({{ count($books) }} book(s) found)</div>
            </div>

            <div class="card-body px-4 pb-4 pt-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">ISBN</th>
                                <th>Title</th>
                                <th>Authors</th>
                                <th class="text-nowrap">Publisher</th>
                                <th class="text-nowrap">Year</th>
                                <th class="text-nowrap">Category</th>
                                <th class="text-nowrap">Price</th>
                                <th class="text-nowrap">Availability</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td class="mono text-nowrap">{{ $book->ISBN }}</td>

                                <td class="fw-semibold">
                                    <div class="clamp-2">{{ $book->Title }}</div>
                                </td>

                                <td>
                                    <div class="clamp-2 muted">{{ $book->authors }}</div>
                                </td>

                                <td class="text-nowrap">{{ $book->PublisherName }}</td>
                                <td class="text-nowrap">{{ $book->PublicationYear }}</td>
                                <td class="text-nowrap">{{ $book->CategoryName }}</td>

                                <td class="text-nowrap fw-semibold">
                                    ${{ number_format($book->Price, 2) }}
                                </td>

                                <td class="text-nowrap">
                                    @if($book->Quantity > 0)
                                        <span class="badge text-bg-success">
                                            <i class="bi bi-check-circle me-1"></i>{{ $book->Quantity }} in stock
                                        </span>
                                    @else
                                        <span class="badge text-bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Out of stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-brand text-white">
                        <i class="bi bi-speedometer2 me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @elseif(isset($search_term) && !empty($search_term))
        <div class="card card-soft">
            <div class="card-body p-5 text-center">
                <div class="display-6 mb-2"><i class="bi bi-emoji-frown"></i></div>
                <h2 class="h5 fw-bold mb-2">No books found</h2>
                <p class="muted mb-4">No books found matching your search criteria.</p>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
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
