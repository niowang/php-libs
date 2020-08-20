<?php
/**
 * Created by PhpStorm.
 * User: zfc
 * Date: 2018/4/13
 * Time: 11:40
 */

namespace JMD\Utils;

use JMD\App\Utils;

class SignHelper
{
    /**
     * @param $params
     * @param null $apiSecretKey
     * @return bool
     * @throws \Exception
     */
    public static function validateSign($params, $apiSecretKey = null)
    {
        if (!isset($params['app_key'])) {
            return false;
        }
        if (!isset($params['sign'])) {
            return false;
        }
        $sign = $params['sign'];
        unset($params['sign']);
        return $sign === self::sign($params, $apiSecretKey);
    }

    /**
     * @param $params
     * @param $apiSecretKey
     * @return string
     * @throws \Exception
     */
    public static function sign(&$params, $apiSecretKey = null)
    {
        if (isset($params['sign'])) {
            unset($params['sign']);
        }
        if (empty($params['app_key'])) {
            throw new \Exception('app_key不存在');
        }
        if (!isset($params['random_str'])) {
            $params['random_str'] = self::getRandom();
        }
        if (!isset($params['time'])) {
            $params['time'] = self::getTime();
        }
        //self::ksortArray($params);
        $str = self::ksortAndSplice($params);
        $sign = hash_hmac('sha256', $str, $apiSecretKey);;
        return $sign;
    }

    /**
     * 参数拼接
     * 此处字符串不使用 http_build_query (多层参数嵌套java侧难实现)
     * 不使用 json 串，在php传递数组时，对方可能解析出不同效果 {"test":1} => {"test":"1"}
     * null => ''
     * @param array $params
     * @param string $str
     *
     * @return string
     */
    public static function ksortAndSplice(array $params, $str = '')
    {
        ksort($params);
        $arr = [];
        foreach ($params as $item) {
            if (is_array($item)) {
                $arr[] = self::ksortAndSplice($item, $str);
            } elseif (is_null($item)) {
                // 在非 application/json 请求中，值为null的值会被剔除，不参与验签
                continue;
            } else {
                $arr[] = $item;
            }
        }
        $str .= implode('|', $arr);
        return $str;
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function ksortArray(&$params)
    {
        foreach ($params as &$value) {
            if (is_array($value)) {
                self::ksortArray($value);
            }
        }
        ksort($params);
        return $params;
    }

    /**
     * 随机值
     * @return string
     */
    public static function getRandom()
    {
        return Utils::random(32);
    }

    /**
     * @return int
     */
    public static function getTime()
    {
        return time();
    }
}
