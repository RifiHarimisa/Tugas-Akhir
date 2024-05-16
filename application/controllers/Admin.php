<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('role') != 'Admin') {
			redirect('keluar');
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('authmin');
	}

	public function index()
	{
		$data['title'] = 'Home Administrator';
		render('admin/home', $data);
	}

	function master_divisi()
	{
		$data['title'] = 'Master Divisi';
		$data['divisi'] = $this->db->query('
			SELECT
			a.*,
			b.id_profile,
			b.nama_divisi,
			b.email_divisi,
			b.no_telp,
			b.foto_divisi,
			b.lastupdate
			FROM tbl_divisi a
			LEFT JOIN tbl_profile_divisi b
			ON a.id_divisi = b.id_divisi
		')->result();

		render('admin/master_divisi', $data);
	}

	function cek_username()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$username = $this->input->post('arg');
			if ($username != '') {
				$cek = $this->db->get_where('tbl_divisi', 'username = "' . $username . '"');
				if ($cek->num_rows() > 0) {
					// http_response_code(204);
					echo json_encode(array('result' => 'not',));
				} else {
					http_response_code(200);
					echo json_encode(array('result' => 'oke',));
				}
			}
		} else {
			http_response_code(404);
		}
	}


	function tambah_divisi()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_divisi = rand(1, 9999999);
			$nama = $this->input->post('divisi');
			$email = $this->input->post('email');
			$notelp = $this->input->post('notelp');

			$username = $this->input->post('username');
			$password = encrypt(md5($username . '1234'));

			$data_profile = array(
				'id_divisi' => $id_divisi,
				'nama_divisi' => $nama,
				'email_divisi' => $email,
				'no_telp' => $notelp,
			);

			$data_login = array(
				'id_divisi' => $id_divisi,
				'username' => $username,
				'password' => $password,
				'flag_aktif' => 'Y',
			);

			$cek = $this->db->get_where('tbl_profile_divisi', 'nama_divisi = "' . $nama . '"');
			if ($cek->num_rows() == 0) {
				$insert_login = $this->db->insert('tbl_divisi', $data_login);
				if ($insert_login) {
					$this->db->insert('tbl_profile_divisi', $data_profile);
					$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Divisi ' . $nama . ' berhasil ditambahkan 😎<br>Username = ' . $username . '<br>Password = ' . $username . '1234","success")</script>');
					redirect('m-divisi');
				}
			} else {
				$this->db->insert('tbl_profile_divisi', $data_profile);
				$this->session->set_flashdata('notif', '<script>swal("Gagal","Data Divisi ' . $nama . ' sudah ada 😥","error")</script>');
				redirect('m-divisi');
			}
		} else {
			http_response_code(404);
		}
	}

	function hapus_divisi()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_divisi = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_divisi', array('id_divisi' => $id_divisi,));
			if ($del) {
				echo json_encode(array('result' => 'oke',));
			} else {
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
	}

	function master_lowongan()
	{
		$this->load->model('ModelLowongan', 'm_lowongan');
		$data['title'] = 'Data Lowongan';
		$data['lowongan'] = $this->m_lowongan->get_lowongan();
		render('admin/master_lowongan', $data);
	}


	function detail_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lowongan = $this->input->post('arg');
			$data['l'] = $this->db->get_where('tbl_lowongan', 'id_lowongan = "' . decrypt($id_lowongan) . '"');
			if ($data['l']->num_rows() > 0) {
				$data['l'] = $data['l']->row();
				$this->load->view('divisi/detail_lowongan', $data);
			} else {
				echo '<div class="alert alert-danger" role="alert">
					Data Tidak Ditemukan 😥
				</div>';
			}
		}
	}

	function acc_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lowongan = decrypt($this->input->post('arg'));

			$update = $this->db->update('tbl_lowongan', array('flag_aktif' => 'Y',), array('id_lowongan' => $id_lowongan,));
			if ($update) {
				echo json_encode(array('result' => 'oke',));
			} else {
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
	}

	function lamaran()
	{
		$data['title'] = 'Lamaran';
		$data['lamaran'] = $this->db->get('view_lamaran')->result();
		render('admin/lamaran', $data);
	}

	function cek_lamaran()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lamaran = decrypt($this->input->post('arg'));
			$cek = $this->db->get_where('view_lamaran', 'id_lamaran = "' . $id_lamaran . '"');
			if ($cek->num_rows() > 0) {
				$this->load->model('ModelUser', 'm_user');

				$data['l'] = $cek->row();
				$data['pribadi'] = $this->m_user->get_profile_user($data['l']->id_user);
				$data['pendidikan'] = $this->db->get_where('tbl_pendidikan', 'id_user = "' . $data['l']->id_user . '"')->result();
				$data['pengalaman'] = $this->db->get_where('tbl_pengalaman', 'id_user = "' . $data['l']->id_user . '"')->result();

				// echo "<pre>";
				// echo json_encode ($data,JSON_PRETTY_PRINT);
				// echo "</pre>";

				$this->load->view('admin/data_pelamar', $data);
			} else {
				echo '
				<div class="alert alert-warning" role="alert">
					<strong>opss!</strong> Lamaran Tidak Ditemukan
				</div>
				';
			}
		} else {
			http_response_code(404);
		}
	}

	function simpan_nilai()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$user  = decrypt($this->input->post('users'));
			$lamaran  = decrypt($this->input->post('lamaran'));

			$datas = array();

			$kriteria = $this->db->get('tbl_mas_kriteria')->result();
			foreach ($kriteria as $k) {
				$datas[] = array(
					'id_user' => $user,
					'id_lamaran' => $lamaran,
					'id_kriteria' => $k->id_kriteria,
					'id_alternatif' => decrypt($this->input->post(encrypt($k->id_kriteria))),
				);
			}

			$insert = $this->db->insert_batch('tbl_normalisasi', $datas);
			if ($insert) {
				$update = $this->db->update('tbl_lamaran', array('flag_nilai' => 'S'), array('id_lamaran' => $lamaran,));
				echo json_encode(array('result' => 'oke',));
			} else {
				echo json_encode(array('result' => 'gagal',));
			}
		} else {
			http_response_code(404);
		}
	}


	function cek_berkas()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lamaran = decrypt($this->input->post('arg'));
			$flag = decrypt($this->input->post('arg1'));
			$cek = $this->db->get_where('tbl_lamaran', 'id_lamaran = "' . $id_lamaran . '"');
			if ($cek->num_rows() > 0) {
				$lamaran = $this->db->get_where('view_lamaran', 'id_lamaran = "' . $cek->row()->id_lamaran . '"')->row();
				$id_telegram = $this->db->get_where('tbl_user', 'id_user = "' . $cek->row()->id_user . '"')->row()->id_telegram;
				if ($flag == 'Y') {
					$update = $this->db->update('tbl_lamaran', array('flag_berkas' => $flag,), array('id_lamaran' => $id_lamaran,));
					if ($update) {
						$pesan = "
							
							Selamat !! 
							Anda Lolos Ditahap Berkas !! ✅
							Lamaran : $lamaran->judul_lowongan
							Divisi  : $lamaran->nama_divisi

						";
						$res = sendMessage($pesan, $id_telegram);
					}
				} else {
					$update = $this->db->update('tbl_lamaran', array('flag_berkas' => 'T', 'flag_tes' => 'T', 'flag_aktif' => 'N'), array('id_lamaran' => $id_lamaran,));
					if ($update) {
						$pesan = "
							
							Maaf !! 
							Anda Belum Lolos 🥺
							Lamaran : $lamaran->judul_lowongan
							Divisi  : $lamaran->nama_divisi

						";
						$res = sendMessage($pesan, $id_telegram);
					}
				}

				echo json_encode(array('result' => 'oke',));
			} else {
				echo json_encode(array('result' => 'not_found',));
			}
		}
	}

	function ubahpassword()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$old = $this->input->post('old_pass');
			$new = $this->input->post('new_pass');
			$cek = $this->db->get_where('tbl_admin', 'id_admin = "' . $this->session->userdata('id_admin') . '" AND password = "' . encrypt(md5($old)) . '"');
			if ($cek->num_rows() > 0) {
				$this->db->update('tbl_admin', array('password' => encrypt(md5($new))), array('id_admin' => $this->session->userdata('id_admin'),));
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Password Berhasil Diubah","success")</script>');
				redirect('homemin');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Opss","Password Lama Salah","warning")</script>');
				redirect('homemin');
			}
		} else {
			http_response_code(404);
		}
	}


	function pelamar()
	{
		$data['title'] = 'Data Pelamar';
		$data['pelamar'] = $this->db->order_by('lastupdate', 'desc')->get_where('tbl_profile_user', 'nama IS NOT NULL')->result();
		render('admin/pelamar', $data);
	}

	function update_pelamar()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_user = decrypt($this->input->post('arg1'));
			$flag = decrypt($this->input->post('arg2'));

			$user = $this->db->get_where('tbl_profile_user', 'id_user = "' . $id_user . '"')->row();

			if ($flag == 'V') {
				$pesan = "
					Hallo $user->nama 👋<br>
					Akun Anda Dihapus Oleh Admin
				";
				$this->db->delete('tbl_user', 'id_user = "' . $id_user . '"');
			} else if ($flag == 'Y') {
				$pesan = "
					Hallo $user->nama 👋<br>
					Akun Anda Diaktifkan Oleh Admin
				";
				$data = array('flag_aktif' => 'Y',);
				$update = $this->db->update('tbl_user', $data, array('id_user' => $id_user,));
			} else {
				http_response_code(404);
				return 0;
			}

			http_response_code(200);
			echo json_encode(array('result' => 'oke',));
			sendMessage($pesan, $user->email);
		}
	}

	function perusahaan()
	{
		$data['title'] = 'Data Perusahaan';
		$data['perusahaan'] = $this->db->order_by('lastupdate', 'desc')->get_where('tbl_profile_perusahaan', 'nama IS NOT NULL')->result();
		render('admin/perusahaan', $data);
	}

	function update_perusahaan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_perusahaan = decrypt($this->input->post('arg1'));
			$flag = decrypt($this->input->post('arg2'));


			$perusahaan = $this->db->get_where('tbl_profile_perusahaan', 'id_perusahaan = "' . $id_perusahaan . '"')->row();

			if ($flag == 'V') {
				$data = array('flag_aktif' => 'V',);
				$pesan = "
					Hallo $perusahaan->nama 👋<br>
					Akun Anda Dihapus Oleh Admin
				";
				$this->db->delete('tbl_perusahaan', 'id_perusahaan = "' . $id_perusahaan . '"');
			} else if ($flag == 'Y') {
				$data = array('flag_aktif' => 'Y',);
				$pesan = "
					Hallo $perusahaan->nama 👋<br>
					Akun Anda Diaktifkan Oleh Admin
				";
				$this->db->update('tbl_perusahaan', $data, array('id_perusahaan' => $id_perusahaan,));
			} else {
				http_response_code(404);
				return 0;
			}

			http_response_code(200);
			echo json_encode(array('result' => 'oke',));
			sendMessage($pesan, $perusahaan->email);
		}
	}

	function kriteria()
	{
		$data['title'] = 'Data Kriteria';
		$data['kriteria'] = $this->db->get('tbv_kriteria')->result();
		render('admin/kriteria', $data);
	}


	function simpan_kriteria()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$kriteria = $this->input->post('kriteria');
			$atribut = $this->input->post('atribut');
			$bobot = $this->input->post('bobot');

			$data = array(
				'kriteria' => $kriteria,
				'atribut' => $atribut,
				'Bobot' => $bobot,
			);

			$insert = $this->db->insert('tbl_mas_kriteria', $data);
			if ($insert) {
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Berhasil Ditambahkan","success")</script>');
				redirect('data-kriteria');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Gagal Ditambahkan","warning")</script>');
				redirect('data-kriteria');
			}
		}
	}

	function simpan_edit_kriteria()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$kriteria = $this->input->post('kriteria');
			$atribut = $this->input->post('atribut');
			$bobot = $this->input->post('bobot');
			$id_kriteria = decrypt($this->input->post('arg'));
			$data = array(
				'kriteria' => $kriteria,
				'atribut' => $atribut,
				'Bobot' => $bobot,
			);

			$insert = $this->db->update('tbl_mas_kriteria', $data, array('id_kriteria' => $id_kriteria,));
			if ($insert) {
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Berhasil Diedit","success")</script>');
				redirect('data-kriteria');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Gagal Diedit","warning")</script>');
				redirect('data-kriteria');
			}
		}
	}

	function get_edit_kriteria()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_kriteria = decrypt($this->input->post('arg'));
			$data['kriteria'] = $this->db->get_where('tbv_kriteria', 'id_kriteria = "' . $id_kriteria . '"')->row();
			if ($data['kriteria'] != null) {
				$this->load->view('admin/edit_kriteria', $data);
			} else {
				http_response_code(404);
			}
		}
	}

	function hapus_kriteria()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_kriteria = decrypt($this->input->post('arg'));

			$del = $this->db->delete('tbl_mas_kriteria', array('id_kriteria' => $id_kriteria,));
			if ($del) {
				echo json_encode(array('result' => 'oke',));
			} else {
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
	}


	function alternatif()
	{
		$data['title'] = 'Data Sub Kriteria';
		$data['kriteria'] = $this->db->get('tbv_kriteria')->result();
		$data['alternatif'] = $this->db->get('tbv_alternatif')->result();
		render('admin/alternatif', $data);
	}


	function get_edit_alternatif()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_alternatif = decrypt($this->input->post('arg'));
			$data['kriteria'] = $this->db->get('tbv_kriteria')->result();
			$data['alternatif'] = $this->db->get_where('tbv_alternatif', 'id_alternatif = "' . $id_alternatif . '"')->row();
			if ($data['alternatif'] != null) {
				$this->load->view('admin/edit_alternatif', $data);
			} else {
				http_response_code(404);
			}
		}
	}

	function simpan_edit_alternatif()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$kriteria = decrypt($this->input->post('kriteria'));
			$alternatif = $this->input->post('alternatif');
			$bobot = $this->input->post('bobot');
			$id_alternatif = decrypt($this->input->post('arg'));
			$data = array(
				'id_kriteria' => $kriteria,
				'alternatif' => $alternatif,
				'Bobot' => $bobot,
			);

			$insert = $this->db->update('tbl_mas_alternatif', $data, array('id_alternatif' => $id_alternatif,));
			if ($insert) {
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Berhasil Diedit","success")</script>');
				redirect('data-alternatif');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Gagal Diedit","warning")</script>');
				redirect('data-alternatif');
			}
		}
	}

	function simpan_alternatif()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$kriteria = decrypt($this->input->post('kriteria'));
			$alternatif = $this->input->post('alternatif');
			$bobot = $this->input->post('bobot');

			$data = array(
				'id_kriteria' => $kriteria,
				'alternatif' => $alternatif,
				'Bobot' => $bobot,
			);

			$insert = $this->db->insert('tbl_mas_alternatif', $data);
			if ($insert) {
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Berhasil Ditambahkan","success")</script>');
				redirect('data-alternatif');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Gagal Ditambahkan","warning")</script>');
				redirect('data-alternatif');
			}
		}
	}

	function hapus_alternatif()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_alternatif = decrypt($this->input->post('arg'));

			$del = $this->db->delete('tbl_mas_alternatif', array('id_alternatif' => $id_alternatif,));
			if ($del) {
				echo json_encode(array('result' => 'oke',));
			} else {
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */