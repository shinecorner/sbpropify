<template>
    <ui-card shadow="always">
        <div class="left-circle">
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
                background-image: url('/storage/avatar/tamara-wenger-642.png')
                background-position: center
                background-size: cover
                border-radius: 50%
                
            .right-text
                flex: 1
                padding-left: 20px
</style>