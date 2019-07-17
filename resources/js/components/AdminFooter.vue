<template>
    <footer class="footer">
        <div class="footer-top">
            <span class="footer-top-title">
                {{$t('footerText.top')}}
            </span>
            <p class="footer-top-text">
                {{$t('footerText.bottom')}}
            </p>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <img class="footer-bottom-content-logo" src="~img/logo4.png"/>
                <div class="footer-bottom-content-text">
                    <span>© {{currentYear}} {{$t('footerText.top')}} <br>
                        {{$t('footerText.allRightsSaved')}}</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "AdminFooter",
        data(){
            return {
                currentYear: null
            }
        },

        mounted() {
            let d = new Date();
            this.currentYear = d.getFullYear();
        }
    }
</script>

<style lang="scss" scoped>
    .footer{
        margin: 2rem 20px 0;
        background: #e6e6e6;
        padding: 1.25rem;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;

        &-top{
            &-title{
                font-weight: bold;
            }
        }

        &-bottom{
            border-top: solid #d8d8d8 1px;
            padding-top: 1rem;
            &-content{
                display: flex;
                justify-content: flex-end;

                &-logo{
                    width: 19px;
                    margin-right: 15px;
                }
            }
        }
    }
</style>
