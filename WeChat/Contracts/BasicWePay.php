<?php


namespace WeChat\Contracts;

use WeChat\Exceptions\InvalidArgumentException;
use WeChat\Exceptions\InvalidResponseException;
use WeChat\Exceptions\InvalidDecryptException;
use WeChat\Exceptions\InvalidInstanceException;
use WeChat\Exceptions\LocalCacheException;
use service\DataService;
use service\LogService;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
use WechatPay\GuzzleMiddleware\Validator;
use WechatPay\GuzzleMiddleware\Auth\Signer;
use WechatPay\GuzzleMiddleware\Auth\SignatureResult;
use WechatPay\GuzzleMiddleware\Auth\WechatPay2Credentials;

use GuzzleHttp\Handler\CurlHandler;
use WechatPay\GuzzleMiddleware\Util\AesUtil;
use WechatPay\GuzzleMiddleware\Auth\CertificateVerifier;
use WechatPay\GuzzleMiddleware\Auth\WechatPay2Validator;
use service\FileService;

use WechatPay\GuzzleMiddleware\Util\MediaUtil;
/**
 * 微信支付基础类
 * Class BasicPay
 * @package WeChat\Contracts
 */
class BasicWePay
{
	/**
	 * 商户配置
	 * @var DataArray
	 */
	protected $config;

	/**
	 * 当前请求数据
	 * @var DataArray
	 */
	protected $params;


	/**
	 * WeChat constructor.
	 * @param array $options
	 */
	public function __construct(array $options)
	{

		if (empty($options['appid'])) {
			throw new InvalidArgumentException("Missing Config -- [appid]");
		}
		if (empty($options['mch_id'])) {
			throw new InvalidArgumentException("Missing Config -- [mch_id]");
		}
		if (empty($options['mch_key'])) {
			throw new InvalidArgumentException("Missing Config -- [mch_key]");
		}
		if (!empty($options['cache_path'])) {
			Tools::$cache_path = $options['cache_path'];
		}
		$this->config = new DataArray($options);
		// 商户基础参数
		$this->params = new DataArray([
			'appid'     => $this->config->get('appid'),
			'mch_id'    => $this->config->get('mch_id'),
			'nonce_str' => Tools::createNoncestr(),
		]);
		// 商户参数支持
		if ($this->config->get('sub_appid')) {
			$this->params->set('sub_appid', $this->config->get('sub_appid'));
		}
		if ($this->config->get('sub_mch_id')) {
			$this->params->set('sub_mch_id', $this->config->get('sub_mch_id'));
		}
	}

	/**
	 * 获取微信支付通知
	 * @return array
	 * @throws InvalidResponseException
	 */
	public function getNotify()
	{
		$data = Tools::xml2arr(file_get_contents('php://input'));
		if (isset($data['sign']) && $this->getPaySign($data) === $data['sign']) {
			return $data;
		}
		throw new InvalidResponseException('Invalid Notify.', '0');
	}



	/**
	 * 获取微信支付通知版 V3
	 * @return array
	 * @throws InvalidResponseException
	 */
	public function getNotifyV3()
	{
		$opts = $this->parseOpts();

		$data = Tools::json2arr(file_get_contents('php://input'));

		LogService::paywrite('微信支付通知V3', '返回信息：'.json_encode($data));

		$validator = new WechatPay2Validator();

		// $merchantPrivateKey = PemUtil::loadPrivateKey($this->config->get('ssl_key')); // 商户私钥
		// // 微信支付平台配置
		// $wechatpayCertificate = PemUtil::loadCertificate($this->config->get('ssl_cer')); // 微信支付平台证书
		// $crypto = new SensitiveInfoCrypto($wechatpayCertificate, $merchantPrivateKey);

		// $encrypted = $crypto('Alice');

		// $decrypted = $crypto->setStage('decrypt')($encrypted);
		
		$decrypter = new AesUtil($opts['key']);

		$encCert = $data['resource'];

		$plain = $decrypter->decryptToString($encCert['associated_data'],
					$encCert['nonce'], $encCert['ciphertext']);

		LogService::paywrite('微信支付通知V3', '解密后返回信息：'.json_encode($plain));
		
		return $plain;

		// throw new InvalidResponseException('Invalid Notify.', '0');
	}

	/**
	 * 获取微信支付通知回复内容 V3版
	 * @return string
	 */
	public function getNotifySuccessReplyV3()
	{
		return Tools::arr2xml(['code' => 'SUCCESS', 'message' => 'OK']);
	}


