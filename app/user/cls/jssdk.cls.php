<?php
class jssdk_user {
  private $appId;
  private $appSecret;

  public function __construct() {
    $this->appId = WXAPPID;
    $this->appSecret = WXAPPSECRET;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage;
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }
  private  function getTicket(){
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      //echo ($ticket);
      if ($ticket) {
          $data->expire_time = time() + 7000;
          $data->jsapi_ticket = $ticket;
      }else{
          $data->expire_time = time();
          $data->jsapi_ticket = "";
      }
      return  $data;
  }
  private function getJsApiTicket() {
    //如果使用redis存储
    if (REDIS){
        $client = new Predis\Client(REDISSERVER);
        //如果存在
        if ($client->exists('phpems:ticket')) {
            $data = $client->get('phpems:ticket');
            $data = json_decode($data);
            if ($data->expire_time < time()){
                $data=$this->getTicket();
                $client->set('phpems:ticket',json_encode($data));
            }
        }
        else{
            $data=$this->getTicket();
            $client->set('phpems:ticket',json_encode($data));
        }
    }
    else{
        //判断文件是否存在
        if (file_exists("data/jsapi_ticket.json")) {
            $data = json_decode(file_get_contents("data/jsapi_ticket.json"));;
            if ($data->expire_time < time()){
                $data=$this->getTicket();
                $fp = fopen("data/jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        }
        else{
            $data=$this->getTicket();
            $fp = fopen("data/jsapi_ticket.json", "w");
            fwrite($fp, json_encode($data));
            fclose($fp);
        }
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        
    }
    return $data->jsapi_ticket;
  }
  private function _getAccessToken(){
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      return $res;
  }
  private function getAccessToken() {
    if (REDIS) {
        $client = new Predis\Client(REDISSERVER);
        //如果存在
        if ($client->exists('phpems:getAccessToken')) {
            $data = $client->get('phpems:getAccessToken');
            $data = json_decode($data);
            if ($data->expire_time < time()){
                $data=$this->_getAccessToken();
                $client->set('phpems:getAccessToken',json_encode($data));
            }
        }
        else{
            $data=$this->_getAccessToken();
            $client->set('phpems:getAccessToken',json_encode($data));
        }
    }else{
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("data/access_token.json"));
        if ($data->expire_time < time()) {
            $data =$this->_getAccessToken();
            $access_token=$data->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("data/access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } 
    }   
    return $data->access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}

