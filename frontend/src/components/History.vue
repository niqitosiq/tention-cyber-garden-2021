<template>
    <div class="history">
        <h2>Для вас уже постарались</h2>
        <p>Смотрите, какие работы были созданы до вас:</p>
        <div class="wrapper">
            <ImagePreview v-for="item in history" :key="item.date" :img="item.img" :date="item.date" />
        </div>
    </div>
</template>

<script>
import ImagePreview from "@/components/ImagePreview.vue";

export default {
    name: "History",
    components: {
        ImagePreview
    },

    data() {
        return {
            history: [
                { img: '/background.jpg', date: '24.05.2001' },
                { img: '/background.jpg', date: '25.05.2001' },
                { img: '/background.jpg', date: '26.05.2001' },
                { img: '/background.jpg', date: '27.05.2001' },
                { img: '/background.jpg', date: '28.05.2001' },
            ]
        }
    }
    
}
</script>

<style lang="scss">
.history {
    margin-top: 64px;
    width: 100%;
    position: relative;
    h2 {
        font-family: "Roboto";
        font-size: 18px;
        color: white;
        font-weight: 400;
        text-align: center;
    }
    p {
        font-family: "Roboto";
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 300;
        text-align: center;
    }
    .wrapper {
        display: flex;
        width: 100%;
        overflow: hidden;
        margin-top: 39px;
        padding-left: 82px;
        box-sizing: border-box;
    }
}
</style>