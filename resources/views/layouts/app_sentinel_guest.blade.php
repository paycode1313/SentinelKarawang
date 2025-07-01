<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sentinel Karawang')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bmkg-blue': '#004080',
                        'bmkg-accent': '#34d399',
                    }
                }
            }
        }
    </script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #004080 0%, #0056b3 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        body:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 64, 128, 0.05) 0%, transparent 70%);
            z-index: -1;
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 
                        0 0 0 1px rgba(255, 255, 255, 0.3) inset;
            overflow: hidden;
            width: 100%;
            max-width: 28rem;
            position: relative;
            z-index: 1;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .login-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12),
                        0 0 0 1px rgba(255, 255, 255, 0.4) inset;
            transform: translateY(-5px);
        }
        
        .form-input {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #d1d5db;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:focus {
            border-color: #34d399;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.25),
                        0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background-color: white;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 86, 179, 0.2),
                        0 1px 3px rgba(0, 0, 0, 0.05);
            color: white;
            font-weight: 600;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 86, 179, 0.3),
                        0 2px 4px rgba(0, 0, 0, 0.08);
        }
        
        .link-hover {
            transition: all 0.2s ease;
            position: relative;
            color: #004080;
            text-decoration: none;
            font-weight: 500;
        }
        
        .link-hover:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #004080;
            transition: width 0.3s ease;
        }
        
        .link-hover:hover:after {
            width: 100%;
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.75rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .card-header:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
        }
        
        .card-body {
            padding: 2.25rem 2rem;
        }
        
        .logo-container {
            position: relative;
            z-index: 1;
        }
        
        .logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease;
        }
        
        .logo:hover {
            transform: scale(1.05) rotate(5deg);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            z-index: 10;
            transition: color 0.2s ease;
        }
        
        .password-toggle:hover {
            color: #004080;
        }
        
        .floating-label {
            position: absolute;
            top: 1rem;
            left: 3.25rem;
            font-size: 0.875rem;
            color: #64748b;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within .floating-label,
        .input-filled .floating-label {
            top: 0.5rem;
            left: 3.5rem;
            font-size: 0.75rem;
            color: #004080;
            background: white;
            padding: 0 0.25rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="login-card transform transition-all duration-500">
        <div class="card-header">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('img/sentinel.logo.jpg') }}" alt="Sentinel Logo" class="w-16 h-16 rounded-full">
                </div>
                <h1 class="text-2xl font-bold relative z-10">@yield('page-title')</h1>
                <p class="opacity-90 mt-1 relative z-10 text-sm">@yield('page-description')</p>
            </div>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>