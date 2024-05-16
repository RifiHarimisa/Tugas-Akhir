<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Login Perusahaan</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="<?= asset() ?>vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="<?= asset() ?>vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="<?= asset() ?>vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link
			rel="stylesheet"
			type="text/css"
			href="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.css"
		/>
		<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="<?= asset() ?>vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/style.css" />
		
		<script src="<?= asset() ?>vendors/scripts/core.js"></script>
		<script src="<?= asset() ?>vendors/scripts/script.min.js"></script>
		<script src="<?= asset() ?>vendors/scripts/process.js"></script>
		<script src="<?= asset() ?>vendors/scripts/layout-settings.js"></script>

		<script src="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.all.js"></script>
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="">
						<img src="<?= asset() ?>vendors/images/deskapp-logo.png" alt="" />
					</a>
				</div>
			</div>
		</div>
		<!--  -->
		<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="<?= asset() ?>vendors/images/login-page-img.png" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Login Perusahaan</h2>
								<?php echo $this->session->flashdata('gagal'); ?>
							</div>
							<form action="<?= site_url('authdiv_proc') ?>" method="post" accept-charset="utf-8">
								
								<div class="input-group custom">
									<input type="email" class="form-control form-control-lg" placeholder="Email" name="username" required autocomplate="false">
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg"
										placeholder="**********"
										name="password" required 
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Masuk">
										</div>
										<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373" style="color: rgb(112, 115, 115);">
											ATAU
										</div>
										<div class="input-group mb-0">
											<button type="button" onclick="$('#modal_regis').modal('show')" class="btn btn-outline-primary btn-lg btn-block" href="register.html">Daftar Akun Baru</button>
										</div>
										<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373" style="color: rgb(112, 115, 115);">
											
										</div>
										<div class="input-group mb-0">
											<button type="button" onclick="window.location='<?= site_url('masuk') ?>'" class="btn btn-outline-danger btn-lg btn-block" >Login Pelamar</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- welcome modal start -->
		
		<!-- welcome modal end -->
		<!-- js -->
		
		<div class="modal fade" id="modal_regis">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Daftar Akun Perusahaan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<form id="frm_regis" method="post" accept-charset="utf-8">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									
								</div>
								<div class="col-md-12 form-group">
									<input type="email" id="email" placeholder="Masukan Email" name="email" class="form-control" required>
								</div>
								<div class="col-md-12" id="alert_div" style="display: none;">
									
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
							<button type="submit" id="btnSbmt" class="btn btn-primary">Daftar</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
	<script>
		$('#frm_regis').submit(function(e){
			e.preventDefault();

			$('#alert_div').hide();
			$('#btnSbmt').attr('disabled', '');
			$('#btnSbmt').html('Loading');
			
			$.ajax({
				url: '<?= site_url('regis_perusahaan') ?>',
				type: 'POST',
				dataType: 'json',
				data: $(this).serializeArray(),
				success: function(data, textStatus, xhr)
				{
					if(data.result == 'dup')
					{
						$('#btnSbmt').html('Daftar');
						$('#btnSbmt').removeAttr('disabled');
						$('#alert_div').html(`
							<div class="alert alert-danger" role="alert">
								<strong>Opss!!</strong><br>Email <strong>${$('#email').val()}</strong> sudah digunakan, silakan login
							</div>
						`);
						$('#alert_div').show();
					}
					
					else
					{
						swal({
						   title: "Berhasil",
						   text: `Anda Berhasil Mendaftarkan Akun
						   Silahkan Melakukan Login`,
						   type: "success",
						   buttons: true,
						}).then(function(){
							location.reload();
						});
					}
				},
				error: function(xhr, textStatus, errorThrown)
				{
					swal('error',errorThrown,'error');
				}
			});
			
		});

	</script>
</html>