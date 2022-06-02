<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_tamu extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('log_tamu_m');
	}

	public function index()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'daterangepicker/daterangepicker',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'tamu/log_view';
		
		$this->_script  = 'html2canvas';

		$this->js 		= 'halaman/log_tamu';
		
		$this->_data 	= array(
			'title' 	=> $this->app->app_title . ' - Data Tamu'
		);

		$this->load_view();
	}

	public function data($start, $end)
	{
		$result = [];

		$btn = array(
			'btn_detail' => $this->app_m->getContentMenu('detail-tamu')
		);

		$start 	= (validate_date($start) === false) ? strtotime(date('Ymd')) : strtotime($start);
		$end 	= (validate_date($end) === false) ? strtotime(date('Ymd')) : strtotime($end);
		
		$logs 	= $this->log_tamu_m->getLogTamu($start, $end);

		foreach ($logs as $log) {
			$result[] = array(
				$log->time_in,
				$log->nama_tamu,
				$log->time_in,
				($log->time_out ?? '-'),
				$log->organisasi,
				$log->keperluan,
				'<div class="btn-group" role="group" aria-label="Tools">'.button($btn['btn_detail'], FALSE, 'a', 'href="#" class="btn detail-tamu btn-info p-2" data-id="'.$log->visitor_hash.'" data-toggle="modal" data-target="#tamuModal"').'</div>'
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(['data' => $result]));
	}

	public function detail()
	{
		$post = $this->input->post(null, TRUE);
		$data = [];
		
		$this->form_validation->set_rules('hash', 'Hash tidak Valid.', 'trim|required|exact_length[64]|regex_match[/[a-f0-9]+$/]');

		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->log_tamu_m->getTamuByHash($post['hash']);
		}

		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file Log_tamu.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/controllers/Log_tamu.php */