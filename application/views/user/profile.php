<div class="col-md-12 mb-30">
	<form action="" method="get" accept-charset="utf-8" id="sprofile">
		<div class="card-box" style="padding: 20px;">
			<div class="row">
				<div class="col-md-12 mb-30">
					<div class="title">
						<h4 style="font-size: 18px;">Data Pribadi</h4>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label>NIK<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->nik ?>" type="number" class="form-control" required name="nik" placeholder="Nomor Induk Kependudukan">
				</div>
				<div class="form-group col-md-6">
					<label>Nama Lengkap<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->nama ?>" type="text" class="form-control" required name="nama" placeholder="Nama Lengkap">
				</div>
				<div class="form-group col-md-3">
					<label>Tempat Lahir<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->tmpt_lahir ?>" type="text" class="form-control" required name="tmpt_lahir" placeholder="Tempat">
				</div>
				<div class="form-group col-md-3">
					<label>Tanggal Lahir<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->tgl_lahir ?>" type="date" class="form-control" required name="tgl_lahir">
				</div>
				<div class="form-group col-md-6">
					<label>Status<span style="color: red;">*</span></label>
					<select name="status" class="form-control" required>
						<option value="<?= $pribadi->status ?>"><?= $pribadi->status ?></option>
						<option value="Belum Menikah">Belum Menikah</option>
						<option value="Menikah">Menikah</option>
						<option value="Janda/Duda">Janda/Duda</option>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label>Email<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->email ?>" type="email" class="form-control" placeholder="example@example.com" required name="email">
				</div>
				<div class="form-group col-md-6">
					<label>No Telp<span style="color: red;">*</span></label>
					<input value="<?= $pribadi->no_telp ?>" type="number" class="form-control" required placeholder="08xxxxxxxxxx" name="no_telp">
				</div>
				<!--  -->
				<div class="col-md-12 mb-20 mt-20">
					<div class="title">
						<h4 style="font-size: 18px;">Alamat</h4>
					</div>
				</div>
				<?php
					$provinsi = $this->db->get_where('tbl_provinsi','id_provinsi != "'.$pribadi->id_provinsi.'"')->result();
				?>
				<div class="form-group col-md-6">
					<label>Provinsi<span style="color: red;">*</span></label>
					<select name="prov" id="prov" class="form-control sl2" required onchange="chge_prov($(this).val())">
						<option value="<?= encrypt($pribadi->id_provinsi) ?>"><?= $pribadi->nama_provinsi ?></option>
						<?php foreach ($provinsi as $p){ ?>
							<option value="<?= encrypt($p->id_provinsi) ?>"><?= $p->nama_provinsi ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label>Kabupaten/Kota<span style="color: red;">*</span></label>
					<select name="kota" disabled="" class="form-control sl2" id="kota" onchange="chge_kota($(this).val())" required>
						
					</select>
				</div>
				<div class="form-group col-md-6">
					<label>Kecamatan<span style="color: red;">*</span></label>
					<select name="kec" disabled="" class="form-control sl2" id="kec" onchange="chge_kec($(this).val())" required>
						
					</select>
				</div>
				<div class="form-group col-md-3">
					<label>Desa/Kelurahan<span style="color: red;">*</span></label>
					<select name="kel" disabled="" class="form-control sl2" id="kel" required>
						
					</select>
				</div>
				<div class="form-group col-md-3">
					<label>Lingkungan<span style="color: red;">*</span></label>
					<input type="number" name="ling" min="0" placeholder="Lingkungan/Jaga" class="form-control" required id="ling" value="<?= $pribadi->lingkungan ?>">
				</div>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-block btn-primary"><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	chge_prov('<?= encrypt($pribadi->id_provinsi) ?>')
	
	// chge_kota('<?= encrypt($pribadi->id_kota) ?>')
	// chge_kec('<?= encrypt($pribadi->id_kecamatan) ?>')
	// $('#kec').find(`option[value|='<?= encrypt($pribadi->id_kecamatan) ?>']`).attr('selected','');
	// console.log($('#kec').find(`option[value|='<?= encrypt($pribadi->id_kecamatan) ?>']`));
	function chge_prov(arg)
	{
		$('#kota').html('');
		$('#kota').attr('disabled', '');

		$('#kec').html('');
		$('#kec').attr('disabled', '');

		$('#kel').html('');
		$('#kel').attr('disabled', '');

		$.ajax({
			url: '<?= site_url('Api/get_kota') ?>',
			type: 'POST',
			dataType: 'html',
			data: {arg: arg},
			success: function(data, textStatus, xhr)
			{
				$('#kota').html(data);
				$('#kota').removeAttr('disabled');
				$("#kota").val('<?= encrypt($pribadi->id_kota) ?>').trigger('change');
				// select2('data', { id:"<?= encrypt($pribadi->id_kota) ?>", text: "<?= ($pribadi->nama_kota) ?>"});
				

			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}

	function chge_kota(arg)
	{

		$('#kec').html('');
		$('#kec').attr('disabled', '');

		$('#kel').html('');
		$('#kel').attr('disabled', '');

		$.ajax({
			url: '<?= site_url('Api/get_kec') ?>',
			type: 'POST',
			dataType: 'html',
			data: {arg: arg},
			success: function(data, textStatus, xhr)
			{
				$('#kec').html(data);
				$('#kec').removeAttr('disabled');
				$("#kec").val('<?= encrypt($pribadi->id_kecamatan) ?>').trigger('change');
				// $('#kec').val('<?= encrypt($pribadi->id_kecamatan) ?>')
			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}

	function chge_kec(arg)
	{
		$('#kel').html('');
		$('#kel').attr('disabled', '');

		$.ajax({
			url: '<?= site_url('Api/get_kel') ?>',
			type: 'POST',
			dataType: 'html',
			data: {arg: arg},
			success: function(data, textStatus, xhr)
			{
				$('#kel').html(data);
				$('#kel').removeAttr('disabled');
				$("#kel").val('<?= encrypt($pribadi->id_kelurahan) ?>').trigger('change');

			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}
	$('.sl2').select2({
		placeholder:'Pilih'
	});
	$('#sprofile').submit(function(e) {
		e.preventDefault();
		$.ajax({
			url: '<?= site_url('simpan_pribadi'); ?>',
			type: 'POST',
			dataType: 'json',
			data: $(this).serializeArray(),
			success: function(data, textStatus, xhr)
			{
				if (data.result == 'oke')
				{
					swal({
					   title: "Berhasil",
					   text: "Data Berhasil Disimpan",
					    type: "success",
					   buttons: true,
					}).then(function(){
						location.reload();
						// window.location='<?= site_url('keluar') ?>'
					});
				}
				else if(data.result == 'dup')
				{
					swal('Info','NIK Telah Digunakan Akun Lain','warning')
				}
				else
				{
					swal('error','Terjadi Masalah','error')
				}
			},
			error: function(xhr, textStatus, errorThrown) {
			//called when there is an error
			}
		});
		
	});
</script>