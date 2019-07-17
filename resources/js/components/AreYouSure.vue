<template>
    <div class="modal">
        <transition name="bounce">
            <div class="modal-window" v-if="visible">

                <div class="modal-window-icon">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><circle style="fill:#EFCE4A;" cx="25" cy="25" r="25"/><line style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" x1="25" y1="10" x2="25" y2="32"/><line style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" x1="25" y1="37" x2="25" y2="39"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </div>

                <h1 class="modal-window-title">Are you sure?</h1>

                <div class="modal-window-buttons">
                    <el-button type="success" v-on:click="$emit('agree')">Yes</el-button>
                    <el-button type="danger" v-on:click="$emit('cancel')">Cancel</el-button>
                </div>

            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "AreYouSure",
        props: ['visible']
    }
</script>

<style lang="scss" scoped>
    .modal{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        &-window{
            width: 440px;
            padding: 40px 20px;
            text-align: center;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0px 0px 12px 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            &-icon{
                width: 20%;
            }

            &-title{
                font-size: 30px;
            }
        }
    }
</style>
