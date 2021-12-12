<template>
  <div class="view" ref="view">
    <Logo />

    <div class="tags">
      <Tag v-for="tag in tags" :key="tag" :item="tag" />
    </div>

    <Background :image="result || '/water.png'" />

    <img class="image" v-if="result" :src="result" alt="" />

    <Waiting v-else />

    <button class="button" type="button" @click="reload">
      <span>Не хватило? Ещё. </span>
    </button>
  </div>
</template>

<script>
import * as PIXI from 'pixi.js';
import axios from 'axios';
import Tag from '@/components/Tag.vue';
import Background from '@/components/Background.vue';
import Logo from '@/components/Logo.vue';
import Waiting from '@/components/Waiting.vue';

export default {
  name: 'view',

  components: {
    Tag,
    Background,
    Waiting,
    Logo,
  },

  data() {
    return {
      result: null,
      tags: [],
      loading: true,
    };
  },

  async mounted() {
    const { tags } = this.$route.query;

    this.tags = tags;

    const instance = axios.create({
      baseURL: 'http://192.168.43.235:8080/api/',
      timeout: 10000000000000,
    });

    const { data: art } = await instance.post('generateArt', {
      words: tags,
    });

    this.result = art.result.results[0];
    this.loading = false;

    // const app = new PIXI.Application({
    //   transparent: true,
    //   width: window.outerWidth,
    //   height: window.outerHeight,
    //   antialias: true,
    //   ANISOTROPIC_LEVEL: 16,
    // });

    // app.loader
    //   .add('layer_1', '/layers/1-mosaic.jpeg')
    //   .add('layer_1-mask', '/layers/1-mask.jpg')
    //   .load((loader, resources) => {
    //     const layer1 = new PIXI.Sprite(resources['layer_1'].texture);
    //     const layer1Mask = new PIXI.Sprite(resources['layer_1-mask'].texture);

    //     layer1Mask.width = layer1.width;
    //     layer1Mask.height = layer1.height;

    //     let colorMatrix1 = new PIXI.filters.ColorMatrixFilter();
    //     let colorMatrix2 = new PIXI.filters.ColorMatrixFilter();
    //     layer1.filters = [colorMatrix1];
    //     layer1Mask.filters = [colorMatrix2];
    //     colorMatrix1.contrast(600);
    //     colorMatrix2.contrast(-100);

    //     layer1.mask = layer1Mask;
    //     app.stage.addChild(layer1);
    //     app.stage.addChild(layer1Mask);
    //   });

    // this.$refs.view.appendChild(app.view);
  },

  methods: {
    reload() {
      location.reload();
    },
  },
};
</script>

<style lang="scss">
.view {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px 0;

  .logo img {
    margin-top: 0;
  }

  .image {
    margin-bottom: 20px;
  }

  .tags {
    display: flex;
    margin-bottom: 20px;
    margin-top: 20px;
    margin-left: -20px;
  }

  .button {
    position: static;
  }
}
</style>
