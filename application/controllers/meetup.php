<?php

Class Meetup extends CI_Controller
{
	
	const MEETUP_API ='https://api.meetup.com';
	const MEETUP_GET_EVENTS ='/2/events';
    const MEETUP_GET_EVENT ='/2/event/id';
	function __construct()
	{	
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
		$params = array('key'=>'4rbpahpr739k8hodvp2h4am1st', 'secret'=>'tk1f39tmvv45o4820hn6o12tk1');
		$this->load->library('meetup_oauth', $params);		

	}

	private $_key = '6613812237a5b3f161e745b1d191362';


/**
     * Performs the GET query against the specified endpoint
     *
     * @param String $url - Endpoint with URL paramters (for now)
     * @return MeetupApiResponse
     */
    public function get( $url ) {       
                
        $content = $this->_connect($url);

        $header['content'] = $content;
        $status_code = $header['http_code'];
        $response = json_decode($content);
            

        if ( $status_code == "200" ) {
            return $response;
        } else {
            switch( $status_code ) {
                case "400":
                    throw new Exception('Bad Request');
                case "401":
                    throw new Exception('Unauthorized Exception');    
                case "500":
                    throw new Exception('Internal Server Error'); 
                default:
                    return FALSE;
            }        
            return FALSE;
        }*/
        return FALSE;
    }
	/**
     *
     * @param <type> $endpoint
     * @param <type> $parameters
     * @param <type> $requiredParameters - Optional - Some endpoints do not have parameters
     * @return <type>
     */
    public function buildUrl( $endpoint, $parameters, $requiredParameters = null ) {
        if(is_array($requiredParameters) && !$this->verifyParameters( $requiredParameters, $parameters )) {
           throw new Exception();
        }
        $parameters = $this->modify_params($parameters);
        $params = '';
        foreach($parameters AS $k => $v) {
            $params .= "$k=$v&";
        }
        rtrim($params,'&');

        return self::MEETUP_API . $endpoint . "?" . $params;
    }


    /**
     * Checks the input parameters against a list of required parameters to
     * ensure at least one of the required parameters exists.
     *
     * NOTE: The Meetup API contains a list of parameters that are required for
     * each endpoint with a default condition of "any of"
     * 
     * @param Array $RequiredList - Names of required parameters
     * @param Array $Parameters - List of provided paramters
     * @return Boolean
     */
    public function verifyParameters($requiredList, $parameters) {
        $parameters = array_keys($parameters);

        /*
         * Check to see if any of the required list is in the parameters array
         * Since the Meetup API requires "any of" if a required key is found in
         * parameters the verification will pass
         */
        foreach($requiredList AS $r) {
            if(in_array($r, $parameters)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Adds additional query parameters for key authentication
     * 
     * @param Array $params - request parameters
     * @return Array modified request parameters
     */
    public function modify_params($params) {
        $params['key'] = $this->_key;
        $params['sign'] = 'true';
       
        return $params;
    }

	public function request_token()
    {           
        $response = $this->meetup_oauth->get_request_auth(site_url("meetup/access_token"));
        $_SESSION['token_secret'] = $response['token_secret'];
        redirect($response['redirect']);
    }    

    public function access_token(){

        //get access token
        $response = $this->meetup_oauth->get_access_token(false,  $_SESSION['token_secret']);
        $_SESSION['meetup_member_id'] = $response['member_id'];
        redirect('ideas/home');        
    }

	/**
     * Return all events that fit the given parameters
     *
     * Required Parameters:
     * event_id | group_id | group_urlname | member_id | venue_id
     *
     * @link http://www.meetup.com/meetup_api/docs/2/events
     * @param Array $parameters
     * @return Array
     */
    public function meetup_get_events(){
    	//$parameters =  array( 'member_id' => $_SESSION['meetup_member_id']);
        
        $parameters =  array( 'member_id' => 11380807);
    	$required_params = array( 'event_id', 'group_id', 'group_urlname', 'member_id', 'venue_id' );
        $url = $this->buildUrl( self::MEETUP_GET_EVENTS, $parameters, $required_params );
        $response =  $this->get( $url );
        return $response['results'];
    }    

    public function meetup_get_event(){

        
        $parameters =  array( 'id' => 79792362);
        $required_params = array( 'id' );
        $url = $this->buildUrl( self::MEETUP_GET_EVENT, $parameters, $required_params );
        $response =  $this->get( $url );
        return $response['results'];
    }

    /**
     * Connects to the server and sends the request,
     * then returns the response from the server.
     * @param <type> $url
     * @param <type> $auth
     * @return <type>
     */
    private function _connect($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,    // don't return headers
         //   CURLOPT_USERAGENT      => "Idea_Time_Happy_Hour", // who am i
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_HEADER => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        );
     
        $ch = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $response = curl_exec( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        return $response;
    }
}

?>