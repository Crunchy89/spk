<section class="content-header">
    <h1>
        <?= $judul . ' ' . $title ?>
        <input type="hidden" name="id_menu" id="id_menu" value="<?= $id ?>">
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Submenu Management</h3>
                    <br>
                    <hr>
                    <a href="#menu" class="btn btn-info btn-sm" id="kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button type="button" class="btn btn-success btn-sm" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="myData" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama SubMenu</th>
                                    <th>Icon</th>
                                    <th>Url</th>
                                    <th>Order</th>
                                    <th>Aktif</th>
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
                        <label for="title">Nama Submenu</label>
                        <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="Nama Menu" required>
                    </div>

                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <div class="input-group">
                        <input type="text" name="icon" id="icon" class="form-control form-control-sm" placeholder="Icon" required>
                            <span class="input-group-btn">
                                <button type="button" id="ti" class="btn btn-info btn-flat">Icon</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url">Url</label>
                        <input type="text" name="url" id="url" class="form-control form-control-sm" placeholder="Url" required>
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
<!-- modal -->
<div class="modal fade" id="cons" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tes">
                <div class="modal-body" id="con">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        const form = $('.modal-body').html();
        id_menu = $('#id_menu').val();
        $('#myData').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('submenu/getLists/'); ?>" + id_menu,
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }]
        });
        $('#tambah').click(function() {
            $('.modal-body').html(form);
            aksi =
                '<input type="hidden" name="aksi" id="aksi">' +
                '<input type="hidden" name="id_m" id="id_m">';
            $('#add').html(aksi);
            $('#modal').find('h5').html('Tambah')
            $('#modal').find('#btn').html('Tambah')
            $('#aksi').val('tambah');
            $('#id_m').val(id_menu);
            $('#modal').modal('show');
        });
        $('#form').on('click', '#ti', function() {
            $('#cons').modal('show');
            $('#con').html('');
            var getData = function(data) {
                $scope = {};
                $scope.data = data;
                this.getResult = function() {
                    return $scope.getResult();
                }
                $scope.getResult = function() {
                    var _jquery = $($scope.data);
                    return _jquery.find('.fontawesome-icon-list div i');
                }
            }

            $(document).ready(function() {
                $.ajax({
                    url: '<?= site_url('menu/icon') ?>',
                    success: function(data) {

                        var tp = new getData(data);
                        var hasil = tp.getResult();
                        var icon = '';
                        for (i = 0; i < hasil.length; i++) {
                            icon +=
                                '<div class="col-md-2 col-sm-2"><input type="radio" name="con" value="' +
                                hasil[i].className + '"> <i class="' +
                                hasil[i].className +
                                '"></i></div>';
                        }
                        $('#con').html(icon);
                    }
                })
                $('#tes').submit(function(e) {
                    e.preventDefault();
                    icon = $('[name="con"]:checked').val();
                    $('#icon').val(icon);
                    $('#cons').modal('hide');
                })
            });
        });
        $('#data').on('click', '.edit', function() {
            $('.modal-body').html(form);
            aksi = '<input type="hidden" name="aksi" id="aksi">' +
                '<input type="hidden" name="id" id="id">' +
                '<input type="hidden" name="id_m" id="id_m">';
            $('#add').html(aksi);
            $('#modal').find('h5').html('Edit')
            $('#modal').find('#btn').html('Edit')
            id = $(this).data('id_submenu');
            title = $(this).data('title');
            icon = $(this).data('icon');
            url = $(this).data('url');
            $('#aksi').val('edit');
            $('#id').val(id);
            $('#title').val(title);
            $('#icon').val(icon);
            $('#url').val(url);
            $('#id_m').val(id_menu);
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
            id = $(this).data('id_submenu');
            $('#aksi').val('hapus');
            $('#id').val(id);
            $('#modal').modal('show');
        });
        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url('submenu/aksi') ?>',
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false,
                success: function(data) {
                    show_data();
                    toastr['success'](data);
                    $('#myData').DataTable().ajax.reload();
                    $('#modal').modal('hide');
                }
            })
        });
        $('#data').on('click', '#active', function() {
            id_menu = $(this).data('id_submenu');
            active = $(this).data('active');
            $.ajax({
                url: '<?= site_url('submenu/active') ?>',
                type: 'post',
                data: {
                    id: id_menu,
                    active: active
                },
                dataType: 'json',
                success: function(data) {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                    if (data.active == 'true') {
                        toastr['success']("Submenu Aktif");
                    } else {
                        toastr['error']("Submenu Nonaktif");

                    }
                }
            })
        });
        $('#kembali').click(function() {
            $('#show_data').load('<?= site_url('menu') ?>');
        });

        $('#data').on('click', '.down', function() {
            no = $(this).data('order');
            id = $(this).data('id_menu');
            id_sub = $(this).data('id_submenu');
            $.ajax({
                url: '<?= site_url('submenu/down') ?>',
                type: 'post',
                data: {
                    no_order: no,
                    id_menu: id,
                    id_submenu: id_sub
                },
                dataType: 'json',
                success: function() {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                }
            })
        });
        $('#data').on('click', '.up', function() {
            no = $(this).data('order');
            id = $(this).data('id_menu');
            id_sub = $(this).data('id_submenu');
            $.ajax({
                url: '<?= site_url('submenu/up') ?>',
                type: 'post',
                data: {
                    no_order: no,
                    id_menu: id,
                    id_submenu: id_sub
                },
                dataType: 'json',
                success: function() {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                }
            })
        });

    });
</script>