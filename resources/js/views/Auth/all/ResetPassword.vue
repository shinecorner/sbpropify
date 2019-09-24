<template>
    <ResetPassword1 v-if="this.$constants.login.variation == 1"/>
    <ResetPassword2 v-else-if="this.$constants.login.variation==2"/>
</template>
<script>
    import ResetPassword1 from 'views/Auth/1/ResetPassword';
    import ResetPassword2 from 'views/Auth/2/ResetPassword';

    export default {
        components: {
            ResetPassword1,
            ResetPassword2
        }
    }
</script>
<style lang="scss" scoped>
  
</style>
