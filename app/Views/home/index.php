<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Monster Adventure') ?></title>
    <meta name="description" content="From egg to elder, your choices shape the world. Experience a dynamically evolving story in Monster Adventure.">
    
    <!-- Resource Hints for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="<?= $baseURL ?>public/css/style.css" as="style">
    <link rel="preload" href="<?= $baseURL ?>public/js/app.js" as="script">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" as="style">
    
    <!-- Critical CSS for Preloader (Inlined for instant display) -->
    <style>
        /* Preloader Critical CSS */
        #preloader {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #f0fdfb 0%, rgba(0, 210, 164, 0.08) 50%, rgba(108, 92, 231, 0.05) 100%);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.6s;
        }
        #preloader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .preloader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }
        .preloader-logo {
            font-family: 'Nunito', sans-serif;
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(45deg, #00d2a4, #6c5ce7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: logoFloat 2s ease-in-out infinite;
        }
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .preloader-spinner {
            width: 60px;
            height: 60px;
            position: relative;
        }
        .preloader-spinner::before,
        .preloader-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }
        .preloader-spinner::before {
            inset: 0;
            border: 4px solid rgba(0, 210, 164, 0.15);
        }
        .preloader-spinner::after {
            inset: 0;
            border: 4px solid transparent;
            border-top-color: #00d2a4;
            border-right-color: #6c5ce7;
            animation: spinnerRotate 1s linear infinite;
        }
        @keyframes spinnerRotate {
            to { transform: rotate(360deg); }
        }
        .preloader-text {
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            color: #636e72;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: textPulse 1.5s ease-in-out infinite;
        }
        @keyframes textPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        /* Progress bar */
        .preloader-progress {
            width: 200px;
            height: 3px;
            background: rgba(0, 210, 164, 0.15);
            border-radius: 10px;
            overflow: hidden;
        }
        .preloader-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #00d2a4, #6c5ce7);
            width: 0%;
            animation: progressFill 2s ease-out forwards;
            border-radius: 10px;
        }
        @keyframes progressFill {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
    </style>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Main Styles -->
    <link rel="stylesheet" href="<?= $baseURL ?>public/css/style.css">
</head>
<body>
    <!-- Preloader Overlay -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="preloader-logo">MA</div>
            <div class="preloader-spinner"></div>
            <div class="preloader-progress">
                <div class="preloader-progress-bar"></div>
            </div>
            <div class="preloader-text">Loading Experience</div>
        </div>
    </div>
    <!-- Custom Cursor -->
    <div class="cursor"></div>
    <div class="cursor-dot"></div>
    
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <!-- Header -->
    <?php require APPPATH . 'Views/components/header.php'; ?>
    
    <!-- Main Content -->
    <div class="container">
        <?php require APPPATH . 'Views/components/hero.php'; ?>
        <?php require APPPATH . 'Views/components/characters.php'; ?>
        <?php require APPPATH . 'Views/components/news_section.php'; ?>
        <?php require APPPATH . 'Views/components/newsletter.php'; ?>
        
        <footer style="margin-top: 50px; text-align: center; color: var(--text-light); padding-bottom: 30px;">
            <p>&copy; 2024 Monster Adventure Inc.</p>
        </footer>
    </div>
    
    <!-- Admin FAB -->
    <?php if ($user && $user['role'] === 'admin'): ?>
    <button class="admin-fab" id="adminFab" style="display: flex;">
        <i class="fas fa-plus"></i>
    </button>
    <?php endif; ?>
    
    <!-- All Modals -->
    <?php require APPPATH . 'Views/components/modals.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Pass PHP data to JavaScript
        window.APP = {
            baseURL: '<?= $baseURL ?>',
            user: <?= json_encode($user) ?>,
            news: <?= json_encode($news ?? []) ?>
        };
    </script>
    <script src="<?= $baseURL ?>public/js/app.js"></script>
    
    <!-- Preloader Dismissal (Inline Fallback) -->
    <script>
        // Immediate preloader dismissal when this script runs
        (function() {
            var preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.classList.add('loaded');
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 600);
                }, 200);
            }
        })();
    </script>
</body>
</html>
