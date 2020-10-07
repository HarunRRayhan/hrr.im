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
        <link-table :links="links.data"/>
        <pagination :links="links.links"/>
    </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import LinkTable from "../../Shared/LinkTable";
import SearchFilter from "../../Shared/SearchFilter";
import Pagination from "../../Shared/Pagination";

export default {
    components: {
        AppLayout,
        LinkTable,
        SearchFilter,
        Pagination,
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
            },
        }
    },
}
</script>
