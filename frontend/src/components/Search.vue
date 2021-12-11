<template>
  <form class="search">
    <img src="/loupe.png" />
    <div class="line"></div>

    <Tag v-for="item in tags" :key="item" :item="item" />

    <input
      v-model="text"
      type="text"
      :placeholder="placeholder"
      @input="checkTag"
      @keydown="checkKeyDown"
    />
    <button class="button" type="button">
      <span>Генерация</span>
    </button>
  </form>
</template>

<script>
import Tag from '@/components/Tag.vue';

export default {
  name: 'Search',
  components: {
    Tag,
  },

  data() {
    return {
      text: '',
      tags: [],
    };
  },

  computed: {
    placeholder: function () {
      return this.tags.length >= 1 ? '' : 'Категории генерации изображений';
    },
  },

  methods: {
    checkTag() {
      if (this.tags.length > 3) return;

      if (this.text[this.text.length - 1] == ',') {
        this.tags.push(this.text.slice(0, -1));
        this.text = '';
      }
    },
    checkKeyDown({ keyCode }) {
      if (keyCode === 8 && this.text === '') {
        this.tags = this.tags.slice(0, -1);
      }
    },
  },
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
  padding-right: 200px;
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
    flex-shrink: 0;
    &::placeholder {
      color: white;
      font-family: 'Rubik';
      font-weight: 300;
      opacity: 1;
      font-size: 16px;
    }
  }
  .button {
    background-color: #56eef4;
    border: none;
    border-radius: 10px;
    position: absolute;
    height: calc(100% + 2px);
    right: -1px;
    padding: 20px 42px 20px 42px;
    font-family: 'Rubik';
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
    flex-shrink: 0;
  }
}
</style>
