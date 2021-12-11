<template>
    <form class="search">
        <img src="/loupe.png" />
        <div class="line"></div>

        <Tag v-for="item in array" :key="item" :item="item"/>
            
        <input v-model="text" type="text" :placeholder="placeholder" @input="checkTag">
        <button class="button" type="button">
            <span>Генерация</span>
        </button>
    </form>
</template>

<script>
import Tag from "@/components/Tag.vue";

export default {
    name: "Search",
    components: {
        Tag,
    },

    data() {
        return {
            text: '',
            array: [],
        }
    },

    computed: {
        placeholder: function () {
           return this.array.length >= 1 ? '' : "Категории генерации изображений"
        }
    },

    methods: {
        checkTag() {
            if (this.text[this.text.length - 1] == ',') {
                this.array.push(this.text.slice(0, -1));
                this.text = '';
                console.log(this.array);
            }
        }
    }
};
</script>

<style lang="scss">
.search {
    display: flex;
    align-items: center;
    position: relative;
    background-color: rgba(255, 255, 255, 0.4);
    border: 1px solid white;
    border-radius: 10px;
    width: 568px;
    margin-top: 26px;
    input {
        background-color: transparent;
        border: none;
        padding-top: 20px;
        padding-bottom: 20px;
        width: 100%;
        padding-left: 18px;
        outline: none;
        color: white;
        font-size: 16px;
        &::placeholder {
            color: white;
            font-family: "Rubik";
            font-weight: 300;
            opacity: 1;
            font-size: 16px;
        }
    }
    .button {
        background-color: #56EEF4;
        border: none;
        border-radius: 10px;
        position: absolute;
        height: calc(100% + 2px);
        right: -1px;
        padding: 20px 42px 20px 42px;
        font-family: "Rubik";
        font-weight: 300;
        font-size: 16px;
        cursor: pointer;
    }
    img {
        padding-top: 20px;
        padding-bottom: 20px;
        padding-left: 23px;
    }
    .line {
        height: 20px;
        width: 1px;
        background-color: white;
        margin-left: 18px;
    }
}
</style>