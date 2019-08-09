import DashboardListTable from 'components/DashboardListTable';

export default () => ({
    components: {
        DashboardListTable
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
