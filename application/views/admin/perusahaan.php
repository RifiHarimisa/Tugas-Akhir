<div class="col-md-12 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;"><?= $title ?></h4>
				</div>
			</div>
			<div class="col-md-12" style="overflow: auto;">
				<table class="table table-striped  dt" style="width: 100%;" width="100%">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th>Nama</th>
							<th>Email</th>
							<th>No Telp</th>
							<th><center>Foto</center></th>
							<th><center>Aksi</center></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($perusahaan != null){ ?>
							<?php $no=1; foreach ($perusahaan as $p){ ?>
								<tr>
									<td><center><?= $no ?></center></td>
									<td><?= $p->nama ?></td>
									<td><?= $p->email ?></td>
									<td><?= $p->no_telp ?></td>
									<td>
										<center>
											<a href="#" data-fancybox="" data-src="<?= asset() ?>vendors/user/<?= $p->foto ?>" title="">
												<img src="<?= asset() ?>vendors/user/<?= $p->foto ?>" alt="" style="width:50px;height:50px;">
											</a>
											<!-- <img src="" alt="" style="width: 50px;height: 50px;"> -->
										</center>
									</td>
									<td>
										<center>
											<?php $per = $this->db->get_where('tbl_perusahaan','id_perusahaan = "'.$p->id_perusahaan.'"')->row(); ?>
											<?php if ($per->flag_aktif == 'V'){ ?>
												<button type="button" class="btn btn-sm btn-primary" onclick="update_user('<?= encrypt($p->id_perusahaan) ?>','<?= encrypt('Y') ?>')"><i class="fa fa-check"></i></button>
											<?php }else{ ?>
												<button type="button" class="btn btn-sm btn-danger" onclick="update_user('<?= encrypt($p->id_perusahaan) ?>','<?= encrypt('V') ?>')"><i class="fa fa-close"></i></button>
											<?php } ?>
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
	function update_user(arg1,arg2)
	{
		$.ajax({
			url: '<?= site_url('update_perusahaan') ?>',
			type: 'POST',
			dataType: 'json',
			data: {arg1:arg1,arg2:arg2},
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
					});
				}
			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
	}
</script>