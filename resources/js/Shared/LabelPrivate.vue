<template>
    <div class="px-2 py-1 rounded-full w-24 flex items-center justify-center bg-red-100 text-red-500">
        <icon name="lock-closed" class="block w-3 h-3 fill-current"/>
        <span class="pl-2 font-bold text-sm">Private</span>
    </div>
</template>

<script>
import Icon from "./Icon";

export default {
    name: "LabelPrivate",
    components: {
        Icon
    }
}
</script>

<style scoped>

</style>
