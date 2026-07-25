import { showToast } from '../../components/toast.js';
import { confirmAction } from '../../components/confirm';

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

document.addEventListener('DOMContentLoaded', () => {

    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.content;

    // ===========================
    // Update Quantity
    // ===========================

    document.querySelectorAll('.cart-update-form').forEach(form => {

        const input = form.querySelector('.quantity-input');
        const increase = form.querySelector('.increase-btn');
        const decrease = form.querySelector('.decrease-btn');

        const row = form.closest('tr');
        const rowTotal = row.querySelector('.row-total');

        const submit = async (quantity, previousValue) => {

            input.value = quantity;

            try {

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: (() => {

                        const data = new FormData();

                        data.append('_method', 'PUT');
                        data.append('quantity', quantity);

                        return data;

                    })(),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message ?? 'Something went wrong.'
                    );

                }

                rowTotal.textContent = `$${data.itemTotal}`;

                document.getElementById('summary-items').textContent =
                    data.summary.items;

                document.getElementById('summary-quantity').textContent =
                    data.summary.quantity;

                document.getElementById('summary-subtotal').textContent =
                    `$${data.summary.subtotal}`;

                document.getElementById('summary-total').textContent =
                    `$${data.summary.total}`;

                const cartCount = document.getElementById('cartCount');

                if (cartCount) {
                    cartCount.textContent = data.cartCount;
                }

                showToast(data.message);

            } catch (error) {

                input.value = previousValue;

                showToast(error.message, 'danger');

            }

        };

        increase.addEventListener('click', () => {

            const current = parseInt(input.value);
            const max = parseInt(input.max);

            if (current >= max) {

                showToast(
                    'Maximum available quantity reached.',
                    'warning'
                );

                return;

            }

            submit(current + 1, current);

        });

        decrease.addEventListener('click', () => {

            const current = parseInt(input.value);

            if (current <= 1) {
                return;
            }

            submit(current - 1, current);

        });

    });

    // ===========================
    // Remove Item
    // ===========================

    document.querySelectorAll('.remove-item-form').forEach(form => {

        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            const confirmed = await confirmAction(
                'Remove Product',
                'Are you sure you want to remove this product?',
                'Remove'
            );

            if (!confirmed) {
                return;
            }

            const row = form.closest('tr');

            try {

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: (() => {

                        const data = new FormData();

                        data.append('_method', 'DELETE');

                        return data;

                    })(),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message ?? 'Something went wrong.'
                    );

                }

                row.remove();

                document.getElementById('summary-items').textContent =
                    data.summary.items;

                document.getElementById('summary-quantity').textContent =
                    data.summary.quantity;

                document.getElementById('summary-subtotal').textContent =
                    `$${data.summary.subtotal}`;

                document.getElementById('summary-total').textContent =
                    `$${data.summary.total}`;

                const cartCount = document.getElementById('cartCount');

                if (cartCount) {
                    cartCount.textContent = data.cartCount;
                }

                showToast(data.message);

            } catch (error) {

                showToast(error.message, 'danger');

            }

        });

    });

    // ===========================
    // Clear Cart
    // ===========================

    document.querySelector('.clear-cart-form')?.addEventListener('submit', async (e) => {

        e.preventDefault();

        const confirmed = await confirmAction(
            'Clear Cart',
            'All products will be removed from your cart.',
            'Clear'
        );

        if (!confirmed) {
            return;
        }

        const form = document.querySelector('.clear-cart-form');

        if (!form) {
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'DELETE');

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: formData,
        });

        try {
            const formData = new FormData();

            formData.append('_method', 'DELETE');

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

            document.querySelectorAll('.cart-row').forEach(row => {
                row.remove();
            });

            document.getElementById('summary-items').textContent = 0;

            document.getElementById('summary-quantity').textContent = 0;

            document.getElementById('summary-subtotal').textContent = '$0.00';

            document.getElementById('summary-total').textContent = '$0.00';

            const cartCount = document.getElementById('cartCount');

            if (cartCount) {
                cartCount.textContent = 0;
            }

            const tbody = document.querySelector('tbody');

            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <h4>Your cart is empty</h4>
                        <a href="/products" class="btn btn-primary mt-3">
                            Continue Shopping
                        </a>
                    </td>
                </tr>
            `;

            showToast(data.message);

        } catch (error) {

            showToast(error.message, 'danger');

        }

    });

});