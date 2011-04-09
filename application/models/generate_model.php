<?php if (! defined('BASEPATH')) exit('No direct script access');

class Generate_model extends CI_Model {
	
	// Reference data (assoc array)
	private $data;

	//php 5 constructor
	function __construct() {
		 parent::__construct();
	}
	
	public function initialise($data) {
		$this->data = $this->_format_array($data);
		return;
	}
	
	public function make($type) {
		if (isset($this->data)) {			
			$apa = $this->_apa($type);
			$apa_intext = $this->_apa_intext($type);
			$harvard = $this->_harvard($type);
			$harvard_intext = $this->_harvard_intext($type);
			return array(
				'apa' => $apa,
				'apa_intext' => $apa_intext,
				'harvard' => $harvard,
				'harvard_intext' => $harvard_intext
			);
		} else {
			return FALSE;
		}
	}
	
	public function insert_public_ref($ref) {
		$data = array(
				'apa' => $ref['apa'],
				'harvard' => $ref['harvard'],
				'type' => $ref['type'],
				'key' => $ref['key'],
				'apa_intext' => $ref['apa_intext'],
				'harvard_intext' => $ref['harvard_intext'],
			);

		$this->db->insert('public_references', $data); 
	}
	
	private function _apa($ref_type) {
			
		extract($this->data);
		
		// Make APA
		// Prevent title from being added twice when there are no authors
		$title_set = FALSE;
		extract($this->_apa_contributors($contributors));
		$apa_ref = '';
		// Authors or title
		if (!empty($authors)) {
			$apa_ref .= $authors . ' ';
		} else if (!empty($corporate_author)) {
			$apa_ref .= $corporate_author . '. ';
		} else {
			// Use title in pace of author
			if ($ref_type != 'book') {
				$apa_ref .= $title . ' ';
			} else {
				$apa_ref .= '<i>' . $title . '</i> ';
			}
			$title_set = TRUE;
		}
		// Year published
		if (!empty($date_published['year'])) {
			$apa_ref .= '(' . $date_published['year'];
			if ($ref_type == 'newspaper' && !empty($date_published['month'])) {
				$apa_ref .= ', ' . $date_published['month'];
				if (!empty($date_published['day'])) { $apa_ref .= ' ' . $date_published['day']; }
			} 
			$apa_ref .= '). ';
		} else {
			$apa_ref .= '(n.d.). ';
		}
		// Title
		if (!empty($title) & $title_set == FALSE) {
			if ($ref_type != 'book') {
				$apa_ref .= $title;
			} else {
				$apa_ref .= '<i>' . $title . '</i>';
			}
			// Resource type
			if (!empty($resource_type)) { $apa_ref .= ' [' . $resource_type . ']'; }
			if ($ref_type == 'book') {
				// Edition
				if (!empty($edition)) { $apa_ref .= ' (' . $this->_order_suffix($edition) . ' ed.)'; }
			}
			// Editors
			if (!empty($editors)) { $apa_ref .= ' (' . $editors . ')'; }
			if ($ref_type == 'book') {
				// Pages
				if (!empty($pages['from'])) { 
					$apa_ref .= ' (pp. ' . $pages['from']; 
					if (!empty($pages['to'])) { $apa_ref .= '-' . $pages['to'] . ')'; } else { $apa_ref .= ')'; }
				}
			}
			$apa_ref .= '. ';
		}
		// Publication Name, Volume, Issue, and pages(For journals)
		if ($ref_type == 'journal' || $ref_type == 'newspaper') {
			if (!empty($publication_title)) { $apa_ref .= '<i>' . $publication_title . '</i>'; }
			if ($ref_type == 'journal' && !empty($volume)) {
				$apa_ref .= ', <i>' . $volume . '</i>';
				if (!empty($issue)) { $apa_ref .= '(' . $issue . ')'; }
			}
			if ($ref_type == 'journal' || $ref_type == 'newspaper') {
				if (!empty($pages['from'])) {
					if ($ref_type == 'newspaper') { $apa_ref .= ', p. ' . $pages['from']; } 
					else { $apa_ref .= ', ' . $pages['from']; }
					if (!empty($pages['to'])) { $apa_ref .=  '-' . $pages['to']; }
				}	
			}
			$apa_ref .= '.';
		}
		if ($ref_type == 'book') {
			// Location
			 if (!empty($location)) {
				$apa_ref .= $location . ': ';
			 } else {
				$apa_ref .= 'n.p.: ';
			 }
			 // Publisher
			 if (!empty($publisher)) {
				$apa_ref = $apa_ref . $publisher . '.';
			 } else {
				$apa_ref .= 'Unknown.';
			 }	
		}
		
		if ($ref_type == 'webpage') {
			// URL and retrevial date
			if (!empty($url)) {
				$apa_ref .= 'Retrieved ';
				if (!empty($date_retrieved['year'])) { 
					if (!empty($date_retrieved['month']) && !empty($date_retrieved['day'])) { 
						$apa_ref .= $date_retrieved['month'] . ' ' . $date_retrieved['day'] . ', '; 
					}
					$apa_ref .= $date_retrieved['year'] . ' ';
				 }
				 $apa_ref .= 'From ' . $url;
			}
		}
		 
		 return $apa_ref;
		 
	}
	
