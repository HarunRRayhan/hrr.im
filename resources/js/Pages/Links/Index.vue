<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter class="w-full max-w-md mr-4"></search-filter>
            <inertia-link class="btn-indigo" href="/">
                <span>Add</span>
                <span class="hidden md:inline">Shortlink</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Label</th>
                    <th class="px-6 pt-6 pb-4">Shortlink</th>
                    <th class="px-6 pt-6 pb-4">Full URL</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Type</th>
                </tr>
                <tr
                    v-for="link in links.data"
                    :key="link.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('profile.show')"
                        >
                            {{ link.label | char_limit(36) }}
                            <icon
                                name="trash"
                                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                            />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            href="/"
                            tabindex="-1"
                        >
                            <div>
                                {{ link.shortlink | char_limit(36) }}
                            </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            href="/"
                            tabindex="-1"
                        >
                            {{ link.full_link | char_limit(50) }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <label-public v-if="link.is_public"/>
                        <label-private v-else />
                    </td>
                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            href="/"
                            tabindex="-1"
                        >
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="!links.data.length">
                    <td class="border-t px-6 py-4" colspan="4">No shortlink found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="links.links"/>
    </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import LinkTable from "../../Shared/LinkTable";
import SearchFilter from "../../Shared/SearchFilter";
import Icon from "../../Shared/Icon";
import Pagination from "../../Shared/Pagination";
import LabelPublic from "../../Shared/LabelPublic";
import LabelPrivate from "../../Shared/LabelPrivate";

export default {
    components: {
        AppLayout,
        LinkTable,
        SearchFilter,
        Icon,
        Pagination,
        LabelPublic,
        LabelPrivate,
    },
    metaInfo: {title: 'Dashboard'},
    layout: AppLayout,
    props: {
        links: Object,
    },
    data() {
        return {
            form: {
                search: '',
                trashed: '',
            },
        }
    },
}
</script>
