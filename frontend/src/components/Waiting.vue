<template>
  <div class="text">
      <p>Получается, вас интересуют <span>Котики</span> вместе с <span>Кроликами</span>,
      а также <span>красный цвет солнца</span>? Интересно...</p>
  </div>
</template>

<script>
export default {
    name: "Waiting",
}
</script>

<style lang="scss">
.text {
    max-width: 635px;
    text-align: center;
    margin-top: 177px;
    p {
        font-family: "Rubik";
        font-size: 26px;
        font-weight: 300;
        color: white;
    }
    span {
        font-family: "Rubik";
        font-size: 26px;
        font-weight: 300;
        color: white;
        border-bottom: 1px solid #56eef4;
    }
}
</style>