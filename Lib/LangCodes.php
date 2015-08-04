<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Lib;

use Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodesInterface;

/**
 * Translator Language Codes
 * Here is the list (as of February 2014):
 *
 * https://msdn.microsoft.com/en-us/library/hh456380.aspx
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class LangCodes implements LangCodesInterface
{

    /**
     * All defined language codes
     *
     * @var array
     */
    private static $definedLangCodes = [
        self::CODE_AR,
        self::CODE_BG,
        self::CODE_BS_LATN,
        self::CODE_CA,
        self::CODE_CS,
        self::CODE_CY,
        self::CODE_DA,
        self::CODE_DE,
        self::CODE_EL,
        self::CODE_EN,
        self::CODE_ES,
        self::CODE_ET,
        self::CODE_FA,
        self::CODE_FI,
        self::CODE_FR,
        self::CODE_HE,
        self::CODE_HI,
        self::CODE_HR,
        self::CODE_HT,
        self::CODE_HU,
        self::CODE_ID,
        self::CODE_IT,
        self::CODE_JA,
        self::CODE_KO,
        self::CODE_LT,
        self::CODE_LV,
        self::CODE_MS,
        self::CODE_MT,
        self::CODE_MWW,
        self::CODE_NL,
        self::CODE_NO,
        self::CODE_OTQ,
        self::CODE_PL,
        self::CODE_PT,
        self::CODE_RO,
        self::CODE_RU,
        self::CODE_SK,
        self::CODE_SL,
        self::CODE_SR_CYRL,
        self::CODE_SR_LATN,
        self::CODE_SV,
        self::CODE_TH,
        self::CODE_TLH,
        self::CODE_TLH_QAAK,
        self::CODE_TR,
        self::CODE_UK,
        self::CODE_UR,
        self::CODE_VI,
        self::CODE_YUA,
        self::CODE_ZH_CHS,
        self::CODE_ZH_CHT,
    ];

    /**
     * Return all defined language codes
     *
     * @return array
     */
    public static function getDefinedLangCodes()
    {
        return self::$definedLangCodes;
    }
}
