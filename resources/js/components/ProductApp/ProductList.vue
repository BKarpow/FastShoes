<template>
    <div class="productList">
        <div class="my-1">
            <button @click="toSectionPage" class="btn btn-dark btn-sm mt-1">
                <IconBackspace :size="16" />
                {{ sectionName }}
            </button>
            <!-- /.btn btn-dark btn-sm -->
            <button @click="toCategoryPage" class="btn btn-dark btn-sm mt-1">
                <IconBackspace :size="16" />
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
        <Items :items="productItems" v-if="isProductLoaded" />
        <PaginateBox
            @go:page="goPage"
            :items-paginate="products"
            v-if="isProductLoaded"
        />
    </div>
    <!-- /.productList -->
</template>

<script>
import PaginateBox from "./../ui/element/PaginateBox.vue";
import IconBackspace from "./../ui/icons/IconBackspace.vue";
import Product from "./Product.vue";
import Items from "./Items.vue";
import FiltersList from "./FiltersList.vue";
import Spiner from "../Spiner.vue";

export default {
    name: "ProductList",
    metaInfo: {
        title: "Категория"
    },
    components: {
        Product,
        FiltersList,
        Spiner,
        PaginateBox,
        Items,
        IconBackspace
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
        productItems() {
            if (_.isEmpty(this.products)) {
                return [];
            } else if (_.isEmpty(this.products.data)) {
                return [];
            }
            return Array.isArray(this.products.data) ? this.products.data : [];
        },
        isProductLoaded() {
            return !_.isEmpty(this.productItems);
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
</style>
