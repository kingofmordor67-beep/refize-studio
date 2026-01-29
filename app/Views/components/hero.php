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
                <!-- Ginger fur gradient -->
                <linearGradient id="gingerFur" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#ff9d4a"/>
                    <stop offset="50%" style="stop-color:#e88030"/>
                    <stop offset="100%" style="stop-color:#cc6820"/>
                </linearGradient>
                <!-- Fur highlight -->
                <radialGradient id="furShine" cx="30%" cy="20%" r="50%">
                    <stop offset="0%" style="stop-color:#ffb870; stop-opacity:0.8"/>
                    <stop offset="100%" style="stop-color:#e88030; stop-opacity:0"/>
                </radialGradient>
                <!-- Light belly fur -->
                <radialGradient id="bellyFur" cx="50%" cy="40%" r="55%">
                    <stop offset="0%" style="stop-color:#fff8f0"/>
                    <stop offset="100%" style="stop-color:#ffe8d4"/>
                </radialGradient>
                <!-- Green eye gradient -->
                <radialGradient id="greenEye" cx="40%" cy="35%" r="55%">
                    <stop offset="0%" style="stop-color:#90e070"/>
                    <stop offset="50%" style="stop-color:#60c040"/>
                    <stop offset="100%" style="stop-color:#40a020"/>
                </radialGradient>
                <!-- Inner ear -->
                <radialGradient id="innerEar" cx="50%" cy="40%" r="55%">
                    <stop offset="0%" style="stop-color:#ffc0c8"/>
                    <stop offset="100%" style="stop-color:#e0a0a8"/>
                </radialGradient>
                <!-- Hoodie -->
                <linearGradient id="hoodieGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#505060"/>
                    <stop offset="100%" style="stop-color:#303040"/>
                </linearGradient>
            </defs>
            
            <style>
                @keyframes tailSway {
                    0%, 100% { transform: rotate(-2deg); }
                    50% { transform: rotate(4deg); }
                }
                @keyframes gentleFloat {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-2px); }
                }
                @keyframes smoothBlink {
                    0%, 92%, 100% { 
                        transform: scaleY(1);
                        opacity: 1;
                    }
                    95%, 97% { 
                        transform: scaleY(0.1);
                        opacity: 0.8;
                    }
                }
                .cat-tail { 
                    transform-origin: 280px 300px;
                    animation: tailSway 2.5s ease-in-out infinite;
                }
                .cat-main {
                    animation: gentleFloat 5s ease-in-out infinite;
                }
                .cat-eyes.idle .eye-white {
                    animation: smoothBlink 4s ease-in-out infinite;
                    transform-origin: center;
                }
            </style>
            
            <!-- === TAIL === -->
            <g class="cat-tail">
                <path d="M275,300 C310,310 340,280 335,245 C330,215 305,200 290,210 C280,218 285,235 290,250" 
                      fill="url(#gingerFur)" stroke="none"/>
                <ellipse cx="290" cy="252" rx="12" ry="10" fill="url(#gingerFur)"/>
            </g>
            
            <!-- === MAIN CAT GROUP === -->
            <g class="cat-main">
                <!-- Body -->
                <ellipse cx="200" cy="295" rx="100" ry="75" fill="url(#gingerFur)" />
                <ellipse cx="188" cy="280" rx="60" ry="42" fill="url(#furShine)" />
                
                <!-- Hoodie -->
                <path d="M108,265 C118,225 200,212 200,212 C200,212 282,225 292,265 L295,340 C245,358 155,358 105,340 Z" 
                      fill="url(#hoodieGradient)"/>
                <!-- Hood edge -->
                <path d="M130,248 Q200,232 270,248" fill="none" stroke="#606070" stroke-width="6" stroke-linecap="round"/>
                <!-- Pocket -->
                <path d="M150,295 Q200,308 250,295 L250,330 Q200,342 150,330 Z" fill="#252530" opacity="0.6"/>
                <!-- Code symbol -->
                <text x="200" y="318" text-anchor="middle" font-family="monospace" font-size="18" fill="#707080" opacity="0.8">&lt;/&gt;</text>
                
                <!-- Paws -->
                <ellipse cx="135" cy="352" rx="26" ry="16" fill="url(#gingerFur)" />
                <ellipse cx="265" cy="352" rx="26" ry="16" fill="url(#gingerFur)" />
                
                <!-- HEAD -->
                <ellipse cx="200" cy="155" rx="82" ry="72" fill="url(#gingerFur)" />
                <ellipse cx="185" cy="135" rx="48" ry="32" fill="url(#furShine)" />
                
                <!-- Cheek fluff -->
                <ellipse cx="132" cy="168" rx="18" ry="15" fill="url(#bellyFur)" opacity="0.85"/>
                <ellipse cx="268" cy="168" rx="18" ry="15" fill="url(#bellyFur)" opacity="0.85"/>
                
                <!-- === EARS (smooth rounded) === -->
                <!-- Left Ear -->
                <ellipse cx="130" cy="85" rx="22" ry="32" fill="url(#gingerFur)" transform="rotate(-12, 130, 85)"/>
                <ellipse cx="132" cy="90" rx="12" ry="20" fill="url(#innerEar)" transform="rotate(-12, 132, 90)"/>
                <!-- Right Ear -->
                <ellipse cx="270" cy="85" rx="22" ry="32" fill="url(#gingerFur)" transform="rotate(12, 270, 85)"/>
                <ellipse cx="268" cy="90" rx="12" ry="20" fill="url(#innerEar)" transform="rotate(12, 268, 90)"/>
                
                <!-- Forehead M marking -->
                <path d="M178,118 L188,108 L200,116 L212,108 L222,118" stroke="#c05818" stroke-width="2.5" fill="none" stroke-linecap="round" opacity="0.35"/>
                
                <!-- === EYES === -->
                <g class="cat-eyes" id="catEyes">
                    <!-- Left eye -->
                    <g class="eye-white" style="transform-origin: 162px 160px;">
                        <ellipse cx="162" cy="160" rx="22" ry="24" fill="white"/>
                        <ellipse cx="162" cy="162" rx="18" ry="20" fill="url(#greenEye)" />
                        <ellipse class="pupil" id="leftPupil" cx="162" cy="164" rx="7" ry="11" fill="#1a1a1a" />
                        <circle cx="156" cy="155" r="5" fill="white" opacity="0.9" />
                        <circle cx="167" cy="168" r="2" fill="white" opacity="0.5" />
                    </g>
                    <!-- Right eye -->
                    <g class="eye-white" style="transform-origin: 238px 160px;">
                        <ellipse cx="238" cy="160" rx="22" ry="24" fill="white"/>
                        <ellipse cx="238" cy="162" rx="18" ry="20" fill="url(#greenEye)" />
                        <ellipse class="pupil" id="rightPupil" cx="238" cy="164" rx="7" ry="11" fill="#1a1a1a" />
                        <circle cx="232" cy="155" r="5" fill="white" opacity="0.9" />
                        <circle cx="243" cy="168" r="2" fill="white" opacity="0.5" />
                    </g>
                </g>
                
                <!-- Nose -->
                <ellipse cx="200" cy="190" rx="7" ry="5" fill="#d06050" />
                <ellipse cx="198" cy="188" rx="2" ry="1.5" fill="#f0a0a0" opacity="0.5"/>
                
                <!-- Mouth -->
                <path d="M200,195 L200,200" stroke="#905040" stroke-width="2" stroke-linecap="round" />
                <path d="M190,207 Q200,215 210,207" fill="none" stroke="#905040" stroke-width="2" stroke-linecap="round" />
                
                <!-- Whiskers -->
                <g stroke="#a06850" stroke-width="1.5" stroke-linecap="round" opacity="0.5">
                    <line x1="108" y1="180" x2="145" y2="185" />
                    <line x1="105" y1="194" x2="143" y2="194" />
                    <line x1="108" y1="208" x2="145" y2="202" />
                    <line x1="255" y1="185" x2="292" y2="180" />
                    <line x1="257" y1="194" x2="295" y2="194" />
                    <line x1="255" y1="202" x2="292" y2="208" />
                </g>
            </g>
        </svg>
    </div>
</section>
