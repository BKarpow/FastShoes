<template>
    <div class="spo" v-cloak>
        <div class="button-box" @click="showText = !showText">
            <span class="button d-block text-center">{{ textButton }}</span>
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
[v-cloak] {
    display: none;
}
$border-radius: 6px;
.button {
    font-size: 18px;
    font-weight: bold;
}
.spo {
    // border: 1px solid #43506c;
    border-radius: $border-radius;
    .text {
        padding: 0.2rem;
    }
    .button-box {
        border-radius: $border-radius $border-radius 0 0;
        background: lighten(#28a745, 45);
        padding: 0.5rem;
        .button {
            cursor: pointer;
        }
    }
}
</style>
