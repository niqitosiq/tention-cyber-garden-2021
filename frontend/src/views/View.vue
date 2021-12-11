<template>
  <div class="view" ref="view"></div>
</template>

<script>
import * as PIXI from 'pixi.js';

export default {
  name: 'view',

  mounted() {
    const app = new PIXI.Application({
      transparent: true,
      width: window.outerWidth,
      height: window.outerHeight,
      antialias: true,
      ANISOTROPIC_LEVEL: 16,
    });

    app.loader
      .add('layer_1', '/layers/1-mosaic.jpeg')
      .add('layer_1-mask', '/layers/1-mask.jpg')
      .load((loader, resources) => {
        const layer1 = new PIXI.Sprite(resources['layer_1'].texture);
        const layer1Mask = new PIXI.Sprite(resources['layer_1-mask'].texture);

        layer1Mask.width = layer1.width;
        layer1Mask.height = layer1.height;

        let colorMatrix1 = new PIXI.filters.ColorMatrixFilter();
        let colorMatrix2 = new PIXI.filters.ColorMatrixFilter();
        layer1.filters = [colorMatrix1];
        layer1Mask.filters = [colorMatrix2];
        colorMatrix1.contrast(600);
        colorMatrix2.contrast(-100);

        layer1.mask = layer1Mask;
        app.stage.addChild(layer1);
        app.stage.addChild(layer1Mask);
      });

    this.$refs.view.appendChild(app.view);
  },
};
</script>

<style lang="scss">
.view {
}
</style>
