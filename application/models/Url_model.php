<?php
class Url_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_data($id = FALSE)
	{
		if ($id === FALSE)
		{
			$query = $this->db->get('urls');
			return $query->result_array();
		}

		$query = $this->db->get_where('urls', array('id' => $id));
		return $query->row_array();
	}
	public function insert_data()
	{
		$this->load->helper('url');
		$data = array(
			'full_url' => $this->input->post('url')
		);
		if($this->input->post('encoded')){
			$data["encoded"] = $this->input->post('encoded');
		}

		return $this->db->insert('urls', $data);
	}
}