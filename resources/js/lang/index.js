import deLocale from 'element-ui/lib/locale/lang/de';
import enLocale from 'element-ui/lib/locale/lang/en';
import frLocale from 'element-ui/lib/locale/lang/fr';
import itLocale from 'element-ui/lib/locale/lang/it';


import deMsg from './de'
import enMsg from './en'
import frMsg from './fr'
import itMsg from './it'


export default {
    de: _.assign({}, deMsg.de, deLocale),    
    en: _.assign({}, enMsg.en, enLocale),
    fr: _.assign({}, frMsg.fr, frLocale),
    it: _.assign({}, itMsg.it, itLocale),
}
