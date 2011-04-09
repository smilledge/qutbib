<?php if (! defined('BASEPATH')) exit('No direct script access');

class User_model extends CI_Model {
	
	public function is_key_set() {
		if (isset($_COOKIE['key'])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function set_public_user_key() {
		// Set a cookie key for a public user
		// Random string 
		$length = 5;
		$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$strlen = strlen($characters) - 1;
		$string = '';    
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, $strlen)];
		}
		// If not already set
		$key = time() . $string;
		//time()+60*60*24*7
		setcookie('key', $key, mktime (0, 0, 0, 12, 31, 2015), '/');
		return $key;
	}
	
	public function remove_public_user_key() {
		setcookie('key', "", time()-3600, '/');
	}
	
}