<div class="col-md-4 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Tambah Riwayat Pendidikan</h4>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?= site_url('simpan_pendidikan') ?>" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label>Jenjang<span style="color: red;">*</span></label>
						<select name="jenjang" class="form-control" required onchange="cek_jenjang($(this).val())">
							<option value="">Pilih</option>
							<?php foreach ($jenjang as $j) { ?>
								<option value="<?= encrypt($j->id_jenjang) ?>"><?= $j->nama_jenjang ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Instansi<span style="color: red;">*</span></label>
						<input type="text" placeholder="Instansi" class="form-control" required name="nama_sekolah">
					</div>
					<div class="form-group" style="display: none;" id="div_jurusan">

					</div>
					<div class="form-group">
						<label>Tanggal Masuk<span style="color: red;">*</span></label>
						<input type="month" class="form-control" required name="tgl_masuk">
					</div>
					<div class="form-group">
						<label>Tanggal Lulus<span style="color: red;">*</span></label>
						<input type="month" class="form-control" required name="tgl_keluar">
					</div>
					<div class="form-group">
						<label>Ijazah<span style="color: red;">*</span></label><br>
						<input type="file" required name="ijazah" accept="image/*" class="input_tmp">
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
					<h4 style="font-size: 18px;">Riwayat Pendidikan</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-hover table-striped dt table-responsive" width="100%" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">
								<center>#</center>
							</th>
							<th width="10%">Jenjang</th>
							<th width="30%">Instansi</th>
							<th width="30%">Jurusan</th>
							<th width="10%">Masuk</th>
							<th width="10%">Keluar</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($pendidikan != null) { ?>
							<?php $no = 1;
							foreach ($pendidikan as $p) { ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $p->nama_jenjang ?></td>
									<td><?= $p->nama_sekolah ?></td>
									<td><?= $p->jurusan ?></td>
									<td><?= date('M Y', strtotime($p->masuk)) ?></td>
									<td><?= date('M Y', strtotime($p->keluar)) ?></td>
									<td>
										<center>
											<a href="javascript:void(0)" onclick="del_pendidikan('<?= encrypt($p->id_pendidikan) ?>')" data-color="#e95959" style="color: rgb(233, 89, 89);"><i style="font-size: 20px;" class="icon-copy dw dw-delete-3"></i></a>
										</center>
									</td>
								</tr>
							<?php $no++;
							} ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	function cek_jenjang(arg) {
		if (arg != '') {
			$.ajax({
				url: '<?= site_url('Api/cek_jenjang') ?>',
				type: 'POST',
				dataType: 'json',
				data: {
					arg: arg
				},
				success: function(data, textStatus, xhr) {
					let html
					if (data.result == 'oke') {
						html = `
							<label>Jurusan<span style="color: red;">*</span></label>
							<input type="text" placeholder="Jurusan" required class="form-control" id="jurusan" name="jurusan">
						`
						$('#div_jurusan').show()
					} else {
						html = '';
						$('#div_jurusan').hide()
					}
					$('#div_jurusan').html(html)
				},
				error: function(xhr, textStatus, errorThrown) {
					swal('error', errorThrown, 'error');
				}
			});
		} else {

			$('#div_jurusan').hide()
			$('#div_jurusan').html('')
		}

	}

	function del_pendidikan(arg) {
		swal({
			title: 'Apakah Anda Ingin Mengapus ?',
			text: "Menghapus Riwayat Pendidikan Ini ?",
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
					url: '<?= site_url('hapus_pendidikan') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						arg: arg
					},
					success: function(data, textStatus, xhr) {
						if (data.result == 'oke') {
							swal({
								title: "Berhasil",
								text: "Data Pendidikan Berhasil Dihapus",
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
							'Gagal Menghapus Divisi',
							'error'
						)
					}
				});

			} else {
				console.log('cancel')
			}
		})
	}

	function compressImage(from_element, to_element) {
		// var inputFile = document.getElementById("input-file");
		var inputFile = from_element;
		var reader = new FileReader();
		reader.onload = function() {
			var img = new Image();
			img.src = reader.result;
			img.onload = function() {
				var canvas = document.createElement("canvas");
				var ctx = canvas.getContext("2d");
				ctx.drawImage(img, 0, 0);

				var MAX_WIDTH = 3000;
				var MAX_HEIGHT = 2000;
				var width = img.width;
				var height = img.height;

				if (width > height) {
					if (width > MAX_WIDTH) {
						height *= MAX_WIDTH / width;
						width = MAX_WIDTH;
					}
				} else {
					if (height > MAX_HEIGHT) {
						width *= MAX_HEIGHT / height;
						height = MAX_HEIGHT;
					}
				}
				canvas.width = width;
				canvas.height = height;
				ctx = canvas.getContext("2d");
				ctx.drawImage(img, 0, 0, width, height);

				var compressedImage = canvas.toDataURL("image/jpeg", 0.5);
				$(to_element).val(compressedImage);
				// console.log(compressedImage);
				// kirimkan compressedImage ke server melalui form
			};
		};

		reader.readAsDataURL(inputFile.files[0]);
	}

	function insertAfter(referenceNode, newNode) {
		referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}
	document.querySelectorAll(".input_tmp").forEach((inputEl) => {
		inputEl.setAttribute("onchange", "compressImage(this,'#" + inputEl.name + "')")
		var new_hidden = document.createElement('input');
		new_hidden.setAttribute('name', inputEl.name);
		new_hidden.setAttribute('id', inputEl.name);
		new_hidden.setAttribute('type', 'hidden');
		insertAfter(inputEl, new_hidden);
	});
</script>