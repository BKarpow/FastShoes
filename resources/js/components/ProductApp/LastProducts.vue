<template>
    <div id="lastProductSlider">
        <div class="load-area" v-if="process">
            <Spiner />
        </div>
        <!-- /.load-area -->
        <div class="slider" v-show="!process">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div
                        class="swiper-slide product-image"
                        v-for="product in products"
                        :key="product.id"
                    >
                        <Product :product="product" />
                    </div>
                </div>
            </div>
        </div>
        <!-- /.slider -->
    </div>
    <!-- /#lastProductSlider -->
</template>

<script>
// Import Swiper Vue.js components
import Swiper, { Autoplay, FreeMode } from "swiper";
import Product from "./Product.vue";
import Spiner from "./../Spiner.vue";
import "swiper/css";
import "swiper/css/autoplay";

export default {
    name: "LastProducts",
    components: {
        Product,
        Spiner
    },
    data() {
        return {
            products: [],
            process: false,
            loop: true,
            swiperOptions: {
                modules: [Autoplay, FreeMode],
                speed: 800,
                spaceBetween: 10,
                // slidesPerView: "auto",
                loop: true,
                // loopedSlides: 50,
                breakpoints: {
                    320: {
                        slidesPerView: 1
                    },
                    400: {
                        slidesPerView: 2
                    },
                    760: {
                        slidesPerView: 3
                    }
                },
                autoplay: {
                    delay: 3000
                },
                freeMode: {
                    enabled: true,
                    sticky: true
                }
            }
        };
    },
    methods: {
        fetchLastProducts() {
            this.process = true;
            axios.get("/api/product/last").then(r => {
                if (r.status === 200 && r.data.message == null) {
                    this.products = r.data.data;
                    this.process = false;
                    this.initSwiper();
                } else {
                    console.error("error fetch last product", r);
                }
            });
        },
        initSwiper() {
            return new Swiper(".swiper", this.swiperOptions);
        }
    },
    mounted() {
        this.fetchLastProducts();
    },
    updated() {
        this.initSwiper();
    }
};
</script>

<style scoped>
.load-area {
    width: 100% !important;
    height: 100% !important;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
