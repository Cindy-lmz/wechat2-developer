<?php

namespace WePay;

use WeChat\Contracts\BasicWePay;
use WeChat\Contracts\Tools;

/**
 * 微信证书更新
 * Class Coupon
 * @package WePay
 */
class Credownload extends BasicWePay
{

    /**
     * [addcoupon 证书下载（官方sdk）]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function certificates()
    {
        $url = "https://api.mch.weixin.qq.com/v3/certificates";

        $option = [];

        return $this->wxpay_downloadCert();
    }

    public function uploadImg($filename)
    {
        $url = "https://api.mch.weixin.qq.com/v3/marketing/favor/media/image-upload";

        // $file = Tools::createCurlFile($filename);

        return  $this->wxpayv3upload($url,$filename);
    }

}