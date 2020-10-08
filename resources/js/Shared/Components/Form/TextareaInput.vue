<template>
    <div>
        <label
            v-if="label"
            class="form-label"
            :for="id"
        >{{ label }}:</label>
        <textarea
            name=""
            :id="id"
            ref="input"
            v-bind="$attrs"
            class="form-input"
            rows="5"
            :class="{ error: error }"
            :placeholder="placeholder"
            @input="$emit('input', $event.target.value)"
        >{{ value }}</textarea>
        <div
            v-if="error"
            class="form-error"
        >{{ error }}
        </div>
    </div>
</template>

<script>
export default {
    name: "TextareaInput",
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `textarea-input-${this._uid}`
            },
        },
        value: String,
        label: String,
        error: String,
        placeholder: {
            type: String,
            default: '',
        },
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
