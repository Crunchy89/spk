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
					<h3 class="box-title">Nilai Alternatif</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Alternatif</th>
									<?php foreach ($kriteria as $row) : ?>
										<th class="text-center"><?= $row->label ?></th>
									<?php endforeach; ?>
									<th class="text-center">Aksi</th>
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
					<input type="hidden" name="alternatif" id="alternatif">
					<?php $i = 0;
					foreach ($kriteria as $row) : ?>
						<div class="form-group">
							<label for="nilai<?= $i ?>"><?= $row->kriteria ?></label>
							<input type="text" name="<?= $row->id_kriteria ?>" id="nilai<?= $i ?>" placeholder="<?= $row->kriteria ?>" class="form-control" required>
						</div>
					<?php $i++;
					endforeach; ?>
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
				url: `<?= site_url('nilai/getData') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					arr = res;
					let data = '';
					res.map((row, index) => {
						let tes = '';
						for (i in row) {
							tes += `
							<td class="text-center">${row[i][1]}</td>
							`;
						}
						data += `
						<tr>
						<td class="text-center">${index+1}</td>
						${tes}
						<td class="text-center">
						<button data-id_alternatif="${row[0][0]}" type="button" class="btn btn-sm btn-warning edit" ><i class="fa fa-fw fa-edit"></i></button>
						</td>
						</tr>
						`;
					})
					$('#data').html(data)
				}
			})
		}
		$('#data').on('click', '.edit', function() {
			let id = $(this).data('id_alternatif')
			let go = arr.filter((row, index) => {
				return row[0][0] == id
			});
			$('.modal-body').html(form);
			$(`#alternatif`).val(go[0][0][0]);
			go[0].shift();
			for (i in go[0]) {
				$(`#nilai${i}`).val(go[0][i][1]);
			}
			$('#modal').find('h5').html('Edit')
			$('#modal').find('#btn').html('Simpan')
			$('#modal').modal('show');
		});
		$('#form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?= site_url('nilai/aksi') ?>',
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