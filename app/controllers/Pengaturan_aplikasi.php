<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_aplikasi extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
	}

	public function index()
	{
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
			'mdi/css/materialdesignicons.min'
		);

		$this->_module 	= 'utilitas/pengaturan_view';
		
		$this->js 		= 'halaman/pengaturan_aplikasi';
		
		$this->_data 	= array(
			'title' 	=> $this->app->app_title . ' - Pengaturan Aplikasi'
		);

		$this->load_view();
	}

	private function _rules()
	{
		$rules = array(
			array(
				'field' => 'app_title',
				'label' => 'Nama Aplikasi',
				'rules' => 'trim|required|min_length[5]|max_length[100]|regex_match[/[a-zA-Z0-9 \-_]+$/]',
				'errors'=> array(
					'required' => '{field} harus diisi.',
					'min_length' => 'Panjang minimal {field} {param} karakter',
					'max_length' => 'Panjang maksiml {field} {param} karakter',
					'regex_match'=> '{field} hanya boleh mengandung alfanumerik, spasi, dan dash'
				)
			),
			array(
				'field' => 'app_footer',
				'label' => 'Teks Footer',
				'rules' => 'trim|required|min_length[5]|max_length[150]|regex_match[/[a-zA-Z0-9 \-_]+$/]',
				'errors'=> array(
					'required' => '{field} harus diisi.',
					'min_length' => 'Panjang minimal {field} {param} karakter',
					'max_length' => 'Panjang maksiml {field} {param} karakter',
					'regex_match'=> '{field} hanya boleh mengandung alfanumerik, spasi, dan dash'
				)
			)
		);

		return $rules;
	}

	public function submit()
	{
		$status  = 0;
		$error_upload = null;
		$setting = $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());

		if ($this->form_validation->run() == TRUE) {
			
			if(!empty($_FILES['app_logo']['name']))
			{
				// Get Image's filename without extension
				$filename = pathinfo($_FILES['app_logo']['name'], PATHINFO_FILENAME);

				// Remove another character except alphanumeric, space, dash, and underscore in filename
				$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

				// Remove space in filename
				$filename = str_replace(' ', '-', $filename);

				$config = array(
					'form_name' => 'app_logo', // Form upload's name
					'upload_path' => FCPATH . '_/uploads', // Upload Directory. Default : ./uploads
					'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
					'max_size' => '5128', // Maximun image size. Default : 5120
					'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
					'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
					'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
					'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
					'file_name' => $filename, // New Image's Filename
					'extension' => 'webp', // New Imaage's Extension. Default : webp
					'quality' => '100%', // New Image's Quality. Default : 95%
					'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
					'width' => 50, // New Image's width. Default : 800px
					'height' => 50, // New Image's Height. Default : 600px
					'cleared_path' => FCPATH . '_/uploads/sites'
				);

				// Load Library
				$this->load->library('secure_upload');

				// Send library configuration
				$this->secure_upload->initialize($config);

				// Run Library
				if($this->secure_upload->doUpload())
				{
					// Get Image(s) Data
					$data_logo 	= $this->secure_upload->data();
					$app_logo 	= $data_logo['file_name'];
				}
				else
				{
					$app_logo = $this->app->app_logo;	
					$error_upload = $this->secure_upload->show_errors();
				}
			}
			else
			{
				$app_logo = $this->app->app_logo;
			}

			if(!empty($_FILES['app_logo_dashboard']['name']))
			{
				// Get Image's filename without extension
				$filename = pathinfo($_FILES['app_logo_dashboard']['name'], PATHINFO_FILENAME);

				// Remove another character except alphanumeric, space, dash, and underscore in filename
				$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

				// Remove space in filename
				$filename = str_replace(' ', '-', $filename);

				$config = array(
					'form_name' => 'app_logo_dashboard', // Form upload's name
					'upload_path' => FCPATH . '_/uploads', // Upload Directory. Default : ./uploads
					'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
					'max_size' => '5128', // Maximun image size. Default : 5120
					'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
					'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
					'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
					'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
					'file_name' => $filename, // New Image's Filename
					'extension' => 'webp', // New Imaage's Extension. Default : webp
					'quality' => '100%', // New Image's Quality. Default : 95%
					'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
					'width' => 225, // New Image's width. Default : 800px
					'height' => 102, // New Image's Height. Default : 600px
					'cleared_path' => FCPATH . '_/uploads/sites'
				);

				// Load Library
				$this->load->library('secure_upload');

				// Send library configuration
				$this->secure_upload->initialize($config);

				// Run Library
				if($this->secure_upload->doUpload())
				{
					// Get Image(s) Data
					$data_logo_db	= $this->secure_upload->data();
					$logo_dashboard = $data_logo_db['file_name'];
				}
				else
				{
					$logo_dashboard = $this->app->app_logo_dashboard;
					$error_upload = $this->secure_upload->show_errors();
				}
			}
			else
			{
				$logo_dashboard = $this->app->app_logo_dashboard;
			}

			$settings = array_replace($setting, array('app_logo' => $app_logo, 'app_logo_dashboard' => $logo_dashboard));

			$status = ($this->app_m->updateSetting($settings) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Pengaturan berhasil diubah, '.$error_upload : 'Gagal mengubah pengaturan, '.$error_upload;

			if($status === 1) {
				$this->cache->delete('bukutamu_app');
				
				$config = array(
					'log_type' => 'info',
					'log_timestamp' => date('Y-m-d H:i:s'),
					'log_message' => $this->user->real_name . ' telah mengubah pengaturan aplikasi.'
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->insertLog();
			}
		} 
		else 
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result)); 
	}
}

/* End of file Pengaturan_aplikasi.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/controllers/Pengaturan_aplikasi.php */