<?php
/**
 *
 * @author ling
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class junsion_winawardModuleProcessor extends WeModuleProcessor
{
    public function respond(){
        global $_W;
        if ($this->message['msgtype'] == 'event') {
        	//if ($this->message['event'] == 'subscribe') {
        		$content = $this->message['content'];
        		$content = explode(':', $content);
        		if(!empty($content[3])) return ;
        		$wid = str_replace('junsion_winaward', '', $content[0]);//获取小程序id
        		$openid = $this->message['from'];
        		load()->model('mc');
        		$ACCESS_TOKEN = $this->getAccessToken();
        		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$openid}&lang=zh_CN";
        		load()->func('communication');
        		$json = ihttp_get($url);
        		$userInfo = @json_decode($json['content'], true);
        		$unionid = $userInfo['unionid'];
        		if (empty($unionid)) return '';
        		//获取参数设置
        		$cfg = pdo_fetch('select settings from '.tablename('uni_account_modules')." where uniacid='{$wid}' and module='junsion_winaward'");
        		if (empty($cfg['settings'])) return ;
        		$cfg = unserialize($cfg['settings']);
        		if(!empty($cfg['wxapp_title'])){
        			$min_info = pdo_fetch('select `uniacid`,`key`,`name` from ' .tablename('account_wxapp'). " where uniacid='{$wid}'");
        			if (!empty($_W['setting']['remote']['type'])) {
        				//开启了远程附件
        				$img = IA_ROOT."/addons/junsion_winaward/qrcode/temp{$content[1]}.jpg";
        				if(!file_exists($img)){
        					$img = $this->saveImage(toimage($cfg['wxapp_pic']),$content[1]);
        				}
        			}
        			else{
        				$img = IA_ROOT.'/attachment/'.$cfg['wxapp_pic'];
        			}
        			$thumb_media_id = $this->uploadImage($img);
        			$min_data = array(
        					'touser' => $userInfo['openid'],
        					'msgtype' => 'miniprogrampage',
        					'miniprogrampage' => array(
        							'title' => $cfg['wxapp_title'],
        							'appid' => $min_info['key'],
        							'pagepath' => 'pages/index/index?shareid='.$content[1],
        							'thumb_media_id' => $thumb_media_id
        					),
        			);
        			$access_token = $this->getAccessToken();
        			$res = $this->sendRes($access_token, json_encode($min_data,JSON_UNESCAPED_UNICODE));
        		}
        	//}
        }
    }
    
    private function sendRes($access_token, $data) {
    	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
    	load()->func('communication');
    	$ret = ihttp_request($url, $data);
    	$content = @json_decode($ret['content'], true);
    	$this->writelog('send:'.$data." ; result:".$ret['content']);
    	return $content['errcode'];
    }
    
    private function getAccessToken() {
    	global $_W;
    	load()->model('account');
    	$acid = $_W['acid'];
    	if (empty($acid)) {
    		$acid = $_W['uniacid'];
    	}
    	$account = WeAccount::create($acid);
    	$token = $account->fetch_available_token();
    	return $token;
    }
    
    private function uploadImage($img)
    {
    	load()->func('communication');
    	$access_token = $this->getAccessToken();
    	$url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $access_token . '&type=image';
    	$ch1 = curl_init();
    	$data = array('media' => '@' . $img);
    	if (version_compare(PHP_VERSION, '5.5.0', '>')) {
    		$data = array('media' => curl_file_create($img));
    	}
    	curl_setopt($ch1, CURLOPT_URL, $url);
    	curl_setopt($ch1, CURLOPT_POST, 1);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
    	$content = @json_decode(curl_exec($ch1), true);
    	if (!(is_array($content))) {
    		$content = array('media_id' => '');
    	}
    	curl_close($ch1);
    	return $content['media_id'];
    }
    
}
