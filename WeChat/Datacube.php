<?php
namespace WeChat;

use WeChat\Contracts\BasicWeChat;

/**
 * 微信数据统计管理
 * Class datacube
 * @package WeChat
 */
class Datacube extends BasicWeChat
{

    /**
     * 获取用户增减数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getusersummary(array $data){
        $url = "https://api.weixin.qq.com/datacube/getusersummary?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取累计用户数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
   public function getusercumulate(array $data){
        $url = "https://api.weixin.qq.com/datacube/getusercumulate?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文群发每日数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getarticlesummary(array $data){
        $url = "https://api.weixin.qq.com/datacube/getarticlesummary?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文群发总数
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getarticletotal(array $data){
        $url = "https://api.weixin.qq.com/datacube/getarticletotal?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文统计数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getuserread(array $data){
        $url = "https://api.weixin.qq.com/datacube/getuserread?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文统计分时数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getuserreadhour(array $data){
        $url = "https://api.weixin.qq.com/datacube/getuserreadhour?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文分享转发数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getusershare(array $data){
        $url = "https://api.weixin.qq.com/datacube/getusershare?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取图文分享转发分时数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getusersharehour(array $data){
        $url = "https://api.weixin.qq.com/datacube/getusersharehour?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送概况数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsg(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsg?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息分送分时数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsghour(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsghour?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送周数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsgweek(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgweek?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送月数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsgmonth(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgmonth?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送分布数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsgdist(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdist?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送分布周数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsgdistweek(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdistweek?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取消息发送分布月数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getupstreammsgdistmonth(array $data){
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdistmonth?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 广告数据分析 
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  [type]                   $stat 
     * [
     * publisher_adpos_general => 获取公众号分广告位数据,
     * publisher_cps_general   => 获取公众号返佣商品数据,
     * publisher_settlement    => 获取公众号结算收入数据及结算主体信息
     * ]
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function publisher($stat,array $data){
        $url = "https://api.weixin.qq.com/publisher/stat?action=".$stat."&access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        foreach ($data as $key => $value) {
            $url .= $key.'='.$value[$key].'&';
        }
        $url = substr( $url,0,strlen($url)-1);
        return $this->httpGetForJson($url);
    }

    /**
     * 获取接口分析数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getinterfacesummary(array $data){
        $url = "https://api.weixin.qq.com/datacube/getinterfacesummary?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

    /**
     * 获取接口分析分时数据
     * @Author Cindy
     * @E-main cindyli@topichina.com.cn
     * @param  array                    $data [description]
     * @return [type]                         [description]
     */
    public function getinterfacesummaryhour(array $data){
        $url = "https://api.weixin.qq.com/datacube/getinterfacesummaryhour?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url,[]);
    }

}