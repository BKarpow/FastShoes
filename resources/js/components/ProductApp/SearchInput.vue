<template>
    <div class="inputArea">
        <input
            @input="$emit('input', search)"
            @keypress="submitFormKey"
            type="text"
            v-model="search"
            placeholder="Имя товара"
        />
        <button @click="submit">
            <icon-glass :size="32" />
        </button>
    </div>
    <!-- /.inputArea -->
</template>

<script>
import IconGlass from "./../ui/icons/IconGlass.vue";
export default {
    name: "SearchInput",
    components: {
        IconGlass
    },
    data() {
        return {
            search: ""
        };
    },
    methods: {
        submitFormKey(ev) {
            if (ev.keyCode === 13) {
                this.submit();
            }
        },
        submit() {
            this.$emit("submit");
        }
    }
};
</script>

<style scoped lang="scss">
.inputArea {
    input {
        outline: none;
        width: 100%;
        position: relative;
        padding: 0.7rem;
        border: 1px solid #383838;
        border-radius: 18px;
        font-weight: bold;
        font-size: 26px;
    }
    button {
        position: absolute;
        width: 30px;
        height: 63px;
        transform: translateX(-190%);
        background: transparent;
        border: none;
        outline: none;
    }
}
</style>
