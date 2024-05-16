<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title>Verifikssi</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= asset() ?>vendors/images/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= asset() ?>vendors/images/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= asset() ?>vendors/images/favicon-16x16.png" />

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/style.css" />

	<script src="<?= asset() ?>vendors/scripts/core.js"></script>
	<script src="<?= asset() ?>vendors/scripts/script.min.js"></script>
	<script src="<?= asset() ?>vendors/scripts/process.js"></script>
	<script src="<?= asset() ?>vendors/scripts/layout-settings.js"></script>

	<script src="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.all.js"></script>
	<style type="text/css" media="screen">
		.container {
			padding: 30px;
			background: white;
			border-radius: 20px;
		}
	</style>
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
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
				<div class="col-md-6 col-lg-7" id="rw_pic">
					<img src="<?= asset() ?>vendors/images/login-page-img.png" alt="" />
				</div>
				<?php echo $this->session->flashdata('notif'); ?>
				<div class="col-md-6 col-lg-5" id="form_ver">
					<form id="frm_otp" method="post" accept-charset="utf-8">
						<div class="">
							<div class="alert alert-info" role="alert">
								Silahkan Masukkan <strong>Kode OTP</strong> Yang Telah Dikirim Ke Email Anda
							</div>
						</div>
						<div class="input-group custom">
							<input type="text" class="form-control form-control-lg" placeholder="Kode OTP" name="otp" required autocomplate="false">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="input-group mb-3">
									<input class="btn btn-success btn-lg btn-block" type="submit" value="Verifikasi">
								</div>
								<div class="input-group mb-0">
									<a class="btn btn-outline-primary btn-lg btn-block" href="<?= site_url('keluar') ?>" title="">Keluar</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- welcome modal start -->
	<script>
		$('#frm_otp').submit(function(e) {
			e.preventDefault();
			let datas = $(this).serializeArray();
			$.ajax({
				<?php if ($this->session->userdata('role2') == 'Perusahaan') { ?>
					url: '<?= site_url('verifikasi_perusahaan') ?>',
				<?php } else { ?>
					url: '<?= site_url('verifikasi') ?>',
				<?php } ?>
				type: 'POST',
				dataType: 'html',
				data: datas,
				success: function(data, textStatus, xhr) {
					$('#form_ver').html(data);
				},
				error: function(xhr, textStatus, errorThrown) {
					swal('error', errorThrown, 'error');
				}
			});
		});

		$(document).ready(function() {

		});
	</script>
	<!-- welcome modal end -->
	<!-- js -->

</body>

</html>