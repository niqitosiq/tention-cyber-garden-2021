<template>
  <div class="loading">
      <Background image="/background.jpg" />
      <Logo />
      <Waiting />
  </div>
</template>

<script>
import Background from "@/components/Background.vue";
import Logo from "@/components/Logo.vue";
import Waiting from "@/components/Waiting.vue";

export default {
  name: "Loading",
  components: {
      Background,
      Logo,
      Waiting
  },
};
</script>

<style lang="scss">
.loading {
    display: flex;
    align-items: center;
    flex-direction: column;
}
</style>