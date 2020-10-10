<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('dashboard')">Links
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Stats
        </h1>


    </div>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
    name: "Show",
    metaInfo: {title: 'Create Link'},
    layout: AppLayout,
    props: {
        errors: Object,
        link: Object,
    }
}
</script>

<style scoped>

</style>
