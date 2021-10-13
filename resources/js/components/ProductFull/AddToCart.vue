<template>
    <div class="add-to-cart">
        <span class="h5 my-1">Выбираете размер.</span>
        <div class="sizes">
            <div class="size" v-for="(s, i) in sizes" :key="i">
                <input
                    :id="s + '-size'"
                    name="size"
                    type="radio"
                    class="size__item custom-radio"
                    :value="s"
                    v-model="selectSize"
                />
                <label :for="s + '-size'" class="size__item label">{{
                    s
                }}</label>
            </div>
            <!-- /.size -->
            <div class="my-1 alert alert-warning" v-if="!isValidSize">
                <span class="h5">Нужно выбрать размер</span>
            </div>
            <!-- /.alert alert-warning -->
        </div>
        <!-- /.sizes -->
        <div class="button-count">
            <div class="count">
                <label for="input-count">Количество</label>
                <input
                    id="input-count"
                    class="input-count"
                    type="number"
                    size="3"
                    maxlength="3"
                    min="1"
                    max="99"
                    v-model="count"
                />
                <div class="mt-1 alert alert-warning" v-if="!isValidCount">
                    <span class="h5">
                        Неправильно указано количество.
                    </span>
                </div>
                <!-- /.mt-1 alert alert-warning -->
            </div>
            <!-- /.count -->
            <div class="button">
                <button
                    class="btn  btn-lg"
                    @click="addToCart"
                    :class="{
                        'btn-dark': !isInCart,
                        'btn-outline-dark': isInCart
                    }"
                >
                    <!-- icon add to cart -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="26"
                        height="26"
                        v-if="!isInCart"
                        fill="currentColor"
                        class="bi bi-cart-plus-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"
                        />
                    </svg>
                    {{ textBtnAddToCart }}
                </button>
                <!-- /.btn btn-dark -->
            </div>
            <!-- /.button -->
        </div>
        <!-- /.button-count -->
    </div>
    <!-- /.add-to-cart -->
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: {
        sizes: {
            type: Array,
            default: () => {
                return [];
            }
        },
        productId: {
            type: Number,
            require: true
        },
        isInCart: {
            type: Boolean,
            default: () => false
        }
    },
    data() {
        return {
            count: 1,
            selectSize: "",
            isValidSize: true,
            isValidCount: true
        };
    },

    computed: {
        textBtnAddToCart() {
            if (this.isInCart) {
                return "Товар уже в корзине";
            }
            return "Добавить в козину";
        },
        dataForm() {
            return {
                productId: this.productId,
                size: this.selectSize,
                count: this.count
            };
        },
        isValidForm() {
            if (this.selectSize === "") {
                this.isValidSize = false;
                return false;
            }
            this.count = Number(this.count);
            if (
                !Number.isInteger(this.count) ||
                this.count < 1 ||
                this.count > 99
            ) {
                this.isValidCount = false;
                return false;
            }
            return true;
        }
    },
    methods: {
        addToCart() {
            if (this.isValidForm) {
                axios.post("/cart/add", this.dataForm).then(r => {
                    if (r.status === 200 && r.data.message === undefined) {
                        console.log("Add to cart - ok");
                        Swal.fire({
                            title: "Товар добавлен в Вашу корзину",
                            html: '<a href="/cart">Перейти в корзину</a>',
                            icon: "success"
                        });
                        this.$emit('success', true)
                    } else {
                        console.error("Error add to cart", r);
                    }
                });
            }
        }
    }
};
</script>

<style scoped lang="scss">
.button {
    align-self: flex-end;
}
.button-count {
    display: flex;
    column-gap: 0.6em;
}
.input-count {
    display: block;
    padding: 0.4em;
    outline: none;
    border: 1px solid #00ffa9;
    border-radius: 6px;
}
.sizes {
    display: flex;
    align-items: center;
    column-gap: 1rem;
}

.custom-radio {
    position: absolute;
    z-index: -1;
    opacity: 0;
}

.custom-radio + label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.custom-radio + label {
    display: inline-block;
    // width: 3em;
    // height: 2em;
    padding: 0.4em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #3ae2ce;
    transition: all 0.3s;
    border-radius: 6px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
}

.custom-radio:not(:disabled):not(:checked) + label:hover {
    border-color: #00ffa9;
}

.custom-radio:not(:disabled):active + label {
    // background-color: #28a745;
    border-color: #28a745;
}

.custom-radio:focus + label {
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.custom-radio:focus:not(:checked) + label {
    border-color: #80bdff;
}

.custom-radio:checked + label {
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.2);
}

.custom-radio:disabled + label {
    background-color: #e9ecef;
}
</style>
