<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

/**
 * Transport Interface for Microsoft Translator API
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface TransportInterface
{

    /**
     * Scope of config parameters
     *
     * @var string
     */
    const CONFIG_PARAMS_SCOPE = 'microsoft_translator';

    /**
     * Config param 'api_url'
     *
     * @var string
     */
    const CONFIG_API_URL = 'api_url';

    /**
     * Config param 'client_id'
     *
     * @var string
     */
    const CONFIG_CLIENT_ID = 'client_id';

    /**
     * Config param 'client_secret'
     *
     * @var string
     */
    const CONFIG_CLIENT_SECRET = 'client_secret';

    /**
     * Config param 'scope'
     *
     * @var string
     */
    const CONFIG_SCOPE = 'scope';

    /**
     * Config param 'grant_type'
     *
     * @var string
     */
    const CONFIG_GRANT_TYPE = 'grant_type';

    /**
     * Config param 'auth_url'
     *
     * @var string
     */
    const CONFIG_AUTH_URL = 'auth_url';

    /**
     * Transport param 'text'
     *
     * @var string
     */
    const PARAM_TEXT = 'text';

    /**
     * Transport param 'to'
     *
     * @var string
     */
    const PARAM_TO = 'to';

    /**
     * Transport param 'from'
     *
     * @var string
     */
    const PARAM_FROM = 'from';

    /**
     * Call request
     *
     * @param string $cmd
     * @param array $params
     * @return SimpleXMLElement
     * @throws Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function call($cmd, array $params = []);
}
