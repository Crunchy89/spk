<section class="content-header">
	<h1>
		<?= $judul ?>
	</h1>
</section>

<section class="content">

	<div class="row">
		<!-- /.col -->
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#activity" data-toggle="tab">Profil Aplikasi</a></li>
					<li><a href="#settings" data-toggle="tab">Settings</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="activity">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2">Nama Aplikasi</label>
								<div class="col-sm-10">
									<input type="text" name="nama" class="form-control" disabled>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="settings">
						<form id="profil" action="#" method="post" class="form-horizontal">
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama Aplikasi</label>
								<div class="col-sm-10">
									<input type="hidden" name="gambarLama">
									<input type="text" name="nama" id="nama" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label for="gambar" class="col-sm-2">Logo Aplikasi</label>
								<div class="col-sm-10">
									<div class="form-group">
										<label for="gambar" class="col-sm-4" id="reset"><img class="img-fluid" src="<?= base_url() ?>assets/img/noimage.png" id="output" width="200px" height="200px"></label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="custom-file">
													<input type="file" class="custom-file-input" accept="image/*" onchange="loadFile(event)" id="gambar" name="gambar">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" id="save" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Simpan</button>
							<button type="button" id="btn-reset" class="btn btn-primary"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>
<script>
	var loadFile = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
	};
	$(document).ready(function() {
		show_data()
		const form = $('.modal-body').html();

		function show_data() {
			$.ajax({
				url: '<?= site_url('profil/getProfile') ?>',
				type: 'POST',
				dataType: 'json',
				success: function(result) {
					$('[name="nama"]').val(result.nama);
					$('[name="gambarLama"]').val(result.logo);
					$('#reset').html('<img src="<?= base_url() ?>assets/img/profile/' + result.logo + '" alt="Logo Sekolah" id="output" width="200px" height="200px">');
					var med = '';
					var sub = '';
				}
			})
		}
		$('#btn-reset').click(function() {
			show_data();
		});
		$('#profil').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?= site_url('profil/update') ?>',
				type: 'POST',
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				processData: false,
				async: false,
				success: function(hasil) {
					toastr['success'](hasil.pesan);
					$('[name="gambar"]').val('');
					$.ajax({
						url: '<?= site_url('profil/getProfile') ?>',
						type: 'POST',
						dataType: 'json',
						success: function(result) {
							$('[name="nama"]').val(result.nama);
							$('[name="gambarLama"]').val(result.logo);
							$('#reset').html('<img src="<?= base_url() ?>assets/img/profile/' + result.logo + '" alt="Logo Sekolah" id="output" width="200px" height="200px">');
							$('.LOGO').html('<img class="user-image" src="<?= base_url() ?>assets/img/profile/' + result.logo +
								'" width="40px" height="40px" alt="Logo">');
							var med = '';
							var sub = '';
						}
					})
				}
			})
		})
	})
</script>