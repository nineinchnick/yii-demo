<?php
/**
 * @author Anggiajuang Patria <anggiaj@gmail.com>
 * @version 0.0.1 (2012-03-15 11:24)
 */
class Pusher extends CApplicationComponent
{
  const AUTH_VERSION='1.0';
  
  public $key;
  public $secret;
  public $appId;
  public $debug=false;
  public $host='http://api.pusherapp.com';
  public $port=80;
  public $timeout=30;
 /**
  * Trigger an event by providing event name and payload. 
  * Optionally provide a socket ID to exclude a client (most likely the sender).
  * 
  * @param string $channel
  * @param string $event
  * @param mixed $payload
  * @param int $socketId
  * @param bool $debug
  * @param bool $encode Encode to json?
  * @return bool|string
  */
  public function trigger($channel,$event,$payload,$socketId=null,$debug=false,$encode=true)
  {
    $sUrl="/apps/{$this->appId}/channels/{$channel}/events";
    
    #signature
    $signature="POST\n".$sUrl."\n";
    if($encode) $payload=CJSON::encode($payload);
    $query= "auth_key={$this->key}&auth_timestamp=".time()
            ."&auth_version=".self::AUTH_VERSION."&body_md5=".md5($payload)."&name={$event}";
    if($socketId!==null) $query.="&socket_id={$socketId}";
    
    $authSignature=hash_hmac('sha256',$signature.$query,$this->secret,false);
    $signedQuery="{$query}&auth_signature={$authSignature}";
    $url="{$this->host}:{$this->port}{$sUrl}?$signedQuery";
    
    $ch=curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$payload);
    curl_setopt($ch,CURLOPT_TIMEOUT,$this->timeout);

    $response=curl_exec($ch);
    curl_close($ch);
    if($response=="202 ACCEPTED\n"&&$debug===false)
      return true;
    if($debug||$this->debug)
      return $response;
    return false;
  }
 /**
  * Creates a socket signature
  * 
  * @param string $channel
  * @param int $socketId
  * @param string $data
  * @return string
  */
  public function socketAuth($channel,$socketId,$data=false)
  {
    $signature=array();
    $hashData="{$socketId}:{$channel}";
    if($data!==false) 
    {
      $hashData=":{$data}";
      $signature['channel_data']=$data;
    }
    $signature['auth']=$this->key.':'.hash_hmac('sha256',$hashData,$this->secret,false);
    return CJSON::encode($signature);
  }
 /**
  * Creates a presence signature (an extension of socket signing)
  *
  * @param string $channel
  * @param int $socketId
  * @param string $userId
  * @param mixed $userInfo
  * @return string
  */
  public function presenceAuth($channel,$socketId,$userId,$userInfo=false)
  {
    $data=array('user_id'=>$userId);
    if($userInfo!==false) $data['user_info']=$userInfo;
    return $this->socketAuth($channel,$socketId,CJSON::encode($data));
  }
}
