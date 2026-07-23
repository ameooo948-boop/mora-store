const mainImage = document.getElementById('mainImage');

if (mainImage) {

    const thumbnails = document.querySelectorAll('.thumbnail-image');

    thumbnails.forEach(image => {

        image.addEventListener('click', function () {

            mainImage.src = this.dataset.image;

            thumbnails.forEach(img => img.classList.remove('active'));

            this.classList.add('active');

        });

    });

    if (thumbnails.length) {

        thumbnails[0].classList.add('active');

    }

}