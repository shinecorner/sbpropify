<template>
    <auth1 v-if="this.$constants.login.variation == 1" />
    <auth2 v-else-if="this.$constants.login.variation == 2" />
</template>
<script>
    import auth1 from 'layouts/Auth/1/Layout';
    import auth2 from 'layouts/Auth/2/Layout';

export default {
   components: {
       auth1,
       auth2
   }
}
</script>
