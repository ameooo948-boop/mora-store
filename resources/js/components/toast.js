export function showToast(message, type = 'success') {

    // =====================================================
    // TOAST CONFIG
    // =====================================================

    const config = {
        success: {
            icon: 'bi-check-circle-fill',
            title: 'Success',
            className: 'toast-success'
        },

        error: {
            icon: 'bi-x-circle-fill',
            title: 'Error',
            className: 'toast-error'
        },

        warning: {
            icon: 'bi-exclamation-triangle-fill',
            title: 'Warning',
            className: 'toast-warning'
        },

        info: {
            icon: 'bi-info-circle-fill',
            title: 'Information',
            className: 'toast-info'
        }
    };

    const current = config[type] ?? config.success;


    // =====================================================
    // TOAST
    // =====================================================

    const toast = document.createElement('div');

    toast.className = `app-toast ${current.className}`;

    toast.setAttribute('role', 'alert');

    toast.innerHTML = `

        <div class="app-toast-icon">
            <i class="bi ${current.icon}"></i>
        </div>

        <div class="app-toast-content">

            <strong class="app-toast-title">
                ${current.title}
            </strong>

            <span class="app-toast-message">
                ${message}
            </span>

        </div>

        <button
            type="button"
            class="app-toast-close"
            aria-label="Close">

            <i class="bi bi-x"></i>

        </button>

        <div class="app-toast-progress"></div>

    `;


    // =====================================================
    // CONTAINER
    // =====================================================

    let container = document.querySelector('.app-toast-container');

    if (!container) {

        container = document.createElement('div');

        container.className = 'app-toast-container';

        document.body.appendChild(container);
    }


    container.appendChild(toast);


    // =====================================================
    // CLOSE
    // =====================================================

    const removeToast = () => {

        if (toast.classList.contains('is-removing')) {
            return;
        }

        toast.classList.add('is-removing');

        setTimeout(() => {

            toast.remove();

            if (container.children.length === 0) {
                container.remove();
            }

        }, 300);

    };


    toast
        .querySelector('.app-toast-close')
        .addEventListener('click', removeToast);


    // =====================================================
    // AUTO CLOSE
    // =====================================================

    const timeout = setTimeout(removeToast, 4000);


    // =====================================================
    // PAUSE ON HOVER
    // =====================================================

    toast.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
    });

}