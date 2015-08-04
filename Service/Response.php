<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

use Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException;
use Eovz\MicrosoftTranslatorApiClientBundle\Service\ReponseInterface;
use SimpleXMLElement;

/**
 * Base API Response
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Response implements ReponseInterface
{

    /**
     * Return json
     *
     * @param SimpleXMLElement $result
     * @param array $params
     * @return string
     * @throws InvalidObjectException
     */
    public function getPreparedJson(SimpleXMLElement $result = null, array $params = [])
    {
        if (false == ($result instanceof SimpleXMLElement)) {
            throw new InvalidObjectException('Incorrect result SimpleXMLElement object');
        }

        $responseArray = (array) json_decode(json_encode($result));
        $params[self::PARAM_RESULT] = array_pop($responseArray);

        return json_encode($params);
    }
}
