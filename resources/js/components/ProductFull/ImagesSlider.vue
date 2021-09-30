<template>
    <div class="slider">
        <div class="swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
          <!-- Slides -->
          <div 
          class="swiper-slide product-image"
          v-for="image in imageNotNull" :key="image.id"
          >
            <img class="img-fluid" :src="image.uri" :alt="image.name" />
          </div>
        </div>

        <prompt  v-if="isManyImages">
          <p>Свайпай для перегляду фото</p>
        </prompt>
        <!-- /.swipe-alert -->
      </div>
    </div>
    <!-- /.slider -->
</template>

<script>
  // Import Swiper Vue.js components
  import Swiper from 'swiper'
  import 'swiper/css';
import Swal from 'sweetalert2';

export default {
    props:{
        productId:{
            require: true,
        },
    },
    data() {
      return {
        images:[],
        swiper: '',
        swiperConfig: {
          speed: 400,
          spaceBetween: 100,
        }
      }
    },
    computed:{
      isManyImages(){
        return this.imageNotNull.length > 1;
      },
      imageNotNull(){
        return this.images.filter(i => i !== null)
      },
    },
    methods:{
      fetchImages(){
        axios.get(`/api/product/${this.productId}/images`)
        .then(resp => {
          if (resp.status == 200) {
            this.images = resp.data.data;
          }
        })
      },
      initSwiper(){
        this.swiper = new Swiper('.swiper', this.swiperConfig);
      },
    },
    updated(){
      this.initSwiper();
    },
    mounted(){
      this.fetchImages();
    }
}
</script>