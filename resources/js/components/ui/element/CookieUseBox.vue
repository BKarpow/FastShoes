<template>
    <div class="wrapperUseCookie" v-if="!isAccepted">
        <div id="cookieUseBox" v-if="showBox">
            <span class="text">
                Мы используем 🍪cookie, чтобы сделать сайт максимально удобным
                для вас.
            </span>
            <!-- /.text -->
            <button type="button" @click="acceptCookie">Принять</button>
        </div>
        <!-- /#cookieUseBox -->
    </div>
    <!-- /.wrapperUseCookie -->
</template>

<style scoped>
.wrapperUseCookie {
    position: fixed;
    display: flex;
    bottom: 10px;
    justify-content: center;
    align-items: center;
    z-index: 999;
    width: 100%;
}
#cookieUseBox {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    column-gap: 1.5rem;
    padding: 1.3rem;
    background: #111111;
    color: white;
    border-radius: 12px;
    border: 1px solid white;
}

.text {
    font-size: 1rem;
    font-weight: 600;
}
button {
    background: white;
    border-radius: 9px;
    outline: none;
    padding: 1rem;
}
</style>

<script>
export default {
    name: "CookieUseBox",
    computed: {
        getStorageItem() {
            return window.localStorage.getItem(this.nameStorage);
        },
        isAccepted() {
            return this.getStorageItem !== null;
        }
    },
    data() {
        return {
            nameStorage: "cookieAccepted",
            showBox: true
        };
    },
    methods: {
        acceptCookie() {
            window.localStorage.setItem(this.nameStorage, "ok");
            this.showBox = false;
        }
    }
};
</script>
