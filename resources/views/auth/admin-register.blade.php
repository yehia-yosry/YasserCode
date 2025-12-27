<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Registration</title>

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
        .form-control:focus{
            border-color: rgba(91,108,255,.6);
            box-shadow: 0 0 0 .25rem rgba(91,108,255,.15);
        }
    </style>
</head>

<body>

<nav class="navbar bg-white border-bottom">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0">
            <span class="brand-badge text-white rounded-3 px-2 py-1">
                <i class="bi bi-book"></i>
            </span>
            BookStore
        </div>

        <span class="badge rounded-pill text-bg-light border py-2 px-3">
            <i class="bi bi-person-plus me-1"></i> Admin
        </span>
    </div>
</nav>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-5">

            <div class="card card-soft">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-4 border bg-light"
                             style="width:56px;height:56px;">
                            <i class="bi bi-person-plus fs-3"></i>
                        </div>
                        <h2 class="h4 fw-bold mt-3 mb-1">New Admin Registration</h2>
                        <div class="muted">Create an admin account</div>
                    </div>

                    @if(@session('error'))
                        <div class="alert alert-danger d-flex gap-2 align-items-start">
                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.register.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    placeholder="Username"
                                    value="{{ old('username') }}"
                                    required
                                    autocomplete="username"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Password"
                                    value="{{ old('password') }}"
                                    required
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand text-white w-100 py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Register
                        </button>

                        <p class="text-center mt-3 mb-0 muted">
                            Already have an account?
                            <a class="text-decoration-none fw-semibold" href="{{ route('admin.login') }}">
                                Login
                            </a>
                        </p>
                    </form>

                </div>
            </div>

            <div class="text-center small muted mt-4">
                ©️ {{ date('Y') }} BookStore
            </div>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
