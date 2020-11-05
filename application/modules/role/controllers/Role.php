<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("role");
		parent::__construct();
		$this->load->model('role_model', 'model');
	}

	public function index()
	{
		$data = [
			'judul' => 'Role'
		];
		$this->load->view('index', $data);
	}
	function getLists()
	{
		$data = array();
		$role = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($role as $d) {
			$disable = '';
			if ($d->id_role == 1) {
				$disable = "disabled";
			}
			if ($this->session->userdata('role') != 1) {
				if ($d->id_role != 1) {
					$i++;
					$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-role="' . $d->role . '" data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-edit"></i> Edit</button>';
					$btn_hapus = '<button type="button" ' . $disable . ' class="btn btn-danger btn-xs hapus"  data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-trash"></i> Hapus</button>';
					$data[] = array($i, $d->role, $btn_edit . ' ' . $btn_hapus);
				}
			} else {
				$i++;
				$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-role="' . $d->role . '" data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-edit"></i> Edit</button>';
				$btn_hapus = '<button type="button" ' . $disable . ' class="btn btn-danger btn-xs hapus"  data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-trash"></i> Hapus</button>';
				$data[] = array($i, $d->role, $btn_edit . ' ' . $btn_hapus);
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model->countAll(),
			"recordsFiltered" => $this->model->countFiltered($_POST),
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function aksi()
	{
		if ($_POST['aksi'] == 'tambah') {
			$data = $this->model->tambah();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'edit') {
			$data = $this->model->edit();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'hapus') {
			$data = $this->model->hapus();
			echo json_encode($data);
		}
	}
}
