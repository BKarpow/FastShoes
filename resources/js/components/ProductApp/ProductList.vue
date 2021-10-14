<template>
    <div class="productList">
        <div class="my-1">
            <button @click="toSectionPage" class="btn btn-dark btn-sm">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-backspace-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"
                    />
                </svg>
                {{ sectionName }}
            </button>
            <!-- /.btn btn-dark btn-sm -->
            <button @click="toCategoryPage" class="btn btn-dark btn-sm">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-backspace-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"
                    />
                </svg>
                {{ categoryName }}
            </button>
            <!-- /.btn btn-dark btn-sm -->
        </div>
        <!-- /.my-1 -->
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
        sectionAlias() {
            if (this.products.hasOwnProperty("data")) {
                if (
                    Array.isArray(this.products.data) &&
                    this.products.data.length > 0
                ) {
                    return this.products.data[0].hasOwnProperty("sectionAlias")
                        ? this.products.data[0].sectionAlias
                        : "";
                }
            }
            return "";
        },
        sectionId() {
            if (this.products.hasOwnProperty("data")) {
                if (
                    Array.isArray(this.products.data) &&
                    this.products.data.length > 0
                ) {
                    return this.products.data[0].hasOwnProperty("sectionId")
                        ? this.products.data[0].sectionId
                        : 0;
                }
            }
            return 0;
        },
        categoryName() {
            if (this.products.hasOwnProperty("data")) {
                if (
                    Array.isArray(this.products.data) &&
                    this.products.data.length > 0
                ) {
                    return this.products.data[0].hasOwnProperty("categoryName")
                        ? this.products.data[0].categoryName
                        : "К выбору категории";
                }
            }
            return "К выбору категории";
        },
        sectionName() {
            if (this.products.hasOwnProperty("data")) {
                if (
                    Array.isArray(this.products.data) &&
                    this.products.data.length > 0
                ) {
                    return this.products.data[0].hasOwnProperty("sectionName")
                        ? this.products.data[0].sectionName
                        : "К выбору секции";
                }
            }
            return "К выбору секции";
        },
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
        toSectionPage() {
            this.$router.push({ name: "Section" });
        },
        toCategoryPage() {
            this.$router.push({
                name: "Category",
                params: {
                    id: this.sectionId,
                    alias: this.sectionAlias
                }
            });
        },
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
