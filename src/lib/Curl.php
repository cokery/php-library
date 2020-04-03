<?php

namespace cokery\lib;

class Curl
{

    /**
     *  Curl
     * @param  string  $url       [description]
     * @param  string  $post_data [description]
     * @param  integer $timeout   [description]
     * @return string
     */
    function curl($url, $post_data = "", $timeout = 30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        //post提交，否则get
        if ($post_data != '') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);

        //跳过SSL验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');

        // 返回数组
        //return json_decode(curl_exec($ch),true);
        // 返回对象
        return json_decode(curl_exec($ch));
    }
}
