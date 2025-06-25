import { createI18n } from "vue-i18n";
import fr from './locales/fr.json';
import en from './locales/en.json';

export default createI18n({
    locale: 'fr',
    fallbackLocale: 'en',
    legacy: false,
    globalInjection: true,
    messages: {
        fr,
        en
    },
})
