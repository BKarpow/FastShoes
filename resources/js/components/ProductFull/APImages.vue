<template>
    <div id="updateCategory" class="c-pallet">
        <div class="btn-panel">
            <div @click="showForm = !showForm" class="pointer">
                <span class="btn-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="svg-icon bi bi-image"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                        />
                        <path
                            d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"
                        />
                    </svg>
                </span>
                <!-- /.btn-icon -->
                <span class="btn-text">
                    {{ btnText }}
                </span>
                <!-- /.btn-text -->
            </div>
            <div class="formChange" v-if="showForm">
                <div class="mt-2">
                    <h4>Изображения Товара</h4>
                </div>
                <!-- /.mt-2 -->

                <div class="form-group py-1">
                    <ImageUploadBox
                        @upload:index="onLoaded"
                        :image-index="1"
                        :image-self="imageSelfOne"
                    />
                    <ImageUploadBox
                        @upload:index="onLoaded"
                        :image-index="2"
                        :image-self="imageSelfTwo"
                    />
                    <ImageUploadBox
                        @upload:index="onLoaded"
                        :image-index="3"
                        :image-self="imageSelfThree"
                    />
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.formChange -->
        </div>
        <!-- /.btn-secondary -->
    </div>
    <!-- /#updateCategory -->
</template>

<script>
import Swal from "sweetalert2";
import ImageUploadBox from "./../Image/LoadItemImage.vue";
export default {
    name: "APImages",
    props: {
        imageSelfThree: {
            type: Object,
            default: () => {
                return {};
            }
        },
        imageSelfTwo: {
            type: Object,
            default: () => {
                return {};
            }
        },
        imageSelfOne: {
            type: Object,
            default: () => {
                return {};
            }
        },
        productId: {
            type: Number
        }
    },
    components: {
        ImageUploadBox
    },
    data() {
        return {
            showForm: false,
            imageOne: {},
            imageTwo: {},
            imageThree: {}
        };
    },
    computed: {
        btnText() {
            return this.showForm ? "Закрыть форму." : "Фото товара.";
        },
        formData() {
            return {
                imageOne: this.imageOne,
                imageTwo: this.imageTwo,
                imageThree: this.imageThree,
                productId: this.productId
            };
        }
    },
    methods: {
        onLoaded(image) {
            if (image.index === 1 && image.data.hasOwnProperty("uri")) {
                this.imageOne = image.data.uri;
            }
            if (image.index === 2 && image.data.hasOwnProperty("uri")) {
                this.imageTwo = image.data.uri;
            }
            if (image.index === 3 && image.data.hasOwnProperty("uri")) {
                this.imageThree = image.data.uri;
            }
            this.doSave();
        },
        doSave() {
            axios.put("/admin/product/images", this.formData).then(r => {
                if (r.status === 200 && r.data != null) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error("Error update this product", r.data);
                    } else {
                        Swal.fire({
                            title: "Названия, цена - обновлены",
                            icon: "success"
                        });
                        this.showForm = false;
                        // this.$emit("success");
                    }
                } else {
                    console.error("Error network", r);
                }
            });
        }
    },
    mounted() {
        // this.fetchCategories();
    }
};
</script>
