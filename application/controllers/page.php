<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate
 *
 * @desc Display and process reference renerator form
 *
 **/

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function bug() {
		
		if ($_POST) {
			$this->load->model('page_model');
			$this->page_model->insert_bug($_POST['description']);
			$data['submitted'] = TRUE;
		} else {
			
			$data['submitted'] = FALSE;
		}
		
		$data['html_title'] = "QUTBib - Report A Bug";
		$this->load->view('page_template.php', $data);
	}
}
/* End of file page.php */
/* Location: ./application/controllers/page.php */