<div class="col-md-12 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Riwayat Lamaran</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-hover table-striped dt " width="100%" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th width="15%">Pelamar</th>
							<th width="15%">Lowongan</th>
							<th width="15%">Divisi</th>
							<th width="15%">Tgl Lamar</th>
							<th width="10%"><center>Status</center></th>
							<th width="10%"><center>Aksi</center></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($lamaran != null){ ?>
							<?php $no=1; foreach ($lamaran as $l){ ?>
								<tr>
									<?php if ($l->flag_aktif == 'Y'){ ?>
										
										<td><center><?= $no ?></center></td>
									<?php }else{ ?>
										<td><center><?= $no ?></center></td>
									<?php } ?>
									<td><?= $l->nama ?></td>
									<td><?= $l->judul_lowongan ?></td>
									<td><?= $l->nama_divisi ?></td>
									<td><?= date('d/m/Y H:i',strtotime($l->regdate)) ?></td>
									<td>
										<center>
											<?php if ($l->flag_tes == 'Y'){ ?>
												<span class="badge badge-pill badge-success">Lulus</span>
											<?php }else if($l->flag_tes == 'N'){ ?>
												<span class="badge badge-pill badge-warning" style="color: white;">Menunggu</span>
											<?php }else if($l->flag_tes == 'T'){ ?>
												<span class="badge badge-pill badge-danger">Tidak Lulus</span>
											<?php } ?>
										</center>
									</td>
									<td>
										<center>
											<button class="btn btn-sm btn-outline-success" onclick="cek_pemalar(`<?= encrypt($l->id_lamaran) ?>`)"><i class="fa fa-eye"></i> Cek</button>
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

<div class="modal fade" id="modal-pelamar">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Pelamar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body" id="body_pelamar">

			</div>
			<div class="modal-footer">
				<button onclick="$('#body_pelamar').html('')" type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	function cek_pemalar(arg)
	{
		$.ajax({
			url: '<?= site_url('cek_lamaran_div') ?>',
			type: 'POST',
			dataType: 'html',
			data: {arg:arg},
			success: function(data, textStatus, xhr) 
			{
				$('#body_pelamar').html(data)
				$('#modal-pelamar').modal('show')
			},
			error: function(xhr, textStatus, errorThrown)
			{
				swal('error',errorThrown,'error');
			}
		});
		
	}
</script>