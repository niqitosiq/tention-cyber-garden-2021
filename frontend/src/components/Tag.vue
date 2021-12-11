<template>
    <div class="tag">
        {{ item }}
    </div>
</template>

<script>
export default {
    name: "Tag",
    props: [
        'item'
    ]
}
</script>

<style lang="scss">
    .tag {
        background-color: rgba(86, 238, 244, 0.6);
        border-radius: 6px;
        padding: 6px 13px 6px 13px;
        color: white;
        font-size: 16px;
        font-family: "Rubik";
        margin-left: 20px;
        & + & {
            margin-left: 5px;
        }
    }
</style>