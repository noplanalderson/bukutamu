<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_akses extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();

		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('akses_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min'
		);

		$this->_module 	= 'akses/manajemen_akses_view';

		$this->js 		= 'halaman/akses';

		$this->_data	= array(
			'title'		=> $this->app->app_title . ' - Manajemen Akses',
			'menus'		=> $this->akses_m->getMenus(),
			'btn_add'	=> $this->app_m->getContentMenu('tambah-akses'),
		);

		$this->load_view();
	}

	private function getIndexList($type_id, $index_page)
	{
		$select = '<select name="index_page" class="index_page" data-id="'.encrypt($type_id).'" required><option value="">Index Page</option>';

	    foreach ($this->akses_m->getIndexPage($type_id) as $index)
		{	        
	        $selected  = ($index_page === $index->menu_link) ? 'selected' : '';

	        $options[] = '<option value="'.$index->menu_link.'" '.$selected.'>'.$index->menu_label.'</option>';
	    }
	      
	    $endSelect = '</select>';

	    return $select.implode('', $options).$endSelect;
	}

	public function data()
	{
		$btn = array(
			'btn_ubah'	=> $this->app_m->getContentMenu('ubah-akses'),
			'btn_hapus' => $this->app_m->getContentMenu('hapus-akses')
		);

		$result = [];

		$user_type = $this->akses_m->getUserType();

		foreach ($user_type as $type) {
			$result[] = array(
				$type->type_name,
				$this->akses_m->getDaftarAkses($type->type_id),
				$this->getIndexList($type->type_id, $type->index_page),
				'<div class="btn-group" role="group" aria-label="Tools">'.button($btn['btn_ubah'], FALSE, 'a', 'href="#" class="btn edit-access btn-warning p-2" data-id="'.encrypt($type->type_id).'" data-toggle="modal" data-target="#accessModal"').button($btn['btn_hapus'], FALSE, 'button', 'href="#" data-id="'.encrypt($type->type_id).'" class="btn delete-btn btn-danger p-2"').'</div>',
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'data' => $result
		]));
	}

	public function get_akses()
	{	
		$post = $this->input->post(null, TRUE);
		
		$data = (verify($post['id']) === false) ? [] : $this->akses_m->getAksesByHash($post['id']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('type_code', 'Tipe Akses', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|min_length[1]|max_length[100]|is_unique[tb_user_type.type_name]');
		$this->form_validation->set_rules('menu_id[]', 'Role', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{		
			$status = ($this->akses_m->tambahAkses($post) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Tipe akses ditambahkan.' : 'Gagal menambahkan tipe akses.';

			$config = array(
				'log_type' => 'info',
				'log_timestamp' => date('Y-m-d H:i:s'),
				'log_message' => $msg . ' oleh user ' . $this->user->real_name
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->insertLog();
		}
		else
		{
			$msg = validation_errors();
		}
		
		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function ubah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('type_id', 'ID Tipe', 'trim|required|verify_hash');
		$this->form_validation->set_rules('type_code', 'Tipe Akses', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('menu_id[]', 'Role', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{	
			if($this->akses_m->cekAkses($post['type_code'], $post['type_id']) == 0)
			{	
				$status = ($this->akses_m->editAkses($post) == true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Berhasil merubah tipe akses.' : 'Gagal merubah tipe akses.';

				$this->cache->clean();

				$config = array(
					'log_type' => 'info',
					'log_timestamp' => date('Y-m-d H:i:s'),
					'log_message' => $msg . ' oleh user ' . $this->user->real_name
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->insertLog();
			}
			else
			{
				$msg = 'Akses tipe sudah ada.';
			}
		}
		else
		{
			$msg = validation_errors();
		}
		
		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$post = $this->input->post(null, TRUE);
		
		if( ! verify($post['id']) )
		{
			$status = 0;
			$msg = 'Pilih tipe akses yang akan dihapus!';
		}
		else
		{
			$status = ($this->akses_m->hapusAkses($post['id']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus tipe akses.' : 'Gagal menghapus tipe akses.';

			$config = array(
				'log_type' => 'info',
				'log_timestamp' => date('Y-m-d H:i:s'),
				'log_message' => $msg . ' oleh user ' . $this->user->real_name
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->insertLog();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_index()
	{
		$data 	= $this->input->post(null, TRUE);
		$status = 0;

		if(verify($data['id']) !== FALSE) 
		{
			$this->form_validation->set_rules('index_page', 'Index', 'trim|required|regex_match[/[a-z\-]+$/]');
			if ($this->form_validation->run() == TRUE) 
			{
				$status = ($this->akses_m->updateIndex($data) === TRUE) ? 1 : 0;
			}
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}