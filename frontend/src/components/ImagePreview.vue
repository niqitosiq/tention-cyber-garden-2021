<template>
  <div class="imagePreview">
    <img :src="img" />
    <p>{{ date }}</p>
  </div>
</template>

<script>
export default {
  name: 'ImagePreview',
  props: ['img', 'date'],
};
</script>

<style lang="scss">
.imagePreview {
  position: relative;
  overflow: hidden;
  width: 373px;
  height: 266px;
  flex-shrink: 0;
  border-radius: 20px;
  margin-left: 26px;
  margin-right: 26px;
  p {
    position: absolute;
    font-family: 'Roboto';
    font-size: 16px;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 400;
    bottom: 0;
    left: 0;
    z-index: 2;
    margin-left: 36px;
    margin-bottom: 21px;
  }
  img {
    width: 100%;
    height: 100%;
  }
  &::after {
    content: '';
    width: 100%;
    height: 111px;
    position: absolute;
    bottom: 0;
    left: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, #00000080 61.98%);
    z-index: 1;
  }
}
</style>
