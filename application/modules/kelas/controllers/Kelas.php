<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MY_Controller
{
	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("kelas");
		parent::__construct();
		$this->load->model('kelas_model', 'model');
	}

	public function index()
	{
		$db = $this->db;
		$db->select('*');
		$db->from('jurusan');
		$db->join('kelas', 'jurusan.id_jurusan = kelas.id_jurusan', 'inner');
		$db->group_by('jurusan.id_jurusan');
		$result = $this->db->get()->result();
		$data = [
			'judul' => 'Kelas',
			'jurusan' => $result
		];
		$this->load->view('index', $data);
	}
	function getLists()
	{
		$data = array();
		$kelas = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($kelas as $d) {
			$i++;
			$kelas = "data-kelas='" . $d->kelas . "'";
			$jurusan = "data-jurusan='" . $d->id_jurusan . "'";
			$siswa = '<a href="#siswa/kelas/' . $d->id_kelas . '" data-id_kelas="' . $d->id_kelas . '" class="btn btn-info btn-xs siswa"><i class="fa fa-fw fa-users"></i> Siswa</a>';
			$pelajaran = '<a href="#pelajaran/kelas/' . $d->id_kelas . '" data-id_kelas="' . $d->id_kelas . '" class="btn btn-info btn-xs pelajaran"><i class="fa fa-fw fa-book"></i> Mata Pelajaran</a>';
			$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-id="' . $d->id_kelas . '" ' . $kelas . $jurusan . ' ><i class="fa fa-fw fa-edit"></i> Edit</button>';
			$btn_hapus = '<button type="button" class="btn btn-danger btn-xs hapus"  data-id="' . $d->id_kelas . '"><i class="fa fa-fw fa-trash"></i> Hapus</button>';
			$data[] = array($i, $d->kelas, $siswa, $pelajaran, $btn_edit . ' ' . $btn_hapus);
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
