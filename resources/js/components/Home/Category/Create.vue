<template>
    <div id="createSection">
        <div class="btn-group my-2 d-block">
            <button
                title="Показати форму створення нової категорії"
                v-if="!showForm"
                @click="showForm = !showForm"
                class="btn btn-info btn-lg"
            >
                <IconAddFolder />
                Создать категорию
            </button>
            <!-- /.btn btn-info btn-lg -->

            <button
                title="Сховати форму створення нової секції"
                v-if="showForm"
                @click="showForm = !showForm"
                class="btn btn-primary"
            >
                <IconBackspace />
                Закрыть
            </button>
            <!-- /.btn btn-info btn-lg -->
        </div>
        <!-- /.btn-group d-block -->
        <div id="createForm" v-if="showForm">
            <h5>Створити нову категорію</h5>
            <div class="form-group">
                <select
                    data-bs-toggle="tooltip"
                    title="Оберіть секцію для категорії"
                    v-model="sectionSelectId"
                    class="form-select"
                >
                    <option
                        v-for="section in sections"
                        :key="section.id"
                        :value="section.id"
                    >
                        {{ section.title }}
                    </option>
                </select>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <input
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Назва категорії"
                    placeholder="Як назвем?"
                    type="text"
                    v-model="title"
                    class="form-control col-md-6"
                />
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <textarea
                    cols="3"
                    rows="3"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Опис категорії"
                    v-model="description"
                    class="form-control col-md-6"
                ></textarea>
                <!-- /#.form-group -->
                <div class="form-group mt-2 c-box" @click="show = !show">
                    <!-- Enable icon -->
                    <IconEye v-if="show" />

                    <!-- Disable icon -->
                    <IconCloseEye v-if="!show" />

                    <span class="showToggleText">
                        {{ showToggleText }}
                    </span>
                    <!-- /.showToggleText -->
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <button
                        title="Створити секцію"
                        @click="onSubmit"
                        v-if="isValidFormFields"
                        class="btn btn-success"
                    >
                        <IconSuccess />
                        Сохранить
                    </button>
                    <!-- /.btn btn-success -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /#createForm -->
    </div>
    <!-- /#createSection -->
</template>

<script>
import IconAddFolder from "../../ui/icons/IconAddFolder.vue";
import IconCloseEye from "./../../ui/icons/IconCloseEye.vue";
import IconEye from "./../../ui/icons/IconEye.vue";
import IconBackspace from "./../../ui/icons/IconBackspace.vue";
import IconSuccess from "./../../ui/icons/IconSuccess.vue";
import Swal from "sweetalert2";
export default {
    components: {
        IconAddFolder,
        IconBackspace,
        IconCloseEye,
        IconEye,
        IconSuccess
    },
    name: "SectionCreate",
    props: {
        sections: {
            type: Array
        }
    },
    data() {
        return {
            showForm: false,
            title: "",
            description: "",
            show: true,
            sectionSelectId: ""
        };
    },
    methods: {
        load(s) {
            this.$emit("load", s);
        },
        onSubmit() {
            this.load(false);
            route("category.store")
                .then(uri => {
                    axios
                        .post(uri.data, this.dataForm)
                        .then(resp => {
                            this.load(true);
                            this.$emit("update", true);
                            this.title = "";
                            this.description = "";
                            this.showForm = false;
                        })
                        .catch(err => {
                            Swal.fire("Error create", "", "error");
                        });
                })
                .catch(err => {
                    console.error("Error getting name");
                });
        }
    },
    computed: {
        isValidFormFields() {
            if (this.sectionSelectId === "") {
                return false;
            }
            if (this.title === "") {
                return false;
            }
            return true;
        },
        showToggleText() {
            return this.show ? "Показувати на сайті" : "Приховати";
        },
        dataForm() {
            return {
                title: this.title,
                description: this.description,
                show: this.show,
                sectionId: this.sectionSelectId
            };
        }
    },
    updated() {
        setTooltip();
    }
};
</script>

<style scoped lang="scss">
.c-box {
    display: flex;
    padding: 0.7rem;
    border: 1px solid #383838;
    cursor: pointer;
    border-radius: 9px;
    align-items: center;
    column-gap: 0.7rem;
    span {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 20px;
    }
}
</style>
