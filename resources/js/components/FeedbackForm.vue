<template>
    <div class="feedback-wrapper mt-2">
        <button
            class="btn btn-success btn-lg"
            type="button"
            v-if="!showForm"
            @click="showForm = true"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-envelope-fill"
                viewBox="0 0 16 16"
            >
                <path
                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"
                />
            </svg>
            Отправить сообщения
        </button>
        <!-- /.btn btn-success btn-lg -->
        <form @submit.prevent="doSubmit" class="feedback-form" v-if="showForm">
            <input
                type="text"
                v-model="name"
                class="feedback-form__input"
                placeholder="Имя"
                maxlength="50"
            />
            <input
                type="email"
                v-model="email"
                maxlength="50"
                required
                class="feedback-form__input"
                placeholder="Ваш Email"
            />
            <textarea
                required
                maxlength="1000"
                placeholder="Сообщения"
                v-model="message"
                cols="30"
                rows="10"
                class="feedback-form__input"
            ></textarea>
            <!-- /#.feedback-form__textarea -->
            <button type="submit">
                <Spiner v-if="process" /> <span> Отправить </span>
            </button>
            <button type="button" @click="showForm = false">
                <span> Отмена </span>
            </button>
        </form>
        <!-- /.feedback-form -->
    </div>
    <!-- /.feedback-wrapper -->
</template>

<script>
import Swal from "sweetalert2";
import Spiner from "./Spiner.vue";
export default {
    components: {
        Spiner
    },
    data() {
        return {
            process: false,
            showForm: false,
            name: "",
            email: "",
            message: ""
        };
    },
    computed: {
        formData() {
            return {
                name: this.name,
                email: this.email,
                message: this.message
            };
        }
    },
    methods: {
        doSubmit() {
            this.process = true;
            axios.post("/feedback", this.formData).then(r => {
                this.process = false;
                if (r.status == 200 && r.data.message != null) {
                    this.name = "";
                    this.email = "";
                    this.message = "";
                    Swal.fire({
                        title: "Ваше сообщения отправлено.",
                        icon: "success"
                    });
                } else {
                    console.error("Error feedback: ", r);
                }
            });
        }
    }
};
</script>

<style scoped lang="scss">
.feedback-form {
    padding: 0.7rem;
    margin-top: 0.7rem;
    &__input {
        width: 100%;
        display: block;
        margin: 0.4rem 0;
        outline: none;
        border: 1px solid #111111;
        background: #202020;
        color: white;
        padding: 0.6rem;
        border-radius: 6px;
    }
    textarea {
        height: 8rem;
    }
    button {
        outline: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        column-gap: 0.8rem;
        background: #202020;
        color: white;
        padding: 0.9rem;
        border: 1px solid #111;
        border-radius: 6px;
    }
}
</style>
