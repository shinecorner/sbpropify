<template>
    <fragment>
        <el-col :lg="12" :xl="14">
            <el-select
                :loading="remoteLoading"
                :placeholder="$t('models.request.placeholders.search')"
                :remote-method="SearchAssignees"
                class="custom-remote-select"
                filterable
                remote
                reserve-keyword
                style="width: 100%;"
                :value="model" @input="$emit('update:model', $event)"
            >
                <div class="custom-prefix-wrapper" slot="prefix">
                    <i class="el-icon-search custom-icon"></i>
                </div>
                <el-option
                    :key="service.id"
                    :label="service.name"
                    :value="service.id"
                    v-for="service in toAssignList"/>
            </el-select>
        </el-col>
        <el-col :lg="6" :xl="4">
            <el-button :disabled="!toAssign" @click="assign" class="full-button"
                        icon="ti-save" type="primary">
                {{$t('models.request.assign')}}
            </el-button>
        </el-col>
    </fragment>
</template>

<script>
    import { Fragment } from 'vue-fragment'
    export default {
        components: { Fragment },
        props: {
            model: {
                required: true
            },
            toAssignList: {
                type: Array
            },
            toAssign: {
                type: String
            },
            method: { type: Function },
            remoteLoading: {
                type: Boolean
            },
            remotemethod: {
                type: Function
            }
        },
        data() {
            return {
                types: []
            }
        },
        methods: {
            assign() {
                this.method();
            },
            SearchAssignees() {
                this.remotemethod();
            }
        },
        created: function () {
            console.log(this.$props);
            //this.types = this.$props.assignmentTypes;
        },
    }
</script>

<style>

</style>
