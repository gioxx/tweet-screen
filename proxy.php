<?php
	
	/*
	 get tmh oauth tiwtter utils
	*/
	require('asset/twitterapi/tmhOAuth');
	require('asset/twitterapi/tmhUtilities');
	
	/**
	 * Tweet Screen
	 * 
	 * Displays tweets, and promo snippets, for use on a large display 
	 * at conferences.
	 * 
	 * @author William Duyck <wduyck@gmail.com>
	 * @version 2012.08.17
	 */
	class TweetScreen {
		
		private $_OAuth;
		private $_params = array(array());
		
		/**
		 * sets up the oauth session
		 *
		 * @param	string	hashtag	the hashtag to track
		 */
		public function __construct($hastag) {
			$this->_OAuth = new tmhOAuth(array(
				'consumer_key' => 'YOUR_CONSUMER_KEY',
				'consumer_secret' => 'YOUR_CONSUMER_SECRET',
				'user_token' => 'A_USER_TOKEN',
				'user_secret' => 'A_USER_SECRET'
			));
			
			$this->_params = array(
				'q' => $hastag,
				'result_type' => 'recent',
				'include_entities' => 'true'
			);
		}
		
		public function set_param($key, $value) {
			$this->_params[$key] = $value;
		}
		
		public function request() {
			return $this->_OAuth->request('GET', 'http://search.twitter.com/search.json', $args, FALSE);
		}
		
		/**
		 * Generates a qrcode using the google charts api
		 *
		 * Generates a qrcode to tweet a specified message out.
		 *
		 * @param	string	msg	the message to encode
		 */
		public function generate_qr($msg) {
			
		}
		
	}

	/**
	 * Generic cache class
	 * 
	 * Manages a file based cache
	 *
	 * @author William Duyck <wduyck@gmail.com>
	 * @version 2012.08.16
	 */
	class Cache {
		
		// default values
		private	$_dir		= 'cache/';
		private	$_expire	= 172800; // 2 days
		
		/**
		 * sets the cache dir
		 *
		 * @param string	dir	location of the cache dir w/ trailing slash
		 */
		public function set_dir($dir) {
			$this->_dir = $dir;
		}
		
		/**
		 * sets the expire duration of cache files
		 *
		 * @param	int	expire	how long to keep cache for
		 */
		public function set_expire($expire) {
			$this->_expire = $expire;
		}

		/**
		 * saves string to cache
		 *
		 * @param	string	str		what to store
		 * @param	string	name 	name of cache file to store in
		 * @return	boolean	TRUE on success
		 */
		public function save($str, $name){
			// write the cache file
			return (file_put_contents($this->_dir . $name, $str) !== FALSE);
		}
		
		/**
		 * gets string from cache
		 *
		 * @param	string	name	name of cache file
		 * @return	mixed	FALSE on fail, string of cache content on success
		 */
		public function get($name){
			// check cache exists and is not expired
			if($this->exists($this->_dir . $name))
			{
				return file_get_contents($this->_dir . $name);
			}
			
			return FALSE;
		}
		
		/**
		 * checks if a cache exists and hasn't expired
		 *
		 * @param	string	name	name of cache file
		 * @return	boolean	TRUE if cache exists
		 */
		public function exists($name){
			// check if cache exists
			if(file_exists($this->_dir . $name))
			{
				// check not expired
				if(filemtime($this->_dir . $name) < time() - $this->_expire)
				{
					//  expired, delete file
					unlink($this->_dir . $name);
					return FALSE;
				}
				
				return TRUE;
			}
		}

	}

	// process tweets to sperate those w/ images and those w/o

	// send request to twitter api

	// generate snippets for tweets
	
	// generate snippets for tweet outs

	// generate qrcode for tweet out
	
	// expected urls
	/*
	 ?hashtag=%23mozcamp
	 ?hashtag=%23mozcamp&since_id=12243
	*/

// EOF