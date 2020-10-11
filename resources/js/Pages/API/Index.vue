<template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-12 font-bold text-3xl">API Tokens</h1>
                <api-token-manager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions"
                />
            </div>
        </div>
</template>

<script>
import ApiTokenManager from './ApiTokenManager'
import AppLayout from './../../Layouts/AppLayout'
import JetSectionBorder from './../../Jetstream/SectionBorder'

export default {
    props: [
        'tokens',
        'availablePermissions',
        'defaultPermissions',
    ],

    metaInfo: {title: 'API Tokens'},
    layout: AppLayout,

    components: {
        ApiTokenManager,
        AppLayout,
        JetSectionBorder,
    },
}
</script>
