<form id="sprofile" accept-charset="utf-8">
	<div class="row">
		<div class="col-md-12 mb-30">
			<div class="title">
				<h4 style="font-size: 18px;">Data Perusahaan</h4>
			</div>
		</div>
		
		<div class="form-group col-md-12">
			<label>Nama Perusahaan<span style="color: red;">*</span></label>
			<input type="text" class="form-control" required name="nama" placeholder="Nama Perusahaan">
		</div>
		
		<div class="form-group col-md-6">
			<label>Email<span style="color: red;">*</span></label>
			<input type="email" value="<?php echo $this->session->userdata('username') ?>" disabled="" class="form-control" placeholder="example@example.com" name="email">
		</div>
		<div class="form-group col-md-6">
			<label>No Telp<span style="color: red;">*</span></label>
			<input type="number" class="form-control" required placeholder="08xxxxxxxxxx" name="no_telp">
		</div>
		<div class="form-group col-md-12">
			<label>Foto</label><br>
			<input type="file" required name="foto" accept="image/*" class="input_tmp" >
		</div>
		<input type="hidden" name="otp" value="<?= encrypt($otp) ?>">
		<div class="form-group col-md-12 mt-30">
			<button type="submit" class="btn btn-lg btn-success btn-block"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
</form>
<script>
	// $('#rw_pic').remove();
	swal('Berhasil','Silahkan Mengisi Data Perusahaan','success');
	$('#rw_pic').removeClass('col-md-6');
	$('#rw_pic').removeClass('col-lg-7');
	$('#rw_pic').addClass('col-md-3');
	$('#form_ver').removeClass('col-md-6');
	$('#form_ver').removeClass('col-lg-5');
	$('#form_ver').addClass('col-md-9');

	$('.sl2').select2({
		placeholder:'Pilih'
	});

	

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
			url: '<?= site_url('simpan_akun_perusahaan'); ?>',
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
						window.location='<?= site_url('outdiv') ?>'
					});
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