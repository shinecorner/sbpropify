<script>
    import {mapActions} from 'vuex';

    export default {
        data() {
            return {}
        },
        props: {
           
        },
        created() {
            const token = this.$route.query.token;

            if (!token) {
                this.$router.push({name: 'login2'});
                return;
            }

            this.autoLogin({token}).then((response) => {
                window.location.href = response.redirect;
            }).catch((error) => {
                this.$router.push({name: 'login2'});
            });
        },
        render() {
            return false;
        },
        methods: {
            ...mapActions(['autoLogin'])
        },
        beforeCreate() {
            if(this.$constants.login.variation == 1) {
                this.$router.push({
                    name: 'autoLogin'
                });
            }
        }
    }
</script>
