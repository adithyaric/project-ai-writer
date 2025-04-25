<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AI Smart Writer') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom styles -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .footer {
            margin-top: auto;
            padding: 1rem 0;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-robot me-2"></i>AI Smart Writer
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('percakapan.*') ? 'active' : '' }}"
                                href="{{ route('percakapan.index') }}">
                                <i class="bi bi-chat-dots me-1"></i>Percakapan
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        {{-- @guest --}}
                        {{-- <li class="nav-item"> --}}
                        {{-- <a class="nav-link" href="{{ route('login') }}">Login</a> --}}
                        {{-- </li> --}}
                        {{-- <li class="nav-item"> --}}
                        {{-- <a class="nav-link" href="{{ route('register') }}">Register</a> --}}
                        {{-- </li> --}}
                        {{-- @else --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()?->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                {{-- <li> --}}
                                {{-- <a class="dropdown-item" href="{{ route('logout') }}" --}}
                                {{-- onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> --}}
                                {{-- Logout --}}
                                {{-- </a> --}}
                                {{-- </li> --}}
                            </ul>
                        </li>
                        {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> --}}
                        {{-- @csrf --}}
                        {{-- </form> --}}
                        {{-- @endguest --}}
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} AI Smart Writer. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    @yield('scripts')
</body>

</html>
