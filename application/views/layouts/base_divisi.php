<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title> <?= $title ?></title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= asset() ?>vendors/images/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= asset() ?>vendors/images/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= asset() ?>vendors/images/favicon-16x16.png" />

	<!-- Mobile Specific Metas -->

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>src/plugins/datatables/css/dataTables.bootstrap4.min.css" />

	<link rel="stylesheet" type="text/css" href="<?= asset() ?>src/plugins/datatables/css/responsive.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.css" />
	<link rel="stylesheet" type="text/css" href="<?= asset() ?>vendors/styles/style.css" />




	<!-- js -->
	<script src="<?= asset() ?>vendors/scripts/core.js"></script>
	<script src="<?= asset() ?>vendors/scripts/script.js?<?= encrypt(date('Ymd His')) ?>"></script>
	<script src="<?= asset() ?>vendors/scripts/process.js"></script>
	<!-- <script src="<?= asset() ?>vendors/scripts/layout-settings.js"></script> -->


	<script src="<?= asset() ?>src/plugins/sweetalert2/sweetalert2.all.js"></script>
	<script src="<?= asset() ?>src/plugins/apexcharts/apexcharts.min.js"></script>

	<script src="<?= asset() ?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?= asset() ?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= asset() ?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="<?= asset() ?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<style type="text/css" media="screen">
		.page-link {
			color: #0e0081;
		}
	</style>
</head>

<body>

	<div class="header">
		<div class="header-left">
			<div class="menu-icon bi bi-list"></div>


		</div>
		<div class="header-right">


			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="<?= asset() ?>vendors/user/<?= $this->session->userdata('foto') ?>" alt="" style="width: 100%;height: 100%;" />
						</span>
						<span class="user-name"><?php echo $this->session->userdata('nama'); ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-password').modal('show')">
							<i class="icon-copy dw dw-password"></i> Ubah Password
						</a>
						<a class="dropdown-item" href="<?php echo site_url('outdiv') ?>">
							<i class="dw dw-logout"></i> Log Out
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>



	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="<?php echo site_url('home') ?>">
				<img src="<?= asset() ?>vendors/images/deskapp-logo.png" alt="" class="dark-logo" />
				<img src="<?= asset() ?>vendors/images/deskapp-logo-white.png" alt="" class="light-logo" />
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li>
						<a href="<?php echo site_url('homediv') ?>" class="dropdown-toggle no-arrow">
							<span class="micon bi bi-house"></span><span class="mtext">Home</span>
						</a>
					</li>
					<!-- <li>
							<a href="<?php echo site_url('myprofile') ?>" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-user"></span
								><span class="mtext">Profile</span>
							</a>
						</li> -->

					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon icon-copy ion-ios-briefcase"></span><span class="mtext">Lowongan</span>
						</a>
						<ul class="submenu">
							<li><a href="<?= site_url('data_lowongan') ?>">Data Lowongan</a></li>
							<!-- <li><a href="<?= site_url('m-lamaran-div') ?>">Pelamar</a></li> -->
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="row">
				<?php echo $this->session->flashdata('notif'); ?>
				<?php $this->load->view($content); ?>
			</div>

		</div>
	</div>
	<!-- welcome modal start -->

	<div class="modal fade" id="modal-password">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ubah Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?php echo site_url('ubahpassword_divisi') ?>" method="post" accept-charset="utf-8">
					<div class="modal-body">
						<div class="form-group">
							<label>Password Lama</label>
							<input type="password" class="form-control" placeholder="**********" required name="old_pass">
						</div>
						<div class="form-group">
							<label>Password Baru</label>
							<input type="password" class="form-control" placeholder="**********" required name="new_pass">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Keluar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<script>
		// 
		$('document').ready(function() {

			$('.dt').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"lengthMenu": [
					[10, 25, 50],
					[10, 25, 50]
				],
				"language": {
					"url": "<?= asset() ?>src/plugins/datatables/js/id.json",
					"info": "_START_-_END_ of _TOTAL_ entries",
					searchPlaceholder: "Cari",
					// paginate: {
					// 	next: '<i class="ion-chevron-right"></i>',
					// 	previous: '<i class="ion-chevron-left"></i>'  
					// }
				},
			});
		});
	</script>
</body>

</html>