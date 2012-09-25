<?php

Class Twitter extends CI_Controller
{
	
	const TWITTER_API ='https://api.twitter.com';
	const TWITTER_POST_STATUS ='/1/statuses/update.json';

	function __construct()
	{
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
		$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
		$this->load->library('twitter_oauth', $params);		
	}

	function request_token()
	{
	    $response = $this->twitter_oauth->get_request_token(site_url("twitter/access_token"));
	    $_SESSION['token_secret'] = $response['token_secret'];
	    redirect($response['redirect']);
	}

    function post_status(){
    	$url = self::TWITTER_API.self::TWITTER_POST_STATUS;
    	//$twitter_name, $groups
    	$content = $this->_post($url);
    	print_r($content);
    }

	function build_auth_header($oauth)
	{
	    $r = 'Authorization: OAuth '; 
	    $values = array(); 
	    foreach($oauth as $key=>$value)
	        $values[] = "$key=\"" . rawurlencode($value) . "\""; 
	    $r .= implode(', ', $values); 
	    return $r; 
	}

	private function _post($url)
	{
		
		$oauth = array( 'oauth_consumer_key' => '0sd51MbJuom5csE6xeYfw',
                'oauth_nonce' => time(),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_token' => '320236200-efD0A9naQ4vj3pGIrPRda0UOht2ed0RLpH87waAC',
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0');

		$header[]         = 'Content-Type: application/x-www-form-urlencoded';          
    	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);		
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HEADER,false);
 
		$data = array(
		    'status' => 'posting from ideatime'
		);
		
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode("oauth_consumer_key=0sd51MbJuom5csE6xeYfw&
           oauth_signature_method=HMAC-SHA1&
           oauth_token=320236200-efD0A9naQ4vj3pGIrPRda0UOht2ed0RLpH87waAC&
           oauth_timestamp=137131200&
           oauth_nonce=4572616e48616d6d65724c61686176&
           oauth_version=1.0&
           status=tweeting from ideatime"));
		$response = curl_exec($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);
		return $header;

    }

	function access_token()
	{
		//get access token
	    $response = $this->twitter_oauth->get_access_token(false,  $_SESSION['token_secret']);
	    $_SESSION['oauth_token'] = $response["oauth_token"];
	    /*Array ( [oauth_token] => 320236200-efD0A9naQ4vj3pGIrPRda0UOht2ed0RLpH87waAC [oauth_token_secret] => gSRRtMulGDH9iGxaZX8eHFwjmCjZHEpeQnDYFaQKc [user_id] => 320236200 [screen_name] => MyDomainList )*/

	    //make sure user is allowed to visit our sweet site
	    $user = $this->user_model->get_valid_user($response['screen_name']);
	    //see if they have already logged in before
	    $oauthUser = $this->oauth_model->get_user_twitter_info($response['screen_name']);
	    //if both are not empty, then they have been here before so update table
	    if (!empty($user) && !empty($oauthUser))
	    {
		    $twitterData = array(
		    		'oauth_provider' => 'twitter',
		    		'oauth_uid' => $response['user_id'],
		    		'oauth_token' => $response['oauth_token'],
		    		'oauth_secret' => $response['oauth_token_secret'],
		    		'username' => $response['screen_name']
		    		);
		    $this->oauth_model->update_user_twitter($twitterData, $user->id);
		    $group = $this->oauth_model->get_user_groups($user->id);
		    if(empty($group)) $group = array('0');
    	    $this->ideaslib->create_session($user->id, $response['screen_name'], $group);
    	    redirect('ideas/home');
		}
		//user is new addition so lets add them to the oauth table
		elseif (!empty($user)) {
			$twitterData = array(
		    		'oauth_provider' => 'twitter',
		    		'oauth_uid' => $response['user_id'],
		    		'oauth_token' => $response['oauth_token'],
		    		'oauth_secret' => $response['oauth_token_secret'],
		    		'username' => $response['screen_name'],
		    		'users_id' => $user->id
		    		);
		    $this->oauth_model->insert_user_twitter($twitterData);
		    $group = $this->oauth_model->get_user_groups($user->id);
		    if(empty($group)) $group = array('0');
		    $this->ideaslib->create_session($user->id, $response['screen_name'], $group);
		    redirect('ideas/home');
		}
		//user is brand new - create an user entry and an oauth entry
		else{
			$userData = array(
		    		'username' => $response['screen_name']
		    		);
			$this->oauth_model->insert_user($userData);
			$user = $this->user_model->get_valid_user($response['screen_name']);			
			$twitterData = array(
		    		'oauth_provider' => 'twitter',
		    		'oauth_uid' => $response['user_id'],
		    		'oauth_token' => $response['oauth_token'],
		    		'oauth_secret' => $response['oauth_token_secret'],
		    		'username' => $response['screen_name'],
		    		'users_id' => $user->id
		    		);
		    $this->oauth_model->insert_user_twitter($twitterData);
		    $group = array('0');
		    $this->ideaslib->create_session($user->id, $response['screen_name'], $group);
			redirect('groups/home');
		}
	    
	}
}