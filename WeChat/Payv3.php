<?php
namespace WeChat;

use WeChat\Contracts\BasicWePay;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidResponseException;
use WePay\Couponv3;
use WePay\Credownload;
use WePay\Merchantcoupon;
use WePay\Refund;
use WePay\Transfers;
use WePay\TransfersBank;
use WePay\Partnership;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;

/**
 * 微信支付商户
 * Class Pay
 * @package WeChat\Contracts
 */
class Payv3 extends BasicWePay
{

    /**
     * [certificates 证书下载（官方sdk）]
     * @return [type] [description]
     */
    public function certificates()
    {
        $pay = new Credownload($this->config->get());
        return $pay->certificates();
    }

   	/**
     * 创建代金券
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function addcoupon(array $options)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->addcoupon($options);
    }
    

	/**
     * 发放代金券
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function create(array $options,$openid)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->create($options,$openid);
    }

    /**
     * 查询批次详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->queryStock($options,$stock_id);
    }

    /**
     * 查询代金券详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryInfo(array $options,$openid,$coupon_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->queryInfo($options,$openid,$coupon_id);
    }

    /**
     * 激活代金券批次
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function activationStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->activationStock($options,$stock_id);
    }

    /**
     * 暂停代金券批次API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function pauseStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->pauseStock($options,$stock_id);
    }

    /**
     * 重启代金券批次API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function restartStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->restartStock($options,$stock_id);
    }

    /**
     * 条件查询批次列表API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function whereStock(array $options)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->whereStock($options);
    }

    /**
     * 查询批次详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function restartdataStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->restartdataStock($options,$stock_id);
    }

    /**
     * 查询代金券详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function couponsdataStock($openid,$coupon_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->couponsdataStock($options,$coupon_id);
    }

    /**
     * 查询代金券可用商户API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function merchantsStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->merchantsStock($options,$stock_id);
    }

    /**
     * 查询代金券可用单品API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function itemsStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->itemsStock($options,$stock_id);
    }

    /**
     * 根据商户号查用户的券
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function couponsuserStock($openid)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->couponsuserStock($openid);
    }

    /**
     * 下载批次核销明细API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function useflowStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->useflowStock($options,$stock_id);
    }

    /**
     * 下载批次退款明细API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function refundflowStock(array $options,$stock_id)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->refundflowStock($options,$stock_id);
    }

    /**
     * 设置消息通知地址API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function callbacksStock(array $options)
    {
        $pay = new Couponv3($this->config->get());
        return $pay->callbacksStock($options);
    }

    /**
     * 创建商户券
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function merchantcoupon_addcoupon(array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->addcoupon($options);
    }
    
    /**
     * 编辑商家券
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options  [description]
     * @param  [type]                   $stock_id [description]
     * @return [type]                             [description]
     */
    public function merchantcoupon_editcoupon(array $options,$stock_id)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->editcoupon($options,$stock_id);
    }
    
    /**
     * 修改批次预算
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options  [description]
     * @param  [type]                   $stock_id [description]
     * @return [type]                             [description]
     */
    public function merchantcoupon_couponbudget(array $options,$stock_id)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->couponbudget($options,$stock_id);
    }

     /**
     * H5发放代金券
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function H5create(array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->create($options);
    }

     /**
     * 查询商家券详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function mequeryStock($stock_id)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->queryStock($stock_id);
    }

     /**
     * 核销用户券API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function unsetStock(array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->unsetStock($options);
    }

     /**
     * 根据过滤条件查询用户券API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function mewhereuserStock($openid,array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->whereuserStock($openid,$options);
    }

     /**
     * 查询用户单张券详情API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function mecouponsdataStock($openid,$coupon_code)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->couponsdataStock($openid,$coupon_code);
    }

     /**
     * 上传预存code API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function couponcodesStock(array $options,$stock_id)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->couponcodesStock($options,$stock_id);
    }

     /**
     * 设置商家券事件通知地址API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function merchantcoupon_callbacksStock(array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->callbacksStock($options);
    }

     /**
     * 查询商家券事件通知地址API
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function merchantcoupon_querycallbacksStock(array $options)
    {
        $pay = new Merchantcoupon($this->config->get());
        return $pay->addcoupon($options);
    }

    /**
     * [uploadImg 上传图片]
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public function uploadImg($filename)
    {
        $pay = new Credownload($this->config->get());

        return $pay->uploadImg($filename);
    }

    /**
     * 建立合作关系
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options [请求参数]
     * @param  array                    $headers [请求头]
     * @return [type]                            [description]
     */
    public function partnershipsbuild(array $options)
    {
        $pay = new Partnership($this->config->get());

        return $pay->partnershipsbuild($options,['Idempotency-Key'=>Tools::createNoncestr()]);
    }

    /**
     * 查询合作关系列表
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options [请求参数]
     * @return [type]                            [description]
     */
    public function partnershipslist(array $options)
    {
        $pay = new Partnership($this->config->get());

        return $pay->partnershipslist($options);
    }

    
    
}