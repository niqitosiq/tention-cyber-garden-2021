<template>
  <div class="home">
    <Background image="/background.jpg" />
    <Logo />
    <Search />
    <History />
  </div>
</template>

<script>
import Background from "@/components/Background.vue";
import Logo from "@/components/Logo.vue";
import Search from "@/components/Search.vue";
import History from "@/components/History.vue";

export default {
  name: "Home",
  components: {
    Background,
    Logo,
    Search,
    History,
  },
};
</script>

<style lang="scss">
.home {
  display: flex;
  align-items: center;
  flex-direction: column;
}
</style>