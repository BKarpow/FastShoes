<template>
    <div id="products">
        <CreateProduct @create="fetchProducts" />
        <div class="productsList">
            <div v-if="isEmptyProducts" class="alert alert-success my-2">
                <strong>Немає тут товарів, створіть новий ... :(</strong>
            </div>
            <!-- /.alert alert-success -->

            <table
                v-if="!isEmptyProducts"
                class="table table-responsive table-dark table-hover"
            >
                <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Опис</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in productData" :key="product.id">
                        <td class="productImg">
                            <img
                                :src="product.image_1.uri"
                                alt=""
                                class=" img-thumbnail productImg"
                            />
                        </td>
                        <td>
                            <h5>
                                {{ product.title }} ({{
                                    product.sectionName
                                }}
                                -> {{ product.categoryName }})
                            </h5>
                            <h6 @click="updatePrice(product.id, product.price)">
                                {{ product.price | price }}
                                <IconEdit />
                            </h6>
                            <div class="controlPanel btn-group">
                                <button
                                    @click="destroyProduct(product.id)"
                                    class="btn-warning btn-sm"
                                >
                                    <IconTrash />
                                </button>
                                <!-- /.btn-outline-warning btn-sm -->
                                <a
                                    :href="
                                        `/home/product/${product.id}/edit-page`
                                    "
                                    class="btn btn-secondary btn-sm"
                                >
                                    <IconFullEdit />
                                </a>
                                <button
                                    class="btn-primary btn-sm"
                                    @click="showToggle(product.id)"
                                >
                                    <IconEye v-if="product.show" />
                                    <IconCloseEye v-if="!product.show" />
                                </button>
                                <!-- /.btn-outline-primary btn-sm -->
                            </div>
                            <!-- /.controlPanel btn-group -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /.table table-dark table-hover -->
            <paginate-box
                @go:page="fetchProducts"
                :itemsPaginate="products"
                v-if="isProductLoaded"
            />
        </div>
        <!-- /.productsList -->
    </div>
    <!-- /#products -->
</template>

<script>
import Swal from "sweetalert2";
import CreateProduct from "./Create.vue";
import PaginateBox from "./../../ui/element/PaginateBox.vue";
import IconTrash from "./../../ui/icons/IconTrash.vue";
import IconEdit from "./../../ui/icons/IconEdit.vue";
import IconFullEdit from "./../../ui/icons/IconFullEdit.vue";
import IconEye from "./../../ui/icons/IconEye.vue";
import IconCloseEye from "./../../ui/icons/IconCloseEye.vue";

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

export default {
    components: {
        CreateProduct,
        PaginateBox,
        IconTrash,
        IconEdit,
        IconFullEdit,
        IconEye,
        IconCloseEye
    },
    data() {
        return {
            products: []
        };
    },
    filters: {
        price(i) {
            return `${i} грн.`;
        }
    },
    computed: {
        productData() {
            if (this.isProductLoaded) {
                return this.products.data;
            } else {
                return [];
            }
        },
        isProductLoaded() {
            if (
                typeof this.products === "object" &&
                this.products.hasOwnProperty("data") &&
                this.products.data.length > 0
            ) {
                return true;
            } else {
                return false;
            }
        },
        isEmptyProducts() {
            if (
                typeof this.products === "object" &&
                this.products.hasOwnProperty("data") &&
                this.products.data.length === 0
            ) {
                return true;
            } else {
                return false;
            }
        }
    },

    methods: {
        updatePrice(productId, oldPrice) {
            let newPrice;
            Swal.fire({
                title: "Нова ціна товару?",
                input: "tel",
                inputLabel: "Вкажіть ціну",
                inputValue: oldPrice,
                showCancelButton: true,
                inputValidator: value => {
                    if (!value) {
                        return "Зазвичай ціна складаєтся із цифр.";
                    }
                }
            }).then(r => {
                newPrice = r.value;
                route("product.update.price", { id: productId }).then(resp => {
                    axios.put(resp.data, { newPrice: newPrice }).then(r => {
                        console.log("Price updated", r.data);
                        this.fetchProducts();
                    });
                });
            });
        },
        destroyProduct(productId) {
            swalWithBootstrapButtons
                .fire({
                    title: "Ви впевнені?",
                    text: "Товар буде видалено повністю!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Так, видаляй це!",
                    cancelButtonText: "Ні, я передумав!",
                    reverseButtons: true
                })
                .then(result => {
                    if (result.isConfirmed) {
                        route("product.destroy", { product: productId }).then(
                            r => {
                                axios.delete(r.data).then(r => {
                                    console.log(r);
                                    if (r.status === 200) {
                                        swalWithBootstrapButtons.fire(
                                            "Видалено!",
                                            "Ваш товар пішов на упокой!.",
                                            "success"
                                        );
                                    }
                                });
                            }
                        );
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        );
                    }
                });
        },
        showToggle(productId) {
            route("product.update.show", { product: productId }).then(uri => {
                axios.put(uri.data).then(resp => {
                    if (resp.status === 200) {
                        this.fetchProducts();
                    }
                });
            });
        },
        fetchProducts(newUrl = null) {
            axios
                .get(newUrl || "/home/product/")
                .then(r => {
                    this.products = r.data;
                })
                .catch(e => console.error("Error fetch products"));
        }
    },
    mounted() {
        this.fetchProducts();
    }
};
</script>

<style scoped>
.productImg {
    width: 120px !important;
    height: auto;
}
</style>