	private function _apa_intext($ref_type) {
		extract($this->data);
		// Make APA In Text Reference
		// String to return
		$return = '(';
		// Array to hold author last names
		$authors = array();
		// Extract Last Names from array of contributors
		foreach ($contributors as $key => $value) {
			if ($value['contributor_type'] == 'author') {
				if (!empty($value['last_name'])) {
					array_push($authors, $value['last_name']);
				}		
			}
		}
		// Count how many authors
		$author_count = count($authors);
		// Authors or title
		if (!empty($authors)) {
			// 1 author
			if ($author_count == 1) {
				$return .= $authors[0];
			} else if ($author_count == 2) {
				// 2 authors
				$return .= $authors[0] . ' & ' . $authors[1];
			} else {
				// More than 2 authors
				$return .= $authors[0] . ' et al.';
			}
		} else if (!empty($corporate_author)) {
			// If no author and corp. author if exists
			$return .= $corporate_author;
		} else {
			// Use title in pace of author if no authors
			if ($ref_type != 'book') { 
				$return .= $title . ' ';
			} else {
				$return .= '<i>' . $title . '</i> ';
			}
		}
		// Add the year
		if (!empty($date_published['year'])) {
			$return .= ', ' . $date_published['year'];
		} else {
			$return .= ', n.d.';
		}
		// Pages
		if (!empty($pages['from'])) { 
			$return .= ', pp. ' . $pages['from']; 
			if (!empty($pages['to'])) { $return .= '-' . $pages['to']; }
		}
		$return .= ')';
		return $return;
	}
	
	private function _harvard($ref_type) {
		
		extract($this->data);
		if (!isset($resource_type)) {
			$resource_type = null;
		}
		// Make harvard		
		// Prevent title from being added twice when there are no authors
		$title_set = FALSE;
		extract($this->_harvard_contributors($contributors));
		$harvard_ref = '';
		// Authors or title
		if (!empty($authors)) {
			$harvard_ref .= $authors . '. ';
		} else if (!empty($corporate_author)) {
			$harvard_ref .= $corporate_author . '. ';
		} else {
			if ($ref_type != 'book') {
				$harvard_ref .= '"' . $title . '." ';
				$title_set = TRUE;
			} else {
				$harvard_ref .= '<i>' . $title . '</i>. ';
				$title_set = TRUE;
			}
		}
		// If forum post
		if (isset($resource_type) && $resource_type == 'Forum') {
			if (!empty($publication_title)) { $harvard_ref = $publication_title . '. '; }
			$title_set = FALSE;
		}
		// Year published
		if (!empty($date_published['year'])) {
			$harvard_ref .= $date_published['year'] . '. ';
		} else {
			$harvard_ref .= 'n.d. ';
		}
		// Title
		if (!empty($title) & $title_set == FALSE) {
			if ($ref_type != 'book') {
				$harvard_ref .= '"' . $title . '." ';
				// Publication title and date if a blog/journal
				if (!empty($publication_title)) { $harvard_ref .= '<i>' . $publication_title . '</i>' ; }
				// Date published for a blog
				if ($resource_type == 'Blog') {
					if (!empty($date_published['year'])) { 
						$harvard_ref .= ', ';
						if (!empty($date_published['month']) && !empty($date_published['day'])) { 
								$harvard_ref .= $date_published['month'] . ' ' . $date_published['day'] . ', '; 
							}
							$harvard_ref .= $date_published['year'] . '. ';
					 } else {
						$harvard_ref .= '. ';
					 }
				} else if ($ref_type == 'journal') {
					// Volume and issue number
					if (!empty($volume)) { $harvard_ref .= ' ' . $volume; }
					if (!empty($issue)) { $harvard_ref .= ' (' . $issue . ')'; }
					// Page numbers
					if (!empty($pages['from'])) {
						$harvard_ref .= ': ' . $pages['from'];
						if (!empty($pages['to'])) { $harvard_ref .= '-' . $pages['to']; }
					} 
					$harvard_ref .= '.';
				} else if ($ref_type == 'newspaper') {
					if (!empty($date_published['month']) && !empty($date_published['day'])) {
						$harvard_ref .= ', ' .  $date_published['month'] . ' ' . $date_published['day'];
					}
					$harvard_ref .= '.';
				 }
			} else {
				$harvard_ref .= '<i>' . $title . '</i>.';
				// Resource type
				if (!empty($resource_type)) { $harvard_ref .= ', ' . $resource_type . ','; }
				// Edition
				if (!empty($edition)) { $harvard_ref .= ' ' . $this->_order_suffix($edition) . ' ed.'; }
			}
			// Editors
			if (!empty($editors)) { $harvard_ref .= ' Edited by ' . $editors . '.'; }
			$harvard_ref .= ' ';
		}
		
		if ($ref_type == 'book') {
			// Location
			 if (!empty($location)) {
				$harvard_ref .= $location . ': ';
			 } else {
				$harvard_ref .= 'N.p.: ';
			 }
			 // Publisher
			 if (!empty($publisher)) {
				$harvard_ref .= $publisher . '.';
			 } else {
				$harvard_ref .= 'Unknown.';
			 }
		} else if ($ref_type == 'webpage') {
			
			if (!empty($date_published['year']) && $resource_type != 'Blog' && $resource_type != 'Forum') {
				// If has date of publication
				$harvard_ref .= 'Last Modified ';
				if (!empty($date_published['month']) && !empty($date_published['day'])) { 
					$harvard_ref .= $date_published['month'] . ' ' . $date_published['day'] . ', '; 
				}
				$harvard_ref .= $date_published['year'] . '. ';
			} else if (!empty($date_retrieved['year'])) {
				// If has date of retrieval
				$harvard_ref .= 'Accessed ';
				if (!empty($date_retrieved['month']) && !empty($date_retrieved['day'])) { 
					$harvard_ref .= $date_retrieved['month'] . ' ' . $date_retrieved['day'] . ', '; 
				}
				$harvard_ref .= $date_retrieved['year'] . '. ';
			} 
			
			if (!empty($url)) {
				$harvard_ref .= $url . '.';
			}
		}
		
		return $harvard_ref;
		
	}
	
