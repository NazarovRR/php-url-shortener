<?php
class Url_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encode');
	}

	public function get_model_by_url($url = FALSE)
	{
		if ($url === FALSE)
		{
			$query = $this->db->get('urls');
			return $query->result_array();
		}

		$query = $this->db->get_where('urls', array('full_url' => $url));
		return $query->result_array();
	}

	public function get_model_by_hash($hash = FALSE)
	{
		if ($hash === FALSE)
		{
			$query = $this->db->get('urls');
			return $query->result_array();
		}

		$query = $this->db->get_where('urls', array('encoded' => $hash));
		return $query->result_array();
	}

	public function encode_url()
	{
		$model = $this->get_model_by_url($this->input->post('full_url'));
		if(sizeof($model) > 0 && !$this->input->post('encoded')){
			return $model;
		} else {
			return $this->insert_data();
		}
	}

	public function insert_data()
	{
		$data = array(
			'full_url' => $this->input->post('full_url')
		);
		if($this->input->post('encoded')){
			$data["encoded"] = $this->input->post('encoded');
			$this->db->insert('urls', $data);
			return $this->get_last();
		} else {
			$this->db->insert('urls', $data);
			$this->update_with_encoding();
			return $this->get_last();
		}
	}

	public function get_last()
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get('urls',1);
		return $query->result_array();
	}

	public function is_short_unique($short)
	{
		if(!$short) return TRUE;
		$query = $this->db->get_where('urls', array('encoded' => $short));
		if(sizeof($query->result_array()) > 0){
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function update_with_encoding()
	{
		$count = $this->db->insert_id();
		$hash = $this->encode->alphaID($count,false,3,"umbrella");
		while(!$this->is_short_unique($hash)){
			$new_count = $count * 100;
			$hash = $this->encode->alphaID($new_count,false,3,"umbrella");
		}
		$upd_data = array(
			'encoded' => $hash
		);
	    $this->db->set('encoded',$hash)
        ->where('id',$count)
        ->update('urls');
	}
}