<template>
    <ForgotPassword1 v-if="this.$constants.login.variation == 1"/>
    <ForgotPassword2 v-else-if="this.$constants.login.variation==2"/>
</template>
<script>
    import ForgotPassword1 from 'views/Auth/1/ForgotPassword';
    import ForgotPassword2 from 'views/Auth/2/ForgotPassword';

    export default {
        components: {
            ForgotPassword1,
            ForgotPassword2
        }
    }
</script>
<style lang="scss" scoped>
  
</style>
