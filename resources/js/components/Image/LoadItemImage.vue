<!-- Use preprocessors via the lang attribute! e.g. <template lang="pug"> -->
<template>
    <div class="imageItem">
        <!-- Close Icob -->
        <svg
            v-if="deleteIcon"
            @click="doDelete"
            xmlns="http://www.w3.org/2000/svg"
            width="32"
            height="32"
            fill="red"
            class="closeSvg bi bi-x-circle-fill"
            viewBox="0 0 16 16"
        >
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"
            />
        </svg>
        <label>
            <input type="file" v-if="!isSelf" ref="file" @change="doSubmit" />
            <span>
                <div v-if="spiner" class="spinner-border" role="status">
                    <span class="hidden visually-hidden">Loading...</span>
                </div>
                <img v-if="imageBox || isSelf" :src="imageSrc" alt="" />
                <strong v-if="errorText.length > 0">{{ errorText }}</strong>
                <!-- LoadIcon -->
                <svg
                    v-if="icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    fill="currentColor"
                    class="bi bi-file-earmark-plus-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"
                    />
                </svg>
            </span>
        </label>
        <input
            type="hidden"
            v-if="hiddenBlock"
            :name="nameField"
            :value="hiddenFieldValue"
        />
    </div>
</template>

<script>
export default {
    name: "ImageUploadBox",
    props: {
        imageIndex: {
            type: Number,
            default: () => 0
        },
        nameField: {
            type: String,
            default: () => ""
        },
        hiddenBlock: {
            type: Boolean,
            default: () => {
                return false;
            }
        },
        imageSelf: {
            default: () => {
                return {};
            }
        }
    },
    data() {
        return {
            spiner: false,
            icon: true,
            deleteIcon: false,
            imageBox: false,
            image: "",
            errorText: "",
            responseFile: ""
        };
    },

    computed: {
        isSelf() {
            if (this.imageSelf == null) {
                return false;
            }
            return this.imageSelf.hasOwnProperty("id");
        },
        imageSrc() {
            if (
                typeof this.responseFile === "object" &&
                this.responseFile.hasOwnProperty("uri")
            ) {
                return this.responseFile.uri;
            } else if (
                this.imageSelf != null &&
                this.imageSelf.hasOwnProperty("uri")
            ) {
                return this.imageSelf.uri;
            }
            return "";
        },
        isWebP() {
            if (
                typeof this.responseFile === "object" &&
                this.responseFile.type !== undefined
            ) {
                return this.responseFile.type.lowercase() === "webp";
            }
            return false;
        },
        hiddenFieldValue() {
            return this.responseFile.uri || "";
        }
    },

    methods: {
        cleanStade() {
            console.log("clean stade from image");
            this.spiner = false;
            this.icon = true;
            this.deleteIcon = false;
            this.imageBox = false;
            this.image = "";
            this.errorText = "";
            this.responseFile = "";
        },

        doSubmit() {
            const formData = new FormData();
            formData.append("file", this.$refs.file.files[0]);
            this.icon = false;
            this.spiner = true;
            this.errorText = "";
            route("home.upload.image")
                .then(uri => {
                    axios
                        .post(uri.data, formData, {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            }
                        })
                        .then(resp => {
                            this.spiner = false;
                            this.errorText = "";
                            this.imageBox = true;
                            this.deleteIcon = true;
                            this.responseFile = resp.data;
                            this.$emit("upload", this.responseFile);
                            this.$emit("upload:index", {
                                data: this.responseFile,
                                index: this.imageIndex
                            });
                        })
                        .catch(err => {
                            console.error("Error load file");
                            this.spiner = false;
                            this.errorText = "Error!!";
                            this.$emit("error", "Error load file!");
                        });
                })
                .catch(err => console.error("Error getting route name"));
        },
        doDelete() {
            if (
                this.responseFile.id !== undefined ||
                this.imageSelf.id !== undefined
            ) {
                const fileId = this.responseFile.id || this.imageSelf.id;
                route("home.upload.delete", { fileId: fileId })
                    .then(u => {
                        axios
                            .delete(u.data)
                            .then(resp => {
                                this.spiner = false;
                                this.imageBox = false;
                                this.icon = true;
                                this.deleteIcon = false;
                                this.$emit("delete", this.responseFile.id);
                                this.responseFile = "";
                                this.imageSelf = {};
                            })
                            .catch(err => {
                                console.error("Error delete file");
                            });
                    })
                    .catch(err => console.error("Error getting route name"));
            }
        }
    },
    mounted() {
        if (this.isSelf) {
            this.icon = false;
            this.deleteIcon = true;
        }
    }
};
</script>

<style scoped lang="scss">
$block-size: 8em;

.hidden {
    display: none;
    visibility: hidden;
}
input[type="file"] {
    display: none;
}
label {
    display: inline-flex;
    border: 1px solid #383838;
    width: $block-size;
    height: $block-size;
    align-items: center;
    justify-content: center;
    background: #cccccc;
    border-radius: 10px;
    cursor: pointer;
    img {
        max-width: 95%;
        margin-left: 2.5%;
        max-height: $block-size - 1.5em;
        overflow: hidden;
        border-radius: 10px;
    }
}
.imageItem {
    display: inline-block;
    position: relative;
}
.closeSvg {
    position: absolute;
    z-index: 33;
    right: -0.3em;
    top: -0.2em;
    border: 1px solid white;
    border-radius: 50%;
    cursor: pointer;
}
</style>