	private function _harvard_intext($ref_type) {
		extract($this->data);
		$return = '(';
		$authors = array();
		// Extract Last Names from array of contributors
		foreach ($contributors as $key => $value) {
			if ($value['contributor_type'] == 'author') {
				if (!empty($value['last_name'])) {
					array_push($authors, $value['last_name']);
				}		
			}
		}
		// Count how many authors
		$author_count = count($authors);
		// Authors or title
		if (!empty($authors)) {
			// 1 author
			if ($author_count == 1) {
				$return .= $authors[0];
			} else if ($author_count == 2) {
				// 2 authors
				$return .= $authors[0] . ' and ' . $authors[1];
			} else if ($author_count == 3) {
				// 3 authors
				$return .= $authors[0] . ', ' . $authors[1] . ' and ' . $authors[2];
			} else {
				// More than 2 authors
				$return .= $authors[0] . ' et al.';
			}
		} else if (!empty($corporate_author)) {
			// If no author and corp. author if exists
			$return .= $corporate_author;
		} else {
			// Use title in pace of author if no authors
			$return .= '<i>' . $title . '</i> ';
		}
		// Add the year
		if (!empty($date_published['year'])) {
			$return .= ' ' . $date_published['year'];
		} else {
			$return .= ' n.d.';
		}
		// Pages
		if (!empty($pages['from'])) { 
			$return .= ', ' . $pages['from']; 
			if (!empty($pages['to'])) { $return .= '-' . $pages['to']; }
		}
		$return .= ')';
		return $return;		
	}
	
