const quantity = document.getElementById('quantity');

if (quantity) {

    const increase = document.getElementById('increaseQuantity');

    const decrease = document.getElementById('decreaseQuantity');

    const max = parseInt(quantity.max);

    increase.addEventListener('click', () => {

        if (+quantity.value < max) {

            quantity.value++;

        }

    });

    decrease.addEventListener('click', () => {

        if (+quantity.value > 1) {

            quantity.value--;

        }

    });

}