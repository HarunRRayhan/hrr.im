<template>
    <div class="px-2 py-1 rounded-full w-24 flex items-center justify-center bg-green-100 text-green-500">
        <icon name="public" class="block w-3 h-3 fill-current"/>
        <span class="pl-2 font-bold text-sm">Public</span>
    </div>
</template>

<script>
import Icon from "../../Icon";

export default {
    name: "Public",
    components: {
        Icon
    }
}
</script>

<style scoped>

</style>
