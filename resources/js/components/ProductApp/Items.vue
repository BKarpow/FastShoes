<template>
    <div class="items">
        <div class="item" v-for="item in items" :key="item.id">
            <Product :product="item" />
        </div>
        <!-- /.item -->
    </div>
    <!-- /.items -->
</template>

<script>
import Product from "./Product.vue";
export default {
    name: "Items",
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    components: {
        Product
    }
};
</script>

<style scoped>
.items {
    display: flex;
    flex-wrap: wrap;
}
</style>
