<template>
    <AutoLogin1 v-if="this.$constants.login.variation == 1"/>
    <AutoLogin2 v-else-if="this.$constants.login.variation==2"/>
</template>
<script>
    import AutoLogin1 from 'views/Auth/1/AutoLogin';
    import AutoLogin2 from 'views/Auth/2/AutoLogin';

    export default {
        components: {
            AutoLogin1,
            AutoLogin2
        }
    }
</script>
<style lang="scss" scoped>
  
</style>
