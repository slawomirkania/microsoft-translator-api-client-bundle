## About

Basic Client for Microsoft Translator API
https://msdn.microsoft.com/en-us/library/dd576287.aspx

## Installation
Require the "slawomirkania/microsoft-translator-api-client-bundle" package in your composer.json and update your dependencies.

```bash
$ php composer.phar require slawomirkania/microsoft-translator-api-client-bundle dev-master
```

Add the EovzMicrosoftTranslatorApiClientBundle to your application's kernel along with other dependencies:

```php
public function registerBundles()
{
    $bundles = array(
        //...
          new Eovz\MicrosoftTranslatorApiClientBundle\EovzMicrosoftTranslatorApiClientBundle(),
        //...
    );
    //...
}
```

## Configuration

Add parameters in your parameters.yml

```yml
microsoft_translator:
    client_id: "your_microsoft_client_id"
    client_secret: "your_microsoft_client_secret"
    api_url: "http://api.microsofttranslator.com/V2/Http.svc/"
    auth_url: "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/"
    scope: "http://api.microsofttranslator.com"
    grant_type: "client_credentials"
```

Import services in your config.yml

```yml
imports:
    //...
    - { resource: @EovzMicrosoftTranslatorApiClientBundle/Resources/config/services.yml }
    //...
```

## Usage

```php
    //...
    // detect language
    $result = $this->container->get("eovz_microsoft_translator_api.client")->detect("hello");
    echo $result; // output {"text":"hello","result":"en"}
    //...


    //...
    // translate text
    $result = $this->container->get("eovz_microsoft_translator_api.client")->translate("witaj", "en", "pl"); // parameter 'from' is optional
    echo $result; // output {"text":"witaj","to":"en","from":"pl","result":"hello"}
    //...
```
