<?php
/**
 * wechat php test
 */

$str=$_GET['gui'];
include_once("./web/assets/abc.php");
$pdo ->query("set names utf8");
$rs = $pdo->query("SELECT * FROM we_account where atok ='$str'");
$result_arr = $rs->fetchAll();
foreach($result_arr as $val){
    $token=$val['atoken'];
    $appid = $val['appid'];
    $appsecret = $val['appsecret'];
}

//header('content-type:text');
//define your token
define("TOKEN", "abc");
define("APPID", "wx397a734f60e04b31");
define("APPSECRET", "da88bf127932e7de1dbb5076fb3461b1");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();



class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        //echo $this->getAccesstoken();
        if($this->checkSignature()){
            //echo $echoStr;
            $this->createMenu();
            $this->responseMsg();
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $msgtype = $postObj->MsgType;
            $toUsername = $postObj->ToUserName;
            $time = time();

            if($postObj->Event=="CLICK"){
                $Accesstoken=$this->getAccesstoken();
                $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$Accesstoken."&type=image";
                $data=array(
                    "file"=>"@123.jpg"
                );
                $json=$this->curlPost($url,$data,"POST");
                $arr=json_decode($json,true);
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>";
                $msgType = "image";
                $contentStr = $arr['media_id'];
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                $keyword = trim($postObj->Content);

                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                $imageTpl = " <xml>
                            <ToUserName><![CDATA[toUser]]></ToUserName>
                            <FromUserName><![CDATA[fromUser]]></FromUserName>
                            <CreateTime>12345678</CreateTime>
                            <MsgType><![CDATA[image]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[media_id]]></MediaId>
                            </Image>
                            </xml>";

                if($keyword=="1")
                {
                    $msgType = "text";
                    $contentStr = "Welcome to wechat world!";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }else{
                    $msgType = "text";
                    $contentStr = "感谢关注，期待我的作品";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

            }

        }else {
            echo "";
            exit;
        }
    }

    public function createMenu(){
        $Accesstoken=$this->getAccesstoken();
        $url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Accesstoken;

        $data='{
                 "button":[
                 {
                      "type":"click",
                      "name":"我是帅哥",
                      "key":"V1001_TODAY_MUSIC"
                  },
                  {
                       "name":"菜单",
                       "sub_button":[
                       {
                           "type":"view",
                           "name":"搜索",
                           "url":"http://www.soso.com/"
                        },
                        {
                           "type":"view",
                           "name":"视频",
                           "url":"http://v.qq.com/"
                        },
                        {
                           "type":"view",
                           "name":"走你",
                           "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx397a734f60e04b31&redirect_uri=http%3a%2f%2fsntsnt.applinzi.com%2ftemplate.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
                        }]
                   }]
             }';
        $html=$this->curlPost($url,$data,'POST');
        return $html;

    }

    private function getAccesstoken(){
        //return "aaa";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;
        $file=file_get_contents($url);
        $arr=json_decode($file,true);
        $Accesstoken=$arr['access_token'];
        return $Accesstoken;
    }
    public function curlPost($url,$data,$method){
        $ch = curl_init();   //1.初始化
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式
        //4.参数如下
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        if($method=="POST"){//5.post方式的时候添加数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);//6.执行

        if (curl_errno($ch)) {//7.如果出错
            return curl_error($ch);
        }
        curl_close($ch);//8.关闭
        return $tmpInfo;
    }
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        return true;
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

?>