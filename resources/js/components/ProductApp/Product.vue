<template>
    <div class="product" @click="goToProduct(product.uri)">
        <div class="product__image">
            <img :src="product.image_1.uri" alt="" />
        </div>
        <div class="product__title">
            <h3>{{ product.title }}</h3>
        </div>
        <div class="product__link">
            <a :href="product.uri">
                Купить
            </a>
        </div>
        <div class="product__price">
            <span>{{ product.price }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Product",
    props: {
        product: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            //   product:{
            //     image: 'http://localhost/storage/files/2/swtq8EzeLcDee6S21d9SjpSYzSP2HBLkQDW0HIhX.jpg',
            //     title: 'Кросівки тест тест',
            //     price: 870,
            //     id: 1,
            //     uri: '',
            //   }
        };
    },
    methods: {
        goToProduct(u) {
            window.location.href = u;
        }
    }
};
</script>
