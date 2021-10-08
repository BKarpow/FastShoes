<template>
    <div id="reviews">
        <div id="rating" class="my-2" v-if="allRatings !== undefined">
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
            <div class="mt-1">
                <h6>Всего голосов {{ countRatings }}.</h6>
                <ul class="list-group">
                    <li
                        class="list-group-item ratingsItemList"
                        v-if="allRatings['1'] !== undefined"
                    >
                        <star-rating
                            :read-only="true"
                            :inline="true"
                            :star-size="18"
                            :rating="1"
                        />
                        <div class="w-100 progress">
                            <div
                                class="progress__line"
                                :style="
                                    'width:' +
                                        computedRatingPercentageFromItem(
                                            allRatings['1']
                                        )
                                "
                            ></div>
                            <!-- /.progress__line -->
                        </div>
                        <!-- /.progress -->
                        <span>{{ allRatings["1"] }}</span>
                    </li>
                    <!-- /.list-group-item -->

                    <li
                        class="list-group-item ratingsItemList"
                        v-if="allRatings['2'] !== undefined"
                    >
                        <star-rating
                            :read-only="true"
                            :inline="true"
                            :star-size="18"
                            :rating="2"
                        />
                        <div class="w-100 progress">
                            <div
                                class="progress__line"
                                :style="
                                    'width:' +
                                        computedRatingPercentageFromItem(
                                            allRatings['2']
                                        )
                                "
                            ></div>
                            <!-- /.progress__line -->
                        </div>
                        <!-- /.progress -->
                        <span>{{ allRatings["2"] }}</span>
                    </li>
                    <!-- /.list-group-item -->

                    <li
                        class="list-group-item ratingsItemList"
                        v-if="allRatings['3'] !== undefined"
                    >
                        <star-rating
                            :read-only="true"
                            :inline="true"
                            :star-size="18"
                            :rating="3"
                        />
                        <div class="w-100 progress">
                            <div
                                class="progress__line"
                                :style="
                                    'width:' +
                                        computedRatingPercentageFromItem(
                                            allRatings['3']
                                        )
                                "
                            ></div>
                            <!-- /.progress__line -->
                        </div>
                        <!-- /.progress -->
                        <span>{{ allRatings["3"] }}</span>
                    </li>
                    <!-- /.list-group-item -->

                    <li
                        class="list-group-item ratingsItemList"
                        v-if="allRatings['4'] !== undefined"
                    >
                        <star-rating
                            :read-only="true"
                            :inline="true"
                            :star-size="18"
                            :rating="4"
                        />
                        <div class="w-100 progress">
                            <div
                                class="progress__line"
                                :style="
                                    'width:' +
                                        computedRatingPercentageFromItem(
                                            allRatings['4']
                                        )
                                "
                            ></div>
                            <!-- /.progress__line -->
                        </div>
                        <!-- /.progress -->
                        <span>{{ allRatings["4"] }}</span>
                    </li>
                    <!-- /.list-group-item -->

                    <li
                        class="list-group-item ratingsItemList"
                        v-if="allRatings['5'] !== undefined"
                    >
                        <star-rating
                            :read-only="true"
                            :inline="true"
                            :star-size="18"
                            :rating="5"
                        />
                        <div class="w-100 progress">
                            <div
                                class="progress__line"
                                :style="
                                    'width:' +
                                        computedRatingPercentageFromItem(
                                            allRatings['5']
                                        )
                                "
                            ></div>
                            <!-- /.progress__line -->
                        </div>
                        <!-- /.progress -->
                        <span>{{ allRatings["5"] }}</span>
                    </li>
                    <!-- /.list-group-item -->
                </ul>
                <!-- /.list-group -->
            </div>
            <!-- /.mt-1 -->
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
            <p>
                Для того что-бы оставить отзыв, пожалуйста
                <a href="/login"> авторизуйтесь на сайте </a> и сделайте заказ
                на этот товар.
            </p>
        </div>
        <!-- /#noAuth.my-1 alert alert-info -->
        <div
            class="my-1 alert alert-info"
            id="noOrder"
            v-if="!isProductOrdered && authFlag == '1'"
        >
            <p>
                Для того что-бы оставить отзыв, сделайте заказ.
            </p>
        </div>
        <!-- /#noOrder.my-1 alert alert-info -->
        <div id="reviewsList" class="mt-2">
            <div
                class="comment my-1"
                v-for="review in reviews.data"
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
        <div class="pageBox" v-if="isPaginate">
            <button
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Предыдущая страница"
                v-if="prevPage"
                type="button"
                @click="goPage(prevPage)"
                class="p-btn p-prev"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="currentColor"
                    class="bi bi-caret-left"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"
                    />
                </svg>
            </button>
            <!-- /.p-btn -->
            <div
                class="p-text d-flex align-items-center justify-content-center"
            >
                <span
                    data-bs-toggle="tooltip"
                    title="Поточна/Всього сторінок"
                    class="pagesText"
                    >{{ pageText }}</span
                >
                <!-- /.pagesText -->
            </div>
            <!-- /.p-text -->
            <button
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Следующая страница"
                v-if="nextPage"
                type="button"
                @click="goPage(nextPage)"
                class="p-btn p-next"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="currentColor"
                    class="bi bi-caret-right"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"
                    />
                </svg>
            </button>
            <!-- /.p-btn -->
        </div>
        <!-- /.pageBox -->
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
            ratingProduct: 0,
            allRatings: [],
            countRatings: 0,
            paginatePage: ""
        };
    },

    computed: {
        userOrderedPhone() {
            return Cookie.get("my_phone");
        },
        counterMaxLengthComment() {
            return `${this.maxLengthComment}/${this.comment.length}`;
        },
        urlApiGet() {
            if (this.paginatePage === "") {
                return "/api/reviews/from/" + Number(this.productId);
            }
            return this.paginatePage;
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
                rating: String(this.rating),
                phoneOrdered: this.userOrderedPhone
            };
        },
        isPaginate() {
            if (this.reviews.links === undefined) {
                return false;
            }
            if (
                this.reviews.links.prev === null &&
                this.reviews.links.next === null
            ) {
                return false;
            }
            return true;
        },
        nextPage() {
            if (this.reviews.links.next === null) {
                return false;
            }
            return this.reviews.links.next;
        },
        prevPage() {
            if (this.reviews.links.prev === null) {
                return false;
            }
            return this.reviews.links.prev;
        },
        pageText() {
            return `${this.reviews.meta.current_page}/${this.reviews.meta.last_page}`;
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
        goPage(uriPage) {
            this.paginatePage = uriPage;
            this.fetchReviews();
        },
        computedRatingPercentageFromItem(count) {
            return " " + (100 / this.countRatings) * count + "%";
        },
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
                    this.reviews = response.data;
                } else {
                    console.error("Error getting reviews");
                }
            });
        },
        fetchRating() {
            axios.get(this.uriApiRating).then(response => {
                if (response.status === 200) {
                    this.ratingProduct = response.data.rating;
                    this.allRatings = response.data.all;
                    this.countRatings = response.data.count;
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
    padding: 1.3rem;
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

.ratingsItemList {
    display: flex;
    justify-content: space-between;
    column-gap: 1rem;
    align-items: center;
    span {
        font-size: 20px;
        font-weight: bold;
    }
}
.progress {
    height: 0.4rem;
    background: #d8d8d8;
    &__line {
        background: #ffd055;
        height: 100%;
    }
}
</style>
