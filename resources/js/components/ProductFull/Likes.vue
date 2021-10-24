<template>
    <button
        data-bs-toggle="tooltip"
        :title="tooltipText"
        class="ml-2 btn btn-light"
        @click="likeToggle"
    >
        <IconHeart v-if="!iconHeart" :size="26" />
        <IconHeartFill v-if="iconHeart" :size="26" />
        <span>{{ likesCount }}</span>
    </button>
</template>

<script>
import IconHeart from "./../ui/icons/IconHeart.vue";
import IconHeartFill from "./../ui/icons/IconHeartFill.vue";
export default {
    name: "Likes",
    components: {
        IconHeartFill,
        IconHeart
    },
    props: {
        productId: {
            type: Number,
            required: true
        },
        liked: { type: Boolean, default: () => false },
        auth: { type: Boolean, default: () => false }
    },
    computed: {
        tooltipText() {
            if (this.iconHeart) {
                return "Вы сохранили этот товар.";
            }
            return "Сохранить товар в избранное.";
        }
    },
    data() {
        return {
            likesCount: 0,
            iconHeart: this.liked
        };
    },
    methods: {
        fCount() {
            axios.get("/api/like/count?productId=" + this.productId).then(r => {
                if (r.status === 200) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error(
                            "Error getting count like",
                            r.data.message
                        );
                    } else if (r.data.hasOwnProperty("likes")) {
                        this.likesCount = r.data.likes;
                    } else {
                        console.error("Error response from server", r);
                    }
                } else {
                    console.error("Error Network!!");
                }
            });
        },
        likeToggle() {
            if (!this.auth) {
                window.location.href = "/login";
                return;
            }
            axios.get(`/like/${this.productId}`).then(r => {
                if (r.status === 200) {
                    if (r.data.hasOwnProperty("message")) {
                        console.error(
                            "Error getting count like",
                            r.data.message
                        );
                    } else if (r.data.hasOwnProperty("like")) {
                        this.iconHeart = r.data.like;
                        this.fCount();
                    } else {
                        console.error("Error response from server", r);
                    }
                } else {
                    console.error("Error Network!!");
                }
            });
        }
    },
    mounted() {
        this.fCount();
    }
};
</script>
<style scoped>
button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    column-gap: 0.4rem;
}

span {
    font-weight: bold;
    font-size: 30ox;
}
</style>
