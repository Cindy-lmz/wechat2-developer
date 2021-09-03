<?php

namespace WePay;

use WeChat\Contracts\BasicWePay;
use WeChat\Contracts\Tools;

/**
 * 微信商户券 V3版
 * Class Merchantcoupon
 * @package WePay
 */
class Merchantcoupon extends BasicWePay
{
	/**
	 * [addcoupon 创建商户券]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function addcoupon(array $options)
	{
		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks";
		return $this->callApiv3($url, $options);
	}
    
    /**
     * 编辑商家券
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options [description]
     * @param  [type]                   $stock_id [description]
     * @return [type]                             [description]
     */
    public function editcoupon(array $options, $stock_id)
    {
        $url = 'https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/' . $stock_id;
        return $this->callApiv3($url, $options, 'PATCH');
    }
    
    /**
     * 修改批次预算
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $options [description]
     * @param  [type]                   $stock_id [description]
     * @return [type]                             [description]
     */
    public function couponbudget(array $options, $stock_id)
    {
        $url = 'https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/' . $stock_id . '/budget';
        return $this->callApiv3($url, $options, 'PATCH');
        
    }
    
	/**
	 * H5发放代金券
	 * @param array $options
	 * @return array
	 * @throws \WeChat\Exceptions\InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function create(array $options)
	{

		$sign_str = "coupon_code=".$options['stock_id']."&open_id=".$options['stock_id']."&out_request_no=".$options['stock_id']."&send_coupon_merchant=".$options['stock_id']."&stock_id=".$options['stock_id']."&key=".$options['stock_id']."";

		$sign = $this->getPaySign($sign_str, 'SHA256');

		$url = "https://action.weixin.qq.com/busifavor/getcouponinfo?stock_id=".$options['stock_id']."&out_request_no=".$options['out_request_no']."&sign=".$sign."&send_coupon_merchant=".$options['send_coupon_merchant']."&open_id=".$options['open_id']."";

		return Tools::get($url);

	}

	/**
	 * 查询商家券详情API
	 * @param array $options
	 * @return array
	 * @throws \WeChat\Exceptions\InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function queryStock($stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/".$stock_id;

		return $this->callApiv3($url,[],'GET');

	}

	
	/**
	 * [unsetStock 核销用户券API]
	 * @param  array  $options  [请求参数]
	 * @return [type]           [description]
	 */
	 public function unsetStock(array $options)
	{

		 $url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/use";

		return $this->callApiv3($url, $options);
	} 

	/**
	 * [whereStock 根据过滤条件查询用户券API]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function  whereuserStock($openid,array $options)
	{
		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/".$openid."/coupons";

		return $this->callApiv3($url, $options,'GET');
	}

	/**
	 * [couponsdataStock 查询用户单张券详情API]
	 * @param  array  $options  [用户id]
	 * @param  [type] $coupon_id [代金券id]
	 * @return [type]           [description]
	 */
	 public function couponsdataStock($openid,$coupon_code)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/".$openid."/coupons/".$coupon_code."/appids/".$this->config->get('appid');

		return $this->callApiv3($url,[],'GET');
	}


	/**
	 * [couponcodesStock 上传预存code API]
	 * @param  array  $options  [请求参数]
	 * @return [type]           [description]
	 */
	 public function couponcodesStock(array $options,$stock_id)
	{

		 $url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/".$stock_id."/couponcodes";

		return $this->callApiv3($url, $options);
	} 


	/**
	 * [callbacksStock 设置商家券事件通知地址API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function callbacksStock(array $options)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/callbacks";

		return $this->callApiv3($url,$options); 
	}

	/**
	 * [querycallbacksStock 查询商家券事件通知地址API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function querycallbacksStock(array $options)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/busifavor/callbacks";

		return $this->callApiv3($url,$options,'GET'); 
	}










}