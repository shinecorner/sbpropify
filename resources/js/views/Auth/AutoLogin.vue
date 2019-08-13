<script>
    import {mapActions} from 'vuex';

    export default {
        data() {
            return {}
        },
        props: {
            loginMode: {
                type: Number,
                default: () => {
                    return 1;
                }
            }
        },
        created() {
            const token = this.$route.query.token;

            if (!token) {
                this.$router.push({name: `${loginMode == 1? 'login':'login2'}`});
                return;
            }

            this.autoLogin({token}).then((response) => {
                window.location.href = response.redirect;
            }).catch((error) => {
                this.$router.push({name: `${loginMode == 1? 'login':'login2'}`});
            });
        },
        render() {
            return false;
        },
        methods: {
            ...mapActions(['autoLogin'])
        }
    }
</script>
