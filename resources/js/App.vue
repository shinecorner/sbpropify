<template>
  <!-- <div id="app" class="wrapper"> -->
    <router-view></router-view>
  <!-- </div> -->
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import {displayError} from 'helpers/messages';

    export default {
        name: 'App',
        // mixins: [{
        //     methods: {
        //         ...mapActions(['me']),
        //     },
        //     async created () {
        //         if (localStorage.token) {
        //             try {
        //                 await this.me();
        //             } catch (err) {
        //                 displayError(err);
        //             }
        //         }
        //     }
        // }]
    }
</script>


<style lang="scss">
    .custom-remote-select {
        .el-select__tags {
            padding-left: 20px;
        }

        .el-input__prefix {
            display: flex;
            align-items: center;
            margin-left: 5px;
        }

        .el-input--prefix .el-input__inner {
            padding-left: 35px;
            padding-right: 35px;
        }
    }

    .full-button {
        width: 100%;
    }
</style>

