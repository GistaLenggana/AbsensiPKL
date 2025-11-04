<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Absensi PKL - BPKAD Garut')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary: #0ea5e9;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --white: #ffffff;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #e2e8f0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            padding: 24px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: var(--white);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Navigation Menu */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            color: var(--white);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--white);
            color: var(--primary);
            border-color: var(--white);
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 4px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header-title p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 13px;
            font-weight: 400;
        }

        /* Card Styles - Putih Bersih */
        .card {
            background: var(--white);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .card-header {
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--primary);
        }

        .card-header h2 {
            color: var(--primary);
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .card-header p {
            color: var(--gray);
            font-size: 14px;
            font-weight: 400;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }

        .form-label .icon {
            font-size: 18px;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--white);
            font-family: inherit;
            color: var(--dark);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #f8fafc;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        .form-hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--gray);
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.5);
        }

        .btn-secondary {
            background: var(--gray);
            color: var(--white);
            box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--dark);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
        }

        .btn-block {
            width: 100%;
        }

        /* Alert Styles */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid var(--info);
        }

        /* Preview Styles */
        .preview-container {
            margin-top: 16px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid var(--gray-light);
            background: #f8fafc;
            display: none;
        }

        .preview-container.active {
            display: block;
        }

        .preview-container img {
            width: 100%;
            max-width: 400px;
            display: block;
            margin: 0 auto;
        }

        /* Location Info */
        .location-info {
            margin-top: 12px;
            padding: 16px;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-radius: 12px;
            border: 1px solid rgba(30, 64, 175, 0.2);
            display: none;
        }

        .location-info.active {
            display: block;
        }

        /* Loading Spinner */
        .loading {
            display: none;
            text-align: center;
            padding: 24px;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 3px solid var(--gray-light);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 12px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Success Icon Animation */
        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 32px 20px;
            color: var(--white);
            margin-top: 60px;
        }

        .footer p {
            font-size: 14px;
            opacity: 0.95;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            color: var(--dark);
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
            border-left: 5px solid;
        }

        .stat-card:nth-child(1) { border-left-color: #667eea; }
        .stat-card:nth-child(2) { border-left-color: #10b981; }
        .stat-card:nth-child(3) { border-left-color: #f59e0b; }
        .stat-card:nth-child(4) { border-left-color: #3b82f6; }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 500;
            color: var(--gray);
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .card {
                padding: 24px;
                border-radius: 16px;
            }

            .header-title h1 {
                font-size: 20px;
            }

            .header-title p {
                font-size: 12px;
            }

            .logo {
                width: 60px;
                height: 60px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }

            .card-header h2 {
                font-size: 22px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Selection */
        ::selection {
            background: var(--primary);
            color: var(--white);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">
                        <img src="{{ asset('images/lambanggarut.png') }}" alt="Logo BPKAD Garut">
                    </div>
                    <div class="header-title">
                        <h1>Sistem Absensi PKL/Magang</h1>
                        <p>Badan Pengelola Keuangan dan Aset Daerah Kabupaten Garut</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} BPKAD Kabupaten Garut. Hak Cipta Dilindungi.</p>
    </div>

    @stack('scripts')
</body>
</html>