<template>
    <ui-card shadow="always">
        <div class="left-circle icon-attention-alt">
        </div>
        <div class="right-text">
            <p>Emegerency Number</p>
            If you have an emergency outside of office hours, please call the following number : 079 999 99 99
        </div>
        
    </ui-card>
</template>

<script>

    export default {
        name: 'p-emergency-card',
        data () {
            return {
                
            }
        },
        async mounted () {
            
        },
    }
</script>

<style lang="sass" scoped>
    .ui-card
        padding: 10px


        /deep/ .ui-card__body
            display: flex
            align-items: center
            
            .left-circle
                width: 50px
                height: 50px
                font-size: 30px
                color: var(--primary-color)
                display: -webkit-box
                display: -ms-flexbox
                display: flex
                -webkit-box-align: center
                -ms-flex-align: center
                align-items: center
                -webkit-box-pack: center
                -ms-flex-pack: center
                justify-content: center
                border-radius: 50%
                border: 8px var(--primary-color) solid
                -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)
                
            .right-text
                flex: 1
                padding-left: 20px
</style>