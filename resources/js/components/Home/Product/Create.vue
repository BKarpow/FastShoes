<template>
    <div class="createForm">
        <div class="d-block my-2 px-1" v-if="!createBox">
            <button
                type="button"
                @click="createBox = true"
                class="btn btn-primary btn-lg"
            >
                Створити новий товар
            </button>
        </div>
        <!-- /.btn-group -->
        <div class="createFormBody" v-if="createBox">
            <div class="d-block my-2 px-1">
                <button
                    type="button"
                    @click="createBox = false"
                    class="btn btn-info"
                >
                    Відміна
                </button>
            </div>
            <h4>Створення нової одиниці товару</h4>
            <div class="form-group">
                <label>В які секції розміщувати товар?</label>
                <vSelect
                    index="id"
                    label="title"
                    :options="catList"
                    v-model="selectCategory"
                    placeholder="Оберіть категорію товару"
                />
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label for="name">Назва товару</label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="title"
                />
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label for="price">Ціна товару</label>
                <input
                    id="price"
                    type="tel"
                    v-model="price"
                    @blur="setCurrencySymbolForPrice"
                    @focus="priceFocus"
                    @input="priceFormat"
                    class="form-control col-md-3 p-3"
                    placeholder="Скільки коштує"
                />
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <h4 class="text-center">Зображення товарів</h4>
                <UploadGroupImage @update="updateImages" ref="imgGroup" />
            </div>
            <!-- /.form-group -->

            <div class="form-group sizes">
                <h5>Розміри</h5>
                <vSelect
                    :options="sizes"
                    multiple
                    taggable
                    v-model="selectSizes"
                    label="value"
                    index="id"
                    placeholder="Розміри товару"
                    @option:created="createNewSize"
                />
            </div>
            <!-- /.form-group sizes -->

            <div class="form-group colors">
                <h5>Кольори</h5>
                <vSelect
                    :options="colors"
                    multiple
                    taggable
                    v-model="colorSelect"
                    label="value"
                    index="id"
                    placeholder="Кольори товару товару"
                    @option:created="createNewColor"
                />
            </div>
            <!-- /.form-group colors -->

            <div class="form-group shortDescription">
                <h5>Опис товару</h5>
                <ckeditor
                    :editor="editor"
                    v-model="editorData"
                    :config="editorConfig"
                ></ckeditor>
            </div>
            <!-- /.form-group shortDescription -->
            <div class="form-group">
                <button
                    class="btn btn-success btn-lg"
                    type="button"
                    @click="doCreateProduct"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-save2-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M8.5 1.5A1.5 1.5 0 0 1 10 0h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h6c-.314.418-.5.937-.5 1.5v6h-2a.5.5 0 0 0-.354.854l2.5 2.5a.5.5 0 0 0 .708 0l2.5-2.5A.5.5 0 0 0 10.5 7.5h-2v-6z"
                        />
                    </svg>
                    Створити товар
                </button>

                <button
                    class="btn btn-success btn-lg"
                    type="button"
                    @click="cleanForm"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-save2-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M8.5 1.5A1.5 1.5 0 0 1 10 0h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h6c-.314.418-.5.937-.5 1.5v6h-2a.5.5 0 0 0-.354.854l2.5 2.5a.5.5 0 0 0 .708 0l2.5-2.5A.5.5 0 0 0 10.5 7.5h-2v-6z"
                        />
                    </svg>
                    Оцистити форму
                </button>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.createFormBody -->
    </div>
    <!-- /.createForm -->
</template>

