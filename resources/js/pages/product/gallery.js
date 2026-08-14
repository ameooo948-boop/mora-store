const mainImage = document.getElementById('mainImage');

if (mainImage) {

    document.querySelectorAll('.product-thumbnail').forEach((thumbnail) => {
        thumbnail.addEventListener('click', function () {
            const mainImage = document.getElementById('mainImage');

            if (!mainImage) {
                return;
            }

            const imageUrl = this.dataset.image;

            if (!imageUrl) {
                return;
            }

            mainImage.src = imageUrl;

            document
                .querySelectorAll('.product-thumbnail')
                .forEach((item) => item.classList.remove('active'));

            this.classList.add('active');
        });
    });

}