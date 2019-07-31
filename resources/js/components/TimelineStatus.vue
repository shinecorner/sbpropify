<template>
    <span class="btn-wrap">
        <template >
            <el-button :style="{
                'border-color': getRequestStatusColor(setStatus(status), 'name'),
                'color' : getRequestStatusColor(setStatus(status), 'name')
                }" plain :type="setStatus(status)" class="btn-priority-badge btn-hove" size="small" round>{{ setStatus(status) }}</el-button>
        </template>
    </span>
</template>

<script>
import globalFunction from "helpers/globalFunction";
import { mapGetters} from 'vuex';
export default {
    mixins: [globalFunction],
     props: {
        status: {
            type: Number,
            required: true
        }
     },
    computed:{
        ...mapGetters('application', {
                constants: 'constants'
            })
    },
    methods: {
        setStatus(id){
            return this.constants.service_requests.status[id];
        }
    }
}
</script>

<style>

</style>
