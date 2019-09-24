import {format} from 'date-fns'

export default {
    methods: {
        formatDatetime (dateTime) {
            return this.$t('general.dateTimeFormat', {
                date: format(dateTime, 'DD.MM.YYYY'),
                time: format(dateTime, 'HH:mm')
            })
        }
    }
}