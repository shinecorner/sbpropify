<template>
    <login1 v-if="this.$constants.login.variation == 1"/>
    <login2 v-else-if="this.$constants.login.variation==2"/>
</template>
<script>
    import login1 from 'views/Auth/1/Login';
    import login2 from 'views/Auth/2/Login';

    export default {
        components: {
            login1,
            login2
        }
    }
</script>
<style lang="scss" scoped>
  
</style>
