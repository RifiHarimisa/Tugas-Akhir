<div class="row">
	<div class="col-md-12" style="overflow: auto;">
		<b>A. Kriteria</b>
		<table class="table table-bordered" style="width: 100%;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>Keterangan</th>
					<?php foreach ($kriteria as $k) { ?>
						<th>
							<center><?= $k->kriteria ?></center>
						</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<center>Bobot</center>
					</td>
					<?php foreach ($kriteria as $k) { ?>
						<td>
							<center><?= $k->Bobot ?></center>
						</td>
					<?php } ?>
				</tr>
				<tr>
					<td>
						<center>Kepentingan</center>
					</td>
					<?php foreach ($kriteria as $k) { ?>
						<?php $kepentingan[$k->id_kriteria] = (float)$k->kepentingan ?>
						<td>
							<center><?= round($k->kepentingan, 2) ?></center>
						</td>
					<?php } ?>
				</tr>
				<tr>
					<td>
						<center>Atribut</center>
					</td>
					<?php foreach ($kriteria as $k) { ?>
						<td>
							<center><?= $k->atribut ?></center>
						</td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-12" style="overflow: auto;">
		<b>B. Sub Kriteria</b>
		<table class="table table-bordered" style="width: 100%;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>NAMA</th>
					<?php foreach ($kriteria as $k) { ?>
						<th>
							<center><?= $k->kriteria ?></center>
						</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php if ($pelamar != null) { ?>
					<?php foreach ($pelamar as $p) { ?>
						<tr>
							<td>
								<center><?= $p->nama_pelamar ?></center>
							</td>
							<?php foreach ($kriteria as $k) { ?>
								<?php
								$where = array(
									'id_user' => $p->id_user,
									'id_lamaran' => $p->id_lamaran,
									'id_kriteria' => $k->id_kriteria,
								);
								?>
								<?php

								$id_alternatif = $this->db->get_where('tbl_normalisasi', $where)->row();
								if ($id_alternatif != null) {
									$id_alternatif = $id_alternatif->id_alternatif;
								} else {
									$id_alternatif = 0;
								}

								$alternatif = $this->db->get_where('tbv_alternatif', 'id_alternatif = "' . $id_alternatif . '"')->row();
								if ($alternatif != null) {
									$MIN_BOBOT[$k->id_kriteria] = $this->db->query('
											SELECT IF(atribut = "Benefit",MAX(bobot_alternatif),MIN(bobot_alternatif)) As MIN_BOBOT FROM tbv_alternatif WHERE id_kriteria = "' . $k->id_kriteria . '"
										')->row()->MIN_BOBOT;
								} else {
									$MIN_BOBOT[$k->id_kriteria] = 0;
								}
								?>
								<?php if ($alternatif != null) { ?>

									<td>
										<center><?= $alternatif->alternatif ?> (<?= $alternatif->bobot_alternatif ?>)</center>
									</td>
								<?php } else { ?>
									<td>
										<center>0</center>
									</td>
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>
					<tr>
						<td></td>
						<?php foreach ($kriteria as $k) { ?>
							<td>
								<b>
									<center><?= $MIN_BOBOT[$k->id_kriteria] ?>
								</b>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12" style="overflow: auto;">
		<b>C. Normalisasi</b>
		<table class="table table-bordered" style="width: 100%;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>NAMA</th>
					<?php foreach ($kriteria as $k) { ?>
						<th>
							<center><?= $k->kriteria ?></center>
						</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php if ($pelamar != null) { ?>
					<?php foreach ($pelamar as $p) { ?>
						<tr>
							<td>
								<center><?= $p->nama_pelamar ?></center>
							</td>
							<?php foreach ($kriteria as $k) { ?>
								<?php
								$where1 = array(
									'id_user' => $p->id_user,
									'id_lamaran' => $p->id_lamaran,
									'id_kriteria' => $k->id_kriteria,
								);
								?>
								<?php

								$id_alternatif = $this->db->get_where('tbl_normalisasi', $where1)->row();
								if ($id_alternatif != null) {
									$id_alternatif = $id_alternatif->id_alternatif;
								} else {
									$id_alternatif = 0;
								}
								$alternatif = $this->db->get_where('tbv_alternatif', 'id_alternatif = "' . $id_alternatif . '"')->row();

								?>

								<?php if ($alternatif != null) { ?>
									<?php if ($alternatif->atribut == 'Cost') { ?>
										<?php $hasil[$p->id_lamaran . '-' . $k->id_kriteria] = round($MIN_BOBOT[$k->id_kriteria] / $alternatif->bobot_alternatif, 6); ?>
									<?php } else { ?>
										<?php $hasil[$p->id_lamaran . '-' . $k->id_kriteria] = round($alternatif->bobot_alternatif / $MIN_BOBOT[$k->id_kriteria], 6); ?>
									<?php } ?>
								<?php } else { ?>
									<?php $hasil[$p->id_lamaran . '-' . $k->id_kriteria] = 0; ?>
								<?php } ?>
								<td>
									<center><?= $hasil[$p->id_lamaran . '-' . $k->id_kriteria] ?></center>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>


	<div class="col-md-12" style="overflow: auto;">
		<b>D. Hasil</b>
		<?php
		$result = array();
		foreach ($pelamar as $p) {
			$res = 0;
			foreach ($kriteria as $k) {
				$res = $res + ($kepentingan[$k->id_kriteria] * $hasil[$p->id_lamaran . '-' . $k->id_kriteria]);
			}

			$result[] = array(
				'nilai' => $res,
				'id_user' => $p->id_user,
				'id_lamaran' => $p->id_lamaran,
				'id_lowongan' => $p->id_lowongan,
				'nama_pelamar' => $p->nama_pelamar,
				'flag_nilai' => $p->flag_nilai
			);
			// echo round($res,2)."<br>";
		}

		// echo "<pre>
		// 	".json_encode($result,JSON_PRETTY_PRINT)."
		// </pre>";
		arsort($result);
		?>
		<table class="table table-bordered" style="width:80% ;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>
						<center>Rengking</center>
					</th>
					<th width="40%">
						<center>Nama Pelamar</center>
					</th>
					<th>
						<center>Nilai</center>
					</th>
					<th width="15%">
						<center>Aksi</center>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($result as $key => $value) { ?>
					<tr>
						<td>
							<center><?= $no ?></center>
						</td>
						<td><?= $value['nama_pelamar'] ?></td>
						<td>
							<center><?= round($value['nilai'], 2) ?></center>
						</td>
						<td>
							<center>
								<button type="button" class="btn btn-success btn-sm" onclick="cek_profil('<?= encrypt($value['id_lamaran']) ?>')"><i class="fa fa-eye"></i></button>
								<?php if ($value['flag_nilai'] != "Y") { ?>

									<button type="button" id="btn_terima_<?= encrypt($value['id_lamaran']) ?>" class="btn btn-primary btn-sm" onclick="terima('<?= encrypt($value['id_lamaran']) ?>')"><i class="fa fa-check"></i></button>
								<?php } ?>
							</center>
						</td>
						<!-- <td><center></center></td> -->
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>

	<div class="col-md-12" style="overflow: auto;" id="profil_pelamar" style="display: none;">

	</div>

</div>

<script>
	function cek_profil(arg) {
		$.ajax({
			url: '<?= site_url('cek_lamaran_div') ?>',
			type: 'POST',
			dataType: 'html',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				$('#profil_pelamar').html("<hr>" + data)
				$('#profil_pelamar').show()
			},
			error: function(xhr, textStatus, errorThrown) {
				swal('error', errorThrown, 'error');
			}
		});
	}

	function terima(arg) {
		$('#btn_terima_' + arg).html('Loading..');
		$('#btn_terima_' + arg).attr('disabled', '');
		$.ajax({
			url: '<?= site_url('terima_pelamar') ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				arg: arg
			},
			success: function(data, textStatus, xhr) {
				if (data.result == 'oke') {
					swal({
						title: "Berhasil",
						text: "Pelamar Berhasil Diterima",
						type: "success",
						buttons: true,
					}).then(function() {
						location.reload();
					});
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				swal('error', errorThrown, 'error');
			}
		});
	}
</script>