<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

	public function grafik()
	{
		$bulan = [];
		$jumlah = [];

		$this->db->select("from_unixtime(time_in, '%M %Y') AS bulan, COUNT(log_id) AS total");
		$this->db->group_by("from_unixtime(time_in, '%Y-%m')");
		$this->db->order_by("from_unixtime(time_in, '%Y-%m') ASC");
		$tamu = $this->db->get('tb_log_tamu', 12)->result();

		foreach ($tamu as $value) {
			$bulan[] = $value->bulan;
			$jumlah[] = $value->total;
		}

		return array('labels' => $bulan, 'data' => ['jumlah' => $jumlah]);
	}

	public function countTamu($from)
	{
		$this->db->select('COUNT(log_id) AS total');
		$this->db->where("time_in BETWEEN ".$from." AND ".time());
		return $this->db->get('tb_log_tamu')->row_array();
	}

	public function countLog($type)
	{
		$this->db->select('COUNT(log_id) AS total');
		$this->db->where('log_type', $type);
		$this->db->where("date_format(log_timestamp,'%Y%m%d') BETWEEN ".date('Ymd', strtotime("-1 month", time()))." AND ".date('Ymd'));
		return $this->db->get('tb_log_sistem')->row_array();
	}

	public function getOrg()
	{
		$this->db->select('organisasi, COUNT(log_id) AS total');
		$this->db->group_by('organisasi');
		return $this->db->get('tb_log_tamu')->result_array();
	}
}

/* End of file Dashboard_m.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/models/Dashboard_m.php */