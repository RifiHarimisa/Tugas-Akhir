<style type="text/css" media="screen">
	td{
		padding: 5px;
/*		height: 45px;*/
	}
	th{
		padding: 5px;
/*		height: 45px;*/
	}
	table{
		font-size: 14px;
	}
</style>
<table width="100%" border="0" style="border-collapse: 1px;">
	<tbody>
		<tr>
			<th colspan="4">Data Diri Pelamar</th>
		</tr>
		<tr>
			<td width="20%">NIK</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->nik ?></td>

			<td rowspan="7" width="20%">
				<img src="<?= asset() ?>vendors/user/<?= $pribadi->foto_profile ?>?<?= encrypt(date('H:i:s')) ?>" style="width: 4cm;height: 6cm;" alt="">
			</td>
		</tr>
		<tr>
			<td width="20%">Nama Lengkap</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->nama ?></td>
		</tr>
		<tr>
			<td width="20%">Tempat Lahir</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->tmpt_lahir ?></td>
		</tr>
		<tr>
			<td width="20%">Tanggal Lahir</td>
			<td width="1%"><center>:</center></td>
			<td><?= date('d/m/Y',strtotime($pribadi->tgl_lahir)) ?></td>
		</tr>
		<tr>
			<td width="20%">Umur</td>
			<td width="1%"><center>:</center></td>
			<td><?= substr((date('Ymd',strtotime($pribadi->tgl_lahir)) - date('Ymd')) * -1,0,2) ?> Tahun</td>
		</tr>
		<tr>
			<td width="20%">Status Pernikahan</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->status ?></td>
		</tr>
		<tr>
			<td width="20%">Alamat</td>
			<td width="1%"><center>:</center></td>
			<td><?= ucwords(strtolower($pribadi->nama_provinsi)," ") ?>, <?= ucwords(strtolower($pribadi->nama_kota)," ") ?>, <?= ucwords(strtolower($pribadi->nama_kecamatan)," ") ?>, <?= ucwords(strtolower($pribadi->nama_kelurahan)," ") ?> Lingkungan <?= $pribadi->lingkungan ?></td>
		</tr>
		<tr>
			<td width="20%">Email</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->email ?></td>
		</tr>
		<tr>
			<td width="20%">No. Telp</td>
			<td width="1%"><center>:</center></td>
			<td><?= $pribadi->no_telp ?></td>
		</tr>
		
	</tbody>
</table>

<hr>
<table width="100%" border="1" style="border-collapse: 1px;">
	<tbody>
		<tr >
			<th colspan="5">Riwayat Pendidikan Pelamar</th>
		</tr>
		<tr>
			<th><center>Jenjang</center></th>
			<th><center>Nama Sekolah</center></th>
			<th><center>Jurusan</center></th>
			<th><center>Masuk</center></th>
			<th><center>Lulus</center></th>
		</tr>
		<?php if ($pendidikan != null){ ?>
			<?php foreach ($pendidikan as $p){ ?>
				<tr>
					<?php $jenjang = $this->db->get_where('tbl_jenjang', 'id_jenjang = "'.$p->id_jenjang.'"')->row()->nama_jenjang; ?>
					<td><center><?= $jenjang ?></center></td>
					<td><center><?= $p->nama_sekolah ?></center></td>
					<td><center><?= $p->jurusan ?></center></td>
					<td><center><?= date('M Y',strtotime($p->masuk)) ?></center></td>
					<td><center><?= date('M Y',strtotime($p->keluar)) ?></center></td>
				</tr>
			<?php } ?>
		<?php } ?>	
	</tbody>
</table>
<hr>
<table width="100%" border="1" style="border-collapse: 1px;">
	<tbody>
		<tr >
			<th colspan="5">Riwayat Pekerjaan Pelamar</th>
		</tr>
		<tr>
			<th><center>Nama Perusahaan</center></th>
			<th><center>Posisi</center></th>
			<th><center>Masuk</center></th>
			<th><center>Keluar</center></th>
		</tr>
		<?php if ($pengalaman != null){ ?>
			<?php foreach ($pengalaman as $p){ ?>
				<tr>
					<td><center><?= $p->nama_perusahaan ?></center></td>
					<td><center><?= $p->posisi ?></center></td>
					<td><center><?= date('M Y',strtotime($p->masuk)) ?></center></td>
					<td><center><?= date('M Y',strtotime($p->keluar)) ?></center></td>
				</tr>
			<?php } ?>
		<?php } ?>	
	</tbody>
</table>
<br>
<br>
<table width="100%" border="0" style="border-collapse: 1px;">
	<thead>
		<tr>
			<th colspan="3">Informasi Lamaran</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="20%">Posisi Yang Dilamar</td>
			<td width="1%"><center>:</center></td>
			<td><?= $l->judul_lowongan ?></td>
		</tr>
		<tr>
			<td width="">Perusahaan</td>
			<td width="1%"><center>:</center></td>
			<td><?= $l->nama_perusahaan ?></td>
		</tr>
		<tr>
			<td width="">Tanggal Lamaran</td>
			<td width="1%"><center>:</center></td>
			<td><?= date('d/m/Y H:i',strtotime($l->regdate)) ?></td>
		</tr>
	</tbody>
</table>
