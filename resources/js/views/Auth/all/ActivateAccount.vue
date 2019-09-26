<template>
    <ActivateAccount1 v-if="this.$constants.login.variation == 1"/>
    <ActivateAccount2 v-else-if="this.$constants.login.variation==2"/>
</template>
<script>
    import ActivateAccount1 from 'views/Auth/1/ActivateAccount';
    import ActivateAccount2 from 'views/Auth/2/ActivateAccount';

    export default {
        components: {
            ActivateAccount1,
            ActivateAccount2
        }
    }
</script>
<style lang="scss" scoped>
  
</style>
