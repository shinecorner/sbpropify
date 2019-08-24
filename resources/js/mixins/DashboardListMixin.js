import ListTable from 'components/dashboard/ListTable';

export default () => ({
    components: {
        ListTable
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
