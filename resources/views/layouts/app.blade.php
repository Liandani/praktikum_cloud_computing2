<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskFlow – Aplikasi Manajemen Tugas Mahasiswa')</title>

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons 1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra_head')
</head>
<body>

    <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <span class="brand-icon">
                    <i class="bi bi-kanban-fill"></i>
                </span>
                <div>
                    <div>TaskFlow</div>
                    <span class="navbar-tagline">Manajemen Tugas Mahasiswa &bull; Laravel</span>
                </div>
            </a>

            <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link-custom nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" href="{{ route('tasks.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Tugas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom nav-link" href="{{ route('health') }}" target="_blank" data-bs-toggle="tooltip" data-bs-title="Cek Kesiapan Server & Database">
                            <i class="bi bi-heart-pulse me-1"></i> Health Check
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <span class="azure-badge">
                        <i class="bi bi-hdd-network-fill text-primary"></i> MySQL Connected
                    </span>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary-azure btn-sm d-flex align-items-center gap-1">
                        <i class="bi bi-plus-lg"></i>
                        <span>Buat Tugas</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES / NOTIFIKASI -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5 text-info"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 fs-5 text-warning"></i>
                <div class="flex-grow-1">{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger"></i>
                <div class="flex-grow-1">
                    @if (session('error'))
                        {{ session('error') }}
                    @else
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- KONTEN UTAMA -->
    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-custom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div>
                <strong>TaskFlow</strong> &copy; {{ date('Y') }} Praktikum Cloud Computing &bull; Full-Stack Laravel & MySQL
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted"><i class="bi bi-database me-1"></i> MySQL Engine</span>
                <span class="text-muted">&bull;</span>
                <a href="{{ route('health') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-activity text-success me-1"></i> API Status
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('extra_scripts')
</body>
</html>

