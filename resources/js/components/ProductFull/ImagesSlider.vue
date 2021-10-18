<template>
    <div class="slider">
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div
                    class="swiper-slide product-image"
                    v-for="image in imageNotNull"
                    :key="image.id"
                >
                    <div class="swiper-zoom-container">
                        <img
                            class="img-fluid"
                            :src="image.uri"
                            :alt="image.name"
                        />
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <!-- /.slider -->
</template>

<script>
// Import Swiper Vue.js components
import Swiper, { Navigation, Pagination, Zoom } from "swiper";
import "swiper/css";

export default {
    props: {
        productId: {
            require: true
        }
    },
    data() {
        return {
            images: [],
            swiper: "",
            swiperConfig: {
                modules: [Navigation, Pagination, Zoom],
                speed: 400,
                spaceBetween: 100,
                loop: true,
                zoom: {
                    maxRatio: 5
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    renderBullet: (index, className) => {
                        console.log("Swiper paginate init:", index, className);
                        return (
                            '<img class="' +
                            className +
                            '" src="' +
                            this.imageNotNull[index].uri +
                            '" width="100">'
                        );
                    }
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                }
            }
        };
    },
    computed: {
        isManyImages() {
            return this.imageNotNull.length > 1;
        },
        imageNotNull() {
            return this.images.filter(i => i !== null);
        }
    },
    methods: {
        fetchImages() {
            axios.get(`/api/product/${this.productId}/images`).then(resp => {
                if (resp.status == 200) {
                    this.images = resp.data.data;
                    this.initSwiper();
                }
            });
        },
        initSwiper() {
            this.swiper = new Swiper(".swiper", this.swiperConfig);
            console.log(this.swiper);
        }
    },
    mounted() {
        this.fetchImages();
    }
};
</script>

<style>
.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
}
.swiper-pagination {
    display: flex;
    align-items: center;
    column-gap: 0.7rem;
    margin-top: 0.7rem;
    margin-bottom: 0.7rem;
}
.swiper-pagination-bullet {
    display: block;
    width: 100px !important;
    border-radius: 6px;
    opacity: 0.4;
    transition: all 0.8s;
}
.swiper-pagination-bullet-active {
    border: 1px solid #28a745;
    opacity: 1;
}
</style>
