<template>
    <div id="reviews">
        <div id="rating" class="my-2">
            <h4>Рейтинг товара</h4>
            <star-rating
                :increment="0.1"
                :read-only="true"
                :show-rating="true"
                :inline="true"
                :fixed-points="1"
                :round-start-rating="false"
                :star-size="50"
                :rating="ratingProduct"
                text-class="text-rating-product"
            />
        </div>
        <!-- /#rating -->
        <div id="formCreate" v-if="isProductOrdered && authFlag == '1'">
            <button
                type="button"
                class="btn btn-info btn-lg"
                v-if="!showCreateForm"
                @click="showCreateForm = true"
            >
                Оставить свой отзыв
            </button>
            <form @submit.prevent="doCreateReviewSubmit" v-if="showCreateForm">
                <div class="form-group">
                    <button
                        type="button"
                        class="btn btn-info"
                        @click="showCreateForm = false"
                    >
                        &times; Спрятать форму
                    </button>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <h5>Оцените товар</h5>
                    <star-rating v-model="rating" />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="yourComment">Ваш отзыв</label>
                    <textarea
                        id="yourComment"
                        v-model="comment"
                        placeholder="Опишите заказ"
                        class="comment"
                    ></textarea>
                    <div class="mt-1 text-right">
                        {{ counterMaxLengthComment }}
                    </div>
                    <!-- /.mt-1 text-right -->
                    <!-- /#.form-control -->
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        Оставить отзыв
                    </button>
                    <!-- /.btn btn-primary btn-block -->
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /#formCreate -->
        <div class="my-1 alert alert-info" id="noAuth" v-if="authFlag != '1'">
            <strong>
                Для того что-бы оставить отзыв, пожалуйста
                <a href="/login"> авторизуйтесь на сайте </a> и сделайте заказ
                на этот товар.
            </strong>
        </div>
        <!-- /#noAuth.my-1 alert alert-info -->
        <div
            class="my-1 alert alert-info"
            id="noOrder"
            v-if="!isProductOrdered"
        >
            <strong>
                Для того что-бы оставить отзыв, сделайте заказ.
            </strong>
        </div>
        <!-- /#noOrder.my-1 alert alert-info -->
        <div id="reviewsList" class="mt-2">
            <div
                class="comment my-1"
                v-for="review in reviews"
                :key="review.id"
            >
                <div class="row">
                    <div class="col-lg-1 col-sm-3 col-md-2 col-4">
                        <img class="circle" :src="review.avatar" />
                    </div>
                    <!-- /.col-sm-2 col-md-1 col-3 avatar -->
                    <div class="pl-lg-4 col-lg-11 col-sm-9 col-md-10 col-4">
                        <h6>
                            {{ review.name }}
                        </h6>
                        <p class="mt-1 ">
                            <star-rating
                                :read-only="true"
                                :show-rating="true"
                                :inline="true"
                                :star-size="18"
                                :rating="review.rating"
                            />
                        </p>
                    </div>
                    <!-- /.col-sm-10 col-md-11 col-9 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col comment__text">
                        <p>{{ review.comment }}</p>
                        <small class="comment__date">
                            {{ review.create }}
                        </small>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.comment -->
        </div>
        <!-- /#reviewsList -->
    </div>
    <!-- /#reviews -->
</template>

<script>
import Cookie from "js-cookie";
import StarRating from "vue-star-rating";
export default {
    props: {
        productId: {
            default: () => 0
        },
        authFlag: {
            default: () => 0
        }
    },
    components: {
        StarRating
    },
    data() {
        return {
            load: false,
            reviews: [],
            rating: 0,
            comment: "",
            maxLengthComment: 249,
            showCreateForm: false,
            ratingProduct: 0
        };
    },

    computed: {
        counterMaxLengthComment() {
            return `${this.maxLengthComment}/${this.comment.length}`;
        },
        urlApiGet() {
            return "/api/reviews/from/" + Number(this.productId);
        },
        uriApiRating() {
            return `/api/reviews/rating/from/${this.productId}`;
        },
        cookieName() {
            return "orderFor_" + this.productId;
        },
        isProductOrdered() {
            return Cookie.get(this.cookieName) !== undefined;
        },
        createReviewData() {
            return {
                productId: this.productId,
                comment: this.comment,
                rating: String(this.rating)
            };
        }
    },
    watch: {
        comment() {
            if (this.comment.length >= this.maxLengthComment) {
                this.comment = this.comment.substring(0, this.maxLengthComment);
            }
        }
    },
    methods: {
        cleanCreateForm() {
            this.rating = 0;
            this.comment = "";
            this.showCreateForm = false;
        },
        doCreateReviewSubmit() {
            this.load = true;
            route("review.store").then(url => {
                axios.post(url.data, this.createReviewData).then(response => {
                    if (response.status === 200) {
                        console.log("create review", response.data);
                        this.cleanCreateForm();
                        this.fetchReviews();
                        this.fetchRating();
                        this.load = false;
                    } else {
                        console.error("Error create review.", response);
                    }
                });
            });
        },
        fetchReviews() {
            axios(this.urlApiGet).then(response => {
                if (
                    response.status === 200 &&
                    response.data.data !== undefined
                ) {
                    this.reviews = response.data.data;
                } else {
                    console.error("Error getting reviews");
                }
            });
        },
        fetchRating() {
            axios.get(this.uriApiRating).then(response => {
                if (response.status === 200) {
                    this.ratingProduct = response.data.rating;
                    console.log("Response rating", response);
                } else {
                    console.error(
                        "Error getting rating from product",
                        response
                    );
                }
            });
        }
    },
    mounted() {
        this.fetchReviews();
        this.fetchRating();
    }
};
</script>

<style scoped lang="scss">
.comment {
    display: block;
    outline: none;
    width: 100%;
    height: auto;
    margin-top: 0.8rem;
    padding: 1rem;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: 1px solid skyblue;
    font-weight: 500;
    font-size: 18px;
}
.circle {
    clip-path: circle(2.1rem);
}
.comment {
    padding: 0.3rem;
    border: 1px solid skyblue;
    border-radius: 9px;
}
.comment_text {
    font-weight: bold;
    margin-top: 0.7rem;
    padding-left: 1rem;
}
.comment__date {
    display: block;
    margin-top: 1rem;
    font-size: 11px;
    color: gray;
}
</style>
