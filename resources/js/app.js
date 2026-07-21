import './bootstrap';

document.querySelectorAll('.delete-image-btn').forEach(button => {

    button.addEventListener('click', function () {

        if (!confirm('Delete this image?')) {
            return;
        }

        const form = document.getElementById('delete-image-form');

        form.action = this.dataset.url;

        form.submit();

    });

});