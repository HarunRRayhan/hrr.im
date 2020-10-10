<template>
    <div class="flex items-center justify-center w-full mb-24">

        <label
            :for="id"
            class="flex items-center cursor-pointer"
        >
            <div class="relative">
                <input
                    :id="id"
                    type="checkbox"
                    class="hidden"
                    @input="click"
                    :checked="enabled"
                />
                <div
                    class="toggle__line w-10 h-4 bg-gray-400 rounded-full shadow-inner"
                ></div>
                <div
                    class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow"
                ></div>
            </div>
            <div
                class="ml-3 text-gray-700 font-medium"
            >
                <slot></slot>
            </div>
        </label>
    </div>
</template>

<script>
export default {
    name: "Toggle",
    props: {
        enabled: {
            type: Boolean,
            default: false,
        },
        id: {
            type: String,
            default() {
                return `toggle-${this._uid}`
            },
        }
    },
    methods: {
        click(e) {
            this.$emit('toggle', e.target.checked);
        }
    }
}
</script>

<style scoped>

</style>
