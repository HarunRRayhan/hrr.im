<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            Delete Link
        </template>

        <template #content>
            <h3>Are you sure you want to delete the following link?</h3>
            <table class="w-full table-fixed rounded border border-gray-300 my-4" v-if="link">
                <tr class="text-left border-b" v-if="link.label">
                    <td class="px-2 py-2 border-r w-24">Label</td>
                    <td class="px-2 py-2">{{ link.label }}</td>
                </tr>
                <tr class="text-left border-b">
                    <td class="px-2 py-2 border-r w-24">Full Link</td>
                    <td class="px-2 py-2">{{ link.full_link }}</td>
                </tr>
                <tr class="text-left">
                    <td class="px-2 py-2 border-r w-24">Shortlink</td>
                    <td class="px-2 py-2">{{ link.shortlink }}</td>
                </tr>
            </table>
            <p>This action is permanent. Once link is deleted you can not retrieve it.</p>
        </template>

        <template #footer>
            <jet-secondary-button @click.native="close">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click.native="deleteLink">
                Delete Link
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '../../../Jetstream/DialogModal';
import JetSecondaryButton from '../../../Jetstream/SecondaryButton';
import JetDangerButton from '../../../Jetstream/DangerButton';

export default {
    name: "DeleteModal",
    components: {
        JetDialogModal,
        JetSecondaryButton,
        JetDangerButton,
    },
    props: {
        show: Boolean,
        link: Object,
    },
    methods: {
        close() {
            this.$emit('close');
        },
        deleteLink() {
            this.$inertia.delete(this.route('links.destroy', this.link.id));
            this.close();
        },
    }
}
</script>
