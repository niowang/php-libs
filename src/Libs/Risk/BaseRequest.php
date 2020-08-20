<?php

namespace JMD\Libs\Risk;

use JMD\App\Utils;
use JMD\Libs\Risk\Interfaces\Request;
use JMD\Utils\SignHelper;


class BaseRequest implements Request
{
    public $data;

    public $url;

    public $domain = 'https://services.indiaox.in/';

    public $method = 1; //1 post 2 get

    public $accessToken;

    protected $appKey;

    protected $secretKey;


    public function __construct($appKey, $secretKey)
    {
        $this->appKey = $appKey;
        $this->secretKey = $secretKey;
    }


    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }


    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    public function setMethod($type)
    {
        $this->method = $type;
        return $this;
    }


    //TODO 有需要验证数据的，通过继承该类，采用模版方法模式
    public function verify()
    {
        return true;
    }

    public function execute()
    {
        if (!$this->verify()) {
            return false;
        }

        $url = $this->domain . $this->url;

        $this->data['app_key'] = $this->appKey;
        $this->data['sign'] = SignHelper::sign($this->data, $this->secretKey);

        if ($this->method == 1) {
            $result = $this->post($url, $this->data, 60);
            return $result;
        } else {
            return $this->get($url . '?' . http_build_query($this->data));
        }
    }

    public function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36');
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    public function post($url, $data = null, $timeOut = 30)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36');
        curl_setopt($ch, CURLOPT_POST, 1); // 设置为POST方式
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8'
            )
        );
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // POST数据
        }
        $html = curl_exec($ch);
        if ($errorno = curl_errno($ch)) {
            // throw new \Exception(curl_error($ch) . json_encode(curl_getinfo($ch), JSON_UNESCAPED_UNICODE), $errorno);
            Utils::alert('php-libs请求异常',
                json_encode(
                    [
                        'url' => $url,
                        'content' => curl_getinfo($ch),
                        'callback' => curl_error($ch),
                        'data' => $data
                    ], 256));
        }


        curl_close($ch);
        return $html;
    }
}
