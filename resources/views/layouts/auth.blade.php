<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SI Besti')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* VARIABLES GLOBAL - HANYA BIRU */
        :root {
            /* Palette Biru dari Gambar */
            --blue-100: #E8F0FE;
            --blue-200: #C6DAFC;
            --blue-300: #A3C4FA;
            --blue-400: #7FACE8;
            --blue-500: #5C95E6;
            --blue-600: #3A7DE4;
            --blue-700: #2674E6;
            --blue-800: #1260D2;
            --blue-900: #0856C8;
            --blue-950: #0645A0;
            
            /* Warna Primer (menggunakan dari palette) */
            --primary: var(--blue-900);
            --primary-dark: var(--blue-950);
            --primary-light: var(--blue-700);
            --primary-lighter: var(--blue-100);
            --gradient-primary: linear-gradient(135deg, var(--blue-900), var(--blue-700));
            --gradient-light: linear-gradient(135deg, var(--blue-700), var(--blue-500));
            
            /* Warna Netral */
            --secondary: #5A5C69;
            --secondary-light: #F8F9FC;
            --light-bg: #F9FAFB;
            --white: #FFFFFF;
            --border-color: #E3E6F0;
            
            /* Warna Status */
            --success: #1CC88A;
            --success-dark: #17A673;
            --warning: #F6C23E;
            --danger: #E74A3B;
            --info: #36B9CC;
            
            /* Shadow dan Border */
            --shadow: 0 0.15rem 1.75rem 0 rgba(8, 86, 200, 0.15);
            --shadow-sm: 0 0.125rem 0.25rem rgba(8, 86, 200, 0.1);
            --shadow-lg: 0 0.5rem 2rem 0 rgba(8, 86, 200, 0.25);
            --border-radius: 18px;
            --border-radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* RESET DAN BASE STYLES */
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7ff 0%, #eef1ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Decorative Elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(38, 116, 230, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(18, 96, 210, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 50% 50%, rgba(8, 86, 200, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        /* Animasi Background */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* UTILITY CLASSES */
        .auth-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        
        .auth-card {
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
            z-index: 2;
        }
        
        .auth-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(8, 86, 200, 0.2);
        }
        
        .auth-card-body {
            padding: 3rem;
        }
        
        @media (max-width: 576px) {
            .auth-container {
                max-width: 100%;
            }
            
            .auth-card-body {
                padding: 2rem;
            }
            
            body {
                padding: 15px;
            }
        }
        
        .auth-label {
            font-weight: 500;
            color: var(--secondary);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }
        
        .auth-label i {
            color: var(--blue-700);
            width: 20px;
            text-align: center;
        }
        
        .auth-input-group {
            position: relative;
            transition: var(--transition);
        }
        
        .auth-input {
            width: 100%;
            padding: 0.9rem;
            font-size: 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--white);
            transition: var(--transition);
            color: #333;
            font-weight: 500;
        }
        
        .auth-input:focus {
            outline: none;
            border-color: var(--blue-600);
            box-shadow: 0 0 0 4px rgba(38, 116, 230, 0.15);
        }
        
        /* VALIDATION STATES */
        .auth-input.is-valid {
            border-color: var(--success);
            background-color: rgba(28, 200, 138, 0.05);
        }
        
        .auth-input.is-invalid {
            border-color: var(--danger);
            background-color: rgba(231, 74, 59, 0.05);
        }
        
        .auth-error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
            min-height: 1.25rem;
            font-weight: 500;
        }
        
        .auth-success {
            color: var(--success);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
            min-height: 1.25rem;
            font-weight: 500;
        }
        
        /* BUTTON BASE */
        .auth-btn {
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.05rem;
            border-radius: var(--border-radius-sm);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .auth-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
            z-index: -1;
        }
        
        .auth-btn:hover::before {
            left: 100%;
        }
        
        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.3);
        }
        
        .auth-btn:active {
            transform: translateY(-1px);
        }
        
        /* LOGO */
        .auth-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: var(--white);
            background: var(--gradient-primary);
            box-shadow: 0 8px 25px rgba(8, 86, 200, 0.3);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .auth-logo::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: transform 0.6s;
        }
        
        .auth-logo:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 35px rgba(8, 86, 200, 0.4);
        }
        
        .auth-logo:hover::after {
            transform: rotate(225deg);
        }
        
        /* HEADER */
        .auth-header {
            text-align: center;
            margin-bottom: 14px;
        }
        
        .auth-title {
            font-weight: 700;
            margin-bottom: 5px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
        }
        
        .auth-subtitle {
            color: var(--secondary);
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.8;
        }
        
        /* FOOTER */
        .auth-footer {
            text-align: center;
            margin-top: 14px;
            padding-top: 1rem;
            border-top: 1px solid rgba(8, 86, 200, 0.1);
            color: var(--secondary);
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .auth-link {
            color: var(--blue-800);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--blue-700);
            transition: var(--transition);
            border-radius: 2px;
        }
        
        .auth-link:hover {
            color: var(--blue-900);
            text-decoration: none;
        }
        
        .auth-link:hover::after {
            width: 100%;
        }
        
        /* PIN INPUT BASE */
        .pin-container {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .pin-input-base {
            width: 70px;
            height: 70px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--primary-lighter);
            transition: var(--transition);
            color: var(--blue-900);
        }
        
        .pin-input-base:focus {
            outline: none;
            border-color: var(--blue-600);
            box-shadow: 0 0 0 4px rgba(38, 116, 230, 0.15);
            transform: translateY(-2px);
            background-color: var(--white);
        }
        
        @media (max-width: 576px) {
            .pin-input-base {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
        
        /* CHECKBOX */
        .auth-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }
        
        .auth-checkbox:hover {
            background: rgba(8, 86, 200, 0.03);
        }
        
        .auth-checkbox input[type="checkbox"] {
            width: 1.3rem;
            height: 1.3rem;
            cursor: pointer;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            appearance: none;
            background: var(--white);
            transition: var(--transition);
            position: relative;
        }
        
        .auth-checkbox input[type="checkbox"]:checked {
            background: var(--blue-700);
            border-color: var(--blue-700);
        }
        
        .auth-checkbox input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .auth-checkbox-label {
            font-size: 0.95rem;
            color: var(--secondary);
            line-height: 1.4;
        }
        
        /* Additional Utility */
        .text-muted {
            color: #6c757d !important;
        }
        
        .text-muted i {
            color: var(--blue-600);
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Floating decorative elements -->
    <div class="position-fixed top-0 start-0 w-100 h-100" style="pointer-events: none; z-index: 0;">
        <div class="position-absolute" style="top: 10%; left: 5%; width: 50px; height: 50px; background: rgba(38, 116, 230, 0.1); border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 70%; right: 10%; width: 80px; height: 80px; background: rgba(18, 96, 210, 0.08); border-radius: 50%; animation: float 10s ease-in-out infinite 1s;"></div>
        <div class="position-absolute" style="top: 30%; right: 20%; width: 40px; height: 40px; background: rgba(8, 86, 200, 0.15); border-radius: 50%; animation: float 7s ease-in-out infinite 0.5s;"></div>
    </div>
    
    @yield('content')
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>