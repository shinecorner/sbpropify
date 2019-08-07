import {mapActions} from "vuex";

export default {
    methods: {
        ...mapActions(['getDistricts']),
        async getFilterDistricts() {
            const districts = await this.getDistricts({
                get_all: true
            });

            return districts.data;
        }
    }
}
