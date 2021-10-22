<template>
    <div>
        <SearchInput @input="doInput" @submit="fetchSearchResult" />
        <div class="my-1" v-if="isProductLoaded">
            <h4>
                Найдено {{ products.data.length }} по запросу "{{ search }}".
            </h4>
        </div>
        <items :items="productItems" v-if="isProductLoaded" />
        <paginate-box
            :items-paginate="products"
            @go:page="fetchSearchResult"
            v-if="isProductLoaded"
        />
    </div>
</template>

<script>
import SearchInput from "./SearchInput.vue";
import ProductList from "./ProductList.vue";
import Items from "./Items.vue";
import PaginateBox from "./../ui/element/PaginateBox.vue";
export default {
    name: "SearchList",
    components: { SearchInput, ProductList, Items, PaginateBox },
    data() {
        return {
            search: "",
            products: []
        };
    },
    metaInfo: {
        title: "Найти товар по имени"
    },
    computed: {
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
        isEmpty(p) {
            return _.isEmpty(p);
        },
        doInput(v) {
            this.search = v;
        },
        fetchSearchResult(url = undefined) {
            const u = url || "/api/product/search?s=" + this.search;
            axios.get(u).then(r => {
                if (!_.isEmpty(r.data) && r.status === 200) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error(
                            "Error fetcheng results, error request",
                            r.data
                        );
                    } else {
                        this.products = r.data;
                    }
                } else {
                    console.error("error network connect", r);
                }
            });
        }
    }
};
</script>
