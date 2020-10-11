<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset"/>
            <inertia-link
                class="btn-indigo"
                :href="route('links.create')"
            >
                <span>Add</span>
                <span class="hidden md:inline">Shortlink</span>
            </inertia-link>
        </div>
        <link-table
            :links="links.data"
            @deleting="confirmingDelete"
        />
        <pagination :links="links.links"/>

        <delete-modal
            :show="deleting.confirming"
            :link="deleting.link"
            @close="dismissDeleteModal"
        />
    </div>
</template>

<script>
import {mapValues, pickBy, throttle} from 'lodash'
import AppLayout from '../../Layouts/AppLayout'
import LinkTable from "../../Shared/LinkTable";
import SearchFilter from "../../Shared/SearchFilter";
import Pagination from "../../Shared/Pagination";
import DeleteModal from "../../Shared/Pertials/Links/DeleteModal";
import deleteLink from "../../Mixins/deleteLink";

export default {
    components: {
        AppLayout,
        LinkTable,
        SearchFilter,
        Pagination,
        DeleteModal
    },
    mixins: [deleteLink],
    metaInfo: {title: 'Dashboard'},
    layout: AppLayout,
    props: {
        links: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
            },
        }
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form)
                this.$inertia.replace(route('dashboard', Object.keys(query).length ? query : {remember: 'forget'}))
            }, 350),
            deep: true,
        },
    },
}
</script>
