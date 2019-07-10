import {format} from 'date-fns'

export default {
    filters: {
        formatDatetime (date) {
            return `${format(date, 'DD.MM.YYYY')} at ${format(date, 'HH:mm')}`
        }
    }
}