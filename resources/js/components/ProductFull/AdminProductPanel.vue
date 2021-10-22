<template>
    <div class="adminPanel">
        <Spoller
            btn-show-text="Управления товаром"
            btn-hide-text="Закрыть панель управления"
        >
            <div class="c-list">
                <admin-update-category
                    :category-id="categoryId"
                    :product-id="productId"
                    @success="reloadPage"
                />
                <APTitlePrice
                    :title-product="titleProduct"
                    :price-product="priceProduct"
                    :product-id="productId"
                    @success="reloadPage"
                />
                <APImages
                    :imageSelfOne="imageSelfOne"
                    :imageSelfTwo="imageSelfTwo"
                    :imageSelfThree="imageSelfThree"
                    :product-id="productId"
                />
                <APShowToggle :productId="productId" />
            </div>
            <!-- /.c-list -->
        </Spoller>
    </div>
    <!-- /.adminPanel -->
</template>

<script>
import Spoller from "./../Spoller.vue";
import AdminUpdateCategory from "./AdminUpdateCategory.vue";
import APTitlePrice from "./APTitlePrice.vue";
import APImages from "./APImages.vue";
import APShowToggle from "./APShowToggle.vue";
export default {
    props: {
        imageSelfThree: {
            type: Object,
            default: () => {
                return {};
            }
        },
        imageSelfTwo: {
            type: Object,
            default: () => {
                return {};
            }
        },
        imageSelfOne: {
            type: Object,
            default: () => {
                return {};
            }
        },
        titleProduct: {
            type: String
        },
        priceProduct: {
            type: String
        },
        productId: {
            type: Number
        },
        categoryId: {
            type: Number
        }
    },
    components: {
        Spoller,
        AdminUpdateCategory,
        APTitlePrice,
        APImages,
        APShowToggle
    },
    data() {
        return {
            debug: true
        };
    },
    methods: {
        reloadPage() {
            if (!this.debug) {
                document.location.reload();
            } else {
                console.log("Success admin panel");
            }
        }
    }
};
</script>

<style>
.svg-icon {
    width: 2rem;
    height: 2rem;
}

.btn-panel {
    display: inline-flex;
    flex-direction: column;
    gap: 0 10px;
    align-items: center;
    justify-content: center;
    border: 1px solid #313131;
    border-radius: 9px;
    padding: 1rem;
    transition: all 0.6s;
}
.btn-panel:hover {
    background: #00ffa9;
}

.btn-panel:active {
    background: #121212;
    color: white;
}

.btn-icon,
.btn-text {
    display: block;
}
.pointer {
    cursor: pointer;
}

.c-list {
    display: flex;
    gap: 0.7rem 0.7rem;
    flex-wrap: wrap;
}
.c-pallet {
    margin-top: 0.7rem;
}

.red {
    background: red !important;
}
</style>
