<template>
  <div class="text">
    <p>
      Генерируем для Вас изображение по <span>тегам</span>... Стойте, что? Вы
      <span>правда</span> хотите это увидеть? Ладно...
    </p>
  </div>
</template>

<script>
export default {
  name: 'Waiting',
};
</script>

<style lang="scss">
.text {
  max-width: 635px;
  text-align: center;
  margin-top: 30px;
  margin-bottom: 30px;
  p {
    font-family: 'Rubik';
    font-size: 26px;
    font-weight: 300;
    color: white;
  }
  span {
    font-family: 'Rubik';
    font-size: 26px;
    font-weight: 300;
    color: white;
    border-bottom: 1px solid #56eef4;
  }
}
</style>
