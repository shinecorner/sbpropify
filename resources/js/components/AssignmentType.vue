<template>
    <el-col :lg="6">
        <el-select @change="resetToAssignList"
                    class="custom-select"
                    :value="model" @input="$emit('update:model', $event)"
        >
            <el-option
                :key="type"
                :label="$t(`models.request.assignmentTypes.${type}`)"
                :value="type"
                v-for="(type) in types">
            </el-option>
        </el-select>
    </el-col>
</template>

<script>
export default {
    props: {
        model: {
            required: true
        },
        assignmentTypes: {
            type: Array
        },
        method: { type: Function }
    },
    data() {
        return {
            types: []
        }
    },
    methods: {
        resetToAssignList() {
            this.method();
        }
    },
    created: function () {
        this.types = this.$props.assignmentTypes;
    },
}
</script>

<style>

</style>
