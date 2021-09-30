<template>
    <div class="prompt" :class="{'show':showPrompt}">
        <div class="prompt__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
        </div>
        <!-- /.prompt__icon -->
        <div class="prompt__text">
            <slot></slot>
        </div>
        <!-- /.prompt__text -->
        <div class="prompt__close" @click="onClose">
            <span>&times;</span>
        </div>
        <!-- /.prompt__close -->

    </div>
    <!-- /.prompt -->
</template>

<script>
import Cookies from 'js-cookie'

export default {
    props:{
        namePrompt:{
            type:String,
            default: () => '',
        },
    },
    data(){
        return {
            name: this.namePrompt || 'prompt-default',
            showPrompt: true,
        }
    },
    methods:{
        onClose(){
            Cookies.set(this.name, 'hide', {expires: 365});
            this.showPrompt = false;
        },
        doStart(){
            const c = Cookies.get(this.name);
            // Cookies.remove(this.name);
            if(c === undefined) {
                this.showPrompt = true;
            } else if ( c === 'hide') {
                this.showPrompt = false;
            } else {
                this.showPrompt = true;
            }
        },
    },
    mounted(){
        this.doStart();
    },
}
</script>

<style scoped lang="scss">
    $bg: #0000ff;
    $pd: .7rem;
    $size-icon: 42px;

    .bi-caret-up-fill{
        fill: $bg;
        height: $size-icon;
        width: $size-icon;
    }

    .show{
        opacity: .8 !important;
    }

    .prompt{
        opacity: 0;
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 1000;
        display: inline-flex;
        padding: 0;
        background: $bg !important;
        color: white !important;
        border-radius: 9px;
        transition: all .8s;
        &__icon{
            position: absolute;
            top:  ( ($size-icon/2) - $size-icon );
            left: ($size-icon / 2);
        }
        &__text{
            padding: $pd + 0.3rem;
        }
        &__close{
            padding: $pd;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .6s;
            cursor: pointer;
            &:hover{
                background: darken($bg, 13);
                border-radius: 0 9px 9px 0;
            }
            span{
                font-size: 23px;
            }
        }
    }
</style>