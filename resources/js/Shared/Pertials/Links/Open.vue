<template>
    <div class="relative flex items-center">
        <input
            class="flex-1 py-2 px-3 rounded bg-gray-50 border border-gray-300 focus:outline-none"
            type="text"
            :value="link"
            disabled
        >
        <a
            class="absolute flex items-center px-2 right-0 top-0 bottom-0 bg-gray-200 hover:bg-green-50 text-gray-500 hover:text-green-400 rounded-tr rounded-br border-t border-b border-r border-gray-300 group text-sm font-bold focus:outline-none"
            target="_blank"
            :href="link"
        >
            <span class="hidden group-hover:block pr-1">Open</span>
            <icon name="link-open" class="block w-5 h-5 stroke-current"/>
        </a>
    </div>
</template>

<script>
import Icon from "../Icon";

export default {
    name: "LinkOpen",
    components: {
        Icon
    },
    props: {
        link: String,
    }
}
</script>

<style scoped>

</style>
