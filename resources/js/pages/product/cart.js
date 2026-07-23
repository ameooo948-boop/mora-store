import { showToast } from '../../components/toast';

const cartForm = document.getElementById('addToCartForm');

if (cartForm) {

    cartForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const button = document.getElementById('addToCartButton');

        const original = button.innerHTML;

        button.disabled = true;

        button.innerHTML = 'Adding...';

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

            if (data.success) {

                const cartCount = document.getElementById('cartCount');

                if (cartCount) {

                    cartCount.textContent = data.cartCount;

                }

                showToast(data.message);

            } else {

                showToast(data.message, 'danger');

            }

        } catch (error) {

            showToast(
                'Something went wrong.',
                'danger'
            );

        } finally {

            button.disabled = false;

            button.innerHTML = original;

        }

    });

}