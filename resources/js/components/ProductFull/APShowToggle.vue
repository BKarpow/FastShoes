<template>
    <div id="updateCategory" class="c-pallet">
        <div class="btn-panel red">
            <div @click="doSave" class="pointer">
                <span class="btn-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="svg-icon bi bi-eye-slash-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"
                        />
                        <path
                            d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"
                        />
                    </svg>
                </span>
                <!-- /.btn-icon -->
                <span class="btn-text">
                    {{ btnText }}
                </span>
                <!-- /.btn-text -->
            </div>
        </div>
        <!-- /.btn-secondary -->
    </div>
    <!-- /#updateCategory -->
</template>

<script>
import Swal from "sweetalert2";
import vSelect from "vue-select";
export default {
    name: "APShowToggle",
    props: {
        productId: {
            type: Number
        }
    },

    data() {
        return {};
    },
    computed: {
        btnText() {
            return this.showForm ? "Показать товар." : "Скрыть товар.";
        },
        formData() {
            return {
                productId: this.productId
            };
        }
    },
    methods: {
        doSave() {
            axios.put("/admin/product/show", this.formData).then(r => {
                if (r.status === 200 && r.data != null) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error("Error update this product", r.data);
                    } else {
                        Swal.fire({
                            title:
                                "Товар скрыть, можно восстановить через админку",
                            icon: "success"
                        });
                        this.showForm = false;
                        this.$emit("success");
                    }
                } else {
                    console.error("Error network", r);
                }
            });
        }
    }
};
</script>