	/**
	 * 获取微信支付通知回复内容
	 * @return string
	 */
	public function getNotifySuccessReply()
	{
		return Tools::arr2xml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
	}
	/**
	 * 生成支付签名
	 * @param array $data 参与签名的数据
	 * @param string $signType 参与签名的类型
	 * @param string $buff 参与签名字符串前缀
	 * @return string
	 */
	public function getPaySign(array $data, $signType = 'MD5', $buff = '')
	{
		ksort($data);
		if (isset($data['sign'])) unset($data['sign']);
		foreach ($data as $k => $v) $buff .= "{$k}={$v}&";
		$buff .= ("key=" . $this->config->get('mch_key'));
		if (strtoupper($signType) === 'MD5') {
			return strtoupper(md5($buff));
		}
		return strtoupper(hash_hmac('SHA256', $buff, $this->config->get('mch_key')));
	}


	/**
	 * 转换短链接
	 * @param string $longUrl 需要转换的URL，签名用原串，传输需URLencode
	 * @return array
	 * @throws InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	public function shortUrl($longUrl)
	{
		$url = 'https://api.mch.weixin.qq.com/tools/shorturl';
		return $this->callPostApi($url, ['long_url' => $longUrl]);
	}


	/**
	 * 数组直接转xml数据输出
	 * @param array $data
	 * @param bool $isReturn
	 * @return string
	 */
	public function toXml(array $data, $isReturn = false)
	{
		$xml = Tools::arr2xml($data);
		if ($isReturn) {
			return $xml;
		}
		echo $xml;
	}

