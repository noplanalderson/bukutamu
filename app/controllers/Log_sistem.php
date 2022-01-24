<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_sistem extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('utilitas_m');
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

		$this->_module 	= 'utilitas/log_view';
		
		$this->js 		= 'halaman/log';
		
		$this->_data 	= array(
			'title' 	=> $this->app->app_title . ' - Log Sistem'
		);

		$this->load_view();
	}

	public function data($start, $end)
	{
		$start 	= (validate_date($start) === false) ? strtotime(date('Ymd')) : strtotime($start);
		$end 	= (validate_date($end) === false) ? strtotime(date('Ymd')) : strtotime($end);
		
		$logs 	= $this->utilitas_m->getSysLog($start, $end);
		$this->output->set_content_type('application/json')->set_output(json_encode(['data' => $logs]));
	}

}

/* End of file Log_sistem.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/controllers/Log_sistem.php */