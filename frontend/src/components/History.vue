<template>
  <div class="history">
    <h2>Для Вас уже постарались</h2>
    <p>Смотрите, какие работы были созданы до Вас:</p>
    <div class="wrapper">
      <ImagePreview
        v-for="item in history"
        :key="item.date"
        :img="`http://192.168.43.235:8080/api/images/${item}`"
      />
    </div>
  </div>
</template>

<script>
import ImagePreview from '@/components/ImagePreview.vue';
import axios from 'axios';

export default {
  name: 'History',
  components: {
    ImagePreview,
  },

  data() {
    return {
      history: [],
    };
  },

  async mounted() {
    console.log('hiii');
    const instance = axios.create({
      baseURL: 'http://192.168.43.235:8080/api/',
      timeout: 10000000000000,
    });

    const { data: history } = await instance.get('history/6');

    this.history = history;

    this.$emit('history', history);
  },
};
</script>

<style lang="scss">
.history {
  margin-top: 64px;
  width: 100%;
  position: relative;
  padding-bottom: 64px;
  h2 {
    font-family: 'Rubik';
    font-size: 18px;
    color: white;
    font-weight: 400;
    text-align: center;
  }
  p {
    font-family: 'Rubik';
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
