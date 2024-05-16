<div class="col-md-4 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Tambah Data Divisi</h4>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?= site_url('tambah-divisi') ?>" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label>Nama Divisi<span style="color: red;">*</span></label>
						<input type="text" placeholder="Nama Divisi" class="form-control" required name="divisi">
					</div>
					<div class="form-group">
						<label>Alamat Email<span style="color: red;">*</span></label>
						<input type="email" placeholder="Alamat Email" class="form-control" required name="email">
					</div>
					<div class="form-group">
						<label>No.Telp<span style="color: red;">*</span></label>
						<input type="text" placeholder="08xxxxxxx" class="form-control" required name="notelp">
					</div>
					
					<div class="form-group">
						<hr>
					</div>
					<div class="form-group">
						<label>Username<span style="color: red;">*</span></label>
						<input type="text" placeholder="Username" class="form-control" onchange="cek_username($(this).val())" required name="username">
					</div>
					<div class="form-group" id="alert_cek" style="display: none;">
						
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="btnSimpan" disabled=""><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
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
					<h4 style="font-size: 18px;">Data Divisi</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-striped table-responsive table-hover dt" style="width: 100%;">
					<thead>
						<tr>
							<th width="5%"><center>#</center></th>
							<th width="30%">Nama Divisi</th>
							<th>Email</th>
							<th>No.Telp</th>
							<th width="15%"><center>Aksi</center></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($divisi != null){ ?>
							<?php $no=1; foreach ($divisi as $d){ ?>
								<tr>
									<td><center><?= $no ?></center></td>
									<td><?= $d->nama_divisi ?></td>
									<td><?= $d->email_divisi ?></td>
									<td><?= $d->no_telp ?></td>
									<td>
										<center>
											<a href="#" onclick="del_divisi('<?= encrypt($d->id_divisi) ?>')" data-color="#e95959" style="color: rgb(233, 89, 89);"><i style="font-size: 20px;"  class="icon-copy dw dw-delete-3"></i></a>
										</center>
									</td>
								</tr>
							<?php $no++;} ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>

<script>
	function cek_username(arg)
	{
		if (arg != '') {
			$.ajax({
				url: '<?= site_url('cekusername') ?>',
				type: 'POST',
				dataType: 'json',
				data: {arg: arg},
				success: function(data, textStatus, xhr) {
				//called when successful
					if (data.result == 'oke')
					{
						$('#btnSimpan').removeAttr('disabled');
						$('#alert_cek').html(`
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								Username : <strong>${arg}</strong> dapat digunakan
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						`);
					}
					else
					{
						$('#btnSimpan').attr('disabled', '');
						$('#alert_cek').html(`
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								Username : <strong>${arg}</strong> tidak dapat digunakan
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						`);
					}
					$('#alert_cek').show();

				},
				error: function(xhr, textStatus, errorThrown) {
					$('#alert_cek').hide();
					swal('error',errorThrown,'error')
				}
			});
		} else {
			$('#btnSimpan').attr('disabled', '');
		}
		
	}

	function del_divisi(arg)
	{
		swal({
			title: 'Apakah Anda Ingin Mengapus ?',
			text: "Menghapus Divisi Ini Dapat Menghapus Lowongan Yang Terkait",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Tidak, Batal!',
			confirmButtonClass: 'btn btn-success margin-5',
			cancelButtonClass: 'btn btn-danger margin-5',
			buttonsStyling: false
		}).then(function (e) {
			if (e.value) {
				$.ajax({
					url: '<?= site_url('hapusdivisi') ?>',
					type: 'POST',
					dataType: 'json',
					data: {arg: arg},
					success: function(data, textStatus, xhr) {
						if (data.result == 'oke')
						{
							swal({
							   title: "Berhasil",
							   text: "Data Divisi Berhasil Dihapus",
							    type: "success",
							   buttons: true,
							}).then(function(){
								location.reload();
							});
						}
					},
					error: function(xhr, textStatus, errorThrown)
					{
						swal(
							'Opss',
							'Gagal Menghapus Divisi',
							'error'
						)
					}
				});
				
			}
			else
			{
				console.log('cancel')
			}
		})
	}

</script>