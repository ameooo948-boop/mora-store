import { showToast } from '../../components/toast';

document.querySelectorAll('.wishlist-form').forEach(form => {

    form.addEventListener('submit', async function (e) {

        e.preventDefault();

        const button = this.querySelector('button');

        const icon = button.querySelector('i');

        try {

            const response = await fetch(this.action, {

                method: 'POST',

                headers: {

                    'Accept': 'application/json',

                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content,

                },

                body: new FormData(this),

            });

            const data = await response.json();

            if (!data.success) {

                showToast(data.message, 'danger');

                return;

            }

            icon.classList.toggle('bi-heart');

            icon.classList.toggle('bi-heart-fill');

            button.classList.toggle('btn-outline-danger');

            button.classList.toggle('btn-danger');

            showToast(data.message);

        } catch (error) {

            showToast(
                'Something went wrong.',
                'danger'
            );

        }

    });

});