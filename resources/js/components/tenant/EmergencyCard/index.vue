<template>
    <ui-card shadow="always">
        <div class=" icon-attention-alt">
            
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
                min-width: 50px
                height: 50px
                background-size: cover
                display: block
                i 
                    width: 50px
                    height: 50px
                    font-size: 30px
                    display: block
                
            .right-text
                flex: 1
                padding-left: 20px
</style>