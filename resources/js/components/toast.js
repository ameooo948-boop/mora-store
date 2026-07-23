export function showToast(message, type = 'success') {

    const toast = document.createElement('div');

    toast.className =
        `toast align-items-center text-bg-${type} border-0 show position-fixed`;

    toast.style.top = '20px';

    toast.style.right = '20px';

    toast.style.zIndex = '9999';

    toast.innerHTML = `

        <div class="d-flex">

            <div class="toast-body">

                ${message}

            </div>

            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto">
            </button>

        </div>

    `;

    document.body.appendChild(toast);

    toast.querySelector('.btn-close')
        .addEventListener('click', () => toast.remove());

    setTimeout(() => {

        toast.remove();

    }, 3000);

}