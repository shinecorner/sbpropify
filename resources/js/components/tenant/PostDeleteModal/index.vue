<template>
    <el-dialog  :close-on-click-modal="true" 
                :title="$t(`general.swal.delete_listing.title`)"
                :visible="deleteModalVisible"
                width="30%"
                :modal="false"
                class="delete_building_modal"
                :modalAppendToBody="false">
            <el-row>
                <el-col :span="24">
                    <p class="description">{{ $t(`general.swal.delete_listing.text`) }}</p>                    
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="24">
                    <el-switch 
                        :active-text="$t('models.building.delete_building_modal.delete_units')"
                        :inactive-text="$t('models.building.delete_building_modal.dont_delete_units')"
                        v-model="is_units" 
                        class="delete_switch" />
                </el-col>
            </el-row>

            <span class="dialog-footer" slot="footer">
                <el-button @click="close" size="mini">{{$t('models.building.cancel')}}</el-button>
                <el-button @click="deleteSelectedPost()" size="mini" type="danger">{{$t('general.actions.delete')}}</el-button>
            </span>
    </el-dialog>
</template>
<script>
    export default {
        name: 'p-post-delete-modal',
        props: {
            deleteModalVisible: {
                type: Boolean,
                required: true
            },
            delBuildingStatus: {
                type: Number,
                required: true
            },
            deleteSelectedPost: {
                type: Function,
                required: true
            },
            closeModal: {
                type: Function,
                required: true
            }
        },
        data() {
            return {                                
                is_units: false,
                is_request: false,
            }
        },
        methods: {
            close() {
                this.is_units = false;
                this.is_request = false;
                this.closeModal();
            }            
        },        
    };
</script>
<style lang="scss">
    .delete_building_modal {        

        .el-row {
            margin: 0 0 22px 0;
        }

        .description {
            margin: 0;
        }
        .el-dialog__body {
            word-break: break-word;
        }
    }
</style>

<style>
    .delete_switch .el-switch__label--left {         
        min-width: 145px;        
    }
</style>