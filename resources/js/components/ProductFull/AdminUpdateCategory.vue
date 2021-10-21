<template>
    <div id="updateCategory">
        <button @click="showForm = !showForm" class="btn btn-secondary">
            Изменить категорию товара
        </button>
        <!-- /.btn-secondary -->
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
