<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('dashboard')">Links
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Stats
        </h1>

        <div class="flex items-start space-x-6">
            <div class="flex-1 bg-white rounded shadow overflow-hidden">
                <div class="p-8">
                    <div class="pb-1">
                        <public v-if="link.is_public"/>
                        <private v-else/>
                    </div>

                    <div class="mb-4" v-if="link.label">
                        <h2 class="font-bold text-xl leading-normal">{{ link.label }}</h2>
                    </div>

                    <div class="mb-4">
                        <h5 class="pb-1">Shortlink:</h5>
                        <copy :link="link.shortlink"/>
                    </div>

                    <div class="">
                        <h5 class="pb-1">Full Link:</h5>
                        <open :link="link.full_link"/>
                    </div>

                    <div class="mt-4" v-if="link.description">
                        <h5 class="pb-1">Description:</h5>
                        <div class="" v-html="description"></div>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-white rounded shadow overflow-hidden">
                <link-prevue :url="link.full_link" cardWidth="100%" :showButton="false">
                </link-prevue>
            </div>
        </div>

    </div>
</template>

<script>
import LinkPrevue from 'link-prevue';
import AppLayout from "../../Layouts/AppLayout";
import Copy from "../../Shared/Pertials/Links/Copy";
import Open from "../../Shared/Pertials/Links/Open";
import Public from "../../Shared/Components/Labels/Public";
import Private from "../../Shared/Components/Labels/Private";
import {nl2br} from "../../helpers";

export default {
    name: "Show",
    components: {
        LinkPrevue,
        Copy,
        Open,
        Public,
        Private,
    },
    metaInfo: {title: 'Link Statistics'},
    layout: AppLayout,
    props: {
        errors: Object,
        link: Object,
    },
    computed: {
        description() {
            if (!this.link.description) return '';

            return nl2br(this.link.description);
        }
    }
}
</script>

<style scoped>

</style>
