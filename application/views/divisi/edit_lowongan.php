<form action="<?= site_url('div/sedit_lowongan') ?>" method="post" accept-charset="utf-8">
					
	<div class="form-group">
		<label>Judul Lowongan<span style="color: red;">*</span></label>
		<input type="text" placeholder="Judul Lowongan" class="form-control" value="<?= $l->judul_lowongan ?>" required name="judul_lowongan">
	</div>
	<div class="form-group">
		<label>Persayatan<span style="color: red;">*</span></label>
		<textarea name="persyaratan" class="text-editor form-control border-radius-0" id="text-editor-edit"><?= $l->persayaratan ?></textarea>
	</div>
	<div class="form-group">
		<label>Tanggung Jawab<span style="color: red;">*</span></label>
		<textarea name="tanggung_jawab" class="text-editor1 form-control border-radius-0" id="text-editor1-edit"><?= $l->tanggung_jawab ?></textarea>
	</div>
	<div class="form-group">
		<label>Gaji<span style="color: red;">*</span></label>
		<input type="number"  class="form-control" required name="gaji" min="1000" value="<?= $l->gaji ?>" placeholder="100000000">
	</div>
	<input type="hidden" name="arg" value="<?= encrypt($l->id_lowongan) ?>">
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block" id="btnSimpan" ><i class="icon-copy ion-android-checkmark-circle"></i> Simpan</button>
	</div>
</form>

<script>
	$("#text-editor-edit").wysihtml5();
	$("#text-editor1-edit").wysihtml5();
</script>