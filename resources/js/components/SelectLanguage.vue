<template>
    <el-radio-group :value="model" @input="$emit('update:model', $event)">
        <el-radio-button :label="language.symbol" v-for="language in languages" :key="language.symbol">
            <span :class="language.flag"></span> {{$t(`languages.`+ language.symbol)}}
        </el-radio-button>
    </el-radio-group>
</template>

<script>
export default {
    name: 'selectlanguage',
    data() {
        return {
            languages: []
        }
    },
    props: {
        model: {
            required: true
        }
    },
    mounted() {
        let languagesObject = this.$constants.app.languages;
        let languagesArray = Object.keys(languagesObject).map(function(key) {
            return [String(key), languagesObject[key]];
        });
       
        this.languages = languagesArray.map(item => { 
            let flag_class = 'flag-icon flag-icon-';
            let flag = flag_class + item[0];
            if( item[0] == 'en')
            {
                flag = flag_class + 'us'
            }
            return {
                name: item[1],
                symbol: item[0],
                flag: flag
            }
        });
    }
}
</script>