	/**
	 * Take an array of data and format it appropriately 
	 * @param assoc array
	 * @return assoc array
	 **/
	private function _format_array($array) {
		
		// TODO: Sanatize data
		$data = $this->_remove_hyphens($array);
		
		extract($data);
		
		$return['title'] = $this->_clean_input($title);
		
		// Book data
		if (!empty($publisher)) { $return['publisher'] = $this->_clean_input($publisher); }
		if (!empty($location)) { $return['location'] = $this->_clean_input($location); }
		if (!empty($edition)) { $return['edition'] = $this->_clean_input($edition); }
		
		//Journal & Newspaper
		if (!empty($doi)) { $return['doi'] = $this->_clean_input($doi); }
		if (!empty($volume)) { $return['volume'] = $this->_clean_input($volume); }
		if (!empty($issue)) { $return['issue'] = $this->_clean_input($issue); }
		if (!empty($publication_title)) { $return['publication_title'] = $this->_clean_input($publication_title); }
		
		//Webpage
		if (!empty($url)) { $return['url'] = $this->_clean_input($url); }
		
		// Corporate author (Get first value thats set)
		$i = 0;
		foreach ($corporate_author as $key => $value) {
			if (!empty($value)) { 
				$return['corporate_author'] = $this->_clean_input($value); 
				break;
			}
			$i++;
		}
		
		// Unusual resources
		if (!empty($resource_type)) { $return['resource_type'] = $resource_type; }
		
		// Contributors (Put each author in associative array)
		$contributors = array();
		// First name
		$i = 0;
		foreach ($first_name as $key => $value) {
			$contributors[$i]['first_name'] = $this->_clean_input($value);
			$i++;
		}
		// Middle initial
		$i = 0;
		foreach ($middle_initial as $key => $value) {
			$contributors[$i]['middle_initial'] = $this->_clean_input($value);
			$i++;
		}
		// Last name
		$i = 0;
		foreach ($last_name as $key => $value) {
			$contributors[$i]['last_name'] = $this->_clean_input($value);
			$i++;
		}
		// Type of contributor 
		$i = 0;
		foreach ($contributor_type as $key => $value) {
			$contributors[$i]['contributor_type'] = $value;
			$i++;
		}
		$contributors = $this->_check_contributors($contributors);
		$return['contributors'] = $contributors;
		
		// Pages (Put from page and to page into an associative array)
		if (isset($from_page)) {
			$pages = array(
				'from' => $this->_clean_input($from_page),
				'to' => $this->_clean_input($to_page)
			);
			$return['pages'] = $pages;
		}
		
		// Date published
		if (isset($year_published)) {
			$return['date_published']['year'] = $this->_clean_input($year_published);
			if (isset($month_published)) { $return['date_published']['month'] = $this->_month_name($this->_clean_input($month_published)); }
			if (isset($day_published)) { $return['date_published']['day'] = $this->_clean_input($day_published); }
		}	
		
		// Date Retrieved
		if (isset($year_retrieved)) {
			$return['date_retrieved']['year'] = $this->_clean_input($year_retrieved);
			if (isset($month_retrieved)) { $return['date_retrieved']['month'] = $this->_month_name($this->_clean_input($month_retrieved)); }
			if (isset($day_retrieved)) { $return['date_retrieved']['day'] = $this->_clean_input($day_retrieved); }
		}
		// Return
		return $return;
		
	}
	
	/**
	 * Clean a string (trim and remove special chars)
	 * @param string
	 * @return string
	 **/
	private function _clean_input($str) {
		$str = trim($str);
		$str = htmlspecialchars($str, ENT_QUOTES);
		return $str;
	}
	
	/**
	 * Convert month as number to month name (e.g. 1 => 'Janurary') 
	 * @param int
	 * @return string
	 **/	
	private function _month_name($int) {
		$int--;
		$months = array('Janurary', 'Feburary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');	    
		return $months[$int];
	}
	
	/**
	 * Replace all '-' with '_' in key names in an associative array
	 * @param array
	 * @return array
	 **/
	private function _remove_hyphens($array) {
		foreach ($array as $key => $value) {
			if (strstr($key, '-')) {
				unset($array[$key]);
				$key =  str_replace("-", "_", $key); 
				$array[$key] = $value;
			}
		}
		return $array;
	}
	
	/**
	 * Check there are no empty elements in the array and that the last name is always set
	 * @param array
	 * @return array
	 **/	
	private function _check_contributors($contributors) {
		$i = 0;
		foreach ($contributors as $key => $value) {
			if (empty($value['last_name'])) {
				unset($contributors[$key]);
			}
			$i++;
		}
		return $contributors;
	}
	
	/**
	 * Add a suffix to the beginning of number to convert them to an order(1 -> 1st)
	 * @param int
	 * @return string
	 **/
	private function _order_suffix($n) {
		$str = "$n";
		$t = $n > 9 ? substr($str,-2,1) : 0;
		$u = substr($str,-1);
		if ($t==1) return $str . 'th';
		else switch ($u) {
			case 1: return $str . 'st';
			case 2: return $str . 'nd';
			case 3: return $str . 'rd';
			default: return $str . 'th';
		}
	}
	
	
	//
	//
	// Functions for formating data
	//
	//

