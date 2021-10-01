<template>
    <div class="order">
        <div class="order__title">
            <h3>Быстрий заказ</h3>
            <div class="my-1">
                <div
                    class="alert alert-success"
                    v-if="isOrdered || successCreated"
                >
                    <strong>Вы уже делали заказ на этот товар.</strong>
                </div>
                <!-- /.alert alert-success -->
            </div>
            <!-- /.my-1 -->
            <button
                v-if="!showOrderForm"
                class="btn btn-success btn-lg"
                @click="showForm"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-return-right"
                    viewBox="0 0 16 16"
                >
                    <path
                        fill-rule="evenodd"
                        d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"
                    />
                </svg>
                Купить в один клик
            </button>
            <!-- /.btn btn-success btn-lg -->
        </div>
        <!-- /.order__title -->
        <div class="order__form" v-show="showOrderForm">
            <form action="" @submit.prevent="doOrder">
                <div class="form-group">
                    <vSelect
                        :options="sizes"
                        v-model="selectSize"
                        placeholder="Какой Ваш размер?"
                    >
                    </vSelect>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="phone-number">Укажите Ваш телефон?</label>
                    <input
                        v-model="phone"
                        type="tel"
                        id="phone-number"
                        :class="{ 'red-border': phoneError }"
                        class="form-control transit"
                        ref="phoneField"
                    />
                    <p class="mt-1" v-if="phoneError" style="color:red;">
                        Извините, но нужно указать правильный номер телефона.
                    </p>
                    <!-- /.mt-1 -->
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <div
                        class="d-flex align-items-baseline"
                        role="group"
                        aria-label="Использовать мессенджер"
                    >
                        <input
                            type="checkbox"
                            class="btn-check"
                            id="use-messager"
                            v-model="useMessager"
                            autocomplete="off"
                        />
                        <label
                            class="pl-1"
                            aria-label="Вы хотите что-бы при общени с Вами менеджер ислозовал месенжеры (Telegram, Viber, WatsApp). Если нет, то оставти галочку пустой и мы вам перезвоним."
                            for="use-messager"
                            >Использовать мессенджеры
                            <info
                                >Поставьте галочку что-бы мы общались с вами
                                только через мессенджеры, такие как Telegram,
                                Viber, WatsApp</info
                            >
                        </label>
                    </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <button
                        data-bs-toggle="tooltip"
                        :title="orderButtonInfo"
                        class="btn btn-primary"
                        type="submit"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-cart-check-fill"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"
                            />
                        </svg>
                        Заказать
                    </button>
                    <!-- /.btn btn-primary -->
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.order__form -->
        <div class="order__button"></div>
        <!-- /.order__button -->
    </div>
    <!-- /.order -->
</template>

<script>
import vSelect from "vue-select";
import Inputmask from "inputmask";
import Info from "../Info.vue";

import Cookies from "js-cookie";
import Swal from "sweetalert2";
export default {
    props: {
        sizeData: {
            type: String
        },
        productId: {
            type: String
        },
        price: {
            type: String
        }
    },
    components: {
        vSelect,
        Info
    },
    data() {
        return {
            sizes: JSON.parse(this.sizeData),
            selectSize: "",
            phone: "",
            phoneMask: "",
            phoneError: false,
            useMessager: false,
            showOrderForm: false,
            successCreated: false
        };
    },
    watch: {
        // phone(){
        //     console.log('isComplit', this.phoneMask.isComplete())
        // },
    },
    computed: {
        isSavedUserPhone() {
            return Cookies.get("my_phone") !== undefined;
        },
        getSavedUserPhone() {
            return Cookies.get("my_phone");
        },
        isOrdered() {
            return Cookies.get(this.cookieName) !== undefined;
        },
        isValidPhone() {
            return this.phoneMask.isComplete();
        },
        cookieName() {
            return "orderrFor_" + this.productId;
        },
        orderButtonInfo() {
            let text = `Вы заказываете ${this.selectSize}-й размер, с Вами свяжется за номером ${this.phone}.`;
            if (this.useMessager) {
                text += " Вы хотите общаться по мессенджерах.";
            } else {
                text += "Вам позвонить.";
            }
            text += " Все верно?";
            return text;
        },
        formData() {
            return {
                productId: this.productId,
                phone: this.phone,
                size: this.selectSize,
                price: this.price,
                useMessager: this.useMessager
            };
        }
    },
    methods: {
        showForm() {
            this.showOrderForm = true;
            this.phoneMask = Inputmask("+380(99) 999-99-99").mask(
                this.$refs.phoneField
            );
            if (this.isSavedUserPhone) {
                this.phone = this.getSavedUserPhone;
            }
        },

        doOrder() {
            this.showOrderForm = false;
            if (!this.isValidPhone) {
                this.phoneError = true;
                return;
            } else {
                this.phoneError = false;
            }
            route("new.order").then(r => {
                axios.post(r.data, this.formData).then(resp => {
                    if (resp.status === 200 && resp.data.errors === undefined) {
                        this.successCreated = true;

                        Cookies.set(this.cookieName, "1", { expires: 6 });
                        Cookies.set("my_phone", this.phone, { expires: 100 });
                        Swal.fire({
                            title: "Заказ успешно создан.",
                            html:
                                "<p>Ожидайте, с Вами свяжется наш менеджер для уточнения заказа.</p>",
                            icon: "success"
                        });
                        console.log("Order created");
                    } else if (resp.data.errors) {
                        Swal.fire({
                            title: "Ошибка формы заказа",
                            icon: "error"
                        });
                    } else {
                        console.error("Error create form!", resp.data);
                    }
                });
            });
        }
    },
    mounted() {
        // this.phoneMask = Inputmask('+380(99) 999-99-99').mask(this.$refs.phoneField);
        window.setTooltips();
    },
    updated() {
        // window.setTooltips();
        // this.phoneMask = Inputmask('+380(99) 999-99-99').mask(this.$refs.phoneField);
    }
};
</script>

<style scoped>
.transit {
    transition: all 0.8s !important;
}
.red-border {
    border: 2px solid red;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.8s !important;
}
</style>
