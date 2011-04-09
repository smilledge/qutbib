<?php if (! defined('BASEPATH')) exit('No direct script access');

class Page_model extends CI_Model {
	
	public function insert_bug($description) {
		$data = array(
				'description' => $description
			);
		$this->db->insert('bugs', $data); 
	}

}