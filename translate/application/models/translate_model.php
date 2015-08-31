<?php
class Translate_model extends CI_Model {

	// get all countries
	function get_all_country() {
		$sql = 'select country from AmazonBrowseTree group by country';
		$q = $this->db->query($sql);

		if($q->num_rows() > 0) {
			$result = $q->result(); unset($q);

			$res = array();
			foreach($result as $r)
				$res[] = strtolower($r->country);

			return $res;
		} else {
			return array();
		}
	}

	// get total of rows does not translate
	function total_source_rows($country = false) {
		$sql = "select count(*) as total from AmazonBrowseTree";
		if($country)
			$sql .= " where country='$country'";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
			return $query->row()->total;
		else return 0;
	}	

	// get source rows
	function get_source_rows($limit = 20, $start = 0, $country = false) {
		if(!is_numeric($limit) OR !is_numeric($start))
			return false;

		$this->db->select('country, node-id as nodeid, node-path as nodepath, node-enpoint as nodeenpoint');
		if($country)
			$this->db->where('country', $country);
		$this->db->order_by('id', 'ASC');
		$this->db->limit($limit, $start);

		$q = $this->db->get('AmazonBrowseTree');
		if($q->num_rows() > 0) {
			$result = $q->result(); unset($q);
			return $result;
		} else {
			return false;
		}
	}

	function save_translated($data) {
		$this->db->insert('AmazonBrowseTreeTranslate', $data);
		return true;
	}

	function check_exist_target($where) {
		$this->db->where($where);
		$q = $this->db->get('AmazonBrowseTreeTranslate');
		if($q->num_rows() > 0)
			return $q->row();
		else 
			return false;
	}

}