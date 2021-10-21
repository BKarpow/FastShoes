<template>
    <div class="adminPanel">
        <Spoller>
            <admin-update-category
                :category-id="categoryId"
                :product-id="productId"
                @success="reloadPage"
            />
        </Spoller>
    </div>
    <!-- /.adminPanel -->
</template>

<script>
import Spoller from "./../Spoller.vue";
import AdminUpdateCategory from "./AdminUpdateCategory.vue";
export default {
    props: {
        productId: {
            type: Number
        },
        categoryId: {
            type: Number
        }
    },
    components: {
        Spoller,
        AdminUpdateCategory
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
