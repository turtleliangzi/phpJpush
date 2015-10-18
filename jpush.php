<?php
error_reporting(E_ALL^E_NOTICE);
class ApipostAction{

    private $_appkeys = '31ef8194cf6f96fa2ccc6978';
    private $_masterSecret = '7a43ba7f916b2e2eddba62ad';

    function request_post($url="",$param="",$header="") {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        // 增加 HTTP Header（头）里的字段 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($ch);//运行curl

        curl_close($ch);
        return $data;
    }

    function send($title,$message) 
    {
        $url = 'https://api.jpush.cn/v3/push';
        $base64=base64_encode("$this->_appkeys:$this->_masterSecret");
        $header=array("Authorization:Basic $base64","Content-Type:application/json");
        $param='{"platform":"all","audience":"all","notification" : {"alert" : "test success"},"message":{"msg_content":"'.$message.'","title":"'.$title.'"}}';
        $res = $this->request_post($url,$param,$header);
        $res_arr = json_decode($res, true);
    }
}

$jpush=new ApipostAction();
$jpush->send('this title','this mesage');


?>
