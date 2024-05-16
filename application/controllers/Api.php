<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		http_response_code(404);
	}

	function get_kota()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$prov = decrypt($this->input->post('arg'));
			$data['kota'] = $this->db->get_where('tbl_kota', 'id_provinsi = "'.$prov.'"')->result();
			$this->load->view('api/data_kota', $data);
			// echo json_encode($data->result(),JSON_PRETTY_PRINT);
		}
		else
		{
			http_response_code(404);
		}
	}

	function get_kec()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$kota = decrypt($this->input->post('arg'));
			$data['kecamatan'] = $this->db->get_where('tbl_kecamatan', 'id_kota = "'.$kota.'"')->result();
			$this->load->view('api/data_kecamatan', $data);
			// echo json_encode($data->result(),JSON_PRETTY_PRINT);
		}
		else
		{
			http_response_code(404);
		}
	}

	function get_kel()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$kec = decrypt($this->input->post('arg'));
			$data['kelurahan'] = $this->db->get_where('tbl_kelurahan', 'id_kecamatan = "'.$kec.'"')->result();
			$this->load->view('api/data_kelurahan', $data);
			// echo json_encode($data->result(),JSON_PRETTY_PRINT);
		}
		else
		{
			http_response_code(404);
		}
	}

	function cek_jenjang()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$arg = decrypt($this->input->post('arg'));
			$cek = $this->db->get_where('tbl_jenjang', 'id_jenjang = "'.$arg.'"');
			if ($cek->row()->flag_jurusan == 'Y')
			{
				echo json_encode(array('result' => 'oke', ));
			}
			else
			{
				echo json_encode(array('result' => 'not', ));

			}
		}
	}

	function cc($value='')
	{
		echo "string";
	}

	function tes_email()
	{
		echo sendMessage('COBA EMAIL','lalskomputer0@gmail.com');
	}


	function tes_pvt()
	{
		$data['kriteria'] = $this->db->get('tbv_kriteria')->result();
		$data['pelamar'] = $this->db->get_where('view_lamaran','flag_nilai IN ("S","Y") AND id_lowongan = 6')->result();
		$this->load->view('tes_pvt', $data);

	}

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */