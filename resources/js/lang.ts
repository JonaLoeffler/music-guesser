import * as de from '../lang/de.json';

interface LanguageMap {
    [key: string]: string
}

let lang: LanguageMap = {}
if (navigator.language === "de") {
    lang = de as unknown as LanguageMap;
}

function __(key: string): string {
    return lang[key] ?? key;
}

export default __;