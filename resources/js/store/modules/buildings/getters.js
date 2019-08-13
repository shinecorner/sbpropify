export default {
    buildings({buildings: {data = []}}) {
        return data.map(building => {
            building.basement = building.basement ? 'Yes' : 'No';

            if (building.address) {
                building.address_row = `${building.address.street} ${building.address.street_nr}`;
                building.address_zip = `${building.address.zip} ${building.address.city}`;
            }

            const tenants = [...building.tenants];
            building.tenantscount = 0;
            if(tenants.length) {
                building.tenants = building.tenants.splice(0, 2);
                if(tenants.length > 2) {
                    building.tenantscount = tenants.length - 2;
                }
            }

            const managers = [...building.managers];
            building.managerscount = 0;
            if(managers.length) {
                building.managers = building.managers.splice(0, 2);
                if(managers.length > 2) {
                    building.managerscount = managers.length - 2;
                }
            }

            return building;
        });
    },
    buildingsMeta({buildings}) {
        return _.omit(buildings, 'data');
    },
}
