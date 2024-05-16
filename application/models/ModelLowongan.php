<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelLowongan extends CI_Model {

	// public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_lowongan($id_perusahaan='')
	{
		if ($id_perusahaan != '')
		{
			$data = $this->db->query('
				SELECT 
				a.*
				FROM tbl_lowongan a
				WHERE a.id_perusahaan = "'.$id_perusahaan.'"
				ORDER BY a.regdate DESC
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT 
				a.*,
				b.nama as nama_perusahaan
				FROM tbl_lowongan a
				LEFT JOIN tbl_profile_perusahaan b
				ON a.id_perusahaan = b.id_perusahaan
				ORDER BY a.regdate DESC
			')->result();
		}

		return $data;
	}

	function get_lowongan_aktif($id_perusahaan='')
	{
		if ($id_perusahaan != '')
		{
			$data = $this->db->query('
				SELECT 
				a.*
				FROM tbl_lowongan a
				WHERE a.id_perusahaan = "'.$id_perusahaan.'" AND flag_aktif = "Y"
				ORDER BY a.regdate DESC
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT 
				a.*,
				b.nama AS nama_perusahaan,
				b.foto
				FROM tbl_lowongan a
				LEFT JOIN tbl_profile_perusahaan b
				ON a.id_perusahaan = b.id_perusahaan
				WHERE flag_aktif = "Y"
				ORDER BY a.regdate DESC
			')->result();
		}

		return $data;
	}

}

/* End of file ModelLowongan.php */
/* Location: ./application/models/ModelLowongan.php */