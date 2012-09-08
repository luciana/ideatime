<?php

Class Twitter extends CI_Controller
{
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

    
	function access_token()
	{
		//get access token
	    $response = $this->twitter_oauth->get_access_token(false,  $_SESSION['token_secret']);
	    //make sure user is allowed to visit our sweet site
	    $user = $this->user_model->get_valid_user($response['screen_name']);
	    //see if they have already logged in before
	    $oauthUser = $this->oauth_model->get_UserTwitterInfo($response['screen_name']);
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
		    $this->oauth_model->update_UserTwitter($twitterData, $user->id);
    	    $this->ideaslib->create_session($user->id, $response['screen_name'], '1');
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
		    $this->oauth_model->insert_UserTwitter($twitterData);
		    $this->ideaslib->create_session($user->id, $response['screen_name'], '1');
		}
	    redirect('ideas/home');
	}
}