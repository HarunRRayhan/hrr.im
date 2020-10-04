<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter class="w-full max-w-md mr-4"></search-filter>
            <inertia-link class="btn-indigo" href="/">
                <span>Create</span>
                <span class="hidden md:inline">Contact</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">Organization</th>
                    <th class="px-6 pt-6 pb-4">City</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
                </tr>
                <tr
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            href="/"
                        >
                            My Name
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
                                My Organization
                            </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            href="/"
                            tabindex="-1"
                        >
                            City
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            href="/"
                            tabindex="-1"
                        >
                            Phone Number
                        </inertia-link>
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
<!--                <tr v-if="!contacts">-->
<!--                    <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>-->
<!--                </tr>-->
            </table>
        </div>
        <!--        <pagination :links="contacts.links"/>-->
    </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import LinkTable from "../../Shared/LinkTable";
import SearchFilter from "../../Shared/SearchFilter";
import Icon from "../../Shared/Icon";

export default {
    components: {
        AppLayout,
        LinkTable,
        SearchFilter,
        Icon,
    },
    metaInfo: {title: 'Dashboard'},
    layout: AppLayout,
    props: {
        contacts: Object,
        filters: Object,
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
