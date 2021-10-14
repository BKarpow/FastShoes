<template>
    <div class="category">
        <div class="my-1">
            <button @click="backToMain" class="btn btn-dark btn-sm">
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
        </div>
        <!-- /.my-1 -->
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
    props: {
        parent: {
            type: Object,
            default: () => {
                return { name: "" };
            }
        }
    },
    metaInfo: {
        title: "Уточните категорию."
    },
    data() {
        return {
            categories: []
        };
    },
    computed: {
        sectionName() {
            if (this.categories[0] !== undefined) {
                return this.categories[0].sectionName || "Назад";
            }
            return "Назад";
        }
    },
    methods: {
        backToMain() {
            this.$router.push({ name: "Section" });
        },
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
$color-bg: #28a745;

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
        background: darken($color-bg, 15);
    }
}
</style>
