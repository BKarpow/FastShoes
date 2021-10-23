<template>
    <div class="mt-2 d-flex justify-content-end align-items-center">
        <router-link v-if="!isPageSearch" :to="{ name: 'Search' }">
            <button-border>
                <icon-glass :size="32" />
            </button-border>
        </router-link>
        <router-link v-if="isPageSearch" to="/">
            <button-border>
                <icon-backspace :size="32" />
            </button-border>
        </router-link>
    </div>
    <!-- /.mt-2 -->
</template>

<script>
import ButtonBorder from "./../ui/element/ButtonBorder.vue";
import IconGlass from "./../ui/icons/IconGlass.vue";
import IconBackspace from "./../ui/icons/IconBackspace.vue";
export default {
    name: "SearchButton",
    components: {
        ButtonBorder,
        IconGlass,
        IconBackspace
    },
    props: {
        isPageSearch: {
            type: Boolean,
            default: () => false
        }
    },
    mounted() {
        this.isPageSearch = this.$router.currentRoute.name === "Search";
    }
};
</script>

<style scoped>
a {
    color: #383838;
}
</style>
