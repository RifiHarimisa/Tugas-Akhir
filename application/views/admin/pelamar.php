<script src="<?= asset() ?>vendors/scripts/xlsx.full.min.js" type="text/javascript" charset="utf-8" ></script>
<div class="col-md-12 mb-30">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Data Pelamar</h4>
					<br>
					<button type="button" onclick="ExportToExcel('xlsx','resume')" class="btn btn-sm btn-success">Export Excel</button>
				</div>
			</div>
			<div class="col-md-12" style="overflow: auto;">
				<table class="table table-striped data-table-export dt" style="width: 100%;" width="100%">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th>Nama</th>
							<th>Email</th>
							<th>No Telp</th>
							<th><center>Foto</center></th>
							<th><center>Ijazah</center></th>
							<th><center>Angkatan</center></th>
							<th><center>Aksi</center></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($pelamar != null){ ?>
							<?php $no=1; foreach ($pelamar as $p){ ?>
								<tr>
									<td><center><?= $no ?></center></td>
									<td><?= $p->nama ?></td>
									<td><?= $p->email ?></td>
									<td><?= $p->no_telp ?></td>
									<td>
										<center>
											<a href="#" data-fancybox="" data-src="<?= asset() ?>vendors/user/<?= $p->foto_profile ?>" title="">
												<img src="<?= asset() ?>vendors/user/<?= $p->foto_profile ?>" alt="" style="width:50px;height:50px;">
											</a>
											<!-- <img src="" alt="" style="width: 50px;height: 50px;"> -->
										</center>
									</td>
									<td>
										<center>
											<a href="#" data-fancybox="" data-src="<?= asset() ?>vendors/user/<?= $p->foto_ijazah ?>" title="">
												<img src="<?= asset() ?>vendors/user/<?= $p->foto_ijazah ?>" alt="" style="width:50px;height:50px;">
											</a>
										</center>
									</td>
									<td><center><?= $p->angkatan ?></center></td>
									<td>
										<center>
											<?php $user = $this->db->get_where('tbl_user','id_user = "'.$p->id_user.'"')->row(); ?>
											<?php if ($user->flag_aktif == 'V'){ ?>
												<button type="button" class="btn btn-sm btn-primary" onclick="update_user('<?= encrypt($p->id_user) ?>','<?= encrypt('Y') ?>')"><i class="fa fa-check"></i></button>
											<?php }else{ ?>
												<button type="button" class="btn btn-sm btn-danger" onclick="update_user('<?= encrypt($p->id_user) ?>','<?= encrypt('V') ?>')"><i class="fa fa-close"></i></button>
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
<table style="display: none;" id="resume">
	<thead>
		<tr>
			<th width="10%"><center>#</center></th>
			<th>Nama</th>
			<th>Email</th>
			<th>No Telp</th>
			<th>Angkatan</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($pelamar != null){ ?>
			<?php $no=1; foreach ($pelamar as $p){ ?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $p->nama ?></td>
					<td><?= $p->email ?></td>
					<td>'<?= $p->no_telp ?></td>
					<td><?= $p->angkatan ?></td>
				</tr>
			<?php $no++;} ?>
		<?php } ?>
	</tbody>
</table>
<script>
	function update_user(arg1,arg2)
	{
		$.ajax({
			url: '<?= site_url('update_pelamar') ?>',
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

	function ExportToExcel(type,id, fn, dl) {
        var elt = document.getElementById(id);
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('Data Pelamar.' + (type || 'xlsx')));
    }
	
</script>