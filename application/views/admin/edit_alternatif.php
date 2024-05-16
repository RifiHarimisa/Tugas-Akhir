<div class="form-group">
	<label>Kriteria<span style="color: red;">*</span></label>
	<select name="kriteria" class="form-control" required>
		<option value="<?= encrypt($alternatif->id_kriteria) ?>"><?= $alternatif->kriteria ?></option>
		<?php foreach ($kriteria as $k) { ?>
			<option value="<?= encrypt($k->id_kriteria) ?>"><?= $k->kriteria ?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<label>Sub Kriteria<span style="color: red;">*</span></label>
	<input type="text" placeholder="Sub Kriteria" class="form-control" required name="alternatif" value="<?= $alternatif->alternatif ?>">
</div>
<div class="form-group">
	<label>Bobot<span style="color: red;">*</span></label>
	<input type="number" placeholder="Bobot" class="form-control" required name="bobot" value="<?= $alternatif->bobot_alternatif ?>">
</div>
<input type="hidden" name="arg" value="<?= encrypt($alternatif->id_alternatif) ?>">