	private function _apa_contributors($contributors) {
		$authors = array();
		$editors = array();
		$translators = array();
		
		// Step 1: Format each contributor corrently (LastName, F. M.)
		foreach ($contributors as $key => $value) {
			if ($value['contributor_type'] == 'author') {
				$val = $value['last_name'];
				if (!empty($value['first_name'])) {
					$val .= ', ' . $value['first_name'][0] . '.';
				}
				if (!empty($value['middle_initial'])) {
					$val .= ' ' . $value['middle_initial'] . '.';
				}				
				array_push($authors, $val);
			} else if ($value['contributor_type'] == 'editor') {
				$val = $value['first_name'][0] . '.' . $value['middle_initial'] . '. ' . $value['last_name'];
				array_push($editors, $val);
			} else if ($value['contributor_type'] == 'translator') {
				$val = $value['first_name'][0] . '.' . $value['middle_initial'] . '. ' . $value['last_name'];
				array_push($translators, $val);
			}
		}
		
		// Step 2: Compile all contributors (LastName, F. M., LastName, F. M., etc)
		$return_authors = '';
		if(!empty($authors)) {
			sort($authors);
			$size = count($authors);
			$i = 1;
			foreach ($authors as $key => $value) {
				if ($i < 6) {
					$return_authors = $return_authors . $authors[$key];
					if($i != $size) { $return_authors = $return_authors .  ', '; }
				} else if ($i == 7) {
					$return_authors = $return_authors . '...';
				} else if ($i == $size) {
					$return_authors = $return_authors . $authors[$key];
				}
				$i++;
			}
		}
		
		$return_editors = '';
		if(!empty($editors)) {
			sort($editors);
			$size = count($editors);
			$i = 1;
			$return_editors = $return_editors . "ed. ";
			foreach ($editors as $key => $value) {
				$return_editors = $return_editors . $editors[$key];
				if($i != $size) { $return_editors = $return_editors .  '& '; }
				$i++;
			}
		}
		
		$return_translators = '';
		if(!empty($translators)) {
			sort($translators);
			$size = count($translators);
			$i = 1;
			foreach ($translators as $key => $value) {
				$return_translators = $return_translators . $translators[$key];
				if($i != $size) { $return_translators = $return_translators .  '& '; }
				$i++;
			}
			$return_translators = $return_translators . ', Trans.';
		}
		
		return array(
				'authors' => $return_authors, 
				'editors' => $return_editors, 
				'translators' => $return_translators
			);
	}
	
	private function _harvard_contributors($contributors) {
		$authors = array();
		$editors = array();
		
		$author_count = 0;
		$editor_count = 0;
			
		// Step 1: Format each contributor corrently (First: LastName, First M. Additional: , First M. Last )
		foreach ($contributors as $key => $value) {
			if ($value['contributor_type'] == 'author') {
				if ($author_count == 0) {
					// First author inverted
					$val = $value['last_name'];
					if (!empty($value['first_name'])) {
						$val .= ', ' . $value['first_name'];
						if (!empty($value['middle_initial'])) { $val .= ' ' . $value['middle_initial']; }
					}
					array_push($authors, $val);
					$author_count++;
				} else {
					$val = $value['last_name'];
					if (!empty($value['first_name'])) {
						$val = $value['first_name'] . ' ';
						if (!empty($value['middle_initial'])) {
							$val .=  $value['middle_initial'] . '. ';
						}
						$val .=  $value['last_name'];
					}
					array_push($authors, $val);
					$author_count++;
				}
			} else if ($value['contributor_type'] == 'editor') {
				$val = $value['last_name'];
				if (!empty($value['middle_initial']) && !empty($value['first_name'])) {
					$val = $value['first_name'] . ' ' . $value['middle_initial'] . '. ' . $value['last_name'];
				}
				array_push($editors, $val);
				$editor_count++;
			}
		}
		
		// Step 2: Compile all contributors (Author, Author, etc)
		$return_authors = '';
		if(!empty($authors)) {
			$i = 1;
			foreach ($authors as $key => $value) {
				if ($i < 11 && $i != $author_count) {
					$return_authors .= $authors[$key] . ', ';
				} else if ($i > 10) {
					$return_authors .= 'et al';
					break;
				} else if ($i == $author_count) {
					$return_authors .= $authors[$key];
				}
				$i++;
			}
		}
		
		$return_editors = '';
		if(!empty($editors)) {
			$i = 1;
			foreach ($editors as $key => $value) {
				if ($i < 11 && $i != $editor_count) {
					$return_editors .= $editors[$key] . ', ';
				} else if ($i > 10) {
					$return_editor .= 'et al';
					break;
				} else if ($i == $editor_count) {
					$return_editors .= $editors[$key];
				}
				$i++;
			}
		}
		
		return array(
				'authors' => $return_authors, 
				'editors' => $return_editors, 
			);
	}

}