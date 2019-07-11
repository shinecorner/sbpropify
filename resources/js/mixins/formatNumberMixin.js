export default {
    filters: {
        formatNumber (number) {
            if (!number) {
                return
            }
            
            return number.toLocaleString()
        }
    }
}