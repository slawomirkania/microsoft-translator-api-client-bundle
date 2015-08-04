<?php

namespace Eovz\MicrosoftTranslatorApiClientBundle\Service;

use Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException;
use Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Transport for Microsoft Translator API
 * https://msdn.microsoft.com/en-us/library/hh454950.aspx
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Transport implements TransportInterface
{

    /**
     * HttpClient
     *
     * @var GuzzleHttp\Client
     */
    private $guzzle;

    /**
     * Service Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * CONSTRUCT
     *
     * @param HttpClientInterface $guzzle
     * @param ContainerInterface $container
     * @throws InvalidObjectException
     */
    public function __construct(HttpClientInterface $guzzle = null, ContainerInterface $container = null)
    {
        if (false == ($guzzle instanceof HttpClientInterface)) {
            throw new InvalidObjectException('Incorrect guzzle Object');
        }
        if (false == ($container instanceof ContainerInterface)) {
            throw new InvalidObjectException('Incorrect container Object');
        }

        $this->guzzle = $guzzle;
        $this->container = $container;
    }

    /**
     * Call request
     *
     * @param string $cmd
     * @param array $params
     * @return SimpleXMLElement
     * @throws InvalidObjectException
     */
    public function call($cmd, array $params = [])
    {
        $configParams = $this->getConfigParams();
        $accessToken = $this->getAccessToken();
        $headers['Content-Type'] = 'text/xml';
        $headers['Authorization'] = 'Bearer '.$accessToken;
        $formParams = [
            'headers' => $headers,
            'query' => $params
        ];

        $fullCommand = $configParams[self::CONFIG_API_URL].$cmd;
        
        return simplexml_load_string($this->guzzle->get($fullCommand, $formParams)->getBody());
    }

    /**
     * Get the access token.
     *
     * @return string
     * @throws InvalidObjectException
     */
    protected function getAccessToken()
    {
        $configParams = $this->getConfigParams();
        $formParams = [
            'form_params' => [
                self::CONFIG_CLIENT_ID => $configParams[self::CONFIG_CLIENT_ID],
                self::CONFIG_CLIENT_SECRET => $configParams[self::CONFIG_CLIENT_SECRET],
                self::CONFIG_SCOPE => $configParams[self::CONFIG_SCOPE],
                self::CONFIG_GRANT_TYPE => $configParams[self::CONFIG_GRANT_TYPE]
            ]
        ];

        $response = $this->guzzle->post($configParams[self::CONFIG_AUTH_URL], $formParams);
        if (false == ($response instanceof ResponseInterface)) {
            throw new InvalidObjectException('Incorrect Response');
        }

        return json_decode($response->getBody())->access_token;
    }

    /**
     * Params from parameters.yml
     *
     * @return array
     */
    protected function getConfigParams()
    {
        return (array) $this->container->getParameter(self::CONFIG_PARAMS_SCOPE);
    }
}
