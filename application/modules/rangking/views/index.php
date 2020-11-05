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
					<h3 class="box-title">Penjumlahan nilai alternatif</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">Alternatif</th>
									<?php foreach ($kriteria as $row) : ?>
										<th class="text-center"><?= $row->label ?></th>
									<?php endforeach; ?>
									<th class="text-center">Jumlah</th>
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
					<h3 class="box-title">Keputusan</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">Alternatif</th>
									<th class="text-center">Jumlah</th>
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



<script>
	$(document).ready(function() {
		getData()
		rangking()

		function getData() {
			$.ajax({
				url: `<?= site_url('rangking/getData') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					data = '';
					for (i in res) {
						row = '';
						for (j in res[i]) {
							row += `
						<td class="text-center">${res[i][j]}</td>
						`;
						}
						data += `
						<tr>
						${row}
						</tr>
						`;
					}
					$('#data').html(data);
				}
			})
		}

		function sortByCol(arr, index) {
			arr.sort(function(a, b) {
				a = a[index];
				b = b[index];
				return (a === b) ? 0 : (a < b) ? -1 : 1
			})
		}

		function rangking() {
			$.ajax({
				url: `<?= site_url('rangking/rank') ?>`,
				method: 'GET',
				dataType: 'json',
				success: (res) => {
					data = res.sort((a, b) => {
						return b[1] - a[1]
					})
					tes = '';
					console.log(data)
					for (i in data) {
						// tes2 = '';
						// for (j in data[i]) {
						// 	tes2 += `
						// 	<td class="text-center">${data[i][j]}</td>
						// 	`;
						// }
						tes += `
						<tr>
						<td class="text-center">${data[i][0]}</td>
						<td class="text-center">${data[i][1]}</td>
						</tr>
						`;
					}
					$('#data2').html(tes);
				}
			})
		}
	});
</script>