<?php

// @codingStandardsIgnoreStart

/**
 * Test of API Client
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function testConstructorWhenInvalidTransportObject()
    {
        new Eovz\MicrosoftTranslatorApiClientBundle\Service\Client(null, $this->getResponseInstance());
    }

    /**
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     */
    public function testConstructorWhenInvalidResponseObject()
    {
        new Eovz\MicrosoftTranslatorApiClientBundle\Service\Client($this->getTransportMock(), null);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::translate
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Response::getPreparedJson
     */
    public function testCmdTranslateWhenSuccess()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'));
        $result = $object->translate('witaj', Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN, Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_PL);
        $this->assertNotNull($result);
        $this->assertEquals('{"text":"witaj","to":"'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN.'","from":"'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_PL.'","result":"hello"}', $result);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::translate
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\EmptyParamValueException
     */
    public function testCmdTranslateWhenMissingMandatoryParameters()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'));
        $object->translate('', Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN, Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_PL);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::translate
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\UndefinedLangCodeException
     */
    public function testCmdTranslateWhenUndefinedLanguageCodeToParameter()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'));
        $object->translate('hello', 'undefined_code', Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::translate
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\UndefinedLangCodeException
     */
    public function testCmdTranslateWhenUndefinedLanguageCodeFromParameter()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'));
        $object->translate('hello', Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_PL, 'undefined_code');
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::translate
     */
    public function testCmdTranslateWhenSuccessAndEmptyLanguageCodeFrom()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'));
        $object->translate('hello', Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_PL);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::detect
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Response::getPreparedJson
     */
    public function testCmdDetectWhenSuccess()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN.'</string>'));
        $result = $object->detect('hello');
        $this->assertNotNull($result);
        $this->assertEquals('{"text":"hello","result":"'.Eovz\MicrosoftTranslatorApiClientBundle\Lib\LangCodes::CODE_EN.'"}', $result);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::detect
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\EmptyParamValueException
     */
    public function testCmdDetectWhenMissingMandatoryParameters()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">nothing</string>'));
        $object->detect();
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Client::detect
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\EmptyParamValueException
     */
    public function testCmdDetectWhenMandatoryParameterIsNull()
    {
        $object = $this->getClientInstance(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">nothing</string>'));
        $object->detect(null);
    }

    /**
     * Return prepared Client Instance
     * 
     * @param SimpleXMLElement $simpleXMLElementReturnedByCall
     * @return Eovz\MicrosoftTranslatorApiClientBundle\Service\Client
     */
    private function getClientInstance(SimpleXMLElement $simpleXMLElementReturnedByCall)
    {
        $transportMock = $this->getTransportMock();
        $transportMock->expects($this->any())->method('call')->will($this->returnValue($simpleXMLElementReturnedByCall));
        $response = $this->getResponseInstance();

        return new Eovz\MicrosoftTranslatorApiClientBundle\Service\Client($transportMock, $response);
    }

    /**
     * Return mock of API transport
     * 
     * @return Mock
     */
    private function getTransportMock()
    {
        return $this->getMock('Eovz\MicrosoftTranslatorApiClientBundle\Service\TransportInterface');
    }

    /**
     * Return new Instance of Response Handler
     * 
     * @return Eovz\MicrosoftTranslatorApiClientBundle\Service\Response
     */
    private function getResponseInstance()
    {
        return new Eovz\MicrosoftTranslatorApiClientBundle\Service\Response();
    }
}

// @codingStandardsIgnoreEnd