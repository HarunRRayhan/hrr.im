<template>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">&nbsp;</th>
                <th class="px-6 pt-6 pb-4">&nbsp;</th>
                <th class="w-1/4 max-w-2xl px-6 pt-6 pb-4">Label</th>
                <th class="w-1/4 max-w-2xl px-6 pt-6 pb-4">Shortlink</th>
                <th class="px-6 pt-6 pb-4 text-center">Type</th>
                <th class="w-1/4 max-w-2xl px-6 pt-6 pb-4">Full URL</th>
                <th class="px-6 pt-6 pb-4">&nbsp;</th>
            </tr>
            <tr
                v-for="link in links"
                :key="link.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t w-px">
                    <inertia-link
                        class="px-4 flex items-center"
                        :href="route('links.show', link)"
                        tabindex="-1"
                    >
                        <icon name="view-tile" class="block w-5 h-5 fill-gray-500 hover:fill-indigo-700"/>
                    </inertia-link>
                </td>
                <td class="border-t w-px">
                    <inertia-link
                        class="px-4 flex items-center"
                        :href="route('links.edit', link)"
                        tabindex="-1"
                    >
                        <icon name="edit" class="block w-6 h-6 fill-gray-500 hover:fill-indigo-700"/>
                    </inertia-link>
                </td>
                <td class="w-1/4 max-w-2xl border-t overflow-hidden">
                    <inertia-link
                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                        :href="route('links.show', link)"
                    >
                        {{ link.label }}
                    </inertia-link>
                </td>
                <td class="w-1/4 max-w-2xl px-6 border-t">
                    <copy :link="link.shortlink"/>
                </td>
                <td class="border-t">
                    <div class="flex justify-center">
                        <public v-if="link.is_public"/>
                        <private v-else/>
                    </div>
                </td>
                <td class="w-1/4 max-w-2xl px-6 border-t">
                    <open :link="link.full_link"/>
                </td>
                <td class="border-t w-px">
                    <button @click.prevent="$emit('deleting', link)">
                        <icon name="bin" class="block w-6 h-6 ill-gray-400 hover:fill-red-600"/>
                    </button>
                </td>
            </tr>
            <tr v-if="!links.length">
                <td class="border-t px-6 py-4" colspan="4">No shortlink found.</td>
            </tr>
        </table>
    </div>
</template>

<script>
import Icon from "./Icon";
import Copy from "./Pertials/Links/Copy";
import Open from "./Pertials/Links/Open";
import Public from "./Components/Labels/Public";
import Private from "./Components/Labels/Private";

export default {
    name: "LinkTable",
    components: {
        Icon,
        Copy,
        Open,
        Public,
        Private
    },
    props: {
        links: Array
    }
}
</script>

<style scoped>

</style>
