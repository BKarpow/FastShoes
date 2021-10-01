<template>
    <div class="productList">
        <FiltersList :category-id="categoryId" @updated="changeFilters" />
        <div class="noProducts" v-if="products.length === 0">
            <Spiner />
        </div>
        <!-- /.noProducts -->
        <div class="items">
            <div
                class="item"
                v-for="product in products.data"
                :key="product.id"
            >
                <Product :product="product" />
            </div>
            <!-- /.item -->
        </div>
        <!-- /.items -->
        <div class="pageBox" v-if="isPaginate">
            <button
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Предыдущая страница"
                v-if="prevPage"
                type="button"
                @click="goPage(prevPage)"
                class="p-btn p-prev"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="currentColor"
                    class="bi bi-caret-left"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"
                    />
                </svg>
            </button>
            <!-- /.p-btn -->
            <div
                class="p-text d-flex align-items-center justify-content-center"
            >
                <span
                    data-bs-toggle="tooltip"
                    title="Поточна/Всього сторінок"
                    class="pagesText"
                    >{{ pageText }}</span
                >
                <!-- /.pagesText -->
            </div>
            <!-- /.p-text -->
            <button
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Следующая страница"
                v-if="nextPage"
                type="button"
                @click="goPage(nextPage)"
                class="p-btn p-next"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="currentColor"
                    class="bi bi-caret-right"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"
                    />
                </svg>
            </button>
            <!-- /.p-btn -->
        </div>
        <!-- /.pageBox -->
    </div>
    <!-- /.productList -->
</template>

<script>
import Product from "./Product.vue";
import FiltersList from "./FiltersList.vue";
import Spiner from "../Spiner.vue";

export default {
    name: "ProductList",
    metaInfo: {
        title: "Ось що ми знайшли"
    },
    components: {
        Product,
        FiltersList,
        Spiner
    },
    data() {
        return {
            products: [],
            categoryId: "",
            filterParams: "",
            pageNumber: ""
        };
    },
    computed: {
        queryUri() {
            let uri = "/api/product/category-id?categoryId=" + this.categoryId;
            if (this.filterParams !== null || this.filterParams !== "") {
                uri += this.filterParams;
            }
            if (this.pageNumber !== null || this.pageNumber !== "") {
                uri += "&page=" + Number(this.pageNumber);
            }
            return uri;
        },
        isPaginate() {
            if (this.products.links === undefined) {
                return false;
            }
            if (
                this.products.links.prev === null &&
                this.products.links.next === null
            ) {
                return false;
            }
            return true;
        },
        nextPage() {
            if (this.products.links.next === null) {
                return false;
            }
            return this.products.links.next;
        },
        prevPage() {
            if (this.products.links.prev === null) {
                return false;
            }
            return this.products.links.prev;
        },
        pageText() {
            return `${this.products.meta.current_page}/${this.products.meta.last_page}`;
        }
    },
    methods: {
        goPage(urlPage) {
            let page = urlPage.match(/page\=(\d+)/);
            if (Array.isArray(page)) {
                this.pageNumber = page[1];
                this.fecthProducts();
            }
        },
        fecthProducts() {
            const catId = this.$route.params.id;

            if (catId === undefined) {
                console.error("Incorrect category id");
                return;
            }
            this.categoryId = catId;
            axios
                .get(this.queryUri)
                .then(r => {
                    this.products = r.data;
                    console.log("Products fetching ", r.data);
                })
                .catch(e => {
                    console.error("Error getting products");
                });
        },
        changeFilters(par) {
            console.log("filter", par);
            this.filterParams = par;
            this.fecthProducts();
        },
        logger(r) {
            console.log("Log", r);
        }
    },
    mounted() {
        this.fecthProducts();
    },
    updated() {
        //
    }
};
</script>

<style scoped lang="scss">
.pageBox {
    display: grid;
    grid-template-columns: 1fr 4rem 1fr;
    margin-top: 0.7rem;
    .p-btn {
        width: 100%;
        outline: none;
        background: inherit;
        border: 1px solid #383838;
        padding: 1rem;
        border-radius: 10px;
        transition: all 0.6s;
        &:hover {
            background: #383838;
            color: white;
            transition: all 0.6s;
        }
    }
    .p-prev {
        grid-column: 1/2;
    }
    .p-text {
        padding: 0.2rem;
        grid-column: 2/3;
        .pageText {
            font-weight: bold;
            font-size: 18px;
        }
    }
    .p-next {
        grid-column: 3/4;
    }
}

.noProducts {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}
.items {
    display: flex;
    flex-wrap: wrap;
}
</style>
