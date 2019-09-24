import {mapActions} from "vuex";

export default {
    methods: {
        ...mapActions(['getPropertyManagers']),
        async getFilterPropertyManagers() {
            const propertyManagers = await this.getPropertyManagers({
                get_all: true
            });

            let data = this.managersMapper(propertyManagers.data);

            return data;
        },
        managersMapper(propertyManagers) {
            return propertyManagers.map((propertyManager) => {
                return {
                    id: propertyManager.id,
                    name: propertyManager.user.name
                }
            })
        }
    }
}
