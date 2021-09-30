<template>
    <span class="counts" @click="fetchCountNewOrders">
        {{ countNewOrders }}
    </span>
</template>

<script>
export default {
    data() {
        return {
            countNewOrders: 0
        };
    },
    methods: {
        fetchCountNewOrders() {
            route("newOrders").then(u => {
                axios.get(u.data).then(r => {
                    if (r.status === 200) {
                        this.countNewOrders = r.data.newOrders;
                    } else {
                        console.error("Error response.", r);
                    }
                });
            });
        }
    },
    mounted() {
        this.fetchCountNewOrders();
    }
};
</script>

<style scoped>
span {
    /* display: inline-block; */
    padding: 0.4rem;
    border-radius: 5px;
    background: #383838;
    color: white;
    cursor: pointer;
    font-size: 13px;
}
</style>
