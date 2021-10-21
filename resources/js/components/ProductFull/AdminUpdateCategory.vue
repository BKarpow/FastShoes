<template>
    <div id="updateCategory" class="c-pallet">
        <div class="btn-panel">
            <div @click="showForm = !showForm" class="pointer">
                <span class="btn-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="svg-icon bi bi-card-list"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"
                        />
                        <path
                            d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"
                        />
                    </svg>
                </span>
                <!-- /.btn-icon -->
                <span class="btn-text">
                    {{ btnText }}
                </span>
                <!-- /.btn-text -->
            </div>
            <div class="formChange" v-if="showForm">
                <div class="mt-2">
                    <h4>Изменить категорию.</h4>
                </div>
                <!-- /.mt-2 -->
                <div class="pt-2">
                    <h5>Категория сейчас: {{ selfCategory }}</h5>
                </div>
                <!-- /.pt-2 -->
                <div class="form-group py-1">
                    <vSelect
                        :options="categorySelectList"
                        label="title"
                        index="id"
                        v-model="selectCategory"
                        placeholder="Выбрать новую."
                    />
                </div>
                <!-- /.form-group -->
                <div class="form-group pt-1">
                    <button @click.once="doSave" class="btn btn-success">
                        Сохранить
                    </button>
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.formChange -->
        </div>
        <!-- /.btn-secondary -->
    </div>
    <!-- /#updateCategory -->
</template>

<script>
import Swal from "sweetalert2";
import vSelect from "vue-select";
export default {
    name: "AdminUpdateCategory",
    props: {
        categoryId: {
            type: Number
        },
        productId: {
            type: Number
        }
    },
    components: {
        vSelect
    },
    data() {
        return {
            categories: [],
            selectCategory: {},
            showForm: false
        };
    },
    computed: {
        btnText() {
            return this.showForm ? "Закрыть форму." : "Изменить категорию.";
        },
        selfCategory() {
            const res = this.categorySelectList.filter(
                item => item.id === this.categoryId
            );
            if (Array.isArray(res) && res.length >= 1) {
                return res[0].title;
            } else {
                return "";
            }
        },
        categorySelectList() {
            return this.categories.map(item => {
                return {
                    id: item.id,
                    title: item.title + ` -> (${item.sectionName})`
                };
            });
        },
        formData() {
            return {
                categoryId: this.selectCategory.id || this.categoryId,
                productId: this.productId
            };
        }
    },
    methods: {
        doSave() {
            axios.put("/admin/product/", this.formData).then(r => {
                if (r.status === 200 && r.data != null) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error("Error update this product", r.data);
                    } else {
                        Swal.fire({
                            title: "Категория обновлена",
                            icon: "success"
                        });
                        this.showForm = false;
                        this.$emit("success");
                    }
                } else {
                    console.error("Error network", r);
                }
            });
        },
        fetchCategories() {
            axios.get("/api/category/").then(r => {
                if (r.status === 200 && r.data != null) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error(r.data);
                    } else if (r.data.hasOwnProperty("data")) {
                        this.categories = r.data.data;
                    } else {
                        console.error("Error fetching categories list");
                    }
                }
            });
        }
    },
    mounted() {
        this.fetchCategories();
    }
};
</script>
