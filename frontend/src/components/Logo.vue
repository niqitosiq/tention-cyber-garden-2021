<template>
  <div class="logo" @click="$router.push('/')">
    <img src="/logo.png" />
  </div>
</template>

<script>
export default {
  name: 'Logo',
};
</script>

<style lang="scss">
.logo img {
  width: 194px;
  height: 70px;
  margin-top: 162px;
}
</style>
