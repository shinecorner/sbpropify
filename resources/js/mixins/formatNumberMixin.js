export default {
    filters: {
        formatNumber (number) {
            return (number || '').toLocaleString()
        }
    },
    methods: {
        formatNumber (number) {
            this.$options.filters.formatNumber(number)
        }
    }
}