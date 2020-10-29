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
					<h3 class="box-title">Access Management</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="myData" width="100%">
							<thead class="thead-dark">
								<tr>
									<th>Role</th>
									<?php foreach ($menu as $m) : ?>
										<th><?= $m->title ?></th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody id="data">
								<?php foreach ($role as $r) : ?>
									<tr>
										<th><?= $r->role ?></th>
										<?php foreach ($menu as $m) : ?>
											<td><input type="checkbox" class="cek" data-id_role="<?= $r->id_role ?>" data-id_menu="<?= $m->id_menu ?>" <?php $cek = $this->db->get_where('user_access', ['id_role' => $r->id_role, 'id_menu' => $m->id_menu])->row();
																																						if ($cek) : ?> <?php if ($cek->id_role == 1 && $cek->id_menu == 1) : ?> disabled<?php endif; ?> checked <?php endif; ?>>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
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
		function show_data() {
			$.ajax({
				url: '<?= site_url('admin/menu') ?>',
				type: 'post',
				dataType: 'json',
				success: function(data) {
					var menu = ''
					for (var i = 0; i < data.length; i++) {
						var sub = '';
						for (var j = 0; j < data[i].submenu.length; j++) {
							submenu = '<li data-url="' + data[i].submenu[j].url + '" class="submenu"><a href="#"><i class="' + data[i].submenu[j].icon + '"></i> ' + data[i].submenu[j].title + '</a></li>';
							sub += submenu;
						}
						menu += '<li class="treeview">' +
							'<a href="#">' +
							'<i class="' + data[i].icon + '"></i>' +
							'<span>' + data[i].title + '</span>' +
							'<span class="pull-right-container">' +
							'<i class="fa fa-angle-left pull-right"></i>' +
							'</span>' +
							'</a>' +
							'<ul class="treeview-menu submenu">' +
							sub + '</ul>' +
							'</li>';
					}
					$('#menu').html(menu);
					$('.nav-link').click(function() {
						$('.nav-link').removeClass('active');
						$(this).addClass('active');
					});
					$('.submenu').on('click', 'li', function() {
						url = $(this).data('url');
						$('#show_data').load('<?= site_url() ?>' + '/' + url);
					});
				}
			});
		}
		$('#data').on('click', '.cek', function() {
			id_role = $(this).data('id_role');
			id_menu = $(this).data('id_menu');
			$.ajax({
				url: '<?= site_url('access/aksi') ?>',
				type: 'post',
				data: {
					id_role: id_role,
					id_menu: id_menu
				},
				dataType: 'json',
				success: function(result) {
					show_data();
					if (result == true) {
						toastr['success']('Access Diberikan')
					} else {
						toastr['error']('Access Dihapus')
					}

				}
			});
		});
	});
</script>