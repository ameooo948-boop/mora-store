import { showToast } from '../../components/toast.js';
import { confirmAction } from '../../components/confirm';

const cartForm = document.getElementById('addToCartForm');


// =====================================================
// Add To Cart
// =====================================================

if (cartForm) {

    cartForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const button = document.getElementById('addToCartButton');

        if (!button) {
            return;
        }

        const original = button.innerHTML;

        button.disabled = true;
        button.innerHTML = 'Adding...';

        try {

            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.content;

            const response = await fetch(this.action, {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },

                body: new FormData(this),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ?? 'Something went wrong.'
                );

            }

            const cartCount = document.getElementById('cartCount');

            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }

            showToast(data.message);

        } catch (error) {

            showToast(
                error.message ?? 'Something went wrong.',
                'danger'
            );

        } finally {

            button.disabled = false;
            button.innerHTML = original;

        }

    });

}


document.addEventListener('DOMContentLoaded', () => {

    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.content;

    document.querySelectorAll('.cart-update-form').forEach(form => {

        const input = form.querySelector('.quantity-input');
        const increase = form.querySelector('.increase-btn');
        const decrease = form.querySelector('.decrease-btn');

        if (!input || !increase || !decrease) {
            return;
        }

        const row = form.closest('.cart-product-row');
        const rowTotal = row?.querySelector('.row-total');

        async function updateQuantity(quantity, previousValue) {

            input.value = quantity;

            try {

                const formData = new FormData();

                formData.append('_method', 'PUT');
                formData.append('quantity', quantity);

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ?? 'Something went wrong.'
                    );
                }

                if (rowTotal) {
                    rowTotal.innerHTML = `
                        ${data.itemTotal}
                        <small>${data.currency ?? ''}</small>
                    `;
                }

                document.getElementById('summary-items').textContent =
                    data.summary.items;

                document.getElementById('summary-quantity').textContent =
                    data.summary.quantity;

                document.getElementById('summary-subtotal').textContent =
                    `${data.summary.subtotal} ${data.currency ?? ''}`;

                document.getElementById('summary-total').innerHTML =
                    `${data.summary.total}
                    <small>${data.currency ?? ''}</small>`;

                const cartCount =
                    document.getElementById('cartCount');

                if (cartCount) {
                    cartCount.textContent = data.cartCount;
                }

                showToast(data.message);

            } catch (error) {

                input.value = previousValue;

                showToast(
                    error.message ?? 'Something went wrong.',
                    'danger'
                );

            }

        }

        increase.addEventListener('click', () => {

            const current = parseInt(input.value, 10);
            const max = parseInt(input.max, 10);

            if (Number.isNaN(current)) {
                return;
            }

            if (current >= max) {

                showToast(
                    'Maximum available quantity reached.',
                    'warning'
                );

                return;
            }

            updateQuantity(current + 1, current);

        });

        decrease.addEventListener('click', () => {

            const current = parseInt(input.value, 10);

            if (Number.isNaN(current)) {
                return;
            }

            if (current <= 1) {
                return;
            }

            updateQuantity(current - 1, current);

        });

    });

});