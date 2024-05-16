<option value=""></option>
<?php if ($kelurahan != null){ ?>
	<?php foreach ($kelurahan as $k){ ?>
		<option value="<?= encrypt($k->id_kelurahan) ?>"><?= $k->nama_kelurahan ?></option>
	<?php } ?>
<?php } ?>