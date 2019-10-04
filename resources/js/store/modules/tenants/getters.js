import {format} from 'date-fns';
import tenantTitleTypes from '../../../mixins/methods/tenantTitleTypes';

export default {
    tenants({tenants: {data = []}}) {
        return data.map(tenant => {
            tenant.name = `${tenant.first_name} ${tenant.last_name}`;
            tenant.birth_date = format(new Date(tenant.birth_date), 'DD.MM.YYYY');
            tenant.user_email = tenant.user.email;

            if (tenant.building && tenant.building.address) {
                tenant.building_address_row = `${tenant.building.address.street} ${tenant.building.address.house_num}`;
                tenant.building_address_zip = `${tenant.building.address.zip} ${tenant.building.address.city}`;
            }

            tenant.building_name = '';
            tenant.unit_name = '';
            if (tenant.rent_contracts.length) {
                if(tenant.rent_contracts[0].building)
                    tenant.building_name = tenant.rent_contracts[0].building.name;
                if(tenant.rent_contracts[0].unit)
                    tenant.unit_name = tenant.rent_contracts[0].unit.name;
            }

            tenant.building_names = tenant.rent_contracts.map(item => item.building ? item.building.name : '')
            tenant.unit_names = tenant.rent_contracts.map(item => item.unit ? item.unit.name : '')

            tenant.rent_contract_active_count = tenant.counts.rent_contracts.active
            tenant.rent_contract_inactive_count = tenant.counts.rent_contracts.inactive
            

            return tenant;
        });
    },
    tenantsMeta({tenants}) {
        return _.omit(tenants, 'data');
    },
    countries ({countries}) {
        return countries;
    }
}
