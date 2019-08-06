import ListLatestTable from 'components/ListLatestTable';

export default () => ({
    components: {
        ListLatestTable
    },
    data() {
        return {
            items: [],
            header: [],
            loading: false,
            selectedItems: []
        };
    },
    methods: {
        selectionChanged(rows) {
            this.selectedItems = rows;
        }
    }
});
