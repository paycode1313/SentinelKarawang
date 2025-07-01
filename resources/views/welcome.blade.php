<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sentinel Karawang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bmkg-blue: #004080;
            --bmkg-secondary: #0056b3;
            --bmkg-accent: #34d399;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 20%, rgba(52, 211, 153, 0.05) 0%, transparent 20%),
                        radial-gradient(circle at 90% 80%, rgba(0, 64, 128, 0.05) 0%, transparent 20%);
            z-index: -1;
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(0, 86, 179, 0.05) 0%, transparent 15%),
                radial-gradient(circle at 80% 70%, rgba(52, 211, 153, 0.05) 0%, transparent 15%);
            z-index: -1;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(to right, var(--bmkg-blue), var(--bmkg-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .hero-title {
                font-size: 4rem;
            }
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #4b5563;
            max-width: 600px;
            margin-bottom: 2.5rem;
        }
        
        .btn-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--bmkg-blue), var(--bmkg-secondary));
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 86, 179, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 86, 179, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(to right, var(--bmkg-accent), #10b981);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(52, 211, 153, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(52, 211, 153, 0.3);
        }
        
        .features-section {
            padding: 5rem 2rem;
            background-color: white;
            position: relative;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            transition: all 0.3s ease;
            border: 1px solid #f0f4f8;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: #e0e7ff;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0f2fe, #dbeafe);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--bmkg-blue);
            font-size: 1.75rem;
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--bmkg-blue);
        }
        
        .feature-description {
            color: #4b5563;
            line-height: 1.6;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            background: linear-gradient(to right, var(--bmkg-blue), var(--bmkg-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--bmkg-blue), var(--bmkg-secondary));
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .footer-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .footer-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .footer-subtitle {
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .footer-links {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .footer-link {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .footer-link:hover {
            opacity: 1;
            text-decoration: underline;
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0.7;
        }
        
        .wave-divider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }
        
        .wave-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 84px;
        }
        
        .wave-divider .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="text-center md:text-left">
                <h1 class="hero-title">Selamat Datang di Sentinel Karawang</h1>
                <p class="hero-subtitle">
                    Platform inovatif untuk memantau lingkungan dan berpartisipasi dalam program insentif 
                    untuk menjaga kelestarian alam di Kabupaten Karawang.
                </p>
                
                <div class="btn-container">
                    <a href="{{ route('login') }}" class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="wave-divider">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
    
    <div class="features-section">
        <h2 class="section-title">Fitur Utama Sentinel</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="feature-title">Pemantauan Real-Time</h3>
                <p class="feature-description">
                    Pantau kondisi lingkungan di seluruh Karawang secara real-time melalui peta interaktif 
                    dengan data sensor terkini.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tree"></i>
                </div>
                <h3 class="feature-title">Program Insentif</h3>
                <p class="feature-description">
                    Dapatkan poin dan klaim insentif menarik dengan berpartisipasi dalam kegiatan 
                    pelestarian lingkungan.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Analisis Data</h3>
                <p class="feature-description">
                    Akses laporan dan analisis data lingkungan untuk memahami tren dan kondisi 
                    lingkungan di wilayah Anda.
                </p>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('img/sentinel.logo.jpg') }}" alt="Sentinel Logo" class="w-14 h-14 rounded-full">
            </div>
            <h3 class="footer-title">Sentinel Karawang</h3>
            <p class="footer-subtitle">
                Sistem pemantauan lingkungan dan program insentif untuk menjaga kelestarian alam 
                Kabupaten Karawang
            </p>
            
            <div class="footer-links">
                <a href="{{ route('dashboard') }}" class="footer-link">Beranda</a>
                <a href="{{ route('map.index') }}" class="footer-link">Peta</a>
                <a href="{{ route('incentives.index') }}" class="footer-link">Insentif</a>
                <a href="#" class="footer-link">Tentang Kami</a>
                <a href="#" class="footer-link">Kontak</a>
            </div>
            
            <div class="copyright">
                &copy; {{ date('Y') }} Dinas Lingkungan Hidup Kabupaten Karawang. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>
</body>
</html>