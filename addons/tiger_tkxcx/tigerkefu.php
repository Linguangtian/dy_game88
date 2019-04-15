<?php
header('Content-type:text');
define("TOKEN", "tiger_newhu");
define('IN_SYS', true);
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require '../../web/common/bootstrap.sys.inc.php';
require_once "../tiger_newhu/inc/sdk/tbk/TopSdk.php";
global $_W,$_GPC;
// 第三方发送消息给公众平台
//'$encodingAesKey = "zgC133dIJG8zg6IGXXfl8Fj7GoM1j58Oz3gXMc5z8mI";
//$token = "JRg5RA97O84U89a494XOorQO9O851959";
//$timeStamp =time();
//$nonce =11111111111;
//$appId = "wxaa330e77694eb623";'

$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{	
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest 
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }
    
    private function getAccessToken($weid) {
		global $_W;
		load()->model('account');
		$acid = $weid;
		if (empty($acid)) {
			$acid = $weid;
		}
		$account = WeAccount::create($acid);
		//$token = $account->fetch_available_token();
        $token = $account->getAccessToken();
		return $token;
	}

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    
    //正则匹配淘口令
	public function getyouhui2($str){
        preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
        return $matches[1][0];
    }
    
    //淘口令解析
    public function tkljx($msg,$cfg){
    	 global $_W, $_GPC;       
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
         $c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new WirelessShareTpwdQueryRequest;
		$req->setPasswordContent($msg);
		$resp = $c->execute($req);
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/key_log.txt","\ndaohang:".json_encode($jsonArray),FILE_APPEND);
		$url=$jsonArray['url'];
		return $jsonArray;
		/*
		 Array
			(
			    [content] => 趣味儿童剪纸书大全手工di
			    [native_url] => tbopen://m.taobao.com/tbopen/index.html?action=ali.open.nav&module=h5&h5Url=https%3A%2F%2Fuland.taobao.com%2Fcoupon%2Fed
			    [pic_url] => https://img.alicdn.com/imgextra/i3/2372380599/TB2C8pwc3vD8KJjy0FlXXagBFXa_!!2372380599.jpg
			    [suc] => true
			    [thumb_pic_url] => https://img.alicdn.com/imgextra/i3/2372380599/TB2C8pwc3vD8KJjy0FlXXagBFXa_!!2372380599.jpg_170x170.jpg
			    [title] => 淘口令-宝贝
			    [url] => https://uland.taobao.com/coupon/edetail?e=xl7CWoivkXMGQASttHIRq
			    [request_id] => 3b58k7s4f4n1
			)
		 * */

    }
    
    public function myisexists($url) {//判断是不是淘宝的地址
       if (stripos($url,'taobao.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.hk')!==false) {
          return 2;
       }else{
          return 1;
       }
       return 0;
    }
    
    public function getgoodsid($url) {//e22a获取ID
        $str=$url;
		$goodsid=$this->Text_qzj($str,"?id=","&");
        if(empty($goodsid)){
          $goodsid=$this->Text_qzj($str,"&id=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId:",",");
        }
        if(empty($goodsid)){
            $url=$this->Text_qzj($str,"url = '","';");
            $goodsid=$this->Text_qzj($str,"com/i",".htm");
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($goodsid),FILE_APPEND);
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemid=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId=","&");
        }
        if(empty($goodsid)){
           $goodsid=Text_qzj($str,"itemId%3D","%26");
        }
        Return $goodsid;
        

    }
    
    public function hqgoodsid($url) {//e22a获取ID
        $str = $this->curl_request($url);     
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n aaaaassss:".$str,FILE_APPEND);
        //preg_match_all('|url.*&id=([\d]+)&|', $fd,$str);
		$str=str_replace("\"", "", $str);       
        $title=$this->Text_qzj($str,"<title>","</title>");
        if($title=='亲，访问受限了'){
          Return array('error'=>'亲，访问受限了'); 
        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode($str),FILE_APPEND);
		$goodsid=$this->Text_qzj($str,"?id=","&");
        if(empty($goodsid)){
          $goodsid=$this->Text_qzj($str,"&id=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId:",",");
        }
        if(empty($goodsid)){
            $url=$this->Text_qzj($str,"url = '","';");
            $goodsid=$this->Text_qzj($str,"com/i",".htm");
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($goodsid),FILE_APPEND);
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemid=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId=","&");
        }
        if(empty($goodsid)){
           $goodsid=Text_qzj($str,"itemId%3D","%26");
        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode("--------------"),FILE_APPEND);
        Return $goodsid;
    }
    
    public function Text_qzj($Text,$Front,$behind) {
		//语法：strpos(string,find,start)
		//函数返回字符串在另一个字符串中第一次出现的位置，如果没有找到该字符串，则返回 false。
		//参数描述：
		//string 必需。规定被搜索的字符串。
		//find   必需。规定要查找的字符。
		//start  可选。规定开始搜索的位置。
		
		//语法：string mb_substr($str,$start,$length,$encoding)
		//参数描述：
		//str      被截取的母字符串。
		//start    开始位置。
		//length   返回的字符串的最大长度,如果省略，则截取到str末尾。
		//encoding 参数为字符编码。如果省略，则使用内部字符编码。
			
			$t1 = mb_strpos(".".$Text,$Front);
			if($t1==FALSE){
				return "";
			}else{
				$t1 = $t1-1+strlen($Front);
			}
			$temp = mb_substr($Text,$t1,strlen($Text)-$t1);
			$t2 = mb_strpos($temp,$behind);
			if($t2==FALSE){
				return "";
			}
			return mb_substr($temp,0,$t2);
	}
	
	public function curl_request($url,$post='',$cookie='', $returnCookie=0){
    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$Cookies,参数4：是否返回$cookies
        $curl = curl_init();//初始化curl会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);//执行curl会话
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);//关闭curl会话
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }
    
    //解析标题
    public function tklresp($centent){
    	         global $_W, $_GPC;
      	         $stry=str_replace("【天猫超市】","",$centent);   
                 $stry=str_replace("抢","",$centent); 
                 //$str=$this->Text_qzj($stry,"（","），");
                 $str=$this->fun1($stry);
                 if(!empty($str)){
                      return $str;
                 }
                 $str1=$this->fun2($stry);
                 if(!empty($str1)){
                      return $str1;
                 }
                 $str2=$this->Text_qzj($stry,"【抢","】，");
                 if(!empty($str2)){                 
                      return $str2;
                 }
    }
    
    public function fun1($str){
        if (preg_match('/（(.*?)）/sim', $str,$matches)) {
            $title=$matches[1];
        } else {
            # Match attempt failed
            $title="";
        }        
        return $title;
    }
    public function fun2($str){
        if (preg_match('/【(.*?)】/sim', $str,$matches)) {
            $title=$matches[1];
        } else {
            # Match attempt failed
            $title="";
        }        
        return $title;
    }
    
    public function mygetID($url) {//获取链接商品ID
       if (preg_match("/[\?&]id=(\d+)/",$url,$match)) {
          return $match[1];
       } else {
          return '';
       }
    }
    
    //高佣金申请
    public function xcxtaokejh($numid,$sign,$tbuid,$adzoneid,$siteId,$tkurl,$tkip) {
        if(empty($numid) || empty($adzoneid) || empty($sign)){
          $arr=json_decode(array('error'=>1),TRUE);
          Return $arr;
        }
        $url="http://api1.laohucms.com/xcxtaoapi.php?&numid=".$numid."&adzoneid=".$adzoneid."&tbuid=".$tbuid."&siteId=".$siteId."&sign=".$sign."&tkurl=".$tkurl."&tkip=".$tkip."";
        $arr=$this->curl_request($url);
        $arr=json_decode($arr,TRUE);      
        Return $arr;
   }
   
   //通过商品ID取商品详情页内容
	public function getitemid($itemid,$cfg){
		$appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
		$c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new TbkItemInfoGetRequest;
		$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
		$req->setPlatform("2");
		$req->setNumIids($itemid);
		$resp = $c->execute($req);
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		return $jsonArray['results']['n_tbk_item'];
	}
	
	public function tkl($url,$img,$tjcontent,$cfg) {//淘口令转换
        global $_W, $_GPC;
        
        //$cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
        
        $c = new TopClient;
		$c->appkey = $appkey;
        $c->secretKey = $secret;
		$req = new TbkTpwdCreateRequest;
		//$req->setUserId("123");
		$req->setText($tjcontent);
		$req->setUrl($url);
		$req->setLogo($img);
		$req->setExt("{}");
		$resp = $c->execute($req);	
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		$taokou=$jsonArray['data']['model'];

	    //file_put_contents(IA_ROOT."/addons/tiger_newhu/tkl_log.txt","\n".json_encode($jsonArray),FILE_APPEND);
        Return $taokou;
    }
    
    //发送消息
    public function getmsg($openid,$token,$msg,$MsgType=''){
    	//$result='{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
    	if(empty($MsgType)){
    		$result='{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
	    	file_put_contents(IA_ROOT."/addons/tiger_tkxcx/msg_log.txt","\n".$result,FILE_APPEND);
	    	$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
	    	$ret = ihttp_request($url, $result); 
    	}else{    		
    		$time=time();
	    	$result='{"touser":"'.$openid.'","FromUserName":"gh_3371946b4d37","CreateTime":"'.$time.'","msgtype":"transfer_customer_service"}';	    	
	    	$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
	    	$ret = ihttp_request($url, $result);   
	    	file_put_contents(IA_ROOT."/addons/tiger_tkxcx/msg_log.txt","\n".json_encode($ret),FILE_APPEND);
    	}
    }
    
    
    //回复多客服消息
    public function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        file_put_contents(IA_ROOT."/addons/tiger_tkxcx/msg_log.txt","\n".$result,FILE_APPEND);
        return $result;
    }
	
    
    //发送图文消息
    public function sendimg($openid,$token,$msg){
    	//$result='{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
    	$result='{"touser": "'.$openid.'","msgtype": "link","link": {"title": "'.$msg['title'].'","description": "'.$msg['content'].'","url": "'.$msg['url'].'","thumb_url": "'.$msg['picurl'].'"}}';
//  	$result='{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/mb_log.txt","\n".json_encode($msg),FILE_APPEND);
file_put_contents(IA_ROOT."/addons/tiger_tkxcx/mb_log.txt","\n".$result,FILE_APPEND);
    	$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
    	$ret = ihttp_request($url, $result);   	
    	
    }
    
    //获取粉丝推广位
    public function getptpid($weid,$xcxopenid,$cfg){
    	$zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and xcxopenid='{$xcxopenid}'");
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
               $cfg['qqpid']=$zxshare['dlqqpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        

        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
              $cfg['qqpid']=$sjshare['dlqqpid'];
            }   
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
            }
        }
        if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
	    return $cfg['ptpid'];
    }

    public function responseMsg()
    {
    	global $_W;
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
       
        if (!empty($postStr)){        	

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;//小程序OPENID
            $toUsername = $postObj->ToUserName; //小程序原始ID
            $kfkey=$postObj->SessionFrom;//小程序按钮关键词
            $keyword = trim($postObj->Content); //消息内容
            $time = time();
            
            
            
            
            $wxapp = pdo_fetch ("select * from " . tablename ("account_wxapp") . " where original='{$toUsername}' order by acid desc");
            $token=$this->getAccessToken($wxapp['uniacid']);
            if($kfkey=='在线客服'){//转发在线客服
            	//$this->getmsg($fromUsername,$token,"在线客服为您服务！",'	transfer_customer_service');
            	$result=$this->transmitService($postObj);
            	echo $result;
            	exit;
            }           
            
            
            $xcxsite=pdo_fetch ( 'select * from ' . tablename ("tiger_tkxcx_set") . " where weid='{$wxapp['uniacid']}' order by id desc " );
            $cfg=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$xcxsite['gzwid']}'");
            $weid=$xcxsite['gzwid'];//公众号ID
            $cfg=unserialize($cfg['settings']);   
//          file_put_contents("abc_log.txt","\n old:".$postStr."----".$toUsername."---uniacid:".$wxapp['uniacid'],FILE_APPEND);
//          file_put_contents("abc_log.txt","\n oldcfg:".json_encode($xcxsite),FILE_APPEND);
            file_put_contents("abc_log.txt","\n old:".$kfkey."----".$toUsername."----".$postStr,FILE_APPEND);
            
            if(empty($kfkey)){
            	$sendkey=pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_xcxsend") . " WHERE weid='{$weid}' and kfkey='{$keyword}'");
            }else{
            	$sendkey=pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_xcxsend") . " WHERE weid='{$weid}' and kfkey='{$kfkey}'");
            }
//          file_put_contents(IA_ROOT."/addons/tiger_tkxcx/mb_log.txt","\n".$keyword."-----".json_encode($sendkey),FILE_APPEND);
		    
		    if(!empty($sendkey['kfkey'])){
		    	if($sendkey['type']==1){//文本
		    	    //$viewurl='<a href=\"'.$sendkey['url'].'\">点击查看详情</a>';    
		    		//$sendcent=str_replace('#链接#',$viewurl, $sendkey['content']);
		    		$sendcent=htmlspecialchars_decode($sendkey['content']);
		    		$this->getmsg($fromUsername,$token,$sendcent);
		    	}elseif($sendkey['type']==2){
		    		$this->sendimg($fromUsername,$token,$sendkey);
		    	}
		    	exit;		    		
		    } 
            
                     
          
            
            if(!empty($postObj->MsgType) && $postObj->MsgType =='text'){//文本消息   msgType=event 点击按钮到客服的事件    text 文档
            	 
            	  
            	
            	   $tkl=$this->getyouhui2($keyword);  //暂时只支持口令查询
            	   file_put_contents("abc_log.txt","\n old:tkl".$tkl,FILE_APPEND);
		           if(!empty($tkl)){//口令查询
		           	  $klarr=$this->tkljx($keyword,$cfg);
		           	  $title=$klarr['content'];//口令解析出来的标题 有括号
		           	  $title=$this->tklresp($title);//格式化标题，去掉括号
		           	  $url=$klarr['url'];//天猫淘宝，二合一的链接都有可能
		           	  file_put_contents("jxtkl_log.txt","\n".$keyword."--".json_encode($cfg),FILE_APPEND);
		           	  $istao=$this->myisexists($url);
		           	 
		           	  if($istao==1){//e22a地址
		           	  	 $goodsid=$this->getgoodsid($url);
	                 	 if(empty($goodsid)){
	                 	 	$goodsid=$this->hqgoodsid($url);
	                 	 }
		           	  }elseif($istao==2){//淘宝天猫地址
		           	  	$goodsid=$this->mygetID($url); 		           	  	 
	                 	 if(empty($goodsid)){
	                 	 	$goodsid=$this->getgoodsid($url);
	                 	 } 
		           	  }
		           	  
		           	  
		           	  if(!empty($goodsid)){//如果商品ID存在
		           	     //include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
		           	  	 $tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$xcxsite['tbuid']}'"); 
		           	  	 $url="https://item.taobao.com/item.htm?id=".$goodsid;
		           	  	 //$res=xcxhqyongjin($url,'',$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$goodsid); 
		           	  	 $cfg['ptpid']=$this->getptpid($weid,$fromUsername,$cfg);
		           	  	 $pidSplit=explode('_',$cfg['ptpid']);
				         $cfg['siteid']=$pidSplit[2];
				         $cfg['adzoneid']=$pidSplit[3];
		           	  	 $res=$this->xcxtaokejh($goodsid,$tksign['sign'],$tksign['tbuid'], $cfg['adzoneid'],$cfg['siteid'],$_W['setting']['site']['url'],$tkip); 
		           	  	 if(empty($res['coupon_click_url'])){
		           	  	 	$this->getmsg($fromUsername,$token,"该产品暂无优惠！换一个产品试试");
		           	  	 	exit;
		           	  	 }

//		           	  	 $res=
//		           	  	 {
//							"category_id": "30",
//							"coupon_click_url": "https:\/\/uland.taobao.com\/coupon\/edetail?e=C0X5AnmvJpYGQASttHIRqUmf9rtvy3oDaAgJrkAQnJTOYE6ZUVle2SAJlpJvh4j8EmfKcQeS99F5yepcRw0uu0hMrwC97/SyqpYM1S9PYKNY4Y/gpq45GsvnU31E9XTLINsczlw+vUc=&traceId=0bfaef1a15182784795081251e",
//							"item_id": "559950058230",
//							"max_commission_rate": "5.00",//佣金
//							"money": null,//优惠券金额
//							"xemoney": null//满多少
//							}
						$getviews=$this->getitemid($goodsid,$cfg);
						if(empty($res['money'])){
			          		$money=0;
			          	}else{
			          		$money=$res['money'];
			          	}
			          	$views=array(
			          		'itemid'=>$goodsid,
			          		'itemtitle'=>$getviews['title'],
			          		'itempic'=>$getviews['pict_url'],
			          		'itemprice'=>$getviews['zk_final_price'],
			          		'itemendprice'=>$getviews['zk_final_price']-$res['money'],
			          		'couponmoney'=>$money,
			          		'itemdesc'=>$getviews['title'],
			          		'itemsale'=>rand(50,200),
			          		'videoid'=>'',
			          	);
			          	if(empty($res['money'])){
			          		$rhyurl=$res['coupon_click_url']."&activityId=tiger";
			          	}else{
			          		$rhyurl=$res['coupon_click_url'];
			          	}
			          	if(!empty($rhyurl)){
					      	$tjcontent=$views['itemtitle'];
					      	$rhyurl=str_replace("http:","https:",$rhyurl);
					        $taokouling=$this->tkl($rhyurl,$views['itempic'],$tjcontent,$cfg);
					        $views['taokouling']=$taokouling;
					    }
						
                        
                        $msg=str_replace('#换行#','', $xcxsite['flmsg']);
						$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
//						$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
						$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
						$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
						$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
						$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);


		           	  	file_put_contents("abc_log.txt","\n oldresaaaa:".json_encode($res),FILE_APPEND);
		           	  	
		           	  	$this->getmsg($fromUsername,$token,$msg);		           	  	
//		           	  	$viewurl="点击查看".'\n\r<a href=\"https://www.qq.com\" data-miniprogram-appid=\"'.$wxapp['key'].'\" data-miniprogram-path=\"tiger_tkxcx/pages/info/index?itemid='.$views['itemid'].'&lm=3&yj=\">点击查看详情</a>';    
//		           	  	file_put_contents("abc_log.txt","\n old:".$viewurl,FILE_APPEND);        
//                      $this->getmsg($fromUsername,$token,$viewurl);
		           	  }
		           	
		           	  
		           }
            }elseif($postObj->MsgType =='event' && $postObj->Event=='user_enter_tempsession'){//进入客服动作
//          	$this->getmsg($fromUsername,$token,"欢迎光临！需要什么帮助吗！");
//				$sendkey=pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_xcxsend") . " WHERE weid='{$weid}' and kfkey='{$kfkey}'");
//				$this->getmsg($fromUsername,$token,$sendkey);
//          	$this->sendimg($fromUsername,$token,$sendkey);
				 $arr=strstr($kfkey,"kftkl");
            	  if($arr!==false){
            	  	$str=str_replace("kftkl","",$kfkey);  
            	  	$str=htmlspecialchars_decode($str);
            	  	$this->getmsg($fromUsername,$token,$str);
            	  	exit;
            	  }
            }      
            
            /**查询口令**/
           
            
            
            
//          $msg="222";
//          $viewurl=$msg.'\n\r<a href=\"https://www.qq.com\" data-miniprogram-appid=\"wxaa330e77694eb623\" data-miniprogram-path=\"tiger_tkxcx/pages/info/index?itemid=564235579770&lm=2&yj=1.2\">点击跳小程序</a>';            
//          $this->getmsg($fromUsername,$token,$viewurl);
            
//          $textTpl = "<xml>
//                      <ToUserName><![CDATA[%s]]></ToUserName>
//                      <FromUserName><![CDATA[%s]]></FromUserName>
//                      <CreateTime>%s</CreateTime>
//                      <MsgType><![CDATA[%s]]></MsgType>
//                      <Content><![CDATA[%s]]></Content>
//                      <FuncFlag>0</FuncFlag>
//                      </xml>";
//          if($keyword == "?" || $keyword == "？")
//          {
//              $msgType = "text";
//              $contentStr = date("Y-m-d H:i:s",time());
//              $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//              echo $resultStr;
//          }
        }else{
            echo "";
            exit;
        }
    }
}
?>