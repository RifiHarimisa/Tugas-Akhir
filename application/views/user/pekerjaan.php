<div class="col-md-4 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Tambah Pengalaman Kerja</h4>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?= site_url('simpan_pekerjaan') ?>" method="post" accept-charset="utf-8">
					
					<div class="form-group">
						<label>Nama Perusahaan<span style="color: red;">*</span></label>
						<input type="text" placeholder="Nama  Perusahaan" class="form-control" required name="nama_perusahaan">
					</div>
					<div class="form-group">
						<label>Posisi / Jabatan<span style="color: red;">*</span></label>
						<input type="text" placeholder="Posisi / Jabatan" class="form-control" required name="posisi">
					</div>
					<div class="form-group">
						<label>Tanggal Masuk<span style="color: red;">*</span></label>
						<input type="month"  class="form-control" required name="tgl_masuk">
					</div>
					<div class="form-group">
						<label>Tanggal Keluar<span style="color: red;">*</span></label>
						<input type="month"  class="form-control" required name="tgl_keluar">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="btnSimpan" ><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
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
					<h4 style="font-size: 18px;">Pengalaman Kerja</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-hover table-striped dt table-responsive" width="100%" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th width="50%">Perusahaan</th>
							<th width="20%">Posisi / Jabatan</th>
							<th width="10%">Masuk</th>
							<th width="10%">Keluar</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($pekerjaan != null){ ?>
							<?php $no = 1; foreach ($pekerjaan as $p){ ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $p->nama_perusahaan ?></td>
									<td><?= $p->posisi ?></td>
									<td><?= date('M Y',strtotime($p->masuk)) ?></td>
									<td><?= date('M Y',strtotime($p->keluar)) ?></td>
									<td>
										<center>
											<a href="javascript:void(0)" onclick="del_pendidikan('<?= encrypt($p->id_pengalaman) ?>')" data-color="#e95959" style="color: rgb(233, 89, 89);"><i style="font-size: 20px;"  class="icon-copy dw dw-delete-3"></i></a>
										</center>
									</td>
								</tr>
							<?php $no++; } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>

<script>
	function cek_jenjang(arg)
	{
		if (arg != '')
		{
			$.ajax({
				url: '<?= site_url('Api/cek_jenjang') ?>',
				type: 'POST',
				dataType: 'json',
				data: {arg: arg},
				success: function(data, textStatus, xhr)
				{
					let html
					if (data.result == 'oke')
					{
						html = `
							<label>Jurusan<span style="color: red;">*</span></label>
							<input type="text" placeholder="Jurusan" required class="form-control" id="jurusan" name="jurusan">
						`
						$('#div_jurusan').show()
					}
					else
					{
						html = '';
						$('#div_jurusan').hide()
					}
					$('#div_jurusan').html(html)
				},
				error: function(xhr, textStatus, errorThrown)
				{
					swal('error',errorThrown,'error');
				}
			});
		}
		else
		{

			$('#div_jurusan').hide()
			$('#div_jurusan').html('')
		}
		
	}

	function del_pendidikan(arg)
	{
		swal({
			title: 'Apakah Anda Ingin Mengapus ?',
			text: "Menghapus Pengalamnan Kerja Ini ?",
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
					url: '<?= site_url('hapus_pekerjaan') ?>',
					type: 'POST',
					dataType: 'json',
					data: {arg: arg},
					success: function(data, textStatus, xhr) {
						if (data.result == 'oke')
						{
							swal({
							   title: "Berhasil",
							   text: "Data Pengalaman Kerja Berhasil Dihapus",
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
							'Gagal Menghapus Pengalaman',
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