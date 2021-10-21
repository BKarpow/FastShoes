<template>
    <div id="updateCategory" class="c-pallet">
        <div class="btn-panel">
            <div @click="showForm = !showForm" class="pointer">
                <span class="btn-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="svg-icon bi bi-tools"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"
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
                    <h4>Названия, цена.</h4>
                </div>
                <!-- /.mt-2 -->

                <div class="form-group py-1">
                    <label for="nameUpdate">Названия</label>
                    <input
                        type="text"
                        id="nameUpdate"
                        class="form-control"
                        v-model="title"
                    />
                </div>
                <!-- /.form-group -->
                <div class="form-group py-1">
                    <label for="priceUpdate">Цена</label>
                    <input
                        type="text"
                        id="priceUpdate"
                        class="form-control col-6"
                        v-model="price"
                    />
                </div>
                <!-- /.form-group -->
                <div class="form-group pt-1">
                    <button @click.once="doSave" class="btn btn-success">
                        Сохранить
                    </button>
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
import vSelect from "vue-select";
export default {
    name: "APTitlePrice",
    props: {
        titleProduct: {
            type: String
        },
        priceProduct: {
            type: String
        },
        productId: {
            type: Number
        }
    },
    components: {
        vSelect
    },
    data() {
        return {
            title: this.titleProduct,
            price: this.priceProduct,
            showForm: false
        };
    },
    computed: {
        btnText() {
            return this.showForm ? "Закрыть форму." : "Названия, цена.";
        },
        formData() {
            return {
                title: this.title,
                price: this.price,
                productId: this.productId
            };
        }
    },
    methods: {
        doSave() {
            axios.put("/admin/product/title-price", this.formData).then(r => {
                if (r.status === 200 && r.data != null) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error("Error update this product", r.data);
                    } else {
                        Swal.fire({
                            title: "Названия, цена - обновлены",
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
    },
    mounted() {
        // this.fetchCategories();
    }
};
</script>
