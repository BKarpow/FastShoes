<template>
    <div class="productSelectorApp container">
        <div class="mt-2 d-flex justify-content-end align-items-center">
            <router-link to="/search"> <icon-glass /> </router-link>
        </div>
        <!-- /.mt-2 -->
        <div class="my-2">
            <router-view />
        </div>
        <!-- /.my-2 -->
    </div>
    <!-- /.productSelectorApp -->
</template>

<script>
import Vue from "vue";
import VueRouter from "vue-router";
import VueMeta from "vue-meta";
import IconGlass from "./../ui/icons/IconGlass.vue";
import ProductList from "./ProductList.vue";
import SectionList from "./SectionList.vue";
import CategoryList from "./CategoryList.vue";
import SearchList from "./SearchList.vue";

Vue.use(VueRouter);
Vue.use(VueMeta);

const routes = [
    {
        path: "/",
        name: "Section",
        component: SectionList
    },
    {
        path: "/section/:id/:alias",
        name: "Category",
        component: CategoryList
    },
    {
        path: "/category/:id/:alias",
        name: "Products",
        component: ProductList
    },
    {
        path: "/search",
        name: "Search",
        component: SearchList
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default {
    router,
    metaInfo: {
        title: "FourTwo Shoes"
    },
    components: {
        ProductList,
        IconGlass
    },
    data() {
        return {};
    },
    methods: {
        //
    },
    mounted() {
        //
    },
    updated() {
        hideTooltips();
        setTooltips();
    }
};
</script>

<style scoped lang="scss">
$color-bg: #ff6262;
.btn-section {
    outline: none;
    width: 100%;
    font-weight: bold;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 5px;
    background: inherit;
    border: 1px solid $color-bg;
    border-radius: 30px;
    transition: all 0.8s;
    &:hover {
        background: $color-bg;
        color: white;
    }
    &:active {
        background: darken($color-bg, 75);
    }
}

.sections__button {
    padding: 2rem !important;
    margin: 0.5rem;
}

//Sections BLOCK
.sections {
    &__title {
        text-transform: uppercase;
        text-align: center;
    }
}

.sections__body {
    display: flex;
    justify-content: center;
    align-items: center;
    column-gap: 0.6em;
    @media (max-width: 666px) {
        flex-direction: column;
    }
    &__botton {
        padding: 1em;
        margin: 0.5em;
    }
    &__item {
        display: block;
        width: 310px;
        @media (max-width: 666px) {
            width: 100%;
        }
    }
}
</style>
