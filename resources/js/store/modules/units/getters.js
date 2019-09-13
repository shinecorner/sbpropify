export default {
    units({units}, getters, { application: { constants } }) {
        let unitsArr = units.data ? units.data : [];
        return unitsArr.map((unit) => {
            unit.typeLabel = constants.units.type[unit.type];
            return unit;
        });
    },
    unitsMeta({units}) {
        return _.omit(units, 'data');
    }
}
