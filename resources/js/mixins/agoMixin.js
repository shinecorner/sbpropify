import { distanceInWordsToNow } from 'date-fns'
import de from 'date-fns/locale/de'
import en from 'date-fns/locale/en'
import fr from 'date-fns/locale/fr'
import it from 'date-fns/locale/it'
const locales = {'de': de, 'en': en, 'fr': fr, 'it': it};

export default {
    methods: {        
        ago(date,lang='de') {            
            if (!date) return
            
            return distanceInWordsToNow(date, {
                includeSeconds: true,
                addSuffix: 'ago',
                locale: locales[lang]
            })
        }
    }
}