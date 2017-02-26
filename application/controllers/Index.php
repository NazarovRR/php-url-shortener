<?php
class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('url_model');
	}

	public function view()
	{
		$this->load->view('index.html');
		// $this->load->library('encode');
		// echo $this->encode->alphaID(1,false,3,"umbrella");
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['message'] = NULL;
		$this->form_validation->set_rules('url', 'Url to be shorten', 'required|callback_regex_check');
		$this->form_validation->set_rules('encoded', 'Short url', 'min_length[3]|max_length[10]|alpha_numeric');
		if ($this->form_validation->run() === TRUE)
		{
			$data['message'] = 'http://qwe.com';
		}
		$this->load->view('index/main',$data);
	}

	public function regex_check($str)
	{
		if (1 !== preg_match("/^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+()&%$#=~_-]+))*$/", $str))
		{
			$this->form_validation->set_message('regex_check', 'The {field} field is not valid!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}