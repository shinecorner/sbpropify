<template>
    <el-select style="display: block" :value="model" @input="$emit('update:model', $event)" placeholder="Select Language">
        <template slot="prefix">
            <span class="flag-icon flag-icon-us" v-if="showFlag && this.model == 'en'"></span>
            <span class="flag-icon flag-icon-fr" v-if="showFlag && this.model == 'fr'"></span>
            <span class="flag-icon flag-icon-it" v-if="showFlag && this.model == 'it'"></span>
            <span class="flag-icon flag-icon-de" v-if="showFlag && this.model == 'de'"></span>
        </template>
        <el-option :label="language.name" :value="language.symbol" v-for="language in languages" :key="language.symbol">
            <span :class="language.flag" v-if="showFlag"></span>&nbsp;&nbsp;{{$t(`general.languages.`+ language.symbol)}}
        </el-option>
    </el-select>
</template>

<script>
export default {
    name: 'selectlanguage',
    data() {
        return {
            languages: [],
            showFlag: true
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
    },

}
</script>