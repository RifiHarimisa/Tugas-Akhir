<div class="form-group">
	<label>Kriteria<span style="color: red;">*</span></label>
	<input type="text" placeholder="Kriteria" class="form-control" required name="kriteria" value="<?= $kriteria->kriteria ?>">
</div>
<div class="form-group">
	<label>Atribut<span style="color: red;">*</span></label>
	<select name="atribut" class="form-control" required>
		<option value="<?= $kriteria->atribut ?>"><?= $kriteria->atribut ?></option>

		<option value="Benefit">Benefit</option>
		<option value="Cost">Cost</option>
	</select>
	<input type="hidden" name="arg" value="<?= encrypt($kriteria->id_kriteria) ?>">
</div>
<div class="form-group">
	<label>Bobot<span style="color: red;">*</span></label>
	<input type="number" placeholder="Bobot" class="form-control" required name="bobot" value="<?= $kriteria->Bobot ?>">
</div>