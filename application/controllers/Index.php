<?php
class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->model('url_model','', TRUE);
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['message'] = NULL;
		$this->form_validation->set_rules('full_url', 'Url to be shorten', array(
			'required',
			array(
				'valid_url',
				function ($str){
					return regex_url_check($str);
				}
			),
			array(
				'url_exist',
				function ($str){
					return webpage_exist($str);
				}
			)
		), array('valid_url' => 'The {field} field is not valid url',
			'url_exist' => "Such webpage doesn't exist"
		));

		$this->form_validation->set_rules('encoded', 'Short url', array(
			'min_length[3]',
			'max_length[10]',
			'alpha_numeric',
			array('if_short_exist', array($this->url_model, 'is_short_unique'))
		), array('if_short_exist' => 'This short url already taken'));

		if ($this->form_validation->run() === TRUE)
		{
			$model = $this->url_model->encode_url();
			$data['message'] = $model[0]["encoded"];
		}
		$this->load->view('index/main',$data);
	}

	public function redirect_to($param = NULL){
		$model = $this->url_model->get_model_by_hash($param);
		if(sizeof($model) > 0) {
			redirect($model[0]["full_url"], 'location', 301);
		} else {
			redirect(base_url());
		}
	}
}