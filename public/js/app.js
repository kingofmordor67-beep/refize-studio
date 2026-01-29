/**
 * =====================================================
 * REFIZE STUDIO - Monster Adventure
 * Main JavaScript (Vanilla JS - converted from React)
 * =====================================================
 */

// ================================
// PRELOADER HANDLER
// ================================
function dismissPreloader() {
    const preloader = document.getElementById('preloader');
    if (preloader && !preloader.classList.contains('loaded')) {
        // Add a small delay to ensure smooth transition
        setTimeout(() => {
            preloader.classList.add('loaded');
            // Remove from DOM after animation completes
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 600);
        }, 300);
    }
}

// Handle preloader dismissal - check if page already loaded
if (document.readyState === 'complete') {
    // Page already loaded, dismiss immediately
    dismissPreloader();
} else {
    // Wait for page to fully load
    window.addEventListener('load', dismissPreloader);
}

// ================================
// INITIALIZATION
// ================================
document.addEventListener('DOMContentLoaded', () => {
    initCustomCursor();
    initEyeTracking();
    initTilt3D();
    initFadeInSections();
    initNavigation();
    initActiveNavTracking();
    initCarousel();
    initModals();
    initAuth();
});

// ================================
// CUSTOM CURSOR
// ================================
function initCustomCursor() {
    // Only run on non-touch devices
    if (window.matchMedia("(pointer: coarse)").matches) return;

    const cursor = document.querySelector('.cursor');
    const dot = document.querySelector('.cursor-dot');

    if (!cursor || !dot) return;

    document.addEventListener('mousemove', (e) => {
        dot.style.left = e.clientX + 'px';
        dot.style.top = e.clientY + 'px';

        setTimeout(() => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        }, 50);

        // Expand cursor on interactive elements
        const target = e.target;
        if (target.closest('a, button, input, .hamburger, .nav-btn-link, .char-card, .dot')) {
            cursor.classList.add('active');
        } else {
            cursor.classList.remove('active');
        }
    });
}

// ================================
// MONSTER EYE TRACKING
// ================================
function initEyeTracking() {
    const heroMonster = document.getElementById('heroMonster');
    if (!heroMonster) return;

    document.addEventListener('mousemove', (e) => {
        const pupils = heroMonster.querySelectorAll('.pupil');
        const xAxis = (window.innerWidth / 2 - e.pageX) / 20;
        const yAxis = (window.innerHeight / 2 - e.pageY) / 20;

        pupils.forEach(pupil => {
            // Larger movement range for bigger cat pupils
            pupil.style.transform = `translate(${Math.max(-12, Math.min(12, -xAxis))}px, ${Math.max(-10, Math.min(10, -yAxis))}px)`;
        });
    });
}

// ================================
// 3D TILT EFFECT
// ================================
function initTilt3D() {
    if (window.matchMedia("(max-width: 992px)").matches) return;

    document.addEventListener('mousemove', (e) => {
        document.querySelectorAll('.tilt-card:not(.carousel-card)').forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            if (x > -50 && x < rect.width + 50 && y > -50 && y < rect.height + 50) {
                const rotateX = ((y - rect.height / 2) / (rect.height / 2)) * -10;
                const rotateY = ((x - rect.width / 2) / (rect.width / 2)) * 10;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
            } else {
                card.style.transform = `perspective(1000px) rotateX(0) rotateY(0) scale(1)`;
            }
        });
    });
}

// ================================
// FADE IN ON SCROLL
// ================================
function initFadeInSections() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-section').forEach(section => {
        observer.observe(section);
    });
}

// ================================
// NAVIGATION
// ================================
function initNavigation() {
    const navbar = document.getElementById('navbar');
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');
    const navBackdrop = document.querySelector('.nav-backdrop');

    // Scroll effect for glassmorphism navbar
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Hamburger menu toggle
    hamburger?.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        nav.classList.toggle('nav-active');
        // Prevent body scroll when menu is open
        document.body.style.overflow = nav.classList.contains('nav-active') ? 'hidden' : '';
    });

    // Close menu when clicking backdrop
    navBackdrop?.addEventListener('click', () => {
        hamburger?.classList.remove('active');
        nav?.classList.remove('nav-active');
        document.body.style.overflow = '';
    });
}

// ================================
// ACTIVE NAV TRACKING
// ================================
function initActiveNavTracking() {
    const sections = document.querySelectorAll('section[id], .hero, #news, #story');
    const navLinks = document.querySelectorAll('.nav-link[data-section]');

    if (navLinks.length === 0) return;

    const observerOptions = {
        root: null,
        rootMargin: '-20% 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const sectionId = entry.target.id || 'home';

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.section === sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    // Observe sections
    sections.forEach(section => {
        if (section.id) {
            observer.observe(section);
        }
    });

    // Also track hero section for home
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.dataset.section === 'home') {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }, { rootMargin: '-10% 0px -70% 0px' });

        heroObserver.observe(heroSection);
    }
}

// Scroll to section helper
function scrollToSection(id) {
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');

    hamburger?.classList.remove('active');
    nav?.classList.remove('nav-active');
    document.body.style.overflow = '';

    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Update active state immediately
    const navLinks = document.querySelectorAll('.nav-link[data-section]');
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.dataset.section === id) {
            link.classList.add('active');
        }
    });
}

// ================================
// CHARACTER CAROUSEL
// ================================
let currentIndex = 0;
const totalCards = 4;

function initCarousel() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.dot');
    const cards = document.querySelectorAll('.carousel-card');

    prevBtn?.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateCarousel();
    });

    nextBtn?.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalCards;
        updateCarousel();
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentIndex = parseInt(dot.dataset.index);
            updateCarousel();
        });
    });

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const idx = parseInt(card.dataset.index);
            if (idx !== currentIndex) {
                currentIndex = idx;
                updateCarousel();
            }
        });
    });

    updateCarousel();
}

function updateCarousel() {
    const cards = document.querySelectorAll('.carousel-card');
    const dots = document.querySelectorAll('.dot');
    const prevIndex = (currentIndex - 1 + totalCards) % totalCards;
    const nextIndex = (currentIndex + 1) % totalCards;

    cards.forEach((card, index) => {
        // Desktop classes
        card.classList.remove('d-visible', 'd-hidden');

        // Mobile classes
        card.classList.remove('m-active', 'm-next', 'm-prev', 'm-hidden');

        let order = 99;
        let isVisibleDesktop = false;

        if (index === prevIndex) {
            order = 1;
            isVisibleDesktop = true;
            card.classList.add('m-prev');
        } else if (index === currentIndex) {
            order = 2;
            isVisibleDesktop = true;
            card.classList.add('m-active');
        } else if (index === nextIndex) {
            order = 3;
            isVisibleDesktop = true;
            card.classList.add('m-next');
        } else {
            card.classList.add('m-hidden');
        }

        card.style.setProperty('--order', order);
        card.classList.add(isVisibleDesktop ? 'd-visible' : 'd-hidden');
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentIndex);
    });
}

// ================================
// MODALS
// ================================
function initModals() {
    // Close modals when clicking overlay
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });

    // Admin FAB
    document.getElementById('adminFab')?.addEventListener('click', () => {
        openAdminModal();
    });
}

function openModal(id) {
    document.getElementById(id)?.classList.add('active');
}

function closeModal(id) {
    document.getElementById(id)?.classList.remove('active');
}

function switchModal(fromId, toId) {
    closeModal(fromId);
    setTimeout(() => openModal(toId), 100);
}

// News Modal - supports both images and YouTube videos
function openNewsModal(post) {
    const mediaContainer = document.getElementById('newsModalMedia');
    const thumb = post.thumb || '';

    // Check if it's a YouTube URL
    const youtubeMatch = thumb.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/);

    if (youtubeMatch) {
        // Render YouTube embed
        const videoId = youtubeMatch[1];
        mediaContainer.innerHTML = `
            <iframe 
                src="https://www.youtube.com/embed/${videoId}?autoplay=0" 
                style="width: 100%; height: 100%; border: none;"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>`;
    } else if (thumb) {
        // Render image
        mediaContainer.innerHTML = `
            <img src="${thumb}" 
                style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;" 
                alt="Cover"
                onerror="this.src='https://via.placeholder.com/800x400?text=No+Image+Available'">`;
    } else {
        // Fallback placeholder
        mediaContainer.innerHTML = `
            <img src="https://via.placeholder.com/800x400?text=No+Media" 
                style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;" 
                alt="No media">`;
    }

    document.getElementById('newsModalVersion').textContent = post.version;
    document.getElementById('newsModalTitle').textContent = post.title;
    document.getElementById('newsModalBody').textContent = post.body;
    openModal('newsModal');
}

// Admin Modal
function openAdminModal(post = null) {
    const isEdit = post !== null;
    document.getElementById('adminModalTitle').textContent = isEdit ? 'Edit Update' : 'New Changelog';
    document.getElementById('newsSubmitBtn').textContent = isEdit ? 'Save Changes' : 'Post Update';

    document.getElementById('newsId').value = isEdit ? post.id : '';
    document.getElementById('newsTitle').value = isEdit ? post.title : '';
    document.getElementById('newsVersion').value = isEdit ? post.version : '';
    document.getElementById('newsThumb').value = isEdit ? post.thumb : '';
    document.getElementById('newsBody').value = isEdit ? post.body : '';

    openModal('adminModal');
}

function openEditModal(post) {
    openAdminModal(post);
}

// ================================
// AUTHENTICATION (Using CMS Admin Key)
// ================================
let cmsAdminKey = null; // Stored in memory only

function initAuth() {
    // Check if admin key is in session storage (for current tab)
    const storedKey = sessionStorage.getItem('cmsAdminKey');
    if (storedKey) {
        cmsAdminKey = storedKey;
        showCMSAdminUI();
    }

    // Admin FAB button handling - now opens CMS admin modal
    const adminFab = document.querySelector('.admin-fab');
    if (adminFab) {
        adminFab.addEventListener('click', () => {
            if (cmsAdminKey) {
                openModal('adminModal');
            } else {
                openModal('cmsAdminModal');
            }
        });
    }
}

// Verify CMS Admin Key
async function verifyCMSAdmin(e) {
    e.preventDefault();
    const key = document.getElementById('cmsAdminKey').value;
    const errorDiv = document.getElementById('cmsError');

    try {
        const response = await fetch(window.APP.baseURL + 'cms/verify', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ adminKey: key })
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.error || 'Invalid admin key');
        }

        // Store key in session storage (cleared when tab closes)
        cmsAdminKey = key;
        sessionStorage.setItem('cmsAdminKey', key);

        closeModal('cmsAdminModal');
        showCMSAdminUI();

        Swal.fire({
            icon: 'success',
            title: '🔓 CMS Access Granted',
            text: 'You can now manage news content.'
        });
    } catch (err) {
        errorDiv.textContent = err.message || 'Invalid admin key';
        errorDiv.style.display = 'block';
        document.getElementById('cmsLoginForm').style.animation = 'shake 0.3s';
        setTimeout(() => {
            document.getElementById('cmsLoginForm').style.animation = '';
        }, 300);
    }
}

// Show CMS admin UI elements
function showCMSAdminUI() {
    document.querySelectorAll('.cms-admin-only').forEach(el => {
        el.style.display = 'flex';
    });

    // Show admin FAB if hidden
    const adminFab = document.querySelector('.admin-fab');
    if (adminFab) {
        adminFab.style.display = 'flex';
    }
}

// Hide CMS admin UI elements
function hideCMSAdminUI() {
    document.querySelectorAll('.cms-admin-only').forEach(el => {
        el.style.display = 'none';
    });
}

// Logout from CMS admin
function logoutCMSAdmin() {
    cmsAdminKey = null;
    sessionStorage.removeItem('cmsAdminKey');
    hideCMSAdminUI();
    Swal.fire('Logged Out', 'CMS admin access revoked.', 'info');
}

// ================================
// NEWS CRUD (CMS API)
// ================================
async function submitNews(e) {
    e.preventDefault();

    if (!cmsAdminKey) {
        Swal.fire('Not Authorized', 'Please login with admin key first.', 'warning');
        openModal('cmsAdminModal');
        return;
    }

    const id = document.getElementById('newsId').value;
    const isEdit = id !== '';

    const data = {
        adminKey: cmsAdminKey,
        title: document.getElementById('newsTitle').value,
        version: document.getElementById('newsVersion').value,
        thumb: document.getElementById('newsThumb').value,
        body: document.getElementById('newsBody').value,
        date: new Date().toISOString().split('T')[0]
    };

    try {
        const url = isEdit
            ? `${window.APP.baseURL}cms/update/${id}`
            : `${window.APP.baseURL}cms/create`;

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Failed to save');
        }

        closeModal('adminModal');
        Swal.fire(
            isEdit ? 'Updated!' : 'Published!',
            isEdit ? 'Content has been modified.' : 'News has been published.',
            'success'
        ).then(() => location.reload());
    } catch (err) {
        Swal.fire('Error', err.message || 'Could not save content.', 'error');
    }
}

async function deleteNews(id) {
    if (!cmsAdminKey) {
        Swal.fire('Not Authorized', 'Please login with admin key first.', 'warning');
        openModal('cmsAdminModal');
        return;
    }

    const result = await Swal.fire({
        title: 'Delete permanently?',
        text: 'This will remove the content from the CMS.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff7675',
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`${window.APP.baseURL}cms/delete/${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ adminKey: cmsAdminKey })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Failed to delete');
            }

            Swal.fire('Deleted', 'Content removed from CMS', 'success')
                .then(() => location.reload());
        } catch (err) {
            Swal.fire('Error', err.message || 'Failed to delete content.', 'error');
        }
    }
}

// ================================
// NEWSLETTER
// ================================
function subscribeNewsletter() {
    const email = document.getElementById('newsletterEmail').value;
    if (!email) {
        Swal.fire('Oops!', 'Please enter your email.', 'warning');
        return;
    }
    Swal.fire('Awesome!', "You're on the list.", 'success');
    document.getElementById('newsletterEmail').value = '';
}