	/**
	 * 以Post请求接口
	 * @param string $url 请求
	 * @param array $data 接口参数
	 * @param bool $isCert 是否需要使用双向证书
	 * @param string $signType 数据签名类型 MD5|SHA256
	 * @param bool $needSignType 是否需要传签名类型参数
	 * @return array
	 * @throws InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	protected function callPostApi($url, array $data, $isCert = false, $signType = 'HMAC-SHA256', $needSignType = true)
	{
		$option = [];
		if ($isCert) {
			$option['ssl_p12'] = $this->config->get('ssl_p12');
			$option['ssl_cer'] = $this->config->get('ssl_cer');
			$option['ssl_key'] = $this->config->get('ssl_key');
			if (is_string($option['ssl_p12']) && file_exists($option['ssl_p12'])) {
				$content = file_get_contents($option['ssl_p12']);
				if (openssl_pkcs12_read($content, $certs, $this->config->get('mch_id'))) {
					$option['ssl_key'] = Tools::pushFile(md5($certs['pkey']) . '.pem', $certs['pkey']);
					$option['ssl_cer'] = Tools::pushFile(md5($certs['cert']) . '.pem', $certs['cert']);
				} else throw new InvalidArgumentException("P12 certificate does not match MCH_ID --- ssl_p12");
			}
			if (empty($option['ssl_cer']) || !file_exists($option['ssl_cer'])) {
				throw new InvalidArgumentException("Missing Config -- ssl_cer", '0');
			}
			if (empty($option['ssl_key']) || !file_exists($option['ssl_key'])) {
				throw new InvalidArgumentException("Missing Config -- ssl_key", '0');
			}
		}
		$params = $this->params->merge($data);
		$needSignType && ($params['sign_type'] = strtoupper($signType));
		$params['sign'] = $this->getPaySign($params, $signType);
		$result = Tools::xml2arr(Tools::post($url, Tools::arr2xml($params), $option));
		if ($result['return_code'] !== 'SUCCESS') {
			throw new InvalidResponseException($result['return_msg'], '0');
		}
		return $result;
	}


	/**
	 * 微信支付v3 版通用请求接口
	 * @param string $url 请求
	 * @param array $data 接口参数
	 * @return array
	 * @throws InvalidResponseException
	 * @throws \WeChat\Exceptions\LocalCacheException
	 */
	protected function callApiv3($base_url, array $data,$request_type='POST',array $options = [])
	{
	   
	   // 商户相关配置
		$merchantId = $this->config->get('mch_id');// // 商户号

		$merchantSerialNumber =  $this->config->get('mch_serialno');// 商户API证书序列号

		$merchantPrivateKey = PemUtil::loadPrivateKey($this->config->get('ssl_key')); // 商户私钥
		// 微信支付平台配置
		$wechatpayCertificate = PemUtil::loadCertificate($this->config->get('ssl_cer')); // 微信支付平台证书
		// 构造一个WechatPayMiddleware
		$wechatpayMiddleware = WechatPayMiddleware::builder()
			->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey) // 传入商户相关配置
			->withWechatPay([ $wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
			->build();

		// 将WechatPayMiddleware添加到Guzzle的HandlerStack中
		$stack = HandlerStack::create();

		$stack->push($wechatpayMiddleware, 'wechatpay');

		// 创建Guzzle HTTP Client时，将HandlerStack传入
		$client = new Client(['handler' => $stack]);
		// 接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
		
		$headers['Accept'] = 'application/json';

		try {

			!empty($options) && $headers = array_merge($headers,$options);

			if($request_type=='GET'){

				if (!empty($data)) {

					$base_url .= '?';
					
					foreach ($data as $key => $value) {
					
						$base_url .= $key.'='.$value.'&';
					}

					$base_url = substr($base_url, 0,strlen($base_url)-1);
				}

				$resp = $client->request('GET', $base_url, [ // 注意替换为实际URL
					'headers' => $headers
				]);

			}else{

				$resp = $client->request('POST', $base_url, [
					'json' => $data,
					'headers' => $headers
				]);

			}
			
			
			$list = $resp->getBody()->getContents();

			return Tools::json2arr($list);

		} catch (RequestException $e) {

 			$list = Tools::json2arr($e->getResponse()->getBody()->getContents());

 			if (isset($list['code'])) {
 				
 				// throw new InvalidResponseException($e->getResponse()->getBody()->getContents());

				if ($e->hasResponse()) {

					if (isset($data['coupon_code_list']) && isset($data['upload_request_no'])) {
						
						return $list;
					}

					if (isset($data['detail'])) {
						
						throw new InvalidResponseException('错误码：'.$list['code'].'提示信息：'.$list['message'].json_encode($list['detail']),$list['code']);
					}

					// return $list;
					throw new InvalidResponseException('错误码：'.$list['code'].'提示信息：'.$list['message'],$list['code']);
				}

 			}
			// 进行错误处理

			return $list;
			
		}

	}

	

	/**
	 * [downloadCert 微信支付证书下载]
	 * @return [type] [description]
	 */
	protected function wxpay_downloadCert()
	{
		try {


			$opts = $this->parseOpts();

			// 构造一个WechatPayMiddleware
			$builder = WechatPayMiddleware::builder()
						->withMerchant($opts['mchid'], $opts['serialno'], PemUtil::loadPrivateKey($opts['privatekey'])); // 传入商户相关配置

			if (isset($opts['wechatpay-cert'])) {

				$builder->withWechatPay([ PemUtil::loadCertificate($opts['wechatpay-cert']) ]); // 使用平台证书验证
			}else {

				$builder->withValidator(new NoopValidator); // 临时"跳过”应答签名的验证

			}

			$wechatpayMiddleware = $builder->build();

			// 将WechatPayMiddleware添加到Guzzle的HandlerStack中
			$stack = HandlerStack::create();

			$stack->push($wechatpayMiddleware, 'wechatpay');

			// 创建Guzzle HTTP Client时，将HandlerStack传入
			$client = new Client(['handler' => $stack]);

			// 接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
			$resp = $client->request('GET', 'https://api.mch.weixin.qq.com/v3/certificates', [
				'headers' => [ 'Accept' => 'application/json' ]
			]);

			if ($resp->getStatusCode() < 200 || $resp->getStatusCode() > 299) {

				throw new InvalidResponseException($getBody->getMessage(), $resp->getStatusCode());
				
			}

			$list = json_decode($resp->getBody(), true);

			$plainCerts = [];

			$x509Certs = [];

			$decrypter = new AesUtil($opts['key']);

			foreach ($list['data'] as $item) {

				$encCert = $item['encrypt_certificate'];

				$plain = $decrypter->decryptToString($encCert['associated_data'],
					$encCert['nonce'], $encCert['ciphertext']);

				if (!$plain) {

					throw new InvalidDecryptException('encrypted certificate decrypt fail!');

				}

				// 通过加载对证书进行简单合法性检验
				$cert = \openssl_x509_read($plain); // 从字符串中加载证书

				if (!$cert) {

					 throw new InvalidResponseException('downloaded certificate check fail!');
	  
				}

				$plainCerts[] = $plain;

				$x509Certs[] = $cert;

			}

			// 使用下载的证书再来验证一次应答的签名
			$validator = new WechatPay2Validator(new CertificateVerifier($x509Certs));

			if (!$validator->validate($resp)) {

				throw new InvalidResponseException('validate response fail using downloaded certificates!');

			}

			$wechatconfig_data = array();
			// 保存到文件并更新到数据库
			foreach ($list['data'] as $index => $item) {

				date_default_timezone_set('Asia/Shanghai');
				//证书保存路径
				$outpath = 'wechatpay_'.$item['serial_no'].'.pem';

				$save_key_suss = FileService::local($outpath, $plainCerts[$index]);

				//获取服务器URL前缀
				$site_url = FileService::getBaseUriLocal();

				$wechatconfig_data = array( 'wechat_cert_cert'=>'static/upload/'.$outpath,
											'wechat_certificate_effective_time'=>date('Y-m-s H:i:s',strtotime($item['effective_time'])),
											'wechat_certificate_expire_time'=>date('Y-m-s H:i:s',strtotime($item['expire_time'])),
											'wechat_certificate_serial_no'=>$item['serial_no'],
											'wechat_appid'=>$this->config->get('appid'),
										);

				sysconf('ssl_cer',$outpath);

				sysconf('certificate_effectivetime',date('Y-m-s H:i:s',strtotime($item['effective_time'])));

				sysconf('certificate_expiretime',date('Y-m-s H:i:s',strtotime($item['expire_time'])));
				
				sysconf('certificate_serialno',$item['serial_no']);

			}

			DataService::save('system_wechatconfig', $wechatconfig_data, 'wechat_appid',[['wechat_appid', 'eq', $this->config->get('appid')]]);

			return $wechatconfig_data;

		}catch (InvalidResponseException $e) {

			throw new InvalidResponseException($e->getMessage());

			if ($e->hasResponse()) {

				throw new InvalidResponseException($e->getMessage(),$e->getStatusCode(),$e->getBody());
			}
		}catch (Exception $e) {
	
			throw new LocalCacheException($e->getMessage(),'-1',$e);
		}
	}

	/**
	 * [parseOpts 微信支付基础参数]
	 * @return [type] [description]
	 */
	public function parseOpts()
	{

	   $data = array(
					'key'=>$this->config->get('mch_key'),
					'mchid'=>$this->config->get('mch_id'),
					'privatekey'=>$this->config->get('ssl_key'),
					'serialno'=>$this->config->get('mch_serialno'),
					'output'=>$this->config->get('appid')
				);
		
		return $data;
	}

	/**
	 * [wxpayv3upload 微信支付v3 上传文件]
	 * @param  [type] $url      [description]
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	public function wxpayv3upload($url,$filename)
	{

		$merchantId = $this->config->get('mch_id');// // 商户号

		$merchantSerialNumber =  $this->config->get('mch_serialno');// 商户API证书序列号

		$merchantPrivateKey = PemUtil::loadPrivateKey($this->config->get('ssl_key')); // 商户私钥
		// 微信支付平台配置
		$wechatpayCertificate = PemUtil::loadCertificate($this->config->get('ssl_cer')); // 微信支付平台证书
		// 构造一个WechatPayMiddleware
		$wechatpayMiddleware = WechatPayMiddleware::builder()
			->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey) // 传入商户相关配置
			->withWechatPay([ $wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
			->build();

		// 将WechatPayMiddleware添加到Guzzle的HandlerStack中
		$stack = HandlerStack::create();

		$stack->push($wechatpayMiddleware, 'wechatpay');

		// 创建Guzzle HTTP Client时，将HandlerStack传入
		$client = new Client(['handler' => $stack]);

		// 实例化一个媒体文件流，注意文件后缀名需符合接口要求
		$media = new MediaUtil($filename);

		// 正常使用Guzzle发起API请求
		try {
			
		    $resp = $client->request('POST', $url, [
		        'body'    => $media->getStream(),
		        'headers' => [
		            'Accept'       => 'application/json',
		            'content-type' => $media->getContentType(),
		        ]
		    ]);

		    $list = $resp->getBody()->getContents();

		    $list = Tools::json2arr($list);

			return $list['media_url'];

		} catch (RequestException $e) {

 			$list = Tools::json2arr($e->getResponse()->getBody()->getContents());

 			if (isset($list['code'])) {
 				

				if ($e->hasResponse()) {

	 
					throw new InvalidResponseException($list['message'],$list['code']);
				}

 			}
			// 进行错误处理

			return $list;
			
		}
	}

   
}