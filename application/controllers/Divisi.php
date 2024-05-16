<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Divisi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_login') != true or $this->session->userdata('role') != 'Perusahaan') {
			redirect('outdiv');
		}
	}

	public function index()
	{
		$data['title'] = 'Home Perusahaan';
		render('divisi/home', $data);
	}

	function lowongan()
	{
		$this->load->model('ModelLowongan', 'm_lowongan');
		$data['title'] = 'Data Lowongan';
		$data['lowongan'] = $this->m_lowongan->get_lowongan($this->session->userdata('id_perusahaan'));
		render('divisi/lowongan', $data);
	}

	function simpan_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$email_admin = $this->db->get('tbl_profile_admin')->result();
			$email_user = $this->db->get_where('tbl_profile_user', 'NIK IS NOT NULL')->result();

			$judul = $this->input->post('judul_lowongan');
			$persyaratan = $this->input->post('persyaratan');
			$tanggung_jawab = $this->input->post('tanggung_jawab');
			$gaji = $this->input->post('gaji');

			$data = array(
				'id_perusahaan' => $this->session->userdata('id_perusahaan'),
				'judul_lowongan' => $judul,
				'persayaratan' => $persyaratan,
				'tanggung_jawab' => $tanggung_jawab,
				'gaji' => $gaji,
			);

			$insert = $this->db->insert('tbl_lowongan', $data);
			if ($insert) {
				foreach ($email_admin as $ea) {
					sendMessage("Lowongan Terbaru<br>Nama Perusahaan = " . $this->session->userdata('nama') . "<br>Lowongan : $judul", $ea->email);
				}

				foreach ($email_user as $eu) {
					sendMessage("Lowongan Terbaru<br>Nama Perusahaan = " . $this->session->userdata('nama') . "<br>Lowongan : $judul", $ea->email);
				}

				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Lowongan berhasil ditambahkan","success")</script>');
				redirect('data_lowongan');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Lowongan gagal ditambahkan","error")</script>');
				redirect('data_lowongan');
			}
		}
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

	function edit_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lowongan = $this->input->post('arg');
			$data['l'] = $this->db->get_where('tbl_lowongan', 'id_lowongan = "' . decrypt($id_lowongan) . '"');
			if ($data['l']->num_rows() > 0) {
				$data['l'] = $data['l']->row();
				$this->load->view('divisi/edit_lowongan', $data);
			} else {
				echo '<div class="alert alert-danger" role="alert">
					Data Tidak Ditemukan 😥
				</div>';
			}
		}
	}

	function simpan_edit_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id = decrypt($this->input->post('arg'));
			$judul = $this->input->post('judul_lowongan');
			$persyaratan = $this->input->post('persyaratan');
			$tanggung_jawab = $this->input->post('tanggung_jawab');
			$gaji = $this->input->post('gaji');

			$data = array(
				'id_perusahaan' => $this->session->userdata('id_perusahaan'),
				'judul_lowongan' => $judul,
				'persayaratan' => $persyaratan,
				'tanggung_jawab' => $tanggung_jawab,
				'gaji' => $gaji,
			);

			$insert = $this->db->update('tbl_lowongan', $data, array('id_lowongan' => $id,));
			if ($insert) {
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Lowongan berhasil diubah","success")</script>');
				redirect('data_lowongan');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Lowongan gagal diubah","error")</script>');
				redirect('data_lowongan');
			}
		}
	}

	function hapus_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lowongan = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_lowongan', array('id_lowongan' => $id_lowongan,));
			if ($del) {
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
		$data['lamaran'] = $this->db->get_where('view_lamaran', 'flag_aktif = "Y" AND flag_berkas = "Y" AND id_perusahaan = "' . $this->session->userdata('id_perusahaan') . '"')->result();
		render('divisi/lamaran', $data);
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

				$this->load->view('divisi/data_pelamar', $data);
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


	function ubahpassword()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$old = $this->input->post('old_pass');
			$new = $this->input->post('new_pass');
			$cek = $this->db->get_where('tbl_perusahaan', 'id_perusahaan = "' . $this->session->userdata('id_perusahaan') . '" AND password = "' . encrypt(md5($old)) . '"');
			if ($cek->num_rows() > 0) {
				$this->db->update('tbl_perusahaan', array('password' => encrypt(md5($new))), array('id_perusahaan' => $this->session->userdata('id_perusahaan'),));
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Password Berhasil Diubah","success")</script>');
				redirect('homediv');
			} else {
				$this->session->set_flashdata('notif', '<script>swal("Opss","Password Lama Salah","warning")</script>');
				redirect('homediv');
			}
		} else {
			http_response_code(404);
		}
	}

	function get_hasil_pelamar()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lowongan = decrypt($this->input->post('arg'));
			$data['kriteria'] = $this->db->get('tbv_kriteria')->result();
			$data['pelamar'] = $this->db->get_where('view_lamaran', 'flag_nilai IN ("S","Y") AND id_lowongan = "' . $id_lowongan . '" AND id_perusahaan = "' . $this->session->userdata('id_perusahaan') . '"')->result();
			$this->load->view('divisi/hasil_saw', $data);
		}
	}

	function terima_pelamar()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$id_lamaran = decrypt($this->input->post('arg'));
			$pelamar = $this->db->get_where('view_lamaran', 'id_lamaran = "' . $id_lamaran . '"')->row();

			$where = array(
				'id_lamaran' => $id_lamaran,
				'id_user' => $pelamar->id_user,
			);

			$data = array(
				'flag_nilai' => 'Y',
			);

			$update = $this->db->update('tbl_lamaran', $data, $where);
			if ($update) {
				$pesan = "
					<h3>Selamat !! </h3>
					Lamaran Anda Di <b>$pelamar->nama_perusahaan - $pelamar->judul_lowongan</b> Diterima✅<br>	
					Anda Akan Dihubungi dari $pelamar->nama_perusahaan Untuk Proses Selanjutnya.
				";

				sendMessage($pesan, $pelamar->email_pelamar);
				echo json_encode(array('result' => 'oke',));
			} else {
				http_response_code(500);
			}
		}
	}
}

/* End of file Divisi.php */
/* Location: ./application/controllers/Divisi.php */