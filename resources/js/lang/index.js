import deLocale from 'element-ui/lib/locale/lang/de';
import enLocale from 'element-ui/lib/locale/lang/en';
import frLocale from 'element-ui/lib/locale/lang/fr';
import itLocale from 'element-ui/lib/locale/lang/it';


import deMsg from './i18n/de'
import enMsg from './i18n/en'
import frMsg from './i18n/fr'
import itMsg from './i18n/it'


export default {
    de: _.assign({}, deMsg.de, deLocale),    
    en: _.assign({}, enMsg.en, enLocale),
    fr: _.assign({}, frMsg.fr, frLocale),
    it: _.assign({}, itMsg.it, itLocale),
}
