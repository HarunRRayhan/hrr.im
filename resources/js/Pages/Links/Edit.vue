<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('dashboard')">Links
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Edit
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-4xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input
                        v-model="form.label"
                        :error="errors.label"
                        class="pr-6 pb-8 w-full"
                        label="Label"
                        placeholder="Add label to easy to find the URL"
                    />

                    <text-input
                        v-model="form.full_link"
                        :error="errors.full_link"
                        class="pr-6 pb-8 w-full"
                        label="Full URL"
                        placeholder="ex: https://harun.dev/this-is-the-link-i-want-to-go"
                    />

                    <text-input
                        v-model="form.slug"
                        :error="errors.slug"
                        class="pr-6 pb-8 w-full"
                        label="Slug (optional)"
                        placeholder="Keep it blank to use auto generated slug"
                        :prefix="`${app_url}/`"
                    />

                    <textarea-input
                        v-model="form.description"
                        :error="errors.description"
                        class="pr-6 pb-8 w-full"
                        label="Description (optional)"
                        placeholder="Link description goes here"
                    />

                    <toggle :enabled="form.private" @toggle="form.private=$event">
                        <span
                            class="flex items-center"
                        >
                            <icon name="lock-closed" class="block w-4 h-4 fill-current mr-1"/>
                            <span>Private Link</span>
                        </span>
                    </toggle>
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                >
                    <loading-button
                        :loading="sending"
                        class="btn-indigo"
                        type="submit"
                    >Update Shortlink
                    </loading-button>
                </div>
            </form>
        </div>


    </div>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import TextInput from "../../Shared/Components/Form/TextInput";
import TextareaInput from "../../Shared/Components/Form/TextareaInput";
import LoadingButton from "../../Shared/Components/LoadingButton";
import Toggle from "../../Shared/Components/Buttons/Toggle";
import Icon from "../../Shared/Icon";

export default {
    name: "Edit",
    components: {
        TextInput,
        TextareaInput,
        LoadingButton,
        Toggle,
        Icon,
    },
    metaInfo: {title: 'Edit Link'},
    layout: AppLayout,
    props: {
        errors: Object,
        app_url: String,
        link: Object
    },
    data() {
        return {
            sending: false,
            form: {
                label: this.link.label,
                full_link: this.link.full_link,
                slug: this.link.slug,
                description: this.link.description,
                private: !!this.link.secret,
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.put(route('links.update', this.link), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
    }
}
</script>

<style scoped>

</style>
