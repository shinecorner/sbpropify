import {mapActions} from "vuex";

export default {
    methods: {
        ...mapActions(['getQuarters']),
        async getFilterQuarters() {
            const quarters = await this.getQuarters({
                get_all: true
            });

            return quarters.data;
        }
    }
}
