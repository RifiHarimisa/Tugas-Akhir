<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js" integrity="sha512-ajcjI21X2TXh2y3AbYfcyHhyDvkm56bNiwx8vLPPt2l8N3FJ8vM8GwhL+ACNw+I4KagIJUjtjzWILBdaktd5FA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<div class="col-md-8 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Tambah Lowongan Kerja</h4>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?= site_url('div/simpan_lowongan') ?>" method="post" accept-charset="utf-8">

					<div class="form-group">
						<label>Judul Lowongan<span style="color: red;">*</span></label>
						<input type="text" placeholder="Judul Lowongan" class="form-control" required name="judul_lowongan">
					</div>
					<div class="form-group">
						<label>Persyaratan<span style="color: red;">*</span></label>
						<textarea name="persyaratan" class="text-editor form-control border-radius-0"></textarea>
					</div>
					<div class="form-group">
						<label>Tanggung Jawab<span style="color: red;">*</span></label>
						<textarea name="tanggung_jawab" class="text-editor1 form-control border-radius-0"></textarea>
					</div>
					<div class="form-group">
						<label>Gaji<span style="color: red;">*</span></label>
						<input type="number" class="form-control" required name="gaji" min="1000" placeholder="100000000">
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="btnSimpan"><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Lowongan Kerja</h4>
				</div>
			</div>
			<div class="col-md-12" style="width: 100%;overflow: auto;min-height: 100vh;height: 100vh;">
				<div class="list-group">
					<?php if ($lowongan) { ?>
						<?php foreach ($lowongan as $l) { ?>
							<div class="list-group-item list-group-item-action flex-column align-items-start">

								<h5 class="mb-1 h5 "><?= $l->judul_lowongan ?></h5>
								<div class="pb-1">
									<small class="weight-600">Rp. <?= format_nomor($l->gaji) ?></small>
								</div>

								<small class="mt-0" style="font-size: 10px;"><?= date('d/m/Y H:i', strtotime($l->regdate)) ?></small>
								<br>

								<!-- <button type="button" class="btn btn-sm btn-primary mt-2" onclick="alert(1)">Lihat</button> -->
								<button type="button" class="btn btn-sm btn-success mt-2" onclick="view_detail('<?= encrypt($l->id_lowongan) ?>')"><i class="icon-copy dw dw-view"></i> Lihat</button>
								<button type="button" class="btn btn-sm btn-outline-warning mt-2" onclick="edit_lowongan('<?= encrypt($l->id_lowongan) ?>')"><i class="icon-copy dw dw-edit"></i> Edit</button>
								<button type="button" class="btn btn-sm btn btn-outline-danger mt-2" onclick="hapus_lowongan('<?= encrypt($l->id_lowongan) ?>')"><i class="icon-copy dw dw-trash"></i> Hapus</button>
								<?php if ($l->flag_aktif == 'N') { ?>
									<div class="pb-1">
										<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(215 120 38);background-color: rgb(242 245 231);"><i class="icon-copy dw dw-wall-clock"></i> Menunggu Persetujuan Admin</span>
									</div>
								<?php } else { ?>
									<button type="button" class="btn btn-sm btn btn-dark mt-2" onclick="pelamar('<?= encrypt($l->id_lowongan) ?>')"> Pelamar</button>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } else { ?>
						<center>Belum Ada Data Lowongan</center>
					<?php } ?>

				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_view">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Rinci Lowongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body" id="modal-view-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" onclick="$('#modal-view-body').html('')" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_edit">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Lowongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body" id="modal-edit-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" onclick="$('#modal-edit-body').html('')" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_hasil">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hasil Lowongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body" id="modal-hasil-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" onclick="$('#modal-hasil-body').html('')" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('body').addClass('wysihtml5-supported')
	$(".text-editor").wysihtml5();
	$(".text-editor1").wysihtml5();

	function view_detail(arg) {
		$.ajax({
			url: '<?= site_url('div/detail_lowongan') ?>',
			type: 'POST',
			dataType: 'html',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				$('#modal-view-body').html(data)
				$('#modal_view').modal('show')
			},
			error: function(xhr, textStatus, errorThrown) {
				swal('error', errorThrown, 'error');
			}
		});
	}

	function edit_lowongan(arg) {
		$.ajax({
			url: '<?= site_url('div/edit_lowongan') ?>',
			type: 'POST',
			dataType: 'html',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				$('#modal-edit-body').html(data)
				$('#modal_edit').modal('show')
			},
			error: function(xhr, textStatus, errorThrown) {
				swal('error', errorThrown, 'error');
			}
		});
	}

	function hapus_lowongan(arg) {

		swal({
			title: 'Apakah Anda Ingin Mengapus ?',
			text: "Menghapus Lowongan Ini ?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Tidak, Batal!',
			confirmButtonClass: 'btn btn-success margin-5',
			cancelButtonClass: 'btn btn-danger margin-5',
			buttonsStyling: false
		}).then(function(e) {
			if (e.value) {
				$.ajax({
					url: '<?= site_url('div/hapus_lowongan') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						arg: arg
					},
					success: function(data, textStatus, xhr) {
						if (data.result == 'oke') {
							swal({
								title: "Berhasil",
								text: "Data Lowongan Berhasil Dihapus",
								type: "success",
								buttons: true,
							}).then(function() {
								location.reload();
							});
						}
					},
					error: function(xhr, textStatus, errorThrown) {
						swal('error', errorThrown, 'error');
					}
				});

			} else {
				console.log('cancel')
			}
		})


	}

	function pelamar(arg) {
		$.ajax({
			url: '<?= site_url('hasil_pelamar') ?>',
			type: 'POST',
			dataType: 'html',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				$('#modal-hasil-body').html(data)
				$('#modal_hasil').modal('show')
			},
			error: function(xhr, textStatus, errorThrown) {
				swal('error', errorThrown, 'error');
			}
		});
	}
</script>