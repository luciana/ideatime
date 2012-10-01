<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class twitter_oauth
{
    const SCHEME = 'https';
    const HOST = 'api.twitter.com';
    const AUTHORIZE_URI = '/oauth/authorize';
    const REQUEST_URI   = '/oauth/request_token';
    const ACCESS_URI    = '/oauth/access_token';
    const POST_STATUS_URI ='/1/statuses/update.json';
    
    //Array that should contain the consumer secret and
    //key which should be passed into the constructor.
    private $_consumer = false;
    
    /**
     * Pass in a parameters array which should look as follows:
     * array('key'=>'example.com', 'secret'=>'mysecret');
     * Note that the secret should either be a hash string for
     * HMAC signatures or a file path string for RSA signatures.
     *
     * @param array $params
     */
    public function twitter_oauth($params)
    {
        $this->CI = get_instance();
        $this->CI->load->helper('oauth');
        
        if(!array_key_exists('method', $params))$params['method'] = 'GET';
        if(!array_key_exists('algorithm', $params))$params['algorithm'] = OAUTH_ALGORITHMS::HMAC_SHA1;
        
        $this->_consumer = $params;
    }
    
    /** 
     * This is called to begin the oauth token exchange. This should only
     * need to be called once for a user, provided they allow oauth access.
     * It will return a URL that your site should redirect to, allowing the
     * user to login and accept your application.
     *
     * @param string $callback the page on your site you wish to return to
     *                         after the user grants your application access.
     * @return mixed either the URL to redirect to, or if they specified HMAC
     *         signing an array with the token_secret and the redirect url
     */
    public function get_request_token($callback)
    {
        $baseurl = self::SCHEME.'://'.self::HOST.self::REQUEST_URI;

        //Generate an array with the initial oauth values we need
        $auth = build_auth_array($baseurl, $this->_consumer['key'], $this->_consumer['secret'],
                                 array('oauth_callback'=>urlencode($callback)),
                                 $this->_consumer['method'], $this->_consumer['algorithm']);
        //Create the "Authorization" portion of the header
        $str = "";
        foreach($auth as $key => $value)
            $str .= ",{$key}=\"{$value}\"";
        $str = 'Authorization: OAuth '.substr($str, 1);
        //Send it
        $response = $this->_connect($baseurl, $str);
        //We should get back a request token and secret which
        //we will add to the redirect url.
        parse_str($response, $resarray);
        //Return the full redirect url and let the user decide what to do from there.
        $redirect = self::SCHEME.'://'.self::HOST.self::AUTHORIZE_URI."?oauth_token={$resarray['oauth_token']}";
        //If they are using HMAC then we need to return the token secret for them to store.
        if($this->_consumer['algorithm'] == OAUTH_ALGORITHMS::RSA_SHA1)return $redirect;
        else return array('token_secret'=>$resarray['oauth_token_secret'], 'redirect'=>$redirect);
    }

    /**
     * This is called to finish the oauth token exchange. This too should
     * only need to be called once for a user. The token returned should
     * be stored in your database for that particular user.
     *
     * @param string $token this is the oauth_token returned with your callback url
     * @param string $secret this is the token secret supplied from the request (Only required if using HMAC)
     * @param string $verifier this is the oauth_verifier returned with your callback url
     * @return array access token and token secret
     */
    public function get_access_token($token = false, $secret = false, $verifier = false)
    {
        //If no request token was specified then attempt to get one from the url
        if($token === false && isset($_GET['oauth_token']))$token = $_GET['oauth_token'];
        if($verifier === false && isset($_GET['oauth_verifier']))$verifier = $_GET['oauth_verifier'];
        //If all else fails attempt to get it from the request uri.
        if($token === false && $verifier === false)
        {
            $uri = $_SERVER['REQUEST_URI'];
            $uriparts = explode('?', $uri);

            $authfields = array();
            parse_str($uriparts[1], $authfields);
            $token = $authfields['oauth_token'];
            $verifier = $authfields['oauth_verifier'];
        }
        
        $tokenddata = array('oauth_token'=>urlencode($token), 'oauth_verifier'=>urlencode($verifier));
        if($secret !== false)$tokenddata['oauth_token_secret'] = urlencode($secret);
        
        $baseurl = self::SCHEME.'://'.self::HOST.self::ACCESS_URI;
        //Include the token and verifier into the header request.
        $auth = get_auth_header($baseurl, $this->_consumer['key'], $this->_consumer['secret'],
                                $tokenddata, $this->_consumer['method'], $this->_consumer['algorithm']);
        $response = $this->_connect($baseurl, $auth);
        //Parse the response into an array it should contain
        //both the access token and the secret key. (You only
        //need the secret key if you use HMAC-SHA1 signatures.)
        parse_str($response, $oauth);
        //Return the token and secret for storage
        return $oauth;
    }

    public function get_account_credentials($userId)
    { 
        $url = 'http://twitter.com/users/show/'.$userId.'.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($response);
        return $json;
    } 

    public function post_status(){
        //$baseurl = self::SCHEME.'://'.self::HOST.self::POST_STATUS_URI;
        $baseurl = 'https://api.twitter.com/1.1/statuses/update.json';

        $auth = get_auth_header($baseurl, $this->_consumer['key'], $this->_consumer['secret'],
                                array('oauth_token'=>urlencode($_SESSION['oauth_token'])), 'POST', $this->_consumer['algorithm']);

       //print_r($auth);

       /*Array ( [oauth_consumer_key] => 0sd51MbJuom5csE6xeYfw 
        [oauth_signature_method] => HMAC-SHA1 
        [oauth_timestamp] => 1349048908 
        [oauth_nonce] => d95ee5c11547e5656a043a8a0978848d 
        [oauth_version] => 1.0 
        [oauth_token] => 39792346-pa44yR1UXmyHURyfGm9t2prlWQR4zshHmjL95QzAL 
        [oauth_signature] => islIzFc72lsDbMaA0Rng7SKuv%2Fk%3D )

%26 => &
%3D => =
%3A => :
%2F => /
%25 => %
%3F => ?
        */

        $url ='POST%26';
        $url .='https%3A%2F%2Fapi.twitter.com%2F1.1%2Fstatuses%2Fupdate.json&';      
        $url .='oauth_consumer_key%3D'.$auth['oauth_consumer_key'].'%26';
        $url .='oauth_nonce%3D'.$auth['[oauth_nonce]'].'%26';
        $url .='oauth_signature_method%3D'.$auth['oauth_signature_method'].'%26';
        $url .='oauth_timestamp%3D'.$auth['oauth_timestamp'].'%26';
        $url .='oauth_token%3D'.$_SESSION['oauth_token'].'%26';
        $url .='oauth_version%3D'.$auth['oauth_version'].'%26';
        $url .='status=Maybe%20he%27ll%20finally%20find%20his%20keys.%20%23luciana123_2002';


        //Send it
        $response = $this->_connect($url, $auth, 'POST');
        return $response;
    }

   /**
     * Connects to the server and sends the request,
     * then returns the response from the server.
     * @param <type> $url
     * @param <type> $auth
     * @return <type>
     */
    private function _connect($url, $auth, $type='GET')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_SSLVERSION,3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth));
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Display communication with server

        if($type=='POST'){
            $data = array(
                'status' => 'posting from ideatime',
                'include_entities' => true
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
// ./system/application/libraries
?>