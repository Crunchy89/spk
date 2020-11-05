<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("access");
		parent::__construct();
		$this->load->model('access_model', 'model');
	}

	public function index()
	{
		if ($this->session->userdata('role') != 1) {
			$role = $this->db->query('SELECT * FROM user_role WHERE id_role != 1')->result();
			$menu = $this->db->query('SELECT * FROM user_menu WHERE id_menu != 1 ORDER BY no_order ASC')->result();
		} else {
			$role = $this->db->get('user_role')->result();
			$menu = $this->db->get('user_menu')->result();
		}
		$data = [
			'judul' => 'Access',
			'role' => $role,
			'menu' => $menu
		];
		$this->load->view('index', $data);
	}
	public function aksi()
	{
		$data = $this->model->aksi();
		echo json_encode($data);
	}
}
