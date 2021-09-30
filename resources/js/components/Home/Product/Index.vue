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
                    <tr v-for="product in products" :key="product.id">
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
                            <h6>
                                {{ product.price | price }}
                                <svg
                                    @click="
                                        updatePrice(product.id, product.price)
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-pencil-fill"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"
                                    />
                                </svg>
                            </h6>
                            <div class="controlPanel btn-group">
                                <button
                                    @click="destroyProduct(product.id)"
                                    class="btn-warning btn-sm"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-trash-fill"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"
                                        />
                                    </svg>
                                </button>
                                <!-- /.btn-outline-warning btn-sm -->
                                <button
                                    class="btn-primary btn-sm"
                                    @click="showToggle(product.id)"
                                >
                                    <svg
                                        v-if="product.show"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-eye"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
                                        />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
                                        />
                                    </svg>
                                    <svg
                                        v-if="!product.show"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-eye-slash"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                                        />
                                        <path
                                            d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                                        />
                                    </svg>
                                </button>
                                <!-- /.btn-outline-primary btn-sm -->
                            </div>
                            <!-- /.controlPanel btn-group -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /.table table-dark table-hover -->
        </div>
        <!-- /.productsList -->
    </div>
    <!-- /#products -->
</template>

<script>
import Swal from "sweetalert2";
import CreateProduct from "./Create.vue";

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

export default {
    components: {
        CreateProduct
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
        isEmptyProducts() {
            return this.products.length === 0;
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
        fetchProducts() {
            axios
                .get("/home/product/")
                .then(r => {
                    this.products = r.data.data;
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
