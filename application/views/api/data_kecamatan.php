<option value=""></option>
<?php if ($kecamatan != null){ ?>
	<?php foreach ($kecamatan as $k){ ?>
		<option value="<?= encrypt($k->id_kecamatan) ?>"><?= $k->nama_kecamatan ?></option>
	<?php } ?>
<?php } ?>