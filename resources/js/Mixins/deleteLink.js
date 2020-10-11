export default {
    data() {
        return {
            deleting: {
                confirming: false,
                link: null,
            },
        }
    },
    methods: {
        dismissDeleteModal() {
            this.deleting.confirming = false;
            setTimeout(() => {
                this.deleting.link = null;
            }, 250)

        },
        confirmingDelete(link) {
            this.deleting.link = link;
            this.deleting.confirming = true;
        },
    }
}
