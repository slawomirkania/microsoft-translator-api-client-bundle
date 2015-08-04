<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

use SimpleXMLElement;

/**
 * Interface for API response
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface ReponseInterface
{

    /**
     * Own result param index
     *
     * @var string
     */
    const PARAM_RESULT = 'result';

    /**
     * Return json
     *
     * @param SimpleXMLElement $result
     * @param array $params
     * @return string
     * @throws Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function getPreparedJson(SimpleXMLElement $result, array $params = []);
}
