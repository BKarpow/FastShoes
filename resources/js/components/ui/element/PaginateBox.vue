<template>
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
            <IconArrowLeft :size="24" />
        </button>
        <!-- /.p-btn -->
        <div class="p-text d-flex align-items-center justify-content-center">
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
            <IconArrowRight :size="24" />
        </button>
        <!-- /.p-btn -->
    </div>
    <!-- /.pageBox -->
</template>

<script>
import IconArrowRight from "../icons/IconArrowRight.vue";
import IconArrowLeft from "../icons/IconArrowLeft.vue";
export default {
    name: "PaginateBox",
    components: {
        IconArrowRight,
        IconArrowLeft
    },
    props: {
        itemsPaginate: {
            type: Object,
            required: true
        },
        scrollToId: {
            type: String,
            default: () => ""
        }
    },
    computed: {
        isPaginate() {
            if (this.itemsPaginate.links === undefined) {
                return false;
            }
            if (
                this.itemsPaginate.links.prev === null &&
                this.itemsPaginate.links.next === null
            ) {
                return false;
            }
            return true;
        },
        nextPage() {
            if (this.itemsPaginate.links.next === null) {
                return false;
            }
            return this.itemsPaginate.links.next;
        },
        prevPage() {
            if (this.itemsPaginate.links.prev === null) {
                return false;
            }
            return this.itemsPaginate.links.prev;
        },
        pageText() {
            return `${this.itemsPaginate.meta.current_page}/${this.itemsPaginate.meta.last_page}`;
        }
    },
    methods: {
        scroll() {
            if (this.scrollToId !== "") {
                document.querySelector("#" + this.scrollToId).scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        },
        goPage(url) {
            this.$emit("go:page", url);
            this.scroll();
        }
    }
};
</script>
