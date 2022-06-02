<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();

		$this->load->model('dashboard_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/css/timeline.min'
		);

		$this->js_plugin = array(
			'chart.js/Chart.min',
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/js/timeline.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'dashboard/dashboard_view';
		
		$this->js 		= 'halaman/dashboard';

		$this->_data 	= array(
			'title' 		=> $this->app->app_title . ' - Dashboard'
		);

		$this->load_view();
	}

	public function grafik()
	{
		$result = $this->dashboard_m->grafik();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function statistik()
	{
		$data = array(
			'tamu_mtd' => $this->dashboard_m->countTamu(strtotime("-1 month", time())),
			'tamu_ytd' => $this->dashboard_m->countTamu(strtotime("-1 year", time())),
			'log_info' => $this->dashboard_m->countLog('info'),
			'log_warning' => $this->dashboard_m->countLog('warning')
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function org()
	{
		$result = [];

		foreach ($this->dashboard_m->getOrg() as $value) {
			$result[] = array(
				$value['organisasi'],
				$value['total']
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['data' => $result]));
	}
}