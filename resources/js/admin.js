import './bootstrap';

import './admin/index';

document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.getElementById('adminSidebarToggle');
    const overlay = document.getElementById('adminSidebarOverlay');

    if (!sidebar || !toggle || !overlay) {
        return;
    }

    const openSidebar = () => {

        sidebar.classList.add('mobile-open');
        overlay.classList.add('mobile-visible');

        toggle.setAttribute('aria-expanded', 'true');

        document.body.style.overflow = 'hidden';
    };


    const closeSidebar = () => {

        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('mobile-visible');

        toggle.setAttribute('aria-expanded', 'false');

        document.body.style.overflow = '';
    };


    toggle.addEventListener('click', () => {

        if (sidebar.classList.contains('mobile-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }

    });


    overlay.addEventListener('click', closeSidebar);


    // Close after clicking a sidebar link on mobile

    sidebar.querySelectorAll('a').forEach(link => {

        link.addEventListener('click', () => {

            if (window.innerWidth <= 991) {
                closeSidebar();
            }

        });

    });


    // Reset when returning to desktop

    window.addEventListener('resize', () => {

        if (window.innerWidth > 991) {
            closeSidebar();
        }

    });

});