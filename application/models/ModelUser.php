<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelUser extends CI_Model {

	// public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_profile_user($id_user='')
	{
		if ($id_user != '')
		{
			$data = $this->db->query('
				SELECT
	 			a.nama,
	 			a.nik,
	 			a.tmpt_lahir,
	 			a.tgl_lahir,

	 			b.id_kelurahan,
	 			b.nama_kelurahan,
	 			
	 			c.id_kecamatan,
	 			c.nama_kecamatan,

	 			d.id_kota,
	 			d.nama_kota,

	 			e.id_provinsi,
	 			e.nama_provinsi,

	 			a.lingkungan,
	 			a.`status`,
	 			a.email,
	 			a.no_telp,
	 			a.foto_profile,
	 			a.lastupdate
	 			FROM tbl_profile_user a
	 			
	 			LEFT JOIN tbl_kelurahan b
	 			ON a.id_kelurahan = b.id_kelurahan
	 			
	 			LEFT JOIN tbl_kecamatan c
	 			ON b.id_kecamatan = c.id_kecamatan
	 			
	 			LEFT JOIN tbl_kota d 
	 			ON c.id_kota = d.id_kota
	 			
	 			LEFT JOIN tbl_provinsi e 
	 			ON d.id_provinsi = e.id_provinsi
	 			
	 			WHERE a.id_user = "'.$id_user.'"
			')->row();
		}
		else
		{
			$data = $this->db->query('
				SELECT
	 			a.nama,
	 			a.nik,
	 			a.tmpt_lahir,
	 			a.tgl_lahir,

	 			b.id_kelurahan,
	 			b.nama_kelurahan,
	 			
	 			c.id_kecamatan,
	 			c.nama_kecamatan,

	 			d.id_kota,
	 			d.nama_kota,

	 			e.id_provinsi,
	 			e.nama_provinsi,

	 			a.lingkungan,
	 			a.`status`,
	 			a.email,
	 			a.no_telp,
	 			a.foto_profile,
	 			a.lastupdate
	 			FROM tbl_profile_user a
	 			
	 			LEFT JOIN tbl_kelurahan b
	 			ON a.id_kelurahan = b.id_kelurahan
	 			
	 			LEFT JOIN tbl_kecamatan c
	 			ON b.id_kecamatan = c.id_kecamatan
	 			
	 			LEFT JOIN tbl_kota d 
	 			ON c.id_kota = d.id_kota
	 			
	 			LEFT JOIN tbl_provinsi e 
	 			ON d.id_provinsi = e.id_provinsi
			')->result();	
		}

		return $data;
	}

	function get_pendidikan_user($id_user='')
	{
		if ($id_user != '')
		{
			$data = $this->db->query('
				SELECT a.*,b.nama_jenjang, b.flag_jurusan FROM tbl_pendidikan a
				LEFT JOIN tbl_jenjang b
				ON a.id_jenjang = b.id_jenjang
				WHERE a.id_user = "'.$id_user.'"
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT a.*,b.nama_jenjang, b.flag_jurusan FROM tbl_pendidikan a
				LEFT JOIN tbl_jenjang b
				ON a.id_jenjang = b.id_jenjang
			')->result();
		}
		return $data;
	}

	function get_pekerjaan_user($id_user='')
	{
		if ($id_user != '')
		{
			$data = $this->db->query('
				SELECT a.* FROM tbl_pengalaman a
				WHERE a.id_user = "'.$id_user.'"
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT a.* FROM tbl_pengalaman a
			')->result();
		}
		return $data;
	}

	function get_lamaran($id_user='')
	{
		if ($id_user != '')
		{
			$data = $this->db->get_where('view_lamaran', 'id_user = "'.$id_user.'"')->result();
		}
		else
		{
			$data = $this->db->get('view_lamaran')->result();

		}

		return $data;
	}

}

/* End of file ModelUser.php */
/* Location: ./application/models/ModelUser.php */