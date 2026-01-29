<!-- Characters/Companions Section -->
<section class="section-padding fade-in-section" id="story">
    <div class="section-header">
        <h2>Companions</h2>
        <p>Select your starting lineage</p>
    </div>

    <div class="carousel-wrapper">
        <button class="carousel-btn prev-btn" id="prevBtn">&#10094;</button>

        <div class="deck-container" id="deckContainer">
            <!-- Zippo -->
            <div class="char-card tilt-card carousel-card c-zippo" data-index="0">
                <div class="char-img">
                    <svg width="100" height="120" viewBox="0 0 100 120">
                        <path d="M20,100 Q10,60 50,50 Q90,60 80,100 Q50,110 20,100" fill="#0984e3" />
                        <circle cx="40" cy="80" r="8" fill="white" />
                        <circle cx="40" cy="80" r="3" fill="black" />
                        <circle cx="65" cy="80" r="8" fill="white" />
                        <circle cx="65" cy="80" r="3" fill="black" />
                        <path d="M48 95 Q52 100 56 95" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3>Zippo</h3>
                <p>Energetic and curious. Gains bonus XP from exploration.</p>
                <a href="#" class="card-link" onclick="event.preventDefault()">Select Zippo &rarr;</a>
            </div>

            <!-- Tokko -->
            <div class="char-card tilt-card carousel-card c-tokko" data-index="1">
                <div class="char-img">
                    <svg width="100" height="120" viewBox="0 0 100 120">
                        <path d="M20,100 L30,40 L50,20 L70,40 L80,100 Z" fill="#ff7675" />
                        <rect x="20" y="40" width="60" height="60" rx="15" fill="#ff7675" />
                        <path d="M30,40 L20,20 L40,35" fill="#d63031" />
                        <path d="M70,40 L80,20 L60,35" fill="#d63031" />
                        <path d="M35 55 L45 60 L35 65" fill="white" />
                        <path d="M65 55 L55 60 L65 65" fill="white" />
                        <rect x="40" y="80" width="20" height="5" fill="#2d3436" rx="2" />
                    </svg>
                </div>
                <h3>Tokko</h3>
                <p>Brave and stubborn. Features high defense.</p>
                <a href="#" class="card-link" onclick="event.preventDefault()">Select Tokko &rarr;</a>
            </div>

            <!-- Ellize -->
            <div class="char-card tilt-card carousel-card c-ellize" data-index="2">
                <div class="char-img">
                    <svg width="100" height="120" viewBox="0 0 100 120">
                        <rect x="30" y="30" width="40" height="70" rx="20" fill="#00b894" />
                        <circle cx="50" cy="50" r="15" fill="#55efc4" />
                        <circle cx="50" cy="50" r="5" fill="#2d3436" />
                        <circle cx="20" cy="40" r="5" fill="#55efc4" opacity="0.6" />
                        <circle cx="80" cy="80" r="8" fill="#55efc4" opacity="0.6" />
                    </svg>
                </div>
                <h3>Ellize</h3>
                <p>Mystical and calm. Specialized in magic and puzzles.</p>
                <a href="#" class="card-link" onclick="event.preventDefault()">Select Ellize &rarr;</a>
            </div>

            <!-- Glacius -->
            <div class="char-card tilt-card carousel-card c-glacius" data-index="3">
                <div class="char-img">
                    <svg width="100" height="120" viewBox="0 0 100 120">
                        <path d="M20,20 L80,20 L70,100 L30,100 Z" fill="#74b9ff" />
                        <path d="M20,20 L50,5 L80,20" fill="#0984e3" />
                        <rect x="35" y="40" width="10" height="30" fill="white" />
                        <rect x="55" y="40" width="10" height="30" fill="white" />
                    </svg>
                </div>
                <h3>Glacius</h3>
                <p>Cold and calculating. Freezes enemies in their tracks.</p>
                <a href="#" class="card-link" onclick="event.preventDefault()">Select Glacius &rarr;</a>
            </div>
        </div>

        <button class="carousel-btn next-btn" id="nextBtn">&#10095;</button>
    </div>

    <div class="carousel-dots" id="carouselDots">
        <span class="dot active" data-index="0"></span>
        <span class="dot" data-index="1"></span>
        <span class="dot" data-index="2"></span>
        <span class="dot" data-index="3"></span>
    </div>
</section>
