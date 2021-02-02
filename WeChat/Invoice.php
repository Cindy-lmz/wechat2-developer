<?php


namespace WeChat;

use WeChat\Contracts\BasicWeChat;

/**
 * 微信发票管理
 * Class Invoice
 * @package WeChat
 */
class Invoice extends BasicWeChat
{

    /**
     * 获取Spappid
     */
    public function getSappid(){
        $url = "https://api.weixin.qq.com/card/invoice/seturl?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 创建发票卡券模板
     * @param array $data
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function createcard(array $data)
    {
        $url = "https://api.weixin.qq.com/card/invoice/platform/createcard?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 设置商户联系方式
     * @param string $type TICKET类型(wx_card|jsapi)
     * @param string $appid 强制指定有效APPID
     * @return string
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function setbizattr(array $data)
    {
        $url = "https://api.weixin.qq.com/card/invoice/setbizattr?action=set_contact&access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }


}