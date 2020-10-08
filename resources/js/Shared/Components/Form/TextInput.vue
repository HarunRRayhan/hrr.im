<template>
    <div>
        <label
            v-if="label"
            class="form-label"
            :for="id"
        >{{ label }}:</label>
        <span :class="{'flex': prefix}">
            <span v-if="prefix" class="py-2 pl-2 pr-1 leading-normal block border-t border-b border-l text-gray-700 bg-gray-200 font-sans rounded text-left rounded-tr-none rounded-br-none">{{prefix}}</span>
            <input
                :id="id"
                ref="input"
                v-bind="$attrs"
                class="form-input"
                :class="{ error: error, 'border-l-0 rounded-tl-none rounded-bl-none': prefix }"
                :type="type"
                :value="value"
                :placeholder="placeholder"
                @input="$emit('input', $event.target.value)"
            >
        </span>
        <div
            v-if="error"
            class="form-error"
        >{{ error }}
        </div>
    </div>
</template>

<script>
export default {
    name: "TextInput",
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`
            },
        },
        type: {
            type: String,
            default: 'text',
        },
        value: String,
        label: String,
        error: String,
        placeholder: {
            type: String,
            default: '',
        },
        prefix: {
            type: String,
            default: '',
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end)
        },
    },
}
</script>
