<template>
    <div class="product" @click="goToProduct(product.uri)">
        <div class="product__image">
            <img :src="product.image_1.uri" alt="" />
        </div>
        <div class="product__title pl-2">
            <h3>{{ product.title }}</h3>
            <star-rating
                v-if="isRating"
                :read-only="true"
                :increment="0.1"
                :show-rating="true"
                :inline="true"
                :star-size="24"
                :rating="rating"
            />
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
import StarRating from "vue-star-rating";
export default {
    name: "Product",
    components: {
        StarRating
    },
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
    computed: {
        isRating() {
            if (!this.product.hasOwnProperty("rating")) {
                return false;
            }
            if (this.product.rating > 0) {
                return true;
            }
            return false;
        },
        rating() {
            return this.product.rating;
        }
    },
    methods: {
        goToProduct(u) {
            window.location.href = u;
        }
    }
};
</script>
