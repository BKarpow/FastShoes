<template>
    <form @submit.prevent="doSubmit" class="feedback-form">
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
    </form>
    <!-- /.feedback-form -->
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
