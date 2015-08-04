<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

use Eovz\MicrosoftTranslatorApiClientBundle\Exception\EmptyParamValueException;
use Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException;
use Eovz\MicrosoftTranslatorApiClientBundle\Exception\MissingParamException;
use Eovz\MicrosoftTranslatorApiClientBundle\Exception\UndefinedLangCodeException;
use Eovz\MicrosoftTranslatorApiClientBundle\Exception\UnrecognizedCmdException;
use Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes;
use Eovz\MicrosoftTranslatorApiClientBundle\Service\ClientInterface;
use Eovz\MicrosoftTranslatorApiClientBundle\Service\ReponseInterface;
use Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface;

/**
 * Client for Microsoft Translator API
 * https://msdn.microsoft.com/en-us/library/hh454950.aspx
 * https://datamarket.azure.com/dataset/explore/bing/microsofttranslator
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Client implements ClientInterface
{

    /**
     * Defined API commands
     *
     * @var array
     */
    private static $definedCommands = [
        self::CMD_DETECT,
        self::CMD_TRANSLATE,
    ];

    /**
     * HttpClient
     *
     * @var TransportInterface
     */
    private $transport;

    /**
     * Response Handler
     *
     * @var ReponseInterface
     */
    private $response;

    /**
     * CONSTR
     * null - for phpunit
     *
     * @param TransportInterface $transport
     * @param ReponseInterface $response
     * @throws InvalidObjectException
     */
    public function __construct(TransportInterface $transport = null, ReponseInterface $response = null)
    {
        if (false == ($transport instanceof TransportInterface)) {
            throw new InvalidObjectException('Incorrect transport Object');
        }
        if (false == ($response instanceof ReponseInterface)) {
            throw new InvalidObjectException('Incorrect response Object');
        }

        $this->transport = $transport;
        $this->response = $response;
    }

    /**
     * Run translate text
     * Return json {'result':'hello', ...}
     *
     * @param string $text
     * @param string $to
     * @param string $from
     * @return string
     * @throws MissingParamException
     * @throws UnrecognizedCmdException
     * @throws UndefinedLangCodeException
     */
    public function translate($text = null, $to = null, $from = null)
    {
        $params = [
            TransportInterface::PARAM_TEXT => trim($text),
            TransportInterface::PARAM_TO => trim($to),
            TransportInterface::PARAM_FROM => trim($from),
        ];

        $mandatoryParams = [
            TransportInterface::PARAM_TEXT,
            TransportInterface::PARAM_TO,
        ];

        $this->checkLangCode($params[TransportInterface::PARAM_TO]);
        $this->checkLangCode($params[TransportInterface::PARAM_FROM]);

        return $this->callCommand(self::CMD_TRANSLATE, $params, $mandatoryParams);
    }

    /**
     * Detect language of included text
     * Return json {'result':'en', ...}
     *
     * @param text $text
     * @return string
     * @throws MissingParamException
     * @throws UnrecognizedCmdException
     */
    public function detect($text = null)
    {
        $params = [
            TransportInterface::PARAM_TEXT => trim($text),
        ];

        $mandatoryParams = [
            TransportInterface::PARAM_TEXT
        ];

        return $this->callCommand(self::CMD_DETECT, $params, $mandatoryParams);
    }

    /**
     * Make Request
     *
     * @param string $cmd
     * @param array $params
     * @param array $mandatoryParams
     * @return string
     * @throws MissingParamException
     * @throws UnrecognizedCmdException
     */
    protected function callCommand($cmd, array $params = [], array $mandatoryParams = [])
    {
        $this->checkCommand($cmd);
        $this->checkMandatoryParams($params, $mandatoryParams);
        $result = $this->transport->call($cmd, $params);

        return $this->response->getPreparedJson($result, $params);
    }

    /**
     * Check command
     *
     * @throws UnrecognizedCmdException
     */
    protected function checkCommand($cmd)
    {
        if (false == (in_array($cmd, self::$definedCommands))) {
            throw new UnrecognizedCmdException("Unrecognized command: ".$cmd);
        }
    }

    /**
     * Check parameters
     *
     * @param array $paramsToCheck
     * @param array $mandatoryParams
     * @throws MissingParamException
     */
    protected function checkMandatoryParams(array $paramsToCheck = [], array $mandatoryParams = [])
    {
        foreach ($mandatoryParams as $mandatoryParamName) {
            if (false == (array_key_exists($mandatoryParamName, $paramsToCheck))) {
                throw new MissingParamException("Missing mandatory parameter: ".$mandatoryParamName);
            }
        }

        foreach ($mandatoryParams as $mandatoryParam) {
            if ('' == $paramsToCheck[$mandatoryParam]) {
                throw new EmptyParamValueException("Mandatory parameter is empty: ".$mandatoryParam);
            }
        }
    }

    /**
     * Check language codes for params of Translate command
     *
     * @param string $langCodeParam
     * @throws UndefinedLangCodeException
     */
    protected function checkLangCode($langCodeParam = '')
    {
        if ('' != $langCodeParam && false == in_array($langCodeParam, LangCodes::getDefinedLangCodes())) {
            throw new UndefinedLangCodeException('Not defined language code: '.$langCodeParam);
        }
    }
}
