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

    function post_user_status(){    	
    	$content = $this->twitter_oauth->post_status();    	
    	var_dump($content);
    }

    function credentials(){
    	$content = $this->twitter_oauth->get_account_credentials($_SESSION['username']);
    	print_r($content);
    }

	function access_token()
	{
		//get access token
	    $response = $this->twitter_oauth->get_access_token(false,  $_SESSION['token_secret']);
	   	$_SESSION['oauth_token'] = $response['oauth_token'];	    
	   	//Check if user already exists
	   	$user = $this->user_model->get_valid_user($response['screen_name']);

	   	//User is new...
	   	if (empty($user)){
		    //Insert info into User table
			$userData = array(
			    		'username' => $response['screen_name']
			    		);
			$userId = $this->oauth_model->insert_user($userData);

			//Insert info into Twitter table
			$twitterData = array(
			    		'oauth_provider' => 'twitter',
			    		'oauth_uid' => $response['user_id'],
			    		'oauth_token' => $response['oauth_token'],
			    		'oauth_secret' => $response['oauth_token_secret'],
			    		'username' => $response['screen_name'],
			    		'users_id' => $userId
			    		);
			$this->oauth_model->insert_user_twitter($twitterData);

			$user = $this->user_model->get_valid_user($response['screen_name']);

		}
		
		//Is user assigned to any groups?
		$groups = $this->oauth_model->get_user_groups($user->id);
				
    	//User is not associated with any groups - redirect to group home
		if(empty($groups)) {			
			//Save Session Data
    		$this->ideaslib->create_session($user->id, $response['screen_name'], array('0'),0);
    	}else{
    		//Save Session Data
    		$this->ideaslib->create_session($user->id, $response['screen_name'], $groups,0);
    	}

    	redirect('ideas/home');	    
	    
	}
}