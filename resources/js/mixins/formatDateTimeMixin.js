import {format} from 'date-fns'

export default {
    methods: {
        formatDatetime (dateTime) {
            var res = dateTime.split(" ");
            return this.$t('general.dateTimeFormat', {
                date: res[0],
                time: res[1]
            })
            // return this.$t('general.dateTimeFormat', {
            //     date: format(dateTime, 'DD.MM.YYYY'),
            //     time: format(dateTime, 'HH:mm')
            // })
        }
    }
}