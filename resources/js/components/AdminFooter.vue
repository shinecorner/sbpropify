<template>
    <footer class="footer">
        <div class="footer-top">
            <span class="footer-top-title">Gull - Laravel + Bootstrap 4 admin template</span>
            <p class="footer-top-text">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero quis beatae officia saepe perferendis voluptatum minima eveniet voluptates dolorum, temporibus nisi maxime nesciunt totam repudiandae commodi sequi dolor quibusdam sunt.
            </p>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <img class="footer-bottom-content-logo" src="~img/logo4.png"/>
                <div class="footer-bottom-content-text">
                    <span>© {{currentDate}} ProPify <br>
                        All rights reserved</span>
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
                currentDate: null
            }
        },

        mounted() {
            let d = new Date();
            this.currentDate = d.getFullYear();
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
