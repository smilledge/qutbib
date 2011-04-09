<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mybib
 *
 * @desc Display a list of the users references
 *
 **/

class Mybib extends CI_Controller {
	
	public function index() {
		$this->view();
	}
	
	public function view() {
		
		if (isset($_POST['order-by'])) { 
			$config['order'] = $_POST['order-by']; 
			$data['order'] = $_POST['order-by'];
		} else {
			$data['order'] = 'date';
		}
		if (isset($_POST['style'])) { 
			$config['style'] = $_POST['style']; 
			$data['style'] = $_POST['style'];
		} else {
			$data['style'] = 'apa';
		}
		if (isset($_POST['type'])) {
			$config['type'] = $_POST['type']; 
			$data['type'] = $_POST['type']; 
		} else {
			$data['type'] = 'all';
		}
		
		// Load model
		$this->load->model('mybib_model');
		$this->load->model('user_model');
		
		$public_key = $this->uri->segment(3);
		if (!empty($public_key)) {
			$config['key'] = $this->uri->segment(3);
			$data['key'] = $this->uri->segment(3);
		} else {
			// Check if the user's key is set
			if (!$this->user_model->is_key_set()) {
				$key_temp = $this->user_model->set_public_user_key();
				$config['key'] = $key_temp;
				$data['key'] = $key_temp;
			} else {
				$config['key'] = $_COOKIE['key'];
				$data['key'] = $_COOKIE['key'];
			}
		}

		$data['data'] = $this->mybib_model->get($config);
		$data['html_title'] = "QUTBib";
		
		$this->load->view('mybib_template.php', $data);
		
	}
	
	public function remove() {
		$id = $this->uri->segment(3);
		$key = $_COOKIE['key'];
		if (empty($id) && $this->user_model->is_key_set() === TRUE) {
			return FALSE;
		}
		
		$this->load->model('mybib_model');
		$result = $this->mybib_model->remove($id,$key);
		
		if ($result == FALSE) {
			return FALSE;
		}
		return TRUE;	
	}
	
	public function remove_bibliography() {
		$this->load->model('user_model');
		$this->user_model->remove_public_user_key();
		redirect('/mybib');
	}
	
}