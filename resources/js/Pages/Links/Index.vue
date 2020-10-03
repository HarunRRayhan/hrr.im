<template>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('dashboard')">
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
                <tr v-for="contact in contacts.data" :key="contact.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('contacts.edit', contact.id)">
                            {{ contact.name }}
                            <icon v-if="contact.deleted_at" name="trash"
                                  class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"/>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)"
                                      tabindex="-1">
                            <div v-if="contact.organization">
                                {{ contact.organization.name }}
                            </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)"
                                      tabindex="-1">
                            {{ contact.city }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)"
                                      tabindex="-1">
                            {{ contact.phone }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)"
                                      tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="contacts.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="contacts.links"/>
    </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import LinkTable from "../../Shared/LinkTable";
import SearchFilter from "../../Shared/SearchFilter";

export default {
    components: {
        AppLayout,
        LinkTable,
        SearchFilter
    },
    metaInfo: {title: 'Dashboard'},
    // layout: AppLayout,
}
</script>
