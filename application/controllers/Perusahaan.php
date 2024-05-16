<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perusahaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('is_login') != true OR $this->session->userdata('role') != 'Perusahaan')
		{
			redirect('keluar');
		}
	}

	public function index()
	{
		
	}

}

/* End of file Perusahaan.php */
/* Location: ./application/controllers/Perusahaan.php */