<?php

class VanillaUser extends Front_Controller {

	public function index(){

		// config file has the secret and clientID
		$this->config->load('vanillaUser/config');

		// functions to sign and create the JSONP data
		$this->load->helper('vanilla/functions.jsconnect');

		$this->load->library('session');

		$secret = $this->config->item('secret');
		$clientID = $this->config->item('clientID');
		$this->load->model('users/User_model','user_model');

		$loggedIn = $this->auth->is_logged_in();

		$user = array();

		if($loggedIn) {
			$detail = $this->user_model->find_by('id',$this->auth->user_id());
			$user['uniqueid'] = $detail->id;
			$user['name'] = $detail->username;
			$user['email'] = $detail->email;
			$user['photourl'] = '';
		}

		$secure = true;
		WriteJsConnect($user, $_GET, $clientID, $secret, $secure);
	}
}
