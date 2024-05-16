<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginUser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('is_login') != true AND $this->session->userdata('role') != 'User')
		{
			$this->load->view('login_user');
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
			$cek = $this->db->get_where('tbl_profile_user','email = "'.$email.'"');
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
					$insert = $this->db->insert('tbl_user', $data_insert);
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

	function login()
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

			$cek = $this->db->get_where('tbl_user','(username = "'.$username.'") AND password = "'.encrypt(md5($password)).'" AND flag_aktif IN ("Y","V")');
			if ($cek->num_rows() > 0)
			{
				$cs = $cek->row();
				$pr = $this->db->get_where('tbl_profile_user','id_user = "'.$cs->id_user.'"')->row();

				if ($cs->flag_otp == 'Y')
				{
					$welcome = '
					<script>
						swal({
							type: "success",
							title: "Selamat Datang <br> Silakan Melakukan Verifikasi Akun dan Mengisi Data Diri",
							text: "Tanggal '.date('d/m/Y').'",
							icon: "success",
							confirmButtonText: "Tutup"
						})

					</script>';
					$data_session = array(
						'is_login' => false,
						'id_user' => $cs->id_user,
						'email' => $pr->email,
						'username' => $cs->username,
						'lastlogin' => $cs->lastlogin,
						'role' => 'Verifikasi',
						'role2' => 'User'
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
					redirect('masuk');
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
						'id_user' => $cs->id_user,
						'email' => $pr->email,
						'username' => $cs->username,
						'nama' => $pr->nama,
						'lastlogin' => $cs->lastlogin,
						'foto' => $pr->foto_profile,
						'role' => 'User'
					);

					$this->db->update('tbl_user', $status, $where);
					$this->session->set_userdata($data_session);
					$this->session->set_flashdata('notif', $welcome);
					redirect('home');
				}
			}
			else
			{
				$this->session->set_flashdata('gagal', $salah);
				redirect('masuk');
			}
		}
		else
		{
			http_response_code(404);
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
				'id_user' => $this->session->userdata('id_user'), 
				'lastotp' => $otp, 
				'flag_otp' => 'Y' 
			);
			$cek = $this->db->get_where('tbl_user', $where);
			if ($cek->num_rows() > 0)
			{
				//true
				$data['otp'] = $otp;
				$this->load->view('profile',$data);
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

	function simpan_akun()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$email_admin = $this->db->get('tbl_profile_admin')->result();
			$id_user = $this->session->userdata('id_user');
			$nik = $this->input->post('nik');
			$nama = $this->input->post('nama');
			$tmpt = $this->input->post('tmpt_lahir');
			$tgl = $this->input->post('tgl_lahir');
			$status = $this->input->post('status');
			$id_kelurahan = $this->input->post('kel');
			$lingkungan = $this->input->post('ling');
			$no_telp = $this->input->post('no_telp');
			$angkatan = $this->input->post('angkatan');
			
			$ijazah = foto_upload64($this->input->post('ijazah'),'Ijazah_'.str_replace(' ', '_', $nama));
			
			$foto = foto_upload64($this->input->post('foto'),str_replace(' ', '_', $nama));
			
			// echo $foto;

			$data = array(
				'nik' => $nik, 
				'nama' => $nama, 
				'tmpt_lahir' => $tmpt, 
				'tgl_lahir' => $tgl, 
				'id_kelurahan' => decrypt($id_kelurahan), 
				'lingkungan' => $lingkungan, 
				'status' => $status, 
				'no_telp' => $no_telp, 
				'foto_profile' => $foto, 
				'foto_ijazah' => $ijazah, 
				'angkatan' => $angkatan, 
			);

			$where = array('id_user' => $id_user,);


			$update = $this->db->update('tbl_profile_user', $data,$where);
			if ($update)
			{
				$this->db->update('tbl_user',array(
					'flag_otp' => 'N',
					'lastotp' => '',
					'flag_aktif' => 'V'
				),$where);
				echo json_encode(array('result' => 'oke',));

				sendMessage('Silahkan menunggu persetujuan admin',$this->session->userdata('email'));
				foreach ($email_admin as $ea)
				{
					sendMessage("Pelamar Baru Berhasil Mendaftar<br>Nama = $nama<br>Angkatan = $angkatan<br><br>Silakan Melakukan Verifikasi",$ea->email);
				}
			}
			else
			{
				echo json_encode(array('result' => 'gagal',));

			}
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('masuk');
	}
}

/* End of file LoginUser.php */
/* Location: ./application/controllers/LoginUser.php */