<script>
import vSelect from "vue-select";
import UploadGroupImage from "../../Image/UploadGroupImage.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    name: "CreateProduct",
    props: {
        productData: {
            type: Object,
            default: () => {
                return {};
            }
        }
    },
    components: {
        vSelect,
        UploadGroupImage
    },
    watch: {
        sizeSelect() {
            console.log("change size");
        }
    },
    computed: {
        isUpdateMode() {
            return this.productData.title !== undefined;
        },
        updateTitle() {
            if (this.productData.title !== undefined) {
                return this.productData.title;
            }
            return "";
        },
        dataCreate() {
            return {
                title: this.title,
                price: this.price.replace(/\D/g, "") || 0,
                description: this.editorData,
                colors: JSON.stringify(this.colorSelect.map(i => i.value)),
                sizes: JSON.stringify(this.selectSizes.map(i => i.value)),
                image_1:
                    typeof this.images[0] === "object"
                        ? this.images[0].uri
                        : "",
                image_2:
                    typeof this.images[1] === "object"
                        ? this.images[1].uri
                        : "",
                image_3:
                    typeof this.images[2] === "object"
                        ? this.images[2].uri
                        : "",
                image_4:
                    typeof this.images[3] === "object"
                        ? this.images[3].uri
                        : "",
                image_5:
                    typeof this.images[4] === "object"
                        ? this.images[4].uri
                        : "",
                image_6:
                    typeof this.images[5] === "object"
                        ? this.images[5].uri
                        : "",
                image_7:
                    typeof this.images[6] === "object"
                        ? this.images[6].uri
                        : "",
                image_8:
                    typeof this.images[7] === "object"
                        ? this.images[7].uri
                        : "",
                categoryId: this.selectCategory.id || undefined
            };
        },
        catList() {
            let data = [];
            this.categories.forEach(item => {
                data.push({
                    title: `${item.title} (${item.sectionName})`,
                    id: item.id
                }); //Add object from data
            });
            return data;
        }
    },
    data() {
        return {
            createBox: false,
            categories: [],
            selectCategory: "",
            title: "",
            price: "",
            images: [],
            sizes: ["39", "40", "41", "42", "43", "44", "45"],
            selectSizes: [],
            colors: ["чорний", "білий", "синій", "коричневий"],
            colorSelect: [],
            editor: ClassicEditor,
            editorData: "",
            editorConfig: {
                placeholder: "Опис товару",
                height: 300
            }
        };
    },
    methods: {
        cleanForm() {
            this.$refs.imgGroup.cleanStadeImages();
        },
        updateImages(image) {
            this.images = image;
        },
        isExistsColor() {
            let s = "";
            if (typeof size === "object") {
                s = size.value;
            } else if (typeof size === "string") {
                s = size;
            } else {
                // console.log('size undefined', size);
                return false;
            }
            // console.log('short size', s)
            let exists = false;
            this.colors.forEach(i => {
                // console.log('in list sizes', i)
                if (i.value === s) {
                    // console.log('Size exists', i)
                    exists = true;
                    return;
                }
            });
            // console.log('exists status', exists)
            return exists;
        },
        isExistsSize(size) {
            let s = "";
            if (typeof size === "object") {
                s = size.value;
            } else if (typeof size === "string") {
                s = size;
            } else {
                // console.log('size undefined', size);
                return false;
            }
            // console.log('short size', s)
            let exists = false;
            this.sizes.forEach(i => {
                // console.log('in list sizes', i)
                if (i.value === s) {
                    // console.log('Size exists', i)
                    exists = true;
                    return;
                }
            });
            // console.log('exists status', exists)
            return exists;
        },
        createNewColor(item) {
            if (this.isExistsColor(item)) {
                console.info("Color exists", item);
                return;
            }
            if (typeof item === "object") {
                item = {
                    value: item.value || item.toString()
                };
            } else if (typeof item === "string") {
                item = {
                    value: item
                };
            } else {
                console.error("Error item from color!");
                return;
            }
            route("color.store")
                .then(u => {
                    axios
                        .post(u.data, item)
                        .then(response => {
                            console.log("Created new color", response);
                        })
                        .catch(e =>
                            console.error("Error create new item color")
                        );
                })
                .catch(e =>
                    console.error(
                        "Error getting route from create new item color",
                        e
                    )
                );
        },
        createNewSize(item) {
            if (this.isExistsSize(item)) {
                // console.log('exists item size');
                return;
            }
            if (typeof item === "object") {
                item = {
                    value: item.value || item.toString()
                };
            } else if (typeof item === "string") {
                item = {
                    value: item
                };
            } else {
                console.error("Error item from size!");
                return;
            }
            route("size.store")
                .then(u => {
                    console.log("Route getting", u);
                    axios
                        .post(u.data, item)
                        .then(response => {
                            console.log("Response create size", response);
                        })
                        .catch(error => {
                            console.error("Error create new size.", error);
                        });
                })
                .catch(error => {
                    console.error("Error getting url new store size.", error);
                });
        },
        priceFocus() {
            if (this.price.length > 0) {
                this.price = this.price.replace(/[^\d\s]/g, "").trim();
            }
        },
        priceFormat() {
            let p = this.price;
            p = p.replace(/\D/, "").substring(0, 7);
            if (p.length === 4) {
                p = p.replace(/(\d)(\d\d\d)/, "$1 $2");
            } else if (p.length === 5) {
                p = p.replace(/(\d\d)(\d\d\d)/, "$1 $2");
            } else if (p.length === 6) {
                p = p.replace(/(\d\d\d)(\d\d\d)/, "$1 $2");
            } else if (p.length === 7) {
                p = p.replace(/(\d)(\d\d\d)(\d\d\d)/, "$1 $2 $3");
            }
            this.price = p;
        },
        setCurrencySymbolForPrice() {
            if (this.price.length > 0) {
                this.price = this.price + " грн.";
                console.log("Blur price focus");
            }
        },
        fetchColors() {
            route("api.color.all")
                .then(u => {
                    axios
                        .get(u.data)
                        .then(resp => {
                            this.colors = resp.data.data;
                        })
                        .catch(err => console.error("Eroor getting colors"));
                })
                .catch(err => console.error("Eroor getting route from colors"));
        },
        fetchSizes() {
            route("api.size.all")
                .then(u => {
                    axios
                        .get(u.data)
                        .then(resp => {
                            this.sizes = resp.data.data;
                        })
                        .catch(err => console.error("Eroor getting sizes"));
                })
                .catch(err => console.error("Eroor getting route from size"));
        },
        fetchCategories() {
            axios
                .get("/api/category/")
                .then(resp => {
                    this.categories = resp.data.data;
                })
                .catch(err => console.error("Eroor getting category"));
        },

        doCreateProduct() {
            route("product.store")
                .then(u => {
                    this.$emit("load", true);
                    axios
                        .post(u.data, this.dataCreate)
                        .then(resp => {
                            console.log("Product created!", resp);
                            this.cleanForm();
                            this.createBox = false;
                            this.$emit("created", resp.data);
                            this.$emit("load", false);
                        })
                        .catch(err => {
                            console.error("Error create product", err);
                        });
                })
                .catch(e => {
                    console.error("Error getting product uri store");
                });
        }
    },
    mounted() {
        this.fetchCategories();
        this.fetchSizes();
        this.fetchColors();
    }
};
</script>

<style lang="scss">
.shortDescription {
    height: 400px !important;
}
</style>
