<?php

namespace WePay;

use WeChat\Contracts\BasicWePay;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidResponseException;

/**
 * 微信商户委托营销 
 * Class Coupon
 * @package WePay
 */
class Partnership extends BasicWePay
{
    /**
     * 建立合作关系
     * @param array $options
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function  partnershipsbuild(array $options, array $headers)
    {
        $url = "https://api.mch.weixin.qq.com/v3/marketing/partnerships/build";
        return $this->callApiv3($url, $options, 'POST',$headers);
    }

    public function partnershipslist(array $options)
    {
        $url = "https://api.mch.weixin.qq.com/v3/marketing/partnerships";
        return $this->callApiv3($url, $options, 'GET');
    }

}