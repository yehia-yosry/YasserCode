@csrf

<div class="row g-3">

    {{-- ISBN --}}
    <div class="col-12">
        <label class="form-label fw-semibold">ISBN</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
            <input
                name="ISBN"
                value="{{ $book->ISBN ?? old('ISBN') }}"
                class="form-control {{ $errors->has('ISBN') ? 'is-invalid' : '' }}"
                {{ isset($book) ? 'readonly' : '' }}
                placeholder="Enter ISBN"
            >
        </div>
        @error('ISBN')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        @if(isset($book))
            <div class="form-text text-muted">ISBN is locked while editing.</div>
        @endif
    </div>

    {{-- Title --}}
    <div class="col-12">
        <label class="form-label fw-semibold">Title</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-book"></i></span>
            <input
                name="Title"
                value="{{ $book->Title ?? old('Title') }}"
                class="form-control {{ $errors->has('Title') ? 'is-invalid' : '' }}"
                placeholder="Book title"
            >
        </div>
        @error('Title')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Price + Quantity --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Price</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
            <input
                name="Price"
                value="{{ $book->Price ?? old('Price') }}"
                class="form-control {{ $errors->has('Price') ? 'is-invalid' : '' }}"
                placeholder="0.00"
            >
        </div>
        @error('Price')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Quantity</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
            <input
                name="Quantity"
                value="{{ $book->Quantity ?? old('Quantity') }}"
                class="form-control {{ $errors->has('Quantity') ? 'is-invalid' : '' }}"
                placeholder="0"
            >
        </div>
        @error('Quantity')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

        <div class="col-md-6">
        <label class="form-label fw-semibold">Threshold</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
            <input
                name="Threshold"
                value="{{ $book->Threshold ?? old('Threshold') }}"
                class="form-control {{ $errors->has('Threshold') ? 'is-invalid' : '' }}"
                placeholder="0"
            >
        </div>
        @error('Threshold')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

        <div class="col-md-6">
        <label class="form-label fw-semibold">Publication Year</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
            <input
                name="PublicationYear"
                value="{{ $book->PublicationYear ?? old('PublicationYear') }}"
                class="form-control {{ $errors->has('PublicationYear') ? 'is-invalid' : '' }}"
                placeholder="0"
            >
        </div>
        @error('PublicationYear')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Category --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Category</label>
        <select
            name="CategoryID"
            class="form-select"
        >
            <option value="">--</option>
            @foreach($categories as $cat)
                <option
                    value="{{ $cat->CategoryID }}"
                    {{ isset($book) && $book->CategoryID == $cat->CategoryID ? 'selected' : '' }}
                >
                    {{ $cat->CategoryName }}
                </option>
            @endforeach
        </select>
        <div class="form-text text-muted">Choose the book category.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publisher</label>
        <select name="PublisherID" class="form-select">
            <option value="">--</option>
            @foreach($publishers as $p)
                <option value="{{ $p->PublisherID }}">{{ $p->Name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Authors</label>
        <select name="AuthorIDs[]" class="form-select" multiple size="3">
            @foreach($authors as $a)
                <option value="{{ $a->AuthorID }}">{{ $a->AuthorName }}</option>
            @endforeach
        </select>
        <div class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple authors.</div>
        @error('AuthorIDs')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
