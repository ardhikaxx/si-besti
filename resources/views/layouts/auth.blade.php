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
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --primary-light: #eef2ff;
            --secondary-color: #858796;
            --secondary-light: #f0f0f0;
            --light-bg: #f8f9fc;
            --white: #ffffff;
            --success-color: #1cc88a;
            --success-dark: #17a673;
            --success-light: #e6fff5;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
            --border-color: #e3e6f0;
            --shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.25);
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
            background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="60" fill="none"/><circle cx="30" cy="30" r="1" fill="%234e73df" opacity="0.1"/></svg>');
            background-size: 40px 40px;
        }
        
        /* UTILITY CLASSES */
        .auth-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }
        
        .auth-card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
            overflow: hidden;
            background-color: var(--white);
            transition: var(--transition);
        }
        
        .auth-card:hover {
            box-shadow: var(--shadow-lg);
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
            color: #5a5c69;
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
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .auth-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
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
        }
        
        /* HEADER */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
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
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .auth-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
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
        }
        
        .auth-checkbox-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
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