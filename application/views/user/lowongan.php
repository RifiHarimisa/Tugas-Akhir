<div class="product-list col-md-12">
	<ul class="row">
		<?php if ($lowongan != null){ ?>
			<?php foreach ($lowongan as $l){ ?>
				<li class="col-lg-3">
					<div class="product-box">
						<div class="producct-img">
							<img src="<?= asset() ?>vendors/user/<?= $l->foto ?>" alt="">
						</div>
						<div class="product-caption">
							<h4 style="margin-bottom: 0px;"><a href="#"><?= $l->judul_lowongan ?></a></h4>
							<div class="price" style="font-size: 12px;padding-bottom: 5px;"><?= $l->nama_perusahaan ?></div>
							<div class="price">Rp. <?= format_nomor($l->gaji) ?></div>
							<button type="button" class="btn btn-sm btn-outline-success" onclick="view_detail('<?= encrypt($l->id_lowongan) ?>')"><i class="fa fa-eye"></i> Lihat</button>
							<?php
								$cek = $this->db->get_where('tbl_lamaran', 'id_user = "'.$this->session->userdata('id_user').'" AND id_lowongan = "'.$l->id_lowongan.'" AND flag_nilai != "N"'); 
							?>
							<?php if ($cek->num_rows() > 0){ ?>
								<div class="pb-1">
									<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(215 120 38);background-color: rgb(242 245 231);"><i class="icon-copy dw dw-wall-clock"></i> Anda Sudah Melamar Pekerjaan Ini</span>
								</div>	
							<?php }else{ ?>
								<button type="button" class="btn btn-sm btn-outline-dark" onclick="lamar('<?= encrypt($l->id_lowongan) ?>')"><i class="icon-copy ion-person-add"></i> Lamar</button>
							<?php } ?>
						</div>
					</div>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
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
<script>
	function view_detail(arg)
	{
		$.ajax({
			url: '<?= site_url('detail_lowongan') ?>',
			type: 'POST',
			dataType: 'html',
			data: {arg:arg},
			success: function(data, textStatus, xhr)
			{
				$('#modal-view-body').html(data)
				$('#modal_view').modal('show')
			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}

	function lamar(arg)
	{
		swal({
			title: 'Kirim Lamaran ?',
			text: "Apakah Anda Yakin Melamar Pekerjaan Ini ?",
			type: 'info',
			showCancelButton: true,
			confirmButtonText: 'Ya, Kirim!',
			cancelButtonText: 'Tidak, Batal!',
			confirmButtonClass: 'btn btn-success margin-5',
			cancelButtonClass: 'btn btn-outline-danger margin-5',
			buttonsStyling: false
		}).then(function (e) {
			if (e.value) {
				$.ajax({
					url: '<?= site_url('lamar_lowongan') ?>',
					type: 'POST',
					dataType: 'json',
					data: {arg:arg},
					success: function(data, textStatus, xhr)
					{
						if (data.result == 'oke')
						{
							swal({
							   title: "Berhasil",
							   text: "Data Lowongan Berhasil Dikirim",
							    type: "success",
							   buttons: true,
							}).then(function(){
								location.reload();
							});
						}else if (data.result == 'dup')
						{
							swal({
							   title: "Opss",
							   text: "Anda Sudah Pernah Melamar Pekerjaan Ini",
							    type: "warning",
							   buttons: true,
							}).then(function(){
								location.reload();
							});
						}
					},
					error: function(xhr, textStatus, errorThrown)
					{
						swal('error',errorThrown,'error');
					}
				});
				
			}
			else
			{
				console.log('cancel')
			}
		})

		// $.ajax({
		// 	url: '<?= site_url('lamar_lowongan') ?>',
		// 	type: 'POST',
		// 	dataType: 'json',
		// 	data: {arg:arg},
		// 	success: function(data, textStatus, xhr)
		// 	{
				
		// 	},
		// 	error: function(xhr, textStatus, errorThrown)
		// 	{
		// 		swal('error',errorThrown,'error');
		// 	}
		// });
	}	
</script>