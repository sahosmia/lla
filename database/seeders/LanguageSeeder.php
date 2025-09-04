<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Language::truncate();
        $languages = [
            [
                'name' => "Afrikaans",
                'code' => "af",
                'status' => '1'
            ],
            [
                'name' => "albii",
                'code' => "sq",
                'status' => '1'
            ],
            [
                'name' => "Amharic",
                'code' => "am",
                'status' => '1'
            ],
            [
                'name' => "Arabic",
                'code' => "ar",
                'status' => '1'
            ],
            [
                'name' => "Aragonese",
                'code' => "an",
                'status' => '1'
            ],
            [
                'name' => "Armenian",
                'code' => "hy",
                'status' => '1'
            ],
            [
                'name' => "Asturian",
                'code' => "ast",
                'status' => '1'
            ],
            [
                'name' => "Azerbaijani",
                'code' => "az",
                'status' => '1'
            ],
            [
                'name' => "Basque",
                'code' => "eu",
                'status' => '1'
            ],
            [
                'name' => "Belarusian",
                'code' => "be",
                'status' => '1'
            ],
            [
                'name' => "Bengali",
                'code' => "bn",
                'status' => '1'
            ],
            [
                'name' => "Bosnian",
                'code' => "bs",
                'status' => '1'
            ],
            [
                'name' => "Breton",
                'code' => "br",
                'status' => '1'
            ],
            [
                'name' => "Bulgarian",
                'code' => "bg",
                'status' => '1'
            ],
            [
                'name' => "Catalan",
                'code' => "ca",
                'status' => '1'
            ],
            [
                'name' => "Central Kurdish",
                'code' => "ckb",
                'status' => '1'
            ],
            [
                'name' => "Chinese",
                'code' => "zh",
                'status' => '1'
            ],
            [
                'name' => "Corsican",
                'code' => "co",
                'status' => '1'
            ],
            [
                'name' => "Croatian",
                'code' => "hr",
                'status' => '1'
            ],
            [
                'name' => "Czech",
                'code' => "cs",
                'status' => '1'
            ],
            [
                'name' => "Danish",
                'code' => "da",
                'status' => '1'
            ],
            [
                'name' => "Dutch",
                'code' => "nl",
                'status' => '1'
            ],
            [
                'name' => "English",
                'code' => "en",
                'status' => '1'
            ],
            [
                'name' => "Esperanto",
                'code' => "eo",
                'status' => '1'
            ],
            [
                'name' => "Estonian",
                'code' => "et",
                'status' => '1'
            ],
            [
                'name' => "Faroese",
                'code' => "fo",
                'status' => '1'
            ],
            [
                'name' => "Filipino",
                'code' => "fil",
                'status' => '1'
            ],
            [
                'name' => "Finnish",
                'code' => "fi",
                'status' => '1'
            ],
            [
                'name' => "French",
                'code' => "fr",
                'status' => '1'
            ],
            [
                'name' => "Galician",
                'code' => "gl",
                'status' => '1'
            ],
            [
                'name' => "Georgian",
                'code' => "ka",
                'status' => '1'
            ],
            [
                'name' => "German",
                'code' => "de",
                'status' => '1'
            ],
            [
                'name' => "Greek",
                'code' => "el",
                'status' => '1'
            ],
            [
                'name' => "Guarani",
                'code' => "gn",
                'status' => '1'
            ],
            [
                'name' => "Gujarati",
                'code' => "gu",
                'status' => '1'
            ],
            [
                'name' => "Hausa",
                'code' => "ha",
                'status' => '1'
            ],
            [
                'name' => "Hawaiian",
                'code' => "haw",
                'status' => '1'
            ],
            [
                'name' => "Hebrew",
                'code' => "he",
                'status' => '1'
            ],
            [
                'name' => "Hindi",
                'code' => "hi",
                'status' => '1'
            ],
            [
                'name' => "Hungarian",
                'code' => "hu",
                'status' => '1'
            ],
            [
                'name' => "Icelandic",
                'code' => "is",
                'status' => '1'
            ],
            [
                'name' => "Indonesian",
                'code' => "id",
                'status' => '1'
            ],
            [
                'name' => "Interlingua",
                'code' => "ia",
                'status' => '1'
            ],
            [
                'name' => "Irish",
                'code' => "ga",
                'status' => '1'
            ],
            [
                'name' => "Italian",
                'code' => "it",
                'status' => '1'
            ],
            [
                'name' => "Italian (Italy)",
                'code' => "it",
                'status' => '1'
            ],
            [
                'name' => "Italian (Switzerland)",
                'code' => "it",
                'status' => '1'
            ],
            [
                'name' => "Japanese",
                'code' => "ja",
                'status' => '1'
            ],
            [
                'name' => "Kannada",
                'code' => "kn",
                'status' => '1'
            ],
            [
                'name' => "Kazakh",
                'code' => "kk",
                'status' => '1'
            ],
            [
                'name' => "Khmer",
                'code' => "km",
                'status' => '1'
            ],
            [
                'name' => "Korean",
                'code' => "ko",
                'status' => '1'
            ],
            [
                'name' => "Kurdish",
                'code' => "ku",
                'status' => '1'
            ],
            [
                'name' => "Kyrgyz",
                'code' => "ky",
                'status' => '1'
            ],
            [
                'name' => "Lao",
                'code' => "lo",
                'status' => '1'
            ],
            [
                'name' => "Latin",
                'code' => "la",
                'status' => '1'
            ],
            [
                'name' => "Latvian",
                'code' => "lv",
                'status' => '1'
            ],
            [
                'name' => "Lingala",
                'code' => "ln",
                'status' => '1'
            ],
            [
                'name' => "Lithuanian",
                'code' => "lt",
                'status' => '1'
            ],
            [
                'name' => "Macedonian",
                'code' => "mk",
                'status' => '1'
            ],
            [
                'name' => "Malay",
                'code' => "ms",
                'status' => '1'
            ],
            [
                'name' => "Malayalam",
                'code' => "ml",
                'status' => '1'
            ],
            [
                'name' => "Maltese",
                'code' => "mt",
                'status' => '1'
            ],
            [
                'name' => "Marathi",
                'code' => "mr",
                'status' => '1'
            ],
            [
                'name' => "Mongolian",
                'code' => "mn",
                'status' => '1'
            ],
            [
                'name' => "Nepali",
                'code' => "ne",
                'status' => '1'
            ],
            [
                'name' => "Norwegian",
                'code' => "no",
                'status' => '1'
            ],
            [
                'name' => "Turkish",
                'code' => "tr",
                'status' => '1'
            ],
            [
                'name' => "Ukrainian",
                'code' => "uk",
                'status' => '1'
            ],
            [
                'name' => "Vietnamese",
                'code' => "vi",
                'status' => '1'
            ],
            [
                'name' => "Welsh",
                'code' => "cy",
                'status' => '1'
            ],
            [
                'name' => "Albanian",
                'code' => "sq",
                'status' => '1'
            ],
            [
                'name' => "Occitan",
                'code' => "oc",
                'status' => '1'
            ],
            [
                'name' => "Oriya",
                'code' => "or",
                'status' => '1'
            ],
            [
                'name' => "Oromo",
                'code' => "om",
                'status' => '1'
            ],
            [
                'name' => "Pashto",
                'code' => "ps",
                'status' => '1'
            ],
            [
                'name' => "Persian",
                'code' => "fa",
                'status' => '1'
            ],
            [
                'name' => "Polish",
                'code' => "pl",
                'status' => '1'
            ],
            [
                'name' => "Portuguese",
                'code' => "pt",
                'status' => '1'
            ],
            [
                'name' => "Portuguese (Brazil)",
                'code' => "pt-BR",
                'status' => '1'
            ],
            [
                'name' => "Portuguese (Portugal)",
                'code' => "pt-PT",
                'status' => '1'
            ],
            [
                'name' => "Punjabi",
                'code' => "pa",
                'status' => '1'
            ],
            [
                'name' => "Quechua",
                'code' => "qu",
                'status' => '1'
            ],
            [
                'name' => "Romanian",
                'code' => "ro",
                'status' => '1'
            ],
            [
                'name' => "Romanian (Moldova)",
                'code' => "ro-MD",
                'status' => '1'
            ],
            [
                'name' => "Romansh",
                'code' => "rm",
                'status' => '1'
            ],
            [
                'name' => "Russian",
                'code' => "ru",
                'status' => '1'
            ],
            [
                'name' => "Scottish Gaelic",
                'code' => "gd",
                'status' => '1'
            ],
            [
                'name' => "Serbian",
                'code' => "sr",
                'status' => '1'
            ],
            [
                'name' => "Serbo",
                'code' => "sh",
                'status' => '1'
            ],
            [
                'name' => "Shona",
                'code' => "sn",
                'status' => '1'
            ],
            [
                'name' => "Sindhi",
                'code' => "sd",
                'status' => '1'
            ],
            [
                'name' => "Sinhala",
                'code' => "si",
                'status' => '1'
            ],
            [
                'name' => "Slovak",
                'code' => "sk",
                'status' => '1'
            ],
            [
                'name' => "Slovenian",
                'code' => "sl",
                'status' => '1'
            ],
            [
                'name' => "Somali",
                'code' => "so",
                'status' => '1'
            ],
            [
                'name' => "Southern Sotho",
                'code' => "st",
                'status' => '1'
            ],
            [
                'name' => "Spanish",
                'code' => "es",
                'status' => '1'
            ],
            [
                'name' => "Sundanese",
                'code' => "su",
                'status' => '1'
            ],
            [
                'name' => "Swahili",
                'code' => "sw",
                'status' => '1'
            ],
            [
                'name' => "Swedish",
                'code' => "sv",
                'status' => '1'
            ],
            [
                'name' => "Tajik",
                'code' => "tg",
                'status' => '1'
            ],
            [
                'name' => "Tamil",
                'code' => "ta",
                'status' => '1'
            ],
            [
                'name' => "Tatar",
                'code' => "tt",
                'status' => '1'
            ],
            [
                'name' => "Telugu",
                'code' => "te",
                'status' => '1'
            ],
            [
                'name' => "Thai",
                'code' => "th",
                'status' => '1'
            ],
            [
                'name' => "Tigrinya",
                'code' => "ti",
                'status' => '1'
            ],
            [
                'name' => "Tongan",
                'code' => "to",
                'status' => '1'
            ],
            [
                'name' => "Turkmen",
                'code' => "tk",
                'status' => '1'
            ],
            [
                'name' => "Twi",
                'code' => "tw",
                'status' => '1'
            ],
            [
                'name' => "Urdu",
                'code' => "ur",
                'status' => '1'
            ],
            [
                'name' => "Uyghur",
                'code' => "ug",
                'status' => '1'
            ],
            [
                'name' => "Uzbek",
                'code' => "uz",
                'status' => '1'
            ],
            [
                'name' => "Walloon",
                'code' => "wa",
                'status' => '1'
            ],
            [
                'name' => "Western Frisian",
                'code' => "fy",
                'status' => '1'
            ],
            [
                'name' => "Xhosa",
                'code' => "xh",
                'status' => '1'
            ],
            [
                'name' => "Yiddish",
                'code' => "yi",
                'status' => '1'
            ],
            [
                'name' => "Yoruba",
                'code' => "yo",
                'status' => '1'
            ],
            [
                'name' => "Zulu",
                'code' => "zu",
                'status' => '1'
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                [
                    'name' => $language['name']
                ],
                [
                    'status' => $language['status'],
                    'code' => $language['code']
                ]
            );
        }
    }
}
