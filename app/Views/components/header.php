<!-- Header Navigation - Glassmorphism Enhanced -->
<header id="navbar" class="glass-nav">
    <div class="nav-container">
        <!-- Logo -->
        <div class="logo-wrapper" onclick="scrollToSection('home')">
            <div class="logo-icon">
                <span class="logo-letter">M</span>
                <span class="logo-letter accent">A</span>
            </div>
            <span class="logo-text">Monster<span class="accent">Adventure</span></span>
        </div>
        
        <!-- Hamburger Menu -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="nav-menu" id="nav">
            <div class="nav-backdrop"></div>
            <ul class="nav-links">
                <li>
                    <a href="#home" class="nav-link active" data-section="home" onclick="scrollToSection('home'); return false;">
                        <i class="fas fa-home nav-icon"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#story" class="nav-link" data-section="story" onclick="scrollToSection('story'); return false;">
                        <i class="fas fa-book-open nav-icon"></i>
                        <span>Story</span>
                    </a>
                </li>
                <li>
                    <a href="#news" class="nav-link" data-section="news" onclick="scrollToSection('news'); return false;">
                        <i class="fas fa-newspaper nav-icon"></i>
                        <span>News</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
