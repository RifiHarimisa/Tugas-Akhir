<div class="col-md-4 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Tambah Sub Kriteria</h4>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?= site_url('simpan-alternatif') ?>" method="post" accept-charset="utf-8">

					<div class="form-group">
						<label>Kriteria<span style="color: red;">*</span></label>
						<select name="kriteria" class="form-control" required>
							<option value="">Pilih</option>
							<?php foreach ($kriteria as $k) { ?>
								<option value="<?= encrypt($k->id_kriteria) ?>"><?= $k->kriteria ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Sub Kriteria<span style="color: red;">*</span></label>
						<input type="text" placeholder="Sub Kriteria" class="form-control" required name="alternatif">
					</div>
					<div class="form-group">
						<label>Bobot<span style="color: red;">*</span></label>
						<input type="number" placeholder="Bobot" class="form-control" required name="bobot">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="btnSimpan"><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="col-md-8 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Sub Kriteria</h4>
				</div>
			</div>
			<div class="col-md-12" style="overflow: auto;">
				<table class="table table-hover table-striped dt" style="width: 100%;">
					<thead>
						<tr>
							<th>
								<center>Kriteria</center>
							</th>
							<th>
								<center>Sub Kriteria</center>
							</th>
							<th>
								<center>Bobot</center>
							</th>
							<th>
								<center>Aksi</center>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($alternatif != null) { ?>
							<?php foreach ($alternatif as $a) { ?>
								<tr>
									<td><?= $a->kriteria ?></td>
									<td><?= $a->alternatif ?></td>
									<td>
										<center><?= $a->bobot_alternatif ?></center>
									</td>
									<td>
										<center>
											<button type="button" class="btn btn-sm btn-warning" style="color: white;" onclick="update_alternatif('<?= encrypt($a->id_alternatif) ?>')"><i class="fa fa-pencil"></i></button>
											<button type="button" class="btn btn-sm btn-danger" style="color: white;" onclick="hapus_kriteria('<?= encrypt($a->id_alternatif) ?>')"><i class="fa fa-trash"></i></button>
										</center>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-edit">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Subkriteria</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<form action="simpan_edit_alternatif" method="post" accept-charset="utf-8">
				<div class="modal-body" id="body-edit">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	function hapus_kriteria(arg) {
		swal({
			title: 'Apakah Anda Ingin Mengapus ?',
			text: "Menghapus Sub Kriteria Ini ?",
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
					url: '<?= site_url('hapus_alternatif') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						arg: arg
					},
					success: function(data, textStatus, xhr) {
						if (data.result == 'oke') {
							swal({
								title: "Berhasil",
								text: "Data Sub Kriteria Berhasil Dihapus",
								type: "success",
								buttons: true,
							}).then(function() {
								location.reload();
							});
						}
					},
					error: function(xhr, textStatus, errorThrown) {
						swal(
							'Opss',
							'Gagal Menghapus Pengalaman',
							'error'
						)
					}
				});

			} else {
				console.log('cancel')
			}
		})
	}

	function update_alternatif(arg) {
		$.ajax({
			url: '<?= site_url('get_edit_alternatif') ?>',
			type: 'POST',
			dataType: 'html',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				$('#body-edit').html(data);
				$('#modal-edit').modal('show')
			},
			error: function(xhr, textStatus, errorThrown) {
				swal(
					'Opss',
					errorThrown,
					'error'
				)
			}
		});
	}
</script>