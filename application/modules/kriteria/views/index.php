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
					<h3 class="box-title">Kriteria</h3>
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
									<th>Label</th>
									<th>Kriteria</th>
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
						<label for="kriteria">Kriteria</label>
						<input type="text" name="kriteria" id="kriteria" class="form-control form-control-sm" placeholder="Kriteria" required>
					</div>
					<div id="add"></div>
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
		getData()

		function getData() {
			$.ajax({
				url: `<?= site_url('kriteria/getData') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					let data = "";
					res.map((row, index) => {
						data += `
						<tr>
						<td>${index+1}</td>
						<td>${row.label}</td>
						<td>${row.kriteria}</td>
						<td>
						<button data-kriteria="${row.kriteria}" data-id="${row.id_kriteria}" class="btn btn-sm btn-warning edit" type="button"><i class="fa fa-fw fa-edit"></i></button>
						<button data-id="${row.id_kriteria}" class="btn btn-sm btn-danger hapus" type="button"><i class="fa fa-fw fa-trash"></i></button>
						</td>
						</tr>
						`;
					})
					$('#data').html(data);
				},
				error: (err) => {
					console.log(err)
				}
			})
		}
		$('#tambah').click(function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi" value="tambah">';
			$('#add').html(aksi);
			$('#modal').find('h5').html('Tambah')
			$('#modal').find('#btn').html('Tambah')
			$('#modal').modal('show');
		});
		$('#data').on('click', '.edit', function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi" value="edit">' +
				'<input type="hidden" name="id" id="id">';
			$('#add').html(aksi);
			$('#modal').find('h5').html('Edit')
			$('#modal').find('#btn').html('Edit')
			id = $(this).data('id');
			kriteria = $(this).data('kriteria');
			$('#id').val(id);
			$('#kriteria').val(kriteria);
			$('#modal').modal('show');
		});
		$('#data').on('click', '.hapus', function() {
			$('.modal-body').html(form);
			aksi = '<input type="hidden" name="aksi" id="aksi" value="hapus">' +
				'<input type="hidden" name="id" id="id">' +
				'<h3>Apakah Anda Yakin ?</h3>';
			$('.modal-body').html(aksi);
			$('#modal').find('h5').html('Hapus')
			$('#modal').find('#btn').html('Hapus')
			id = $(this).data('id');
			$('#id').val(id);
			$('#modal').modal('show');
		});
		$('#form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?= site_url('kriteria/aksi') ?>',
				type: 'post',
				data: new FormData(this),
				dataType: 'json',
				processData: false,
				contentType: false,
				async: false,
				success: function(result) {
					if (result.status == false) {
						toastr['error'](result.pesan);
					} else if (result.status == true) {
						toastr['success'](result.pesan);
					}
					getData()
					$('#modal').modal('hide');
				}
			})
		});
	});
</script>