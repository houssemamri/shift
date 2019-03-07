<?php
/*
 * Copyright 2011 EnfoqueSelectivo.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * 
 * Isidro Solis (isidro.solis@enfoqueselectivo.es) http://www.enfoqueselectivo.es
 *
 * The first PHP Library to support OAuth for 500px's REST API.
 * Adapted to use with 500px API
 * 
 * You can consult 500px API on http://developers.500px.com/
 * 
 */

/* Load OAuth lib. You can find it at http://oauth.net */
require_once(dirname(__FILE__).'/OAuth.php');

/**
 * 500px OAuth class
 */
class _500PXOAuth {
	/* Contains the last HTTP status code returned. */
	public $http_code;
	/* Contains the last API call. */
	public $url;
	/* Set up the API root URL. */
	public $host = "https://api.500px.com/v1/";
	/* Set timeout default. */
	public $timeout = 30;
	/* Set connect timeout. */
	public $connecttimeout = 30;
	/* Verify SSL Cert. */
	public $ssl_verifypeer = FALSE;
	/* Respons format. */
	public $format = 'json';
	/* Decode returned json data. */
	public $decode_json = TRUE;
	/* Contains the last HTTP headers returned. */
	public $http_info;
	/* Set the useragnet. */
	public $useragent = '500PXOAuth v2.0';
	/* Immediately retry the API call if the response was not successful. */
	//public $retry = TRUE;
	public $consumer_key;

	/**
	 * Set API URLS
	 */
	private function accessTokenURL()  { return 'https://api.500px.com/v1/oauth/access_token'; }
	private function authenticateURL() { return 'https://api.500px.com/v1/oauth/authorize'; }
	private function authorizeURL()    { return 'https://api.500px.com/v1/oauth/authorize'; }
	private function requestTokenURL() { return 'https://api.500px.com/v1/oauth/request_token'; }
	private function uploadURL() 	   { return 'https://api.500px.com/v1/upload'; }

	/**
	 * Debug helpers
	 */
	public function lastStatusCode() { return $this->http_status; }
	public function lastAPICall() { return $this->last_api_call; }

	/**
	 * construct 500pxOAuth object
	 */
	function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {
		$this->consumer_key = $consumer_key;
		$this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
		$this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
		if (!empty($oauth_token) && !empty($oauth_token_secret)) {
			$this->token = new OAuthToken($oauth_token, $oauth_token_secret);
		} else {
			$this->token = NULL;
		}
	}


	/**
	 * Get a request_token from 500px
	 *
	 * @param string $oauth_callback callback url to return when verification end
	 *
	 * @returns a key/value array containing request oauth_token and oauth_token_secret
	 */
	public function getRequestToken($oauth_callback = NULL) {
		$parameters = array();
		if (!empty($oauth_callback)) {
			$parameters['oauth_callback'] = $oauth_callback;
		}
		$request = $this->oAuthRequest($this->requestTokenURL(), 'GET', $parameters);
		$token = OAuthUtil::parse_parameters($request);
		$this->token = new OAuthToken($token['oauth_token'], $token['oauth_token_secret']);
		return $token;
	}

	/**
	 * Get the authorize URL
	 *
	 * @param string $token array token obtained on getRequestToken function
	 *
	 * @returns string url to authorize request
	 */
	public function getAuthorizeURL($token) { //, $sign_in_with_500px = TRUE) {
		if (is_array($token)) {
			$token = $token['oauth_token'];
		}
		//if (empty($sign_in_with_500px)) {
		return $this->authorizeURL() . "?oauth_token={$token}";
		//} else {
		//   return $this->authenticateURL() . "?oauth_token={$token}";
		//}
	}

	/**
	 * Exchange request token and secret for an access token and
	 * secret, to sign API calls.
	 *
	 * @param string $oauth_verifier verifier code obtained after call authorize url
	 *
	 * @returns array("oauth_token" => "the-access-token",
	 *                "oauth_token_secret" => "the-access-secret")
	 */
	public function getAccessToken($oauth_verifier = FALSE) {
		$parameters = array();
		if (!empty($oauth_verifier)) {
			$parameters['oauth_verifier'] = $oauth_verifier;
		}
		$request = $this->oAuthRequest($this->accessTokenURL(), 'GET', $parameters);
		$token = OAuthUtil::parse_parameters($request);
		$this->token = new OAuthToken($token['oauth_token'], $token['oauth_token_secret']);
		return $token;
	}

	/**
	 * One time exchange of username and password for access token and secret.
	 * 
	 * @param string $username 
	 * @param string $password
	 *
	 * @returns array("oauth_token" => "the-access-token",
	 *                "oauth_token_secret" => "the-access-secret")
	 */
	public function getXAuthToken($username, $password) {
		$parameters = array();
		$parameters['x_auth_username'] = $username;
		$parameters['x_auth_password'] = $password;
		$parameters['x_auth_mode'] = 'client_auth';
		$request = $this->oAuthRequest($this->accessTokenURL(), 'POST', $parameters);
		$token = OAuthUtil::parse_parameters($request);
		$this->token = new OAuthToken($token['oauth_token'], $token['oauth_token_secret']);
		return $token;
	}

