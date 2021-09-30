<template>
    <div class="category">
        <h2>А именно?</h2>
        <div class="category-list">
            <router-link
                v-for="category in categories"
                :key="category.id"
                :to="{
                    name: 'Products',
                    params: { id: category.id, alias: category.alias }
                }"
                >{{ category.title }}</router-link
            >
        </div>
        <!-- /.category-list -->
    </div>
    <!-- /.category -->
</template>

<script>
export default {
    name: "CategoryList",
    metaInfo: {
        title: "Уточните категорию."
    },
    data() {
        return {
            categories: []
        };
    },
    methods: {
        fetchCategories() {
            const sectionId = this.$route.params.id;
            if (sectionId === undefined) {
                console.error("Incorrect section id");
                return;
            }
            axios
                .get("/api/category/from?sectionId=" + sectionId)
                .then(r => {
                    this.categories = r.data.data;
                    console.log("Loaded categories", r.data.data);
                })
                .catch(e => console.error("Error loaded categories"));
        }
    },
    mounted() {
        this.fetchCategories();
    }
};
</script>

<style scoped lang="scss">
$color-bg: #ff6262;

.category-list {
    display: flex;
    flex-wrap: wrap;
}

a {
    outline: none;
    display: block;
    font-weight: bold;
    font-size: 20px;
    text-align: center;
    text-transform: uppercase;
    text-decoration: none;
    color: $color-bg;
    padding: 1.2rem;
    margin: 0.3rem;
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
</style>
