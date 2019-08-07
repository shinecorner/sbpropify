import {mapActions} from "vuex";

export default {
    methods: {
        ...mapActions(['getStates']),
        async getFilterStates() {
            const states = await this.getStates({
                filters: true
            });
            return states.data;
        }
    }
}