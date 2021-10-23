<template>
    <div class="sectionItem">
        <div class="sectionContent">
            <h3 class="title">
                {{ title | short }} ({{ sectionName | short }})
            </h3>
            <!-- /.title -->
            <div class="descripption">
                {{ description | short }}
            </div>
            <!-- /.descripption -->
        </div>
        <!-- /.sectionContent -->

        <div class="buttonBox">
            <!-- Edit Icon -->
            <span
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Рндагувати секцію"
                @click="editMode"
            >
                <icon-foll-edit />
            </span>

            <!-- Delete Icon -->
            <span
                @click="destroySubmit"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Видалити секцію"
            >
                <icon-trash />
            </span>
        </div>
        <!-- /.buttonBox -->

        <div v-if="edit" :class="{ addActive: editAnim }" class="editBox mt-2">
            <div class="form-group">
                <select
                    data-bs-toggle="tooltip"
                    title="Змінити секцію для категорії"
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
            <input
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Ім'я секції"
                v-model="title"
                placeholder="Уведіть нове ім'я секції"
                type="text"
                class="form-control"
            />

            <textarea
                cols="30"
                rows="5"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Опис секції"
                v-model="description"
                class="form-control"
                placeholder="Опишіть секцію"
            ></textarea>

            <div class="form-group mt-2 c-box" @click="show = !show">
                <!-- Enable icon -->
                <svg
                    v-if="show"
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    class="bi bi-toggle-on"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"
                    />
                </svg>

                <!-- Disable icon -->
                <svg
                    v-if="!show"
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    class="bi bi-toggle-off"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"
                    />
                </svg>

                <span class="showToggleText">
                    {{ showToggleText }}
                </span>
                <!-- /.showToggleText -->
            </div>
            <!-- /.form-group -->

            <div class="form-group ml-4 mt-3">
                <button
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Зберегти нові дані секції"
                    @click="editSubmit"
                    type="button"
                    class="btn btn-dark btn-lg"
                >
                    Зберегти секцію
                </button>
                <!-- /.btn btn-dark btn-lg -->
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.editBox -->
    </div>
    <!-- /.sectionItem -->
</template>

<script>
import IconFollEdit from "./../../ui/icons/IconFullEdit.vue";
import IconTrash from "./../../ui/icons/IconTrash.vue";
import Swal from "sweetalert2";

export default {
    components: {
        IconFollEdit,
        IconTrash
    },
    name: "SectionItem",
    props: {
        section: {
            type: Object
        },
        sections: {
            type: Array
        }
    },
    data() {
        return {
            title: this.section.title,
            sectionName: this.section.sectionName,
            description: this.section.description,
            edit: false,
            editAnim: false,
            sectionSelectId: this.section.sectionId,
            show: this.section.show
        };
    },
    computed: {
        showToggleText() {
            if (this.show) {
                return "Показувати на сторінці";
            }
            return "Не показувати";
        },
        dataFromEdit() {
            return {
                title: this.title,
                description: this.description,
                show: this.show,
                sectionId: this.sectionSelectId
            };
        }
    },
    filters: {
        short(str) {
            if (str.length > 85) {
                return str.substring(0, 85) + "...";
            } else {
                return str;
            }
        }
    },
    methods: {
        load(load) {
            this.$emit("load", load);
        },
        editMode() {
            this.edit = true;
            setTimeout(() => {
                this.editAnim = !this.editAnim;
                if (!this.editAnim) {
                    setTimeout(() => (this.edit = false), 200);
                }
            }, 200);
        },

        editSubmit() {
            this.load(true);
            route("category.update", { category: this.section.id })
                .then(uri => {
                    axios
                        .put(uri.data, this.dataFromEdit)
                        .then(response => {
                            this.load(false);
                            this.$emit("update", true);
                            this.edit = false;
                            this.editAnim = false;
                            Swal.fire({
                                title: "Відредаговано",
                                icon: "success",
                                timer: 850
                            });
                        })
                        .catch(err => Swal.fire("Error edit", "", "error"));
                })
                .catch(err => Swal.fire("Error grtting route", "", "error"));
        },
        destroySubmit() {
            this.load(true);
            route("category.destroy", { category: this.section.id })
                .then(uri => {
                    axios
                        .delete(uri.data)
                        .then(response => {
                            this.load(false);
                            this.$emit("update", true);
                            this.edit = false;
                            this.editAnim = false;
                            Swal.fire({
                                title: "Видалено",
                                icon: "success"
                            });
                        })
                        .catch(err => Swal.fire("Error edit", "", "error"));
                })
                .catch(err => Swal.fire("Error grtting route", "", "error"));
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

.title {
    padding: 0;
    margin: 0.9rem 0.1rem;
    line-height: 28px;
}

.descripption {
    font-size: 12px;
    color: #666;
    padding-top: 0.2rem;
    padding-bottom: 0.4rem;
    border-top: 1px solid #383838;
}

.sectionItem {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 0.3rem;
    border: 1px solid #383838;
    border-radius: 10px;
    margin: 0.3rem;
}

.buttonBox {
    display: flex;
    align-items: center;
    column-gap: 0.7rem;
}

.editBox {
    width: 100%;
    transform: scale(0, 0);
    textarea {
        margin-top: 0.3rem;
    }
    transition: all 0.3s;
}

.addActive {
    transform: scale(1, 1);
    transition: all 0.3s;
}
</style>
