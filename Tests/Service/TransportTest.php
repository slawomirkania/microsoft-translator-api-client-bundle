<?php

// @codingStandardsIgnoreStart

/**
 * Test of API Transport Tier
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function testConstructorWhenInvalidGuzzleObject()
    {
        new Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport(null, $this->getContainerMock());
    }

    /**
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function testConstructorWhenInvalidContainerObject()
    {
        new Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport($this->getGuzzleMock(), null);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport::call
     */
    public function testCallWhenSuccess()
    {
        $secondStatus = 200;
        $secondHeaders = ['Content-Type' => [0 => 'application/xml; charset=utf-8']];

        $secondRequestBodyTranslate = '<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>';
        $transportTranslate = new Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport($this->getGuzzleMock($secondStatus, $secondHeaders, $secondRequestBodyTranslate), $this->getContainerMock());
        $resultTranslate = $transportTranslate->call(Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::CMD_TRANSLATE, []);
        $this->assertInstanceOf('SimpleXMLElement', $resultTranslate);
        $this->assertEquals('{"0":"hello"}', json_encode($resultTranslate));

        $secondRequestBodyDetect = '<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN.'</string>';
        $transportDetect = new Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport($this->getGuzzleMock($secondStatus, $secondHeaders, $secondRequestBodyDetect), $this->getContainerMock());
        $resultDetect = $transportDetect->call(Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::CMD_DETECT, []);
        $this->assertInstanceOf('SimpleXMLElement', $resultDetect);
        $this->assertEquals('{"0":"'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN.'"}', json_encode($resultDetect));
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport::call
     * @expectedException GuzzleHttp\Exception\ClientException
     */
    public function testCallWhenError()
    {
        $secondStatus = 400;
        $secondHeaders = [];
        $secondRequestBody = null;

        $transport = new Eovz\MicrosoftTranslatorApiClientBundle\Service\Transport($this->getGuzzleMock($secondStatus, $secondHeaders, $secondRequestBody), $this->getContainerMock());
        $transport->call(Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::CMD_DETECT, []);
    }

    /**
     * Return Guzzle Mock
     * 
     * @param int $secondStatus
     * @param array $secondHeaders
     * @param string $secondBody
     * @return GuzzleHttp\Client
     */
    private function getGuzzleMock($secondStatus = null, $secondHeaders = [], $secondBody = null)
    {
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, ['Content-Type' => [0 => 'application/json; charset=utf-8']], '{"token_type":"http://schemas.xmlsoap.org/ws/2009/11/swt-token-profile-1.0","access_token":"lorem-ipsum-access-token","expires_in":"599","scope":"lorem ipsum scope"}'),
            new GuzzleHttp\Psr7\Response($secondStatus, $secondHeaders, $secondBody),
        ]);

        $handler = GuzzleHttp\HandlerStack::create($mock);

        return new GuzzleHttp\Client(['handler' => $handler]);
    }

    /**
     * Return Symfony Container Mock
     *
     * @return Mock
     */
    private function getContainerMock()
    {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $parameters = [
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_CLIENT_ID => 'client_id_from_parameters',
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_CLIENT_SECRET => 'client_secret_from_parameters',
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_SCOPE => 'config_scope_from_parameters',
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_GRANT_TYPE => 'grant_type_from_parameters',
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_AUTH_URL => 'auth_url_from_parameters',
            Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface::CONFIG_API_URL => 'api_url_from_parameters',
        ];

        $containerMock->expects($this->any())->method('getParameter')->will($this->returnValue($parameters));

        return $containerMock;
    }
}

// @codingStandardsIgnoreEnd
