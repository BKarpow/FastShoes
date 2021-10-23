<template>
    <div class="sections">
        <div class="load-bg" v-if="load"></div>
        <!-- /.load-bg -->
        <SectionCreate
            @load="loadMethod"
            @update="fetchSections"
            :sections="sectionsSelect"
        />
        <div v-if="!isLoadData" class="my-2 alert alert-success">
            <strong>
                Поки-шо немає жодної категорії :(
            </strong>
        </div>
        <!-- /.alert alert-success -->

        <div class="sectionsList" v-if="isLoadData">
            <SectionItem
                @load="loadMethod"
                @update="fetchSections"
                v-for="section in response.data"
                :key="section.id"
                :section="section"
                :sections="sectionsSelect"
            />
        </div>
        <!-- /.sectionsList -->
        <paginate-box
            @go:page="fetchFromPages"
            :itemsPaginate="response"
            v-if="isPaginate"
        />
    </div>
    <!-- /.sections -->
</template>

<script>
import SectionItem from "./Section.vue";
import SectionCreate from "./Create.vue";
import Swal from "sweetalert2";
import PaginateBox from "./../../ui/element/PaginateBox.vue";

export default {
    components: {
        SectionItem,
        SectionCreate,
        PaginateBox
    },
    data() {
        return {
            load: true,
            response: {},
            sectionsSelect: []
        };
    },
    computed: {
        isLoadData() {
            if (this.response.data === undefined) {
                return false;
            }
            if (typeof this.response !== "object") {
                return false;
            }
            if (
                typeof this.response.data === "object" &&
                this.response.data.length > 0
            ) {
                return true;
            }
            return false;
        },
        isPaginate() {
            if (this.response.links === undefined) {
                return false;
            }
            if (
                this.response.links.prev === null &&
                this.response.links.next === null
            ) {
                return false;
            }
            return true;
        }
    },
    methods: {
        loadMethod(status) {
            this.load = status;
        },
        fetchFromPages(uri) {
            this.load = true;
            axios
                .get(uri)
                .then(response => {
                    this.response = response.data;
                    this.load = false;
                })
                .catch(err => {
                    Swal.fire("Error load sections.", "", "error");
                });
        },
        fetchSectionsForSelect() {
            this.loadMethod(true);
            route("api.section.all")
                .then(u => {
                    axios
                        .get(u.data)
                        .then(resp => {
                            this.loadMethod(false);
                            this.sectionsSelect = resp.data.data;
                        })
                        .catch(err => {
                            Swal.fire(
                                "Error getting sections list",
                                "",
                                "error"
                            );
                        });
                })
                .catch(err => console.error(err));
        },
        fetchSections() {
            this.load = true;
            route("category.index")
                .then(route => {
                    axios
                        .get(route.data)
                        .then(response => {
                            this.load = false;
                            this.response = response.data;
                        })
                        .catch(err => {
                            Swal.fire("Error load sections.", "", "error");
                        });
                })
                .catch(err => {
                    Swal.fire("Error getting uri api", "", "error");
                });
        }
    },
    mounted() {
        this.fetchSectionsForSelect();
        this.fetchSections();
    },
    updated() {
        setTooltip();
    }
};
</script>

<style scoped lang="scss">
.pageBox {
    display: grid;
    grid-template-columns: 1fr 4rem 1fr;
    margin-top: 0.7rem;
    .p-btn {
        width: 100%;
        outline: none;
        background: inherit;
        border: 1px solid #383838;
        padding: 1rem;
        border-radius: 10px;
        transition: all 0.6s;
        &:hover {
            background: #383838;
            color: white;
            transition: all 0.6s;
        }
    }
    .p-prev {
        grid-column: 1/2;
    }
    .p-text {
        padding: 0.2rem;
        grid-column: 2/3;
        .pageText {
            font-weight: bold;
            font-size: 18px;
        }
    }
    .p-next {
        grid-column: 3/4;
    }
}

.load-bg {
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    background: #383838;
    z-index: 1000;
}
</style>
