<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

/**
 * Client Interface for Microsoft Translator API
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface ClientInterface
{

    /**
     * Command 'Translate '
     *
     * @var string
     */
    const CMD_TRANSLATE = 'Translate';

    /**
     * Command 'Detect' Language
     *
     * @var string
     */
    const CMD_DETECT = 'Detect';

    /**
     * Run translate text
     * Return json {'result':'hello', ...}
     *
     * @param string $text
     * @param string $to
     * @param string $from
     * @return string
     * @throws Eovz\MicrosoftTranslatorApiClientBundle\Exception\MissingParamException
     * @throws Eovz\MicrosoftTranslatorApiClientBundle\Exception\UnrecognizedCmdException
     */
    public function translate($text, $to, $from = null);

    /**
     * Detect language of included text
     * Return json {'result':'en', ...}
     *
     * @param text $text
     * @return string
     * @throws MissingParamException
     * @throws UnrecognizedCmdException
     */
    public function detect($text);
}