	/**
	 * GET wrapper for oAuthRequest.
	 *
	 * @param string $url url to call. Ex: get('users');
	 * @param array $parameters Array of optional parameters
	 *
	 * @return array or string $response response result of api call
	 */
	public function get($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'GET', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response,true);
		}
		return $response;
	}

	/**
	 * POST wrapper for oAuthRequest.
	 *
	 * @param string $url url to call. Ex: get('users');
	 * @param array $parameters Array of optional parameters
	 *
	 * @return array or string $response response result of api call
	 */
	public function post($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'POST', $parameters);
		//print_r($response);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response,true);
		}
		return $response;
	}

	/**
	 * DELETE wrapper for oAuthReqeust.
	 * 
	 * @param string $url url to call. Ex: get('users');
	 * @param array $parameters Array of optional parameters
	 *
	 * @return array or string $response response result of api call
	 */
	public function delete($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'DELETE', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response,true);
		}
		return $response;
	}

	/**
	 * Format and sign an OAuth / API request
	 * 
	 * @param string $url url to call. Ex: get('users');
	 * @param string $method GET|POST|DELETE
	 * @param array $parameters Array of optional parameters
	 * 
	 * @return array or string $response response result of api call
	 */
	private function oAuthRequest($url, $method, $parameters) {
		if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
			$url = "{$this->host}{$url}";
		}
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);
		$request->sign_request($this->sha1_method, $this->consumer, $this->token);
		switch ($method) {
			case 'GET':
				return $this->http($request->to_url(), 'GET');
			default:
				return $this->http($request->get_normalized_http_url(), $method, $request->to_postdata());
		}
	}

	/**
	 * Make an HTTP request
	 *
	 * @param string $url url to call. Ex: get('users');
	 * @param string $method GET|POST|DELETE
	 * @param array $postfields Array of optional parameters
	 * 
	 * @return API results
	 */
	private function http($url, $method, $postfields = NULL) {
		$this->http_info = array();
		$ci = curl_init();
		/* Curl settings */
		curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
		curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);

		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}

		curl_setopt($ci, CURLOPT_URL, $url);
		$response = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;

		curl_close ($ci);
		return $response;
	}

	/**
	 * Get the header info to store.
	 */
	public function getHeader($ch, $header) {
		$i = strpos($header, ':');
		if (!empty($i)) {
			$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
			$value = trim(substr($header, $i + 2));
			$this->http_header[$key] = $value;
		}
		return strlen($header);
	}

	/**
	 * Get photoid and upload key to perform upload photo file
	 * 
	 * @param string $title Title of the photo
	 * @param string $desc Description for the photo
	 * @param string $catid A numerical ID for the category of the photo. See http://developers.500px.com/docs/formats#categories
	 * 
	 * @return array with photoid and uploadkey
	 */
	public function getUploadKeyAndId($title,$desc,$catid) {
		
		$_500px=$connection->post('photos',array('name'=>utf8_encode($title), 'description'=>$desc, 'category'=>$catid));
		$photo500pxid = $_500px['photo']['id'];
		$upload_key = $_500px['upload_key'];
		
		return array('photoid'=>$photo500pxid,'uploadkey'=>$upload_key);
		
	}
	
	/**
	 * Upload a photo to 500px
	 * 
	 * @param string $photo absolute path and name to photo file
	 * @param string $photoid id of the photo obtained from getUploadKeyAndId
	 * @param string $upload_key obtainend from getUploadKeyAndId
	 * 
	 * @return string result of upload
	 * 
	 */
	public function sync_upload ($photo, $photoid, $upload_key) {

		//Process arguments, including method and login data.
		$parameters = array("photo_id" => $photoid, "upload_key" => $upload_key);
		$url = $this->uploadURL();
		$method = 'POST';
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);
		$request->sign_request($this->sha1_method, $this->consumer, $this->token);
		$photo = realpath($photo);
		$request->set_parameter('file', new \CurlFile($photo), false);
		$request->set_parameter('consumer_key', $this->consumer->key, false);
		$request->set_parameter('access_key', $this->token->key, false);

		$this->response = $this->http($request->get_normalized_http_url(), $method, $request->get_parameters());
		$rsp = explode("\n", $this->response);
		foreach ($rsp as $line) {
			if (preg_match('|<err code="([0-9]+)" msg="(.*)"|', $line, $match)) {
				if ($this->die_on_error)
				die("The 500px API returned the following error: #{$match[1]} - {$match[2]}");
				else {
					$this->error_code = $match[1];
					$this->error_msg = $match[2];
					$this->parsed_response = false;
					return false;
				}
			} elseif (preg_match("|<photoid>(.*)</photoid>|", $line, $match)) {
				$this->error_code = false;
				$this->error_msg = false;
				return true;
			}
		}
	}
}