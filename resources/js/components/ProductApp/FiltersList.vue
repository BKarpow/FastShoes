<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Фильтры</h2>
                <!-- /.text-center -->
                <div class="row">
                    <div class="col-md-4 mt-1">
                        <vSelect
                            :options="sizes"
                            placeholder="Уточните размер?"
                            v-model="selectSize"
                        />
                    </div>
                    <!-- /.col-md-4 -->
                    <div class="col-md-4 mt-1">
                        <vSelect
                            :options="colors"
                            placeholder="И цвет?"
                            v-model="selectColor"
                        />
                    </div>
                    <!-- /.col-md-4 -->
                    <div class="col-md-4 mt-1 d-flex">
                        <div class="w-75">
                            <vSelect
                                @option:deselecting="logger"
                                :options="pricesSorte"
                                placeholder="Сортировка по цене"
                                v-model="sortPrice"
                            />
                        </div>
                        <!-- /.w-75 -->

                        <button
                            class="btn btn-dark ml-2"
                            data-bs-toggle="tooltip"
                            title="Фильтровать по параметрам."
                            @click="doFilter"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-funnel-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"
                                />
                            </svg>
                        </button>
                        <!-- /.btn btn-dark ml-1 -->
                    </div>
                    <!-- /.col-md-4 -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</template>

<script>
import Spiner from "../Spiner.vue";
import vSelect from "vue-select";
export default {
    name: "FiltersList",
    props: {
        categoryId: {
            // Fix , delete type
            default: () => ""
        }
    },
    components: {
        Spiner,
        vSelect
    },
    computed: {
        paramsStringQ() {
            let q = "";
            if (this.selectSize !== null && this.selectSize !== "") {
                q += "&size=" + this.selectSize;
            }
            if (this.selectColor !== null && this.selectColor !== "") {
                q += "&color=" + this.selectColor;
            }
            if (this.sortPrice !== null && this.sortPrice !== "") {
                q += "&price=" + this.sortPrice.code;
            }
            return q;
        },
        fetchParamsUri() {
            return "/api/product/params-from?categoryId=" + this.categoryId;
        },
        colors() {
            if (this.params.colors !== undefined) {
                return this.params.colors;
            }
            return ["Загрузка параметром..."];
        },
        sizes() {
            if (this.params.sizes !== undefined) {
                return this.params.sizes;
            }
            return ["Загрузка параметром..."];
        }
    },
    watch: {
        categoryId() {
            console.log("Watch category id", this.categoryId);
            this.fetchParams();
        }
        // selectSize(){
        //     this.doFilter();
        // },
        // selectColor(){
        //     this.doFilter();
        // },
        // sortPrice(){
        //     this.doFilter();
        // },
    },
    data() {
        return {
            params: [],
            selectSize: "",
            selectColor: "",
            pricesSorte: [
                { label: "От низкой к высокой цене.", code: "asc" },
                { label: "От высокой к низкой цене.", code: "desc" }
            ],
            sortPrice: ""
        };
    },
    methods: {
        logger() {
            console.log("log...");
        },
        doFilter() {
            this.$emit("updated", this.paramsStringQ);
        },
        fetchParams() {
            axios.get(this.fetchParamsUri).then(r => {
                if (r.status === 200) {
                    this.params = r.data;
                    console.log("Getting params", r.data);
                } else {
                    console.error("Error getting params", r);
                }
            });
        }
    },
    mounted() {
        // this.fetchParams();
    }
};
</script>
