<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginAdmin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('role') != 'Admin')
		{
			$this->load->view('login_admin');
		}
		else
		{
			$not = '
				<script>
					swal({
						type: "success",
						title: "Selamat Datang Kembali <br>'.$this->session->userdata('nama').'",
						text: "Tanggal '.date('d/m/Y').'",
						icon: "success",
						confirmButtonText: "Tutup"
					})

				</script>';
			$this->session->set_flashdata('notif', $not);
			redirect('homemin');
		}
	}

	function proses_login()
	{
		if ($this->session->userdata('is_login') != true)
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST')
			{
				$salah = '<script>
				swal({
						type: "error",
						title: "Ops",
						text: "Username & Password Salah, atau anda tidak terdaftar!",
						icon: "error",
						confirmButtonText: "Tutup"
					})

				</script>';

				$username = $this->input->post('username');
				$password = $this->input->post('password');


				$where = array(
					'username' =>$username,
					'password' =>encrypt(md5($password)),  
					'flag_aktif' => 'Y'  
				);

				$status = array(
					'lastlogin' =>  date('Y-m-d H:i:s'),
				);

				$cek = $this->db->get_where('tbl_admin',$where);
				if ($cek->num_rows() > 0)
				{
					$cs = $cek->row();
					$pr = $this->db->get_where('tbl_profile_admin','id_admin = "'.$cs->id_admin.'"')->row();

					$welcome = '
						<script>
							swal({
								type: "success",
								title: "Selamat Datang <br>'.$pr->nama.'",
								text: "Tanggal '.date('d/m/Y').'",
								icon: "success",
								confirmButtonText: "Tutup"
							})

						</script>'; 

					$data_session = array(
						'is_login' => true,
						'id_admin' => $cs->id_admin,
						'id_telegram' => $pr->id_telegram,
						'username' => $cs->username,
						'nama' => $pr->nama,
						'lastlogin' => $cs->lastlogin,
						'foto' => $pr->foto_admin,
						'role' => 'Admin'
					);

					$this->db->update('tbl_admin', $status, $where);
					$this->session->set_userdata($data_session);
					$this->session->set_flashdata('notif', $welcome);
					redirect('homemin');
				}
				else
				{
					$this->session->set_flashdata('gagal', $salah);
					redirect('authmin');
				}
			}
			else
			{
				http_response_code(404);
			}
		}
		else
		{
			$not = '
				<script>
					swal({
						type: "success",
						title: "Selamat Datang Kembali <br>'.$this->session->userdata('nama').'",
						text: "Tanggal '.date('d/m/Y').'",
						icon: "success",
						confirmButtonText: "Tutup"
					})

				</script>'; 
			$this->session->set_flashdata('notif', $not);
			redirect('homemin');
		}
	}


	function t()
	{
		echo encrypt(md5(1234));
	}


}

/* End of file LoginAdmin.php */
/* Location: ./application/controllers/LoginAdmin.php */