<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginDivisi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_login') == true AND $this->session->userdata('role') == 'Perusahaan')
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
			redirect('home');
		}
	}

	public function index()
	{
		if ($this->session->userdata('is_login') != true AND $this->session->userdata('role') != 'Perusahaan')
		{
			$this->load->view('login_divisi');
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
			redirect('home');
		}
	}

	function proses_login()
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

			$cek = $this->db->get_where('tbl_perusahaan','(username = "'.$username.'") AND password = "'.encrypt(md5($password)).'" AND flag_aktif IN ("Y","V")');
			if ($cek->num_rows() > 0)
			{
				$cs = $cek->row();
				$pr = $this->db->get_where('tbl_profile_perusahaan','id_perusahaan = "'.$cs->id_perusahaan.'"')->row();

				if ($cs->flag_otp == 'Y')
				{
					$welcome = '
					<script>
						swal({
							type: "success",
							title: "Selamat Datang <br> Silakan Melakukan Verifikasi Akun dan Mengisi Data Perusahaan",
							text: "Tanggal '.date('d/m/Y').'",
							icon: "success",
							confirmButtonText: "Tutup"
						})

					</script>';
					$data_session = array(
						'is_login' => false,
						'id_perusahaan' => $cs->id_perusahaan,
						'email' => $pr->email,
						'username' => $cs->username,
						'lastlogin' => $cs->lastlogin,
						'role' => 'Verifikasi',
						'role2' => 'Perusahaan'
					);
					$this->session->set_userdata($data_session);
					$this->session->set_flashdata('notif', $welcome);
					redirect('verifikasi');
				}
				else if($cs->flag_aktif == 'V')
				{
					$welcome = '
					<script>
						swal({
							type: "info",
							title: "Info",
							text: "Silahkan menunggu persetujuan admin",
							icon: "warning",
							confirmButtonText: "Tutup"
						})

					</script>';
					$this->session->set_flashdata('gagal', $welcome);
					redirect('authdiv');
				}
				else
				{
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
						'id_perusahaan' => $cs->id_perusahaan,
						'email' => $pr->email,
						'username' => $cs->username,
						'nama' => $pr->nama,
						'lastlogin' => $cs->lastlogin,
						'foto' => $pr->foto,
						'role' => 'Perusahaan'
					);

					$this->db->update('tbl_perusahaan', $status, $where);
					$this->session->set_userdata($data_session);
					$this->session->set_flashdata('notif', $welcome);
					redirect('homediv');
				}
			}
			else
			{
				$this->session->set_flashdata('gagal', $salah);
				redirect('authdiv');
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function simpan_akun()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$email_admin = $this->db->get('tbl_profile_admin')->result();
			$id_perusahaan = $this->session->userdata('id_perusahaan');
			$nama = $this->input->post('nama');
			$no_telp = $this->input->post('no_telp');

			$foto = foto_upload64($this->input->post('foto'),str_replace(' ', '_', $nama));
			// echo $foto;

			$data = array(
				'nama' => $nama,  
				'no_telp' => $no_telp, 
				'foto' => $foto, 
			);

			$where = array('id_perusahaan' => $id_perusahaan,);


			$update = $this->db->update('tbl_profile_perusahaan', $data,$where);
			if ($update)
			{
				$this->db->update('tbl_perusahaan',array(
					'flag_otp' => 'N',
					'lastotp' => '',
					'flag_aktif' => 'V',
				),$where);
				foreach ($email_admin as $ea)
				{
					sendMessage("Perusahan Baru Berhasil Mendaftar<br>Nama = $nama",$ea->email);
				}
				echo json_encode(array('result' => 'oke',));
			}
			else
			{
				echo json_encode(array('result' => 'gagal',));

			}
		}
	}


	function verifikasi()
	{
		if ($this->session->userdata('role') == 'Verifikasi' AND $this->input->server('REQUEST_METHOD') == 'GET')
		{
			$this->load->view('verifikasi');
		}
		else if($this->session->userdata('role') == 'Verifikasi' AND $this->input->server('REQUEST_METHOD') == 'POST')
		{
			$otp = $this->input->post('otp');
			$where = array(
				'username' => $this->session->userdata('username'), 
				'id_perusahaan' => $this->session->userdata('id_perusahaan'), 
				'lastotp' => $otp, 
				'flag_otp' => 'Y' 
			);
			$cek = $this->db->get_where('tbl_perusahaan', $where);
			if ($cek->num_rows() > 0)
			{
				//true
				$data['otp'] = $otp;
				$this->load->view('profile_perusahaan',$data);
			}
			else
			{
				//false
				echo '<div class="alert alert-danger" role="alert">
					<strong>Kode OPT Salah</strong><br><a href="" title="">Klik Disini</a> Untuk Kembali
				</div>';
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('authdiv');
	}

	function cek_email()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$email = $this->input->post('idtel');
			$cek = $this->db->get_where('tbl_profile_user','email = "'.$email.'"');
			if ($cek->num_rows() > 0)
			{
				echo json_encode(array('result' => 'dup',));
			}
			else
			{
				echo json_encode(array('result' => 'oke',));
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function register($value='')
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$email = $this->input->post('email');
			$cek = $this->db->get_where('tbl_profile_perusahaan','email = "'.$email.'"');
			if ($cek->num_rows() > 0)
			{
				echo json_encode(array('result' => 'dup',));
			}
			else
			{
				$pass = generatePassword();
				$password = encrypt(md5($pass));
				$otp = gen_otp();

				$pesan = "
					Anda Berhasil Mendaftar Di Aplikasi<br>	
					Username = ".$email."<br>
					Password = ".$pass."<br>
					Kode OTP = ".$otp."<br>
					Setelah Login Silahkan Mengubah Password Anda<br>
					";
				$res = sendMessage($pesan,$email);
				if ($res)
				{
					$data_insert = array(
						'username' => $email, 
						'password' => $password, 
						'lastotp' => $otp, 
					);
					$insert = $this->db->insert('tbl_perusahaan', $data_insert);
					if ($insert)
					{	
						echo json_encode(array('result' => 'oke',));
					}
					else
					{
						http_response_code(500);
					}
				}
				else
				{
					http_response_code(201);
					echo json_encode(array('result' => 'not_id',));
				}
			}
		}
		else
		{
			http_response_code(404);
		}
	}

}

/* End of file LoginDivisi.php */
/* Location: ./application/controllers/LoginDivisi.php */