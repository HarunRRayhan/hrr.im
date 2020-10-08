<template>
    <div class="relative flex items-center">
        <input
            class="flex-1 py-2 px-3 bg-gray-50 rounded border border-indigo-400 focus:outline-none"
            type="text"
            :value="link"
            disabled
        >
        <button
            class="absolute flex items-center px-2 right-0 top-0 bottom-0 bg-gray-200 hover:bg-indigo-200 text-gray-500 hover:text-indigo-700 rounded-tr rounded-br border-t border-b border-r border-indigo-400 group text-sm font-bold focus:outline-none"
            @click="doCopy"
            v-tooltip.right="{content: toolTipText, show: showToolTip, classes: tooltipClasses, autoHide: false}"
        >
            <span class="hidden group-hover:block pr-1">Copy</span>
            <icon name="copy" class="block w-5 h-5 fill-current"/>
        </button>
    </div>
</template>

<script>
import Icon from "../Icon";

export default {
    name: "LinkCopy",
    components: {
        Icon,
    },
    props: {
        link: String
    },
    data() {
        return {
            showToolTip: false,
            toolTipText: '',
            copySuccess: true,
            timeout: null,
        }
    },
    computed: {
        tooltipClasses() {
            if (!this.copySuccess) {
                return 'error';
            }
            return 'success';
        }
    },
    methods: {
        doCopy: function () {
            const self = this;
            this.$copyText(this.link).then(function (e) {
                self.copiedTextMessage(e);
            }, function (e) {
                self.copyFailedMessage(e);
            })
        },
        copiedTextMessage(e = null) {
            this.toolTipText = 'Link Copied';
            this.copySuccess = true;
            this.showToolTip = true;
            this.removeToolTipTimeout();
            // alert('Copied')
            console.log(e)
        },
        copyFailedMessage(e = null) {
            this.toolTipText = 'Failed to copy';
            this.copySuccess = false;
            this.showToolTip = true;
            // alert('Can not copy')
            console.log(e)
        },
        removeToolTipTimeout() {
            const self = this;
            this.timeout = setTimeout(function () {
                self.removeToolTip();
            }, 2000)
        },
        removeToolTip() {
            this.showToolTip = false;
            this.toolTipText = '';
            this.copySuccess = true;
        }
    },
    beforeDestroy() {
        this.timeout = null;
    }
}
</script>

<style scoped>

</style>
