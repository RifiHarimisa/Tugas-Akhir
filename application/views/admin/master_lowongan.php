<div class="col-md-12 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Data Lowongan</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-striped table-responsive dt" style="width: 100%;" width="100%">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th width="20%">Perusahaan</th>
							<th width="30%">Lowongan</th>
							<th width="20%">Gaji</th>
							<th width="20%">Tgl Input</th>
							<th width="20%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($lowongan != null){ ?>
							<?php $no=1; foreach ($lowongan as $l){ ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $l->nama_perusahaan ?></td>
									<td><?= $l->judul_lowongan ?></td>
									<td>Rp. <?= format_nomor($l->gaji) ?></td>
									<td><?= date('d/m/Y H:i',strtotime($l->regdate)) ?></td>
									<td>
										<center>
											<?php if ($l->flag_aktif == 'N'){ ?>
												<a href="javascript:void(0)" onclick="acc_lowongan('<?= encrypt($l->id_lowongan) ?>')" class="text-success"><i style="font-size: 20px;"  class="fa fa-check"></i></a>
											<?php } ?>
											<a href="javascript:void(0)" onclick="view_detail('<?= encrypt($l->id_lowongan) ?>')" class="text-dark"><i style="font-size: 20px;"  class="fa fa-eye"></i></a>
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
			url: '<?= site_url('min/detail_lowongan') ?>',
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

	function acc_lowongan(arg)
	{

		$.ajax({
			url: '<?= site_url('min/acc_lowongan') ?>',
			type: 'POST',
			dataType: 'json',
			data: {arg:arg},
			success: function(data, textStatus, xhr)
			{
				if (data.result == 'oke')
				{
					swal({
					   title: "Berhasil",
					   text: "Data Berhasil Diubah",
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