<?php
class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('url_model','', TRUE);
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['message'] = NULL;
		$this->form_validation->set_rules('url', 'Url to be shorten', 'required|callback_regex_check');
		$this->form_validation->set_rules('encoded', 'Short url', 'min_length[3]|max_length[10]|alpha_numeric|callback_if_exist');
		if ($this->form_validation->run() === TRUE)
		{
			$model = $this->url_model->encode_url();
			$data['message'] = $model[0]["encoded"];
		}
		$this->load->view('index/main',$data);
	}

	public function redirect($param){
		$model = $this->url_model->get_model_by_hash($param);
		if(sizeof($model) > 0) {
			redirect($model[0]["full_url"], 'location', 301);
		} else {
			redirect(base_url());
		}
	}

	public function regex_check($str)
	{
		if (1 !== preg_match("/^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+()&%$#=~_-]+))*$/", $str))
		{
			$this->form_validation->set_message('regex_check', 'The {field} field is not valid url');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function if_exist($str)
	{
		if(!$str) return TRUE;
		$not_exist = $this->url_model->is_short_unique($str);
		if($not_exist) {
			return TRUE;
		} else {
			$this->form_validation->set_message('if_exist', 'This short url already taken');
			return FALSE;
		}
	}
}