<?php
namespace AliPay;

use WeChat\Contracts\BasicAliPay;

/**
 * 支付宝转账到账户
 * Class Transfer
 * @package AliPay
 */
class Transfer extends BasicAliPay
{

    /**
     * Transfer constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->options->set('method', 'alipay.fund.trans.toaccount.transfer');
    }

    /**
     * 创建数据操作
     * @param array $options
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function apply($options)
    {
        return $this->getResult($options);
    }
}