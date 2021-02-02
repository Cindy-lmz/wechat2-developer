<?php

namespace WePay;

use WeChat\Contracts\BasicWePay;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidResponseException;

/**
 * 微信商户代金券
 * Class Coupon
 * @package WePay
 */
class Couponv3 extends BasicWePay
{

	/**
	 * [addcoupon 创建代金券]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function addcoupon(array $options)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/coupon-stocks";

		return $this->callApiv3($url, $options);

	}

	/**
	 * 发放代金券
	 * @param array $options
	 * @return array
	 * @throws \WeChat\Exceptions\InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function create(array $options,$openid)
	{
		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/users/".$openid."/coupons";

		return $this->callApiv3($url, $options);

	}

	/**
	 * 查询批次详情API
	 * @param array $options
	 * @return array
	 * @throws \WeChat\Exceptions\InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function queryStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id;

		return $this->callApiv3($url, $options,'GET');

	}

	/**
	 * 查询代金券详情API
	 * @param array $options
	 * @return array
	 * @throws \WeChat\Exceptions\InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function queryInfo(array $options,$openid,$coupon_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/users/".$openid."/coupons/".$coupon_id;

		return $this->callApiv3($url, $options,'GET');
	}

	/**
	 * [activationStock 激活代金券批次]
	 * @param  array  $options  [商户号]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	public function activationStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/start";

		return $this->callApiv3($url, $options);

	}

	/**
	 * [pauseStock 暂停代金券批次API]
	  * @param  array  $options  [商户号]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	public function pauseStock(array $options,$stock_id)
	{

		 $url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/pause";

		return $this->callApiv3($url, $options);
	}

	/**
	 * [restartStock 重启代金券批次API]
	 * @param  array  $options  [商户号]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function restartStock(array $options,$stock_id)
	{

		 $url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/restart";

		return $this->callApiv3($url, $options);
	} 

	/**
	 * [whereStock 条件查询批次列表API]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function  whereStock(array $options)
	{
		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks";

		return $this->callApiv3($url, $options,'GET');
	}

	/**
	 * [restartdataStock 查询批次详情API]
	 * @param  array  $options  [商户号]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function restartdataStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id;

		return $this->callApiv3($url, $options,'GET');
	} 

	/**
	 * [couponsdataStock 查询代金券详情API]
	 * @param  array  $options  [用户id]
	 * @param  [type] $coupon_id [代金券id]
	 * @return [type]           [description]
	 */
	 public function couponsdataStock($openid,$coupon_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/users/".$openid."/coupons/".$coupon_id;

		return $this->callApiv3($url,$this->config->get('appid'),'GET');
	}

	/**
	 * [merchantsStock 查询代金券可用商户API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function merchantsStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/merchants";

		return $this->callApiv3($url, $options,'GET');
	}

	/**
	 * [itemsStock 查询代金券可用单品API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function itemsStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/items";

		return $this->callApiv3($url, $options,'GET');
	}

	/**
	 * [couponsdataStock 根据商户号查用户的券]
	 * @param  array  $options  [用户id]
	 * @param  [type] $coupon_id [代金券id]
	 * @return [type]           [description]
	 */
	 public function couponsuserStock($openid)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/users/".$openid."/coupons";

		return $this->callApiv3($url, $options,'GET');
	}


	/**
	 * [useflowStock 下载批次核销明细API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function useflowStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/use-flow";

		return $this->callApiv3($url,$options,'GET'); 
	}

	/**
	 * [refundflowStock 下载批次退款明细API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function refundflowStock(array $options,$stock_id)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/stocks/".$stock_id."/refund-flow";

		return $this->callApiv3($url,$options,'GET'); 
	}

	/**
	 * [callbacksStock 设置消息通知地址API]
	 * @param  array  $options  [请求参数]
	 * @param  [type] $stock_id [批次号]
	 * @return [type]           [description]
	 */
	 public function callbacksStock(array $options)
	{

		$url = "https://api.mch.weixin.qq.com/v3/marketing/favor/callbacks";

		return $this->callApiv3($url,$options); 
	}










}