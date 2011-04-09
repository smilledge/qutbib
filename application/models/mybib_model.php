<?php if (! defined('BASEPATH')) exit('No direct script access');

class Mybib_model extends CI_Model {
	
	public function get($config) {
		// Extract config array
		extract($config);
		// Set default values
		if (!isset($offset)) { $offset = 0; }
		if (!isset($limit)) { $limit = 50; }
		if (!isset($order)) { $order = 'date'; }
		if (!isset($style)) { $style = 'apa'; }
		if (!isset($type)) { $type = 'all'; }
		if (!isset($key)) { $key = $_COOKIE['key'];; }
		
		// Query
		$this->db->select("id,$style,$style" . "_intext");
		$this->db->from('public_references');
		$this->db->where('key', $key);
		// Get certain type
		if ($type != 'all') {
			$this->db->where('type', $type);
		}
		// Order by date or alphabetical
		if ($order == 'date') {
			$this->db->order_by("timestamp", "desc"); 
		} else if ($order == 'alphabetical') {
			$this->db->order_by("apa", "asc"); 
		}
		// Limit/Offset
		if ($offset > 0) {
			$this->db->limit($limit, $offset);
		} else {
			$this->db->limit($limit);
		}
		// Run query
		$result = $this->db->get();
		return $result;
	}
	
	public function remove($id, $key) {
		$this->db->where('key', $key);
		$this->db->where('id', $id);
		$this->db->delete('public_references');
		return TRUE;
	}
	
}