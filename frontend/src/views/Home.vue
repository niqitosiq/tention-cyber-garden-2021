<template>
  <div class="home">
    <Background :image="background" />
    <Logo />
    <Search />
    <History @history="historySet" />
  </div>
</template>

<script>
import Background from '@/components/Background.vue';
import Logo from '@/components/Logo.vue';
import Search from '@/components/Search.vue';
import History from '@/components/History.vue';

export default {
  name: 'Home',
  components: {
    Background,
    Logo,
    Search,
    History,
  },
  data() {
    return {
      background: '/water.png',
    };
  },

  methods: {
    historySet(history) {
      this.background = `http://192.168.43.235:8080/api/images/${history[0]}`;
    },
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
