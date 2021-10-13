<template>
    <a
        href="/cart"
        data-bs-toggle="tooltip"
        title="Ваша корзина"
        class="cart-info mx-3"
    >
        <!-- icon cart -->
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="currentColor"
            class="bi bi-cart-fill"
            viewBox="0 0 16 16"
        >
            <path
                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
            />
        </svg>
        <span>{{ sum }} грн.</span>
    </a>
    <!-- /.cart-info -->
</template>

<script>
export default {
    data() {
        return {
            sum: 0
        };
    },
    methods: {
        fetchSum() {
            axios.post("/cart/sum", {}).then(r => {
                if (r.data.message === undefined) {
                    this.sum = r.data.sum;
                } else {
                    console.error("Error getting sum");
                }
            });
        }
    },
    mounted() {
        this.fetchSum();
        setTooltips();
    }
};
</script>
