<template>
  <div class="background">
    <img :src="image" />
  </div>
</template>

<script>
export default {
  name: "Background",
  props: [
    'image'
  ],
  components: {},
};
</script>

<style lang="scss">
.background {
  &::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #000;
    opacity: 0.5;
    top: 0;
    left: 0;
    z-index: -1;
  }
  img {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    object-fit: cover;
    z-index: -1;
  }
}
</style>