<option value=""></option>
<?php if ($kota != null){ ?>
	<?php foreach ($kota as $k){ ?>
		<option value="<?= encrypt($k->id_kota) ?>"><?= $k->nama_kota ?></option>
	<?php } ?>
<?php } ?>