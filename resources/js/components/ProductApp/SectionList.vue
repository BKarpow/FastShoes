<template>
    <div class="section">
        <h2>Что Вас интересует?</h2>
        <div class="section-list">
            <router-link
                v-for="category in sections"
                :key="category.id"
                :to="{
                    name: 'Category',
                    params: {
                        id: category.id,
                        alias: category.alias
                    }
                }"
                >{{ category.title }}</router-link
            >
        </div>
        <!-- /.section-list -->
        <h3 class="mt-2 text-center">
            Последние товары
        </h3>
        <!-- /.mt-2 text-center -->
        <LastProducts />
    </div>
    <!-- /.section -->
</template>

<script>
import LastProducts from "./LastProducts.vue";
export default {
    name: "SectionList",
    components: {
        LastProducts
    },
    metaInfo: {
        title: "Найти обувь ето просто"
    },
    data() {
        return {
            sections: []
        };
    },
    methods: {
        fetchSections() {
            axios
                .get("/api/section")
                .then(resp => {
                    console.log("Section loaded", resp.data.data);
                    this.sections = resp.data.data;
                })
                .catch(e => {
                    console.error("Error load sections!", e);
                });
        }
    },
    mounted() {
        this.fetchSections();
    }
};
</script>

<style scoped lang="scss">
$color-bg: #28a745;

.section-list {
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
        background: darken($color-bg, 15);
    }
}
</style>
