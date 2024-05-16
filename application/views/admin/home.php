<div class="col-md-12">
	<div class="row pb-10">
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">
							<?php echo $this->db->query('SELECT COUNT(*) AS total FROM tbl_mas_kriteria')->row()->total; ?>
						</div>
						<div class="font-14 text-secondary weight-500">
							Kriteria
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
							<i class="icon-copy dw dw-table"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">
							<?php echo $this->db->query('SELECT COUNT(*) AS total FROM tbl_mas_alternatif')->row()->total; ?>
						</div>
						<div class="font-14 text-secondary weight-500">
							Sub Kriteria
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
							<span class="icon-copy dw dw-table"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">
							<?php echo $this->db->query('SELECT COUNT(*) AS total FROM tbl_user WHERE flag_aktif = "Y"')->row()->total; ?>
						</div>
						<div class="font-14 text-secondary weight-500">
							Pelamar
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon">
							<i class="icon-copy fa fa-users" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">
							<?php echo $this->db->query('SELECT COUNT(*) AS total FROM tbl_perusahaan WHERE flag_aktif = "Y"')->row()->total; ?>
						</div>
						<div class="font-14 text-secondary weight-500">Perusahaan</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#09cc06" style="color: rgb(9, 204, 6);">
							<i class="icon-copy bi bi-building" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12 mb-30">
	<div class="card-box pd-20 height-100-p mb-30">
		<div class="row align-items-center">
			<div class="col-md-4">
				<img src="<?= asset() ?>vendors/images/banner-img.png" alt="" />
			</div>
			<div class="col-md-8">
				<h4 class="font-20 weight-500 mb-10 text-capitalize">
					Selamat Datang
					<div class="weight-600 font-30 text-blue"><?php echo $this->session->userdata('nama'); ?></div>
				</h4>
				<p class="font-18">
					<b>SMKN 1 Tondano</b> Merupakan salah satu sekolah menengah yang berada di Minahasa, provinsi Sulawesi Utara. Adapun Nomor pokok sekolah nasional (NPSN) untuk SMKN 1 TONDANO ini adalah 40100906.
				</p>
			</div>
		</div>
	</div>
</div>
