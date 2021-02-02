<?php

namespace WeChat\Contracts;

use WeChat\Exceptions\InvalidArgumentException;
use WeChat\Exceptions\InvalidResponseException;
use think\cache;
use WechatPay\GuzzleMiddleware\Auth\Signer;
use WechatPay\GuzzleMiddleware\Auth\SignatureResult;
use WechatPay\GuzzleMiddleware\Auth\WechatPay2Credentials;

class CustomSigner implements Signer
{
    public function sign($message)
    {
        // 调用签名RPC服务，然后返回包含签名和证书序列号的SignatureResult
        return new SignatureResult('xxxx', 'yyyyy');
    }
}
