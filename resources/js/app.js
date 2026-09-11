import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Mobile Menu
    |--------------------------------------------------------------------------
    */

    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Navbar Scroll
    |--------------------------------------------------------------------------
    */

    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        if (!navbar) return;

        if (window.scrollY > 30) {
            navbar.classList.add(
                'bg-white/90',
                'backdrop-blur-xl',
                'shadow-sm'
            );

            navbar.classList.remove('bg-transparent');
        } else {
            navbar.classList.remove(
                'bg-white/90',
                'backdrop-blur-xl',
                'shadow-sm'
            );

            navbar.classList.add('bg-transparent');
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Scroll Reveal
    |--------------------------------------------------------------------------
    */

    const revealElements = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        },
        {
            threshold: 0.12,
        }
    );

    revealElements.forEach((element) => {
        observer.observe(element);
    });


    /*
    |--------------------------------------------------------------------------
    | Back To Top
    |--------------------------------------------------------------------------
    */

    const backToTop = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
        if (!backToTop) return;

        if (window.scrollY > 500) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none');
            backToTop.classList.remove('opacity-100');
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Gallery Lightbox
    |--------------------------------------------------------------------------
    */

    const galleryItems = document.querySelectorAll('[data-gallery]');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxClose = document.getElementById('lightbox-close');

    galleryItems.forEach((item) => {
        item.addEventListener('click', () => {
            const image = item.getAttribute('data-gallery');

            if (!lightbox || !lightboxImage) return;

            lightboxImage.src = image;

            lightbox.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    const closeLightbox = () => {
        if (!lightbox) return;

        lightbox.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightbox) {
        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
    }

});