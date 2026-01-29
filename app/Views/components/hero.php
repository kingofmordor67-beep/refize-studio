<!-- Hero Section -->
<section class="hero fade-in-section" id="home">
    <div class="hero-content">
        <span class="badge">V 2.0 Released</span>
        <h1>
            Choose Your<br>
            <span>Adventure</span>
        </h1>
        <p>
            From egg to elder, your choices shape the world. Experience a
            dynamically evolving story.
        </p>
        <button class="cta-btn" onclick="scrollToSection('story')">
            Start Journey
        </button>
    </div>
    <div class="hero-img" id="heroMonster">
        <svg width="400" height="400" viewBox="0 0 400 400">
            <defs>
                <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="10" result="blur" />
                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
                <linearGradient id="catGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#7c8798"/>
                    <stop offset="100%" style="stop-color:#5a6373"/>
                </linearGradient>
                <linearGradient id="bellGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#ffd700"/>
                    <stop offset="80%" style="stop-color:#daa520"/>
                    <stop offset="100%" style="stop-color:#b8860b"/>
                </linearGradient>
            </defs>
            
            <!-- Cat Body - Main rounded shape -->
            <ellipse cx="200" cy="280" rx="120" ry="100" fill="url(#catGradient)" />
            
            <!-- Cat Head -->
            <circle cx="200" cy="170" r="100" fill="url(#catGradient)" />
            
            <!-- Left Ear -->
            <path d="M110,100 L90,40 L140,80 Z" fill="url(#catGradient)" />
            <path d="M115,95 L100,55 L135,85 Z" fill="#ff9fac" />
            
            <!-- Right Ear -->
            <path d="M290,100 L310,40 L260,80 Z" fill="url(#catGradient)" />
            <path d="M285,95 L300,55 L265,85 Z" fill="#ff9fac" />
            
            <!-- Eye whites -->
            <g class="eyes">
                <ellipse cx="155" cy="165" rx="30" ry="35" fill="white" />
                <ellipse cx="245" cy="165" rx="30" ry="35" fill="white" />
                
                <!-- Pupils (these will track the cursor) -->
                <circle class="pupil" cx="155" cy="170" r="15" fill="#2d3436" />
                <circle class="pupil" cx="245" cy="170" r="15" fill="#2d3436" />
                
                <!-- Eye shine -->
                <circle cx="148" cy="160" r="6" fill="white" opacity="0.9" />
                <circle cx="238" cy="160" r="6" fill="white" opacity="0.9" />
                <circle cx="160" cy="175" r="3" fill="white" opacity="0.6" />
                <circle cx="250" cy="175" r="3" fill="white" opacity="0.6" />
            </g>
            
            <!-- Nose -->
            <ellipse cx="200" cy="205" rx="12" ry="8" fill="#ff9fac" />
            
            <!-- Mouth -->
            <path d="M200,213 L200,225" stroke="#5a6373" stroke-width="3" stroke-linecap="round" />
            <path d="M185,230 Q200,245 215,230" fill="none" stroke="#5a6373" stroke-width="3" stroke-linecap="round" />
            
            <!-- Whiskers -->
            <g stroke="#4a5568" stroke-width="2" stroke-linecap="round">
                <line x1="105" y1="195" x2="145" y2="200" />
                <line x1="100" y1="210" x2="145" y2="210" />
                <line x1="105" y1="225" x2="145" y2="218" />
                <line x1="255" y1="200" x2="295" y2="195" />
                <line x1="255" y1="210" x2="300" y2="210" />
                <line x1="255" y1="218" x2="295" y2="225" />
            </g>
            
            <!-- Collar -->
            <path d="M130,260 Q200,290 270,260" fill="none" stroke="#e74c3c" stroke-width="12" stroke-linecap="round" />
            
            <!-- Bell -->
            <circle cx="200" cy="290" r="22" fill="url(#bellGradient)" />
            <ellipse cx="200" cy="283" rx="15" ry="5" fill="#ffeeba" opacity="0.6" />
            <circle cx="200" cy="295" r="5" fill="#8b4513" />
            <line x1="200" y1="300" x2="200" y2="308" stroke="#8b4513" stroke-width="3" stroke-linecap="round" />
            
            <!-- Paws at bottom -->
            <ellipse cx="140" cy="360" rx="35" ry="20" fill="url(#catGradient)" />
            <ellipse cx="260" cy="360" rx="35" ry="20" fill="url(#catGradient)" />
            
            <!-- Paw pads -->
            <ellipse cx="140" cy="365" rx="12" ry="8" fill="#ff9fac" />
            <ellipse cx="260" cy="365" rx="12" ry="8" fill="#ff9fac" />
        </svg>
    </div>
</section>
