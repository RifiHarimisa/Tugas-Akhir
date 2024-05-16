<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelamar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_login') != true OR $this->session->userdata('role') != 'User')
		{
			redirect('keluar');
		}
	}

	public function index()
	{
		$data['title'] = 'Home Pelamar';
		render('user/home',$data);
 	}

 	function data_pribadi()
 	{
 		$this->load->model('ModelUser','m_user');
 		$data['title'] = 'Data Pribadi';
 		$data['pribadi'] = $this->m_user->get_profile_user($this->session->userdata('id_user')); 		
 		// print_r($data);
 		render('user/profile',$data);
 	}

 	function data_pendidikan()
 	{
 		$this->load->model('ModelUser','m_user');
 		$data['title'] = 'Data Pendidikan';
 		$data['pendidikan'] = $this->m_user->get_pendidikan_user($this->session->userdata('id_user'));
 		$data['jenjang'] = $this->db->get('tbl_jenjang')->result();
 		// print_r($data);
 		render('user/pendidikan',$data);
 	}

 	function simpan_pendidikan()
 	{
 		if ($this->input->server('REQUEST_METHOD') == 'POST')
 		{
 			$jenjang = decrypt($this->input->post('jenjang'));
 			$sekolah = $this->input->post('nama_sekolah');
 			$jurusan = $this->input->post('jurusan');
 			$masuk = $this->input->post('tgl_masuk');
 			$keluar = $this->input->post('tgl_keluar');

 			$ijazah = foto_upload64($this->input->post('ijazah'),'Ijazah_'.str_replace(' ', '_', $nama).$jenjang);

 			$cek = $this->db->get_where('tbl_pendidikan', 'id_user = "'.$this->session->userdata('id_user').'" AND id_jenjang = "'.$jenjang.'"');

 			if ($cek->num_rows() > 0)
 			{
 				$this->session->set_flashdata('notif', '<script>swal("Info","Jenjang Pendidikan Sudah Ada","warning")</script>');
				redirect('myprofile/pendidikan');
 			}
 			else
 			{
 				$data = array(
 					'id_user' => $this->session->userdata('id_user'), 
 					'id_jenjang' => $jenjang, 
 					'nama_sekolah' => $sekolah, 
 					'jurusan' => $jurusan, 
 					'masuk' => $masuk, 
 					'keluar' => $keluar, 
 					'ijazah' => $ijazah, 
 				);

 				$this->db->insert('tbl_pendidikan', $data);

 				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Pendidikan berhasil ditambahkan","success")</script>');
				redirect('myprofile/pendidikan');
 			}
 		}
 		else
 		{
 			http_response_code(404);
 		}
 	}

 	function hapus_pendidikan()
 	{
 		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_pendidikan = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_pendidikan',array('id_pendidikan' => $id_pendidikan,));
			if ($del)
			{
				echo json_encode(array('result' => 'oke',));
			}
			else
			{
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
 	}

 	function data_pekerjaan()
 	{
 		$this->load->model('ModelUser','m_user');
 		$data['title'] = 'Data Pekejaan';
 		$data['pekerjaan'] = $this->m_user->get_pekerjaan_user($this->session->userdata('id_user'));
 		render('user/pekerjaan',$data);
 	}

 	function simpan_pekerjaan()
 	{
 		if ($this->input->server('REQUEST_METHOD') == 'POST')
 		{
 			$perusahaan = $this->input->post('nama_perusahaan');
 			$posisi = $this->input->post('posisi');
 			$masuk = $this->input->post('tgl_masuk');
 			$keluar = $this->input->post('tgl_keluar');

 			$data = array(
 				'id_user' => $this->session->userdata('id_user'), 
 				'nama_perusahaan' => $perusahaan, 
 				'posisi' => $posisi, 
 				'masuk' => $masuk, 
 				'keluar' => $keluar, 
 			);

 			$insert = $this->db->insert('tbl_pengalaman', $data);
 			if ($insert)
 			{
 				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Pengalaman Pekerjaan Berhasil Ditambahkan","success")</script>');
				redirect('myprofile/pekerjaan');
 			}
 			else
 			{
 				$this->session->set_flashdata('notif', '<script>swal("Error","Data Pengalaman Pekerjaan Gagal Ditambahkan","error")</script>');
				redirect('myprofile/pekerjaan');
 			}
 		}
 	}

 	function hapus_pekerjaan()
 	{
 		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_pengalaman = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_pengalaman',array('id_pengalaman' => $id_pengalaman,));
			if ($del)
			{
				echo json_encode(array('result' => 'oke',));
			}
			else
			{
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
 	}

 	function simpan_data_pribadi()
 	{
 		if ($this->input->server('REQUEST_METHOD') == 'POST')
 		{
 			$id_user = $this->session->userdata('id_user');
			$nik = $this->input->post('nik');
			$nama = $this->input->post('nama');
			$tmpt = $this->input->post('tmpt_lahir');
			$tgl = $this->input->post('tgl_lahir');
			$status = $this->input->post('status');
			$id_kelurahan = $this->input->post('kel');
			$lingkungan = $this->input->post('ling');
			$email = $this->input->post('email');
			$no_telp = $this->input->post('no_telp');

			// echo $foto;

			$data = array(
				'nik' => $nik, 
				'nama' => $nama, 
				'tmpt_lahir' => $tmpt, 
				'tgl_lahir' => $tgl, 
				'id_kelurahan' => decrypt($id_kelurahan), 
				'lingkungan' => $lingkungan, 
				'status' => $status, 
				'email' => $email, 
				'no_telp' => $no_telp, 
			);

			$where = array('id_user' => $id_user,);


			$update = $this->db->update('tbl_profile_user', $data,$where);
			if ($update)
			{
				
				echo json_encode(array('result' => 'oke',));
			}
			else
			{
				echo json_encode(array('result' => 'gagal',));

			}
 		}
 	}

 	function data_lowongan()
 	{
 		$this->load->model('ModelLowongan','m_lowongan');
 		$data['title'] = 'Lowongan';
 		$data['lowongan'] = $this->m_lowongan->get_lowongan_aktif();
 		render('user/lowongan',$data);
 	}

 	function detail_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lowongan = $this->input->post('arg');
			$data['l'] = $this->db->get_where('tbl_lowongan', 'id_lowongan = "'.decrypt($id_lowongan).'"');
			if ($data['l']->num_rows() > 0)
			{
				$data['l'] = $data['l']->row();
				$this->load->view('divisi/detail_lowongan', $data);
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
					Data Tidak Ditemukan 😥
				</div>';
			}
		}
	}

	function lamar_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$lowongan = decrypt($this->input->post('arg'));
			$user = $this->session->userdata('id_user');

			$cek = $this->db->get_where('tbl_lamaran', 'id_user = "'.$user.'" AND id_lowongan = "'.$lowongan.'" AND flag_nilai = "N"');
			if ($cek->num_rows() > 0)
			{
				echo json_encode(array('result' => 'dup', ));
			}
			else
			{
				$data = array(
					'id_lowongan' => $lowongan, 
					'id_user' => $user, 
				);
				$insert = $this->db->insert('tbl_lamaran', $data);
				if ($insert)
				{
					//notif
					$email = $this->session->userdata('email');
					$l = $this->db->get_where('tbl_lowongan','id_lowongan = "'.$lowongan.'"')->row();
					$perusahaan = $this->db->get_where('tbl_profile_perusahaan','id_perusahaan = "'.$l->id_perusahaan.'"')->row()->nama;
					$pesan = "
						Anda Berhasil Melamar <br>
						Lowongan = ".$l->judul_lowongan." <br>
						Perusahaan = ".$perusahaan." <br>
						Tanggal = ".date('d/m/Y H:i:s')." <br>
						";
					$res = sendMessage($pesan,$email);
					if ($res)
					{
						echo json_encode(array('result' => 'oke',));
					}
					else
					{
						echo json_encode(array('result' => 'oke','msg'=>'not send notif'));
					}
				}
				else
				{
					http_response_code(500);
				}
			}
		}
	}

	function hasil_lowongan()
	{
		$this->load->model('ModelUser','m_user');
		$data['title'] = 'Lamaran Saya';
		$data['lamaran'] = $this->m_user->get_lamaran($this->session->userdata('id_user'));
		render('user/lamaran',$data);
	}

	function ubah_password()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$old = $this->input->post('old_pass');
			$new = $this->input->post('new_pass');
			$cek = $this->db->get_where('tbl_user', 'username = "'.$this->session->userdata('username').'" AND password = "'.encrypt(md5($old)).'"');
			if ($cek->num_rows() > 0)
			{
				$this->db->update('tbl_user', array('password' => encrypt(md5($new))),array('username' => $this->session->userdata('username'), ));
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Password Berhasil Diubah","success")</script>');
				redirect('home');
			}
			else
			{
				$this->session->set_flashdata('notif', '<script>swal("Opss","Password Lama Salah","warning")</script>');
				redirect('home');
			}
		}
		else
		{
			http_response_code(404);
		}
	}
}

/* End of file Pelamar.php */
/* Location: ./application/controllers/Pelamar.php */