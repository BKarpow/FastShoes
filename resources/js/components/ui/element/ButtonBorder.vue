<template>
    <span class="button" @click="$emit('click')">
        <span> <slot></slot> </span>
    </span>
</template>

<script>
export default {
    name: "ButtonBorder"
};
</script>

<style scoped>
.button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 0.7rem;
    background: transparent;
    color: inherit;
    outline: none;
    font-size: 20px;
    font-weight: bold;
    border: 1px solid #141414;
    border-radius: 10px;
    transition: all 0.6s;
}

.button:hover {
    background: #141414;
    color: white;
    border: 1px solid white;
}

.button:active {
    -webkit-box-shadow: 6px 14px 8px 6px rgba(34, 60, 80, 0.2);
    -moz-box-shadow: 6px 14px 8px 6px rgba(34, 60, 80, 0.2);
    box-shadow: 6px 14px 8px 6px rgba(34, 60, 80, 0.2);
}
</style>
