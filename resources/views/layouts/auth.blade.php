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
        /* VARIABLES GLOBAL */
        :root {
            /* Warna Biru untuk Login */
            --primary-blue: #0856C8;
            --primary-blue-dark: #0645A0;
            --primary-blue-light: #2674E6;
            --primary-blue-lighter: #E8F0FE;
            --blue-gradient: linear-gradient(135deg, #0856C8, #2674E6);
            
            /* Warna Merah untuk Register */
            --primary-red: #D74138;
            --primary-red-dark: #A50F06;
            --primary-red-light: #F55F56;
            --primary-red-lighter: #FFEBEE;
            --red-gradient: linear-gradient(135deg, #F55F56, #D74138);
            
            /* Warna Netral */
            --secondary-color: #5A5C69;
            --secondary-light: #F8F9FC;
            --light-bg: #F9FAFB;
            --white: #FFFFFF;
            --border-color: #E3E6F0;
            
            /* Warna Status */
            --success-color: #1CC88A;
            --success-dark: #17A673;
            --warning-color: #F6C23E;
            --danger-color: #E74A3B;
            --info-color: #36B9CC;
            
            /* Shadow dan Border */
            --shadow: 0 0.15rem 1.75rem 0 rgba(8, 86, 200, 0.15);
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 0.5rem 2rem 0 rgba(8, 86, 200, 0.25);
            --border-radius: 15px;
            --border-radius-sm: 10px;
            --transition: all 0.3s ease;
        }
        
        /* RESET DAN BASE STYLES */
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(38, 116, 230, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(245, 95, 86, 0.05) 0%, transparent 20%);
        }
        
        /* UTILITY CLASSES */
        .auth-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }
        
        .auth-card {
            border-radius: var(--border-radius);
            border: 1px solid rgba(8, 86, 200, 0.1);
            box-shadow: var(--shadow);
            overflow: hidden;
            background-color: var(--white);
            transition: var(--transition);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .auth-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }
        
        .auth-card-body {
            padding: 2.5rem;
        }
        
        @media (max-width: 576px) {
            .auth-container {
                max-width: 100%;
            }
            
            .auth-card-body {
                padding: 1.5rem;
            }
            
            body {
                padding: 15px;
            }
        }
        
        /* FORM COMPONENTS */
        .auth-form-group {
            margin-bottom: 1.5rem;
        }
        
        .auth-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .auth-input-group {
            position: relative;
        }
        
        .auth-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--white);
            transition: var(--transition);
        }
        
        .auth-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(8, 86, 200, 0.15);
        }
        
        .auth-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            transition: var(--transition);
        }
        
        .auth-input.with-icon {
            padding-left: 3rem;
        }
        
        /* VALIDATION STATES */
        .auth-input.is-valid {
            border-color: var(--success-color);
            background-color: rgba(28, 200, 138, 0.05);
        }
        
        .auth-input.is-invalid {
            border-color: var(--danger-color);
            background-color: rgba(231, 74, 59, 0.05);
        }
        
        .auth-error {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
            min-height: 1.25rem;
        }
        
        .auth-success {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
            min-height: 1.25rem;
        }
        
        /* BUTTON BASE */
        .auth-btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: var(--border-radius-sm);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }
        
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .auth-btn:active {
            transform: translateY(0);
        }
        
        /* LOGO */
        .auth-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--white);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }
        
        .auth-logo:hover {
            transform: rotate(10deg) scale(1.05);
        }
        
        /* HEADER */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .register-title {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-red-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .auth-subtitle {
            color: var(--secondary-color);
            font-size: 0.95rem;
        }
        
        /* FOOTER */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            color: var(--secondary-color);
            font-size: 0.85rem;
        }
        
        .auth-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
        }
        
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-blue);
            transition: var(--transition);
        }
        
        .auth-link:hover {
            color: var(--primary-blue-dark);
            text-decoration: none;
        }
        
        .auth-link:hover::after {
            width: 100%;
        }
        
        .register-link {
            color: var(--primary-red);
        }
        
        .register-link::after {
            background: var(--primary-red);
        }
        
        .register-link:hover {
            color: var(--primary-red-dark);
        }
        
        /* PIN INPUT BASE */
        .pin-container {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .pin-input-base {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--white);
            transition: var(--transition);
        }
        
        .pin-input-base:focus {
            outline: none;
            transform: translateY(-2px);
        }
        
        @media (max-width: 576px) {
            .pin-input-base {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
        
        /* CHECKBOX */
        .auth-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .auth-checkbox input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
            accent-color: var(--primary-blue);
        }
        
        .register-checkbox input[type="checkbox"] {
            accent-color: var(--primary-red);
        }
        
        .auth-checkbox-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
        
        /* SPECIAL STYLES FOR REGISTER PAGE */
        .register-input:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.2rem rgba(215, 65, 56, 0.15);
        }
        
        .register-pin-container .auth-input-icon {
            color: var(--primary-red);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>