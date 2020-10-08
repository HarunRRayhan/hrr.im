<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('dashboard')">Links
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Create
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
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">Add Shortlink</loading-button>
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

export default {
    name: "Create",
    components: {
        TextInput,
        TextareaInput,
        LoadingButton
    },
    metaInfo: {title: 'Create Link'},
    layout: AppLayout,
    props: {
        errors: Object,
        app_url: String,
    },
    data() {
        return {
            sending: false,
            form: {
                label: '',
                full_link: '',
                slug: '',
                description: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('links.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
    }
}
</script>
