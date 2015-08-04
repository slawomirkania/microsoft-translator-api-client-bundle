<?php

// @codingStandardsIgnoreStart

/**
 * Test of API Response Handler
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Eovz\MicrosoftTranslatorApiClientBundle\Exception\InvalidObjectException
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Response::getPreparedJson
     */
    public function testGetPreparedJsonWhenIncorrectResultParam()
    {
        (new Eovz\MicrosoftTranslatorApiClientBundle\Service\Response())->getPreparedJson(null);
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Response::getPreparedJson
     */
    public function testGetPreparedJsonWhenCorrectResultParamAndEmptyRequestParams()
    {
        $result = (new Eovz\MicrosoftTranslatorApiClientBundle\Service\Response())->getPreparedJson(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'), []);
        $this->assertEquals($result, '{"result":"hello"}');
    }

    /**
     * @covers Eovz\MicrosoftTranslatorApiClientBundle\Service\Response::getPreparedJson
     */
    public function testGetPreparedJsonWhenCorrectResultParamAndIncludesSomeRequestParams()
    {
        $requestParams = [
            'text' => 'witaj',
            'other' => 'additional_param'
        ];

        $result = (new Eovz\MicrosoftTranslatorApiClientBundle\Service\Response())->getPreparedJson(simplexml_load_string('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">hello</string>'), $requestParams);
        $this->assertEquals($result, '{"text":"witaj","other":"additional_param","result":"hello"}');
    }
}

// @codingStandardsIgnoreEnd