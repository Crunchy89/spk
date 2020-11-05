<section class="content-header">
	<h1>
		<?= $judul ?>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Kelas</h3>
					<br>
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th>No</th>
									<th>Kelas</th>
									<th>Tambah Siswa</th>
									<th>Pelajaran</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="data">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">
					<div class="form-group">
						<label for="kelas">Nama Kelas</label>
						<input type="text" name="kelas" id="kelas" class="form-control form-control-sm" placeholder="Nama Kelas" required>
					</div>
					<div class="form-group">
						<label for="jurusan">Jurusan</label>
						<select name="jurusan" id="jurusan" class="form-control form-control-xs" required>
							<option value="">Pilih Jurusan</option>
							<?php foreach ($jurusan as $j) : ?>
								<option value="<?= $j->id_jurusan ?>"><?= $j->jurusan ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div id="add">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary" id="btn">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		const form = $('.modal-body').html();
		$('#myData').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?= site_url('kelas/getLists'); ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0],
				"orderable": false
			}]
		});
		$('#tambah').click(function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi">';
			$('#add').html(aksi);
			$('#modal').find('h5').html('Tambah')
			$('#modal').find('#btn').html('Tambah')
			$('#aksi').val('tambah');
			$('#modal').modal('show');
		});
		$('#data').on('click', '.edit', function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi">' +
				'<input type="hidden" name="id" id="id">';
			$('#add').html(aksi);
			$('#modal').find('h5').html('Edit')
			$('#modal').find('#btn').html('Edit')
			id = $(this).data('id');
			kelas = $(this).data('kelas');
			jurusan = $(this).data('jurusan');
			$('#aksi').val('edit');
			$('#id').val(id);
			$('#kelas').val(kelas);
			$('#jurusan').val(jurusan);
			$('#modal').modal('show');
		});
		$('#data').on('click', '.hapus', function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi">' +
				'<input type="hidden" name="id" id="id">' +
				'<h3>Apakah Anda Yakin ?</h3>';
			$('.modal-body').html(aksi);
			$('#modal').find('h5').html('Hapus')
			$('#modal').find('#btn').html('Hapus')
			id = $(this).data('id');
			$('#aksi').val('hapus');
			$('#id').val(id);
			$('#modal').modal('show');
		});
		$('#data').on('click', '.siswa', function() {
			id = $(this).data('id_kelas');
			$('#show_data').load('<?= site_url('siswa/kelas/') ?>' + id);
		});
		$('#data').on('click', '.pelajaran', function() {
			id = $(this).data('id_kelas');
			$('#show_data').load('<?= site_url('pelajaran/index/') ?>' + id);
		});
		$('#form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?= site_url('kelas/aksi') ?>',
				type: 'post',
				data: new FormData(this),
				dataType: 'json',
				processData: false,
				contentType: false,
				async: false,
				success: function(data) {
					toastr['success'](data);
					$('#myData').DataTable().ajax.reload();
					$('#modal').modal('hide');
				}
			})
		});
	})
</script>