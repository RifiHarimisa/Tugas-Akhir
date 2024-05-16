<form id="sprofile" accept-charset="utf-8">
	<div class="row">
		<div class="col-md-12 mb-30">
			<div class="title">
				<h4 style="font-size: 18px;">Data Pribadi</h4>
			</div>
		</div>
		<div class="form-group col-md-6">
			<label>NIK<span style="color: red;">*</span></label>
			<input type="number" class="form-control" required name="nik" placeholder="Nomor Induk Kependudukan">
		</div>
		<div class="form-group col-md-6">
			<label>Nama Lengkap<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="nama" placeholder="Nama Lengkap">
		</div>
		<div class="form-group col-md-3">
			<label>Tempat Lahir<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="tmpt_lahir" placeholder="Tempat">
		</div>
		<div class="form-group col-md-3">
			<label>Tanggal Lahir<span style="color: red;">*</span></label>
			<input type="date" class="form-control" required name="tgl_lahir">
		</div>
		<div class="form-group col-md-3">
			<label>Status<span style="color: red;">*</span></label>
			<select name="status" class="form-control" required>
				<option value="">Pilih</option>
				<option value="Belum Menikah">Belum Menikah</option>
				<option value="Menikah">Menikah</option>
				<option value="Janda/Duda">Janda/Duda</option>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label>Tahun Angkatan<span style="color: red;">*</span></label>
			<input type="number" class="form-control" required placeholder="2012" name="angkatan">
		</div>
		<div class="form-group col-md-6">
			<label>Email<span style="color: red;">*</span></label>
			<input type="email" value="<?php echo $this->session->userdata('username') ?>" disabled="" class="form-control" placeholder="example@example.com" name="email">
		</div>
		<div class="form-group col-md-6">
			<label>No Telp<span style="color: red;">*</span></label>
			<input type="number" class="form-control" required placeholder="08xxxxxxxxxx" name="no_telp">
		</div>
		<div class="form-group col-md-6">
			<label>Foto</label><br>
			<input type="file" required name="foto" accept="image/*" class="input_tmp" >
		</div>
		<div class="form-group col-md-6">
			<label>Ijazah SMK</label><br>
			<input type="file" required name="ijazah" accept="image/*" class="input_tmp" >
		</div>

		<div class="col-md-12 mb-20 mt-20">
			<div class="title">
				<h4 style="font-size: 18px;">Alamat</h4>
			</div>
		</div>
		
		<?php
			$provinsi = $this->db->get('tbl_provinsi')->result();
		?>
		<div class="form-group col-md-6">
			<label>Provinsi<span style="color: red;">*</span></label>
			<select name="prov" id="prov" class="form-control sl2" required onchange="chge_prov($(this).val())">
				<option value=""></option>
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
			<input type="number" name="ling" min="0" placeholder="Lingkungan/Jaga" class="form-control" required id="ling">
		</div>
		<!-- <div class="col-md-12 mb-20 mt-20">
			<div class="title">
				<h4 style="font-size: 18px;">Informasi Akun</h4>
			</div>
		</div>
		<div class="form-group col-md-6">
			<label>Username<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="username" placeholder="Username" value="<?= $this->session->userdata('username'); ?>">
		</div>
		<div class="form-group col-md-3">
			<label>Password Lama<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="old_pass" placeholder="Password Lama">
		</div>
		<div class="form-group col-md-3">
			<label>Password Baru<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="new_pass" placeholder="Password Baru">
		</div> -->
		
		<input type="hidden" name="otp" value="<?= encrypt($otp) ?>">
		<div class="form-group col-md-12 mt-30">
			<button type="submit" class="btn btn-lg btn-success btn-block"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
</form>
<script>
	// $('#rw_pic').remove();
	swal('Berhasil','Silahkan Mengisi Data Pribadi Anda','success');
	$('#rw_pic').removeClass('col-md-6');
	$('#rw_pic').removeClass('col-lg-7');
	$('#rw_pic').addClass('col-md-3');
	$('#form_ver').removeClass('col-md-6');
	$('#form_ver').removeClass('col-lg-5');
	$('#form_ver').addClass('col-md-9');

	$('.sl2').select2({
		placeholder:'Pilih'
	});

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

			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}

	function compressImage(from_element,to_element)
	{
		// var inputFile = document.getElementById("input-file");
		var inputFile = from_element;
		var reader = new FileReader();
		reader.onload = function()
		{
			var img = new Image();
			img.src = reader.result;
			img.onload = function()
			{
				var canvas = document.createElement("canvas");
				var ctx = canvas.getContext("2d");
				ctx.drawImage(img, 0, 0);

				var MAX_WIDTH = 3000;
				var MAX_HEIGHT = 2000;
				var width = img.width;
				var height = img.height;

				if (width > height)
				{
					if (width > MAX_WIDTH)
					{
						height *= MAX_WIDTH / width;
						width = MAX_WIDTH;
					}
				}
				else
				{
					if (height > MAX_HEIGHT)
					{
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
		inputEl.setAttribute("onchange","compressImage(this,'#"+inputEl.name+"')")
		var new_hidden = document.createElement('input');
		new_hidden.setAttribute('name',inputEl.name);
		new_hidden.setAttribute('id',inputEl.name);
		new_hidden.setAttribute('type','hidden');
		insertAfter(inputEl, new_hidden);
	});

	$('#sprofile').submit(function(e) {
		e.preventDefault();
		$.ajax({
			url: '<?= site_url('simpan_akun'); ?>',
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
						window.location='<?= site_url('keluar') ?>'
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