<template>
    <div class="spo">
        <div class="button-box">
            <span class="button" @click="showText = !showText">{{
                textButton
            }}</span>
        </div>
        <!-- /.button-box -->
        <div class="text" v-if="showText">
            <slot></slot>
        </div>
        <!-- /.text -->
    </div>
    <!-- /.spo -->
</template>

<script>
export default {
    props: {
        btnShowText: {
            default: () => "Показать скрытий текст.",
            type: String
        },
        btnHideText: {
            default: () => "Скрыть текст.",
            type: String
        }
    },
    data() {
        return {
            showText: false
        };
    },
    computed: {
        textButton() {
            return this.showText ? this.btnHideText : this.btnShowText;
        }
    }
};
</script>

<style scoped lang="scss">
$border-radius: 9px;
.spo {
    border: 1px solid #383838;
    border-radius: $border-radius;
    .text {
        padding: 0.2rem;
    }
    .button-box {
        border-radius: $border-radius $border-radius 0 0;
        background: #aaaee7;
        padding: 0.2rem;
        .button {
            cursor: pointer;
        }
    }
}
</style>
