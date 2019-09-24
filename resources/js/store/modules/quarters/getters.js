export default {
    quarters({quarters}) {
        return quarters.data;
    },
    quartersMeta ({quarters}) {
        return _.omit(quarters, 'data');
    }
}