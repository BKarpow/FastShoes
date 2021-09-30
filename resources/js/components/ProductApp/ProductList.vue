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
                v-for="product in products"
                :key="product.id"
            >
                <Product :product="product" />
            </div>
            <!-- /.item -->
        </div>
        <!-- /.items -->
    </div>
    <!-- /.productList -->
</template>

<script>
import Product from './Product.vue';
import FiltersList from './FiltersList.vue';
import Spiner from '../Spiner.vue';

export default {
    name: 'ProductList',
    metaInfo:{
        title: 'Ось що ми знайшли'
    },
    components:{
        Product, FiltersList, Spiner,
    },
    data(){
        return {
            products: [],
            categoryId: '',
            filterParams: '',
            pageNumber: '',
        }
    },
    computed:{
        queryUri(){
            let uri = '/api/product/category-id?categoryId='+this.categoryId;
            if (this.filterParams !== null || this.filterParams !== '') {
                uri += this.filterParams
            }
            if (this.pageNumber !== null || this.pageNumber !== '') {
                uri += '&page=' + Number(this.pageNumber)
            }
            return uri;
        },
        isPaginate(){
            if (this.products.links === undefined) {
                return false;
            }
            if (this.products.links.prev === null &&  this.products.links.next === null) {
                return false;
            }
            return true;
        },
        nextPage(){
            if (this.products.links.next === null) {
                return false;
            }
            return this.products.links.next;
        },
        prevPage(){
            if (this.products.links.prev === null) {
                return false;
            }
            return this.products.links.prev;
        },
        pageText(){
            return `${this.products.meta.current_page}/${this.products.meta.last_page}`
        },
    },
    methods:{
        fecthProducts(){
            const catId = this.$route.params.id;
            
            if (catId === undefined) {
                console.error('Incorect category id');
                return ;
            }
            this.categoryId = catId;
            axios.get(this.queryUri)
            .then(r => {
                this.products = r.data.data;
                console.log('Products fetching ', r.data.data);
            }).catch(e => {
                console.error('Error getting products');
            })
        },
        changeFilters(par){
            console.log('filter', par); 
            this.filterParams = par;
            this.fecthProducts();
        },
        logger(r){
            console.log('Log', r)
        },
    },
    mounted(){
        this.fecthProducts();
    },
    updated(){
        //
    },
}
</script>

<style scoped lang="scss">
    .noProducts{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    .items{
        display:flex;
        flex-wrap: wrap;
        
    }
</style>