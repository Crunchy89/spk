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
					<h3 class="box-title">Matrix perbandingan berpasangan</h3>
					<br>
					<hr>
					<form id="prioritas">
						<div class="col-12">
							<div class="row">
								<div class="col-sm-3 col-md-2 col-lg-2">
									<select name="id_kriteria1" class="form-control">
										<?php foreach ($kriteria as $row) : ?>
											<option value="<?= $row->id_kriteria ?>"><?= $row->label ?>&nbsp;<?= $row->kriteria ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<select name="nilai" class="form-control">
										<?php for ($i = 1; $i <= 9; $i++) : ?>
											<option value="<?= $i ?>"><?= $i ?></option>
										<?php endfor; ?>
									</select>
								</div>
								<div class="col-sm-3 col-md-2 col-lg-2">
									<select name="id_kriteria2" class="form-control">
										<?php foreach ($kriteria as $row) : ?>
											<option value="<?= $row->id_kriteria ?>"><?= $row->label ?>&nbsp;<?= $row->kriteria ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<button class="btn btn-sm btn-primary" type="submit">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr id="head">
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

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Matrix nilai kriteria</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr id="head2">
								</tr>
							</thead>
							<tbody id="data2">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Matrix penjumlahan setiap baris</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr id="head3">
								</tr>
							</thead>
							<tbody id="data3">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Penghitungan rasio Konsistensi</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">\</th>
									<th class="text-center">Jumlah per baris</th>
									<th class="text-center">Prioritas</th>
									<th class="text-center">Hasil</th>
								</tr>
							</thead>
							<tbody id="data4">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Menentukan IR</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">Ukuran Matriks</th>
									<th class="text-center">Nilai IR</th>
								</tr>
							</thead>
							<tbody>
								<?php $data = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
								$i = 1;
								foreach ($data as $row) : ?>
									<tr>
										<td class="text-center"><?= $i ?></td>
										<td class="text-center"><?= $row ?></td>
									</tr>
								<?php $i++;
								endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Hasil</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">Total</th>
									<th class="text-center">CI</th>
									<th class="text-center">IR</th>
									<th class="text-center">CR</th>
									<th class="text-center">Konsistensi</th>
								</tr>
							</thead>
							<tbody id="data5">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {
		getData()
		ahp()
		kriteria()
		matrix()
		rasio()
		ir()

		function getData() {
			$.ajax({
				url: `<?= site_url('hitung/getData') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					let head = "<th class='text-center'>\\</th>";
					let head2 = "<th class='text-center'>\\</th>";
					let head3 = "<th class='text-center'>\\</th>";
					res.map((row, index) => {
						head += `<th class='text-center'>${row.label}</th>`
						head2 += `<th class='text-center'>${row.label}</th>`
						head3 += `<th class='text-center'>${row.label}</th>`
					})
					head2 += `
					<th class='text-center'>Jumlah</th>
					<th class='text-center'>Prioritas</th>
					`;
					head3 += `
					<th class='text-center'>Jumlah</th>
					`;
					$('#head').html(head);
					$('#head2').html(head2);
					$('#head3').html(head3);
				}
			})
		}

		function ahp() {
			$.ajax({
				url: `<?= site_url('hitung/ahp') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					let data = "";
					for (i in res) {
						let tes = '';
						for (j in res[i]) {
							tes += `
							<td class="text-center hit${i}">${res[i][j]}</td>
							`;
						}
						data += `
						<tr>
						${tes}
						</tr>
						`;
					}
					$('#data').html(data);
				}
			})
		}

		function kriteria() {
			$.ajax({
				url: `<?= site_url('hitung/nilai_kriteria') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					let data = "";
					for (i in res) {
						let tes = '';
						for (j in res[i]) {
							tes += `
							<td class="text-center hit${i}">${res[i][j]}</td>
							`;
						}
						data += `
						<tr>
						${tes}
						</tr>
						`;
					}
					$('#data2').html(data);
				}
			})
		}

		function matrix() {
			$.ajax({
				url: `<?= site_url('hitung/matrix_baris') ?>`,
				method: 'GET',
				dataType: 'json',
				success: res => {
					let data = "";
					for (i in res) {
						let tes = '';
						for (j in res[i]) {
							tes += `
							<td class="text-center hit${i}">${res[i][j]}</td>
							`;
						}
						data += `
						<tr>
						${tes}
						</tr>
						`;
					}
					$('#data3').html(data);
				}
			})
		}

		function rasio() {
			$.ajax({
				url: `<?= site_url('hitung/rasio') ?>`,
				method: 'GET',
				dataType: 'JSON',
				success: res => {
					let data = "";
					for (i in res) {
						let tes = '';
						for (j in res[i]) {
							tes += `
							<td class="text-center hit${i}">${res[i][j]}</td>
							`;
						}
						data += `
						<tr>
						${tes}
						</tr>
						`;
					}
					$('#data4').html(data);
				}
			})
		}

		function ir() {
			$.ajax({
				url: `<?= site_url('hitung/ir') ?>`,
				method: 'GET',
				dataType: 'JSON',
				success: res => {
					data = `
					<tr>
					<td class="text-center">${res.total}</td>
					<td class="text-center">${res.ci}</td>
					<td class="text-center">${res.ir}</td>
					<td class="text-center">${res.cr}</td>
					<td class="text-center">${res.konsistensi}</td>
					</tr>
					`;
					$('#data5').html(data)
				}

			})
		}
		$('#prioritas').submit(function(e) {
			e.preventDefault()
			$.ajax({
				url: `<?= site_url('hitung/tambah') ?>`,
				data: new FormData(this),
				method: 'POST',
				dataType: 'json',
				processData: false,
				contentType: false,
				async: false,
				success: res => {
					getData()
					ahp()
					kriteria()
					matrix()
					rasio()
					ir()
					toastr['success'](res.pesan);
				}
			})
		})
	});
</script>