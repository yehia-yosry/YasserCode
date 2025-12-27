<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Book: {{ $book->Title }}</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root{ --brand:#5b6cff; --brand2:#7c4dff; }
        body{ background: #f6f7fb; min-height: 100vh; }
        .card-soft{ border: 1px solid rgba(0,0,0,.06); box-shadow: 0 10px 30px rgba(18, 38, 63, .06); border-radius: 16px; }
        .btn-brand{ background: linear-gradient(135deg, var(--brand), var(--brand2)); border: 0; color: white; }
        .btn-brand:hover{ filter: brightness(.95); color: white; }
    </style>
</head>

<body>

<nav class="navbar bg-white border-bottom sticky-top">
    <div class="container py-2">
        <div class="navbar-brand fw-bold"><i class="bi bi-book me-2"></i>BookStore Admin</div>
        <span class="badge bg-light text-dark border px-3 py-2">Editing: {{ $book->ISBN }}</span>
    </div>
</nav>

<main class="container py-5">

    {{-- Error/Success Alerts --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error:</strong> {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-soft">
        <div class="card-body p-5">
            <h2 class="mb-4">Edit Book Details</h2>

            {{-- FORM STARTS --}}
            <form method="POST" action="{{ route('admin.books.update', $book->ISBN) }}">
                @csrf
                @method('PUT') {{-- Critical: Laravel needs this to treat POST as PUT --}}

                <div class="row g-3">

                    {{-- ISBN (Read Only) --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">ISBN</label>
                        <input type="text" class="form-control bg-light" value="{{ $book->ISBN }}" readonly>
                        <div class="form-text">ISBN cannot be changed.</div>
                    </div>

                    {{-- Title --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="Title" class="form-control" value="{{ old('Title', $book->Title) }}" required>
                    </div>

                    {{-- Publication Year --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Publication Year</label>
                        <input type="number" name="PublicationYear" class="form-control" value="{{ old('PublicationYear', $book->PublicationYear) }}" required>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Price</label>
                        <input type="number" step="0.01" name="Price" class="form-control" value="{{ old('Price', $book->Price) }}" required>
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Quantity</label>
                        <input type="number" name="Quantity" class="form-control" value="{{ old('Quantity', $book->Quantity) }}" required>
                    </div>

                    {{-- Threshold --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Threshold</label>
                        <input type="number" name="Threshold" class="form-control" value="{{ old('Threshold', $book->Threshold) }}" required>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category</label>
                        <select name="CategoryID" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->CategoryID }}" {{ $book->CategoryID == $cat->CategoryID ? 'selected' : '' }}>
                                    {{ $cat->CategoryName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Publisher --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Publisher</label>
                        <select name="PublisherID" class="form-select" required>
                            @foreach($publishers as $pub)
                                <option value="{{ $pub->PublisherID }}" {{ $book->PublisherID == $pub->PublisherID ? 'selected' : '' }}>
                                    {{ $pub->Name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Authors (Multiple Select) --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Authors</label>
                        <select name="AuthorIDs[]" class="form-select" multiple size="4" required>
                            @foreach($authors as $auth)
                                {{-- Check if this author is in the current_author_ids array passed from controller --}}
                                <option value="{{ $auth->AuthorID }}"
                                    {{ in_array($auth->AuthorID, $current_author_ids) ? 'selected' : '' }}>
                                    {{ $auth->AuthorName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Hold Ctrl/Cmd to select multiple. Deselecting all is not allowed.</div>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('admin.books.search') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-brand px-5 py-2">Save Changes</button>
                </div>

            </form>
            {{-- FORM ENDS --}}

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
