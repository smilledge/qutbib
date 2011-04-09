<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate
 *
 * @desc Display and process reference renerator form
 *
 **/

class Generate extends CI_Controller {
	
	// Store public user key
	private $key;

	public function __construct() {
		parent::__construct();
		// Load models
		$this->load->model('generate_model');
		$this->load->model('user_model');	
		// Check key is set
		if (!$this->user_model->is_key_set()) {
			$this->key = $this->user_model->set_public_user_key();
		} else {
			$this->key = $_COOKIE['key'];
		}
	}

	public function index() {
		$this->book();
	}
	
	public function book() {
		
		if ($this->input->post()) { 
			$data = $this->input->post();
			$this->generate_model->initialise($data);
			$ref = $this->generate_model->make('book');
			
			// Insert row
			$ref['type'] = 'book';
			$ref['key'] = $this->key;
			$this->generate_model->insert_public_ref($ref);
			
			$data['apa'] = $ref['apa'];
			$data['apa_intext'] = $ref['apa_intext'];
			$data['harvard'] = $ref['harvard'];		
			$data['harvard_intext'] = $ref['harvard_intext'];
			
		}
		
		
		$data['html_title'] = "QUTBib";
		$data['type'] = 'book';
		
		$this->load->view('generate_template.php', $data);
	}
	
	public function webpage() {
		
		if ($this->input->post()) { 
			$data = $this->input->post();
			$this->generate_model->initialise($data);
			$ref = $this->generate_model->make('webpage');
			
			// Insert row
			$ref['type'] = 'webpage';
			$ref['key'] = $this->key;
			$this->generate_model->insert_public_ref($ref);
			
			$data['apa'] = $ref['apa'];
			$data['harvard'] = $ref['harvard'];
		}
		
		$data['html_title'] = "QUTBib";
		$data['type'] = 'webpage';
		
		$this->load->view('generate_template.php', $data);
	}
	
	public function journal() {
		
		if ($this->input->post()) { 
			$data = $this->input->post();
			$this->generate_model->initialise($data);
			$ref = $this->generate_model->make('journal');
			
			// Insert row
			$ref['type'] = 'journal';
			$ref['key'] = $this->key;
			$this->generate_model->insert_public_ref($ref);
			
			$data['apa'] = $ref['apa'];
			$data['harvard'] = $ref['harvard'];
		}
		
		$data['html_title'] = "QUTBib";
		$data['type'] = 'journal';
		
		$this->load->view('generate_template.php', $data);
	}
	
	public function newspaper() {
		
		if ($this->input->post()) { 
			$data = $this->input->post();
			$this->generate_model->initialise($data);
			$ref = $this->generate_model->make('newspaper');
			
			// Insert row
			$ref['type'] = 'newspaper';
			$ref['key'] = $this->key;
			$this->generate_model->insert_public_ref($ref);
			
			$data['apa'] = $ref['apa'];
			$data['harvard'] = $ref['harvard'];
		}
		
		$data['html_title'] = "QUTBib";
		$data['type'] = 'newspaper';
		
		$this->load->view('generate_template.php', $data);
	}
	
	public function more() {
		$this->book();
	}
	
	private function _input_to_array($data) {
		
		$contributors = array();
		$return = array();
		
		foreach ($data as $key => $value) {
			
			// If field is empty set value to null
			if ($value == '') { $value = null; } else { }
			
			if (is_array($value) == true) {
				
				if ($key == 'authorFirstName') {
					$i = 0;
					foreach ($value as $firstName) {
						$authors[$i] = array($firstName);
						$i++;
					}
				} elseif ($key == 'authorMiddleName') {
					$i = 0;
					foreach ($value as $middleName) {
						$authors[$i][1] = $middleName;
						$i++;
					}				
				} elseif ($key == 'authorLastName') {
					$i = 0;
					foreach ($value as $lastName) {
						$authors[$i][2] = $lastName;
						$i++;
					}	
				}
				
			} 
			
			
			// Put data into output array ($return)
			$return[$key] = $value;
			
		}
	}
}

/* End of file generate.php */
/* Location: ./application/controllers/generate.php */