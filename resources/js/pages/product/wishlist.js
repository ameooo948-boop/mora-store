import { showToast } from '../../components/toast';

document.querySelectorAll('.wishlist-form').forEach((form) => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const button = this.querySelector('button');
        const icon = button?.querySelector('i');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!button || !icon || !csrfToken) {
            showToast('Unable to process your request.', 'danger');
            return;
        }

        // Prevent multiple requests
        if (button.disabled) {
            return;
        }

        const originalHTML = button.innerHTML;

        try {
            button.disabled = true;
            button.classList.add('wishlist-loading');

            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(this),
            });

            // Handle non-JSON / HTTP errors
            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`);
            }

            const data = await response.json();

            if (!data.success) {
                showToast(
                    data.message || 'Unable to update your wishlist.',
                    'danger'
                );

                return;
            }

            // Update wishlist state
            const isAdded = data.added ?? icon.classList.contains('bi-heart');

            icon.classList.toggle('bi-heart', !isAdded);
            icon.classList.toggle('bi-heart-fill', isAdded);

            button.classList.toggle('btn-outline-danger', !isAdded);
            button.classList.toggle('btn-danger', isAdded);

            // Small visual feedback
            button.classList.add('wishlist-updated');

            setTimeout(() => {
                button.classList.remove('wishlist-updated');
            }, 250);

            showToast(
                data.message || 'Wishlist updated successfully.'
            );

        } catch (error) {
            console.error('Wishlist Error:', error);

            showToast(
                'Something went wrong. Please try again.',
                'danger'
            );

        } finally {
            button.disabled = false;
            button.classList.remove('wishlist-loading');
        }
    });
});