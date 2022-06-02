<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tamu extends BUKUTAMU_Core {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('tamu_m');

		$this->_partial = array(
			'head',
			'body',
			'script'
		);
	}

	public function index()
	{
		if(isset($_POST['submit']))
		{
			$status = 0;
			$post 	= $this->input->post(null, FALSE);

			$this->form_validation->set_rules($this->_rules());

			if ($this->form_validation->run() == TRUE) 
			{
				$token  = random_string('numeric', 6);
				$hash 	= hash_hmac('sha3-256', $post['nama_tamu'], $token);
				$status = ($this->tamu_m->tamuMasuk($post, $hash, $token) == true) ? 1 : 0;

				if($status === 1)
				{
					$log_message = $post['nama_tamu'] . " telah melakukan checkin pada " . indonesian_date(date('Y-m-d H:i:s'), true, true).'.';

					/**
					 * Kirim email ke user yang mengaktifkan notifikasi
					 * 
					*/
					$userEmail = $this->user_m->getUserEmail();

					$from = $this->config->item('smtp_user');
					
					if(!empty($userEmail))
					{
						foreach ($userEmail as $email) {
							
							$this->load->library('email');
							$this->email->from($from, $this->app->app_title);
							$this->email->to($email->user_email);
							
							$this->email->subject('NOTIFIKASI '.$this->app->app_title);
							$this->email->message($log_message);
							$this->email->send();
						}
					}

					//-------------------------------------------------
					
					/**
					 * Buat log sistem
					 * 
					*/
					$config = array(
						'log_timestamp' => date('Y-m-d H:i:s'),
						'log_message' => $log_message
					);
					$this->load->library('logging');
					$this->logging->initialize($config);
					$this->logging->insertLog();

					//--------------------------------------------------
					
					/**
					 * Kirim token checkout ke email tamu 
					 * 
					*/
					
					$this->load->library('email');
					
					
					$this->email->from($from, $this->app->app_title);
					$this->email->to($post['email_tamu']);
					
					$this->email->subject('KODE CHECKOUT');
					$this->email->message("Kepada <em>".$post['nama_tamu']."</em>, anda telah melakukan checkin pada aplikasi " . $this->app->app_title.". Gunakan kode berikut untuk melakukan checkout.<br/><br/><h3>".$token."</h3>");
					
					$status = (!$this->email->send()) ? 0 : 1;
					$msg = ($status === 1) ? 'Token checkout telah dikirim ke email anda.' : $this->email->print_debugger();

					//---------------------------------------------------
				}
				else
				{
					$msg = 'Gagal memvalidasi tamu.';
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
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min'
			);
			
			$this->_module 	= 'tamu/masuk_view';
			
			$this->js 		= 'halaman/tamu_masuk';

			$this->_data 	= array(
				'title' 	=> 'Buku Tamu - Tamu Masuk'
			);

			$this->load_view();
		}
	}

	function verify_image($str)
	{
		return (bool) preg_match('/(data:image\/[^;]+;base64[^"]+)$/', $str);
	}

	private function _rules()
	{
		$rules = array(
			array(
				'field' => 'nama_tamu',
				'label' => 'Nama Tamu',
				'rules'	=> 'trim|required|max_length[150]|regex_match[/[a-zA-Z0-9 .,]+$/]',
				'errors'=> array(
					'required' => '{field} wajib diisi.',
					'max_length' => 'Panjang maksimal {field} 150 karakter.',
					'regex_match' => '{field} hanya boleh mengandung alfanumerik, spasi, dan [,.].'
				)
			),
			array(
				'field' => 'nomor_telepon',
				'label' => 'No. Telepon',
				'rules'	=> 'required|min_length[9]|max_length[16]|numeric',
				'errors'=> array(
					'required' => '{field} wajib diisi.',
					'min_length' => 'Panjang minimal {field} 9 angka.',
					'max_length' => 'Panjang maksimal {field} 16 angka.',
					'numeric' => '{field} hanya boleh mengandung angka.'
				)
			),
			array(
				'field' => 'email_tamu',
				'label' => 'Email Tamu',
				'rules'	=> 'required|valid_email',
				'errors'=> array(
					'required' => '{field} wajib diisi.',
					'valid_email' => '{field} harus merupakan email yang valid.'
				)
			),
			array(
				'field' => 'organisasi',
				'label' => 'Asal Instansi/Organisasi',
				'rules'	=> 'trim|required|max_length[150]|regex_match[/[a-zA-Z0-9 \-_.,]+$/]',
				'errors'=> array(
					'required' => '{field} wajib diisi.',
					'max_length' => 'Panjang maksimal {field} 150 karakter.',
					'regex_match' => '{field} hanya boleh mengandung alfanumerik, spasi, dan [-_.,].'
				)
			),
			array(
				'field' => 'keperluan',
				'label' => 'Keperluan',
				'rules'	=> 'trim|required|max_length[255]|regex_match[/[a-zA-Z0-9 &\/\-_.,]+$/]',
				'errors'=> array(
					'required' => '{field} wajib diisi.',
					'max_length' => 'Panjang maksimal {field} 255 karakter.',
					'regex_match' => '{field} hanya boleh mengandung alfanumerik, spasi, dan [&/-_.,].'
				)
			),
			array(
				'field' => 'dataurl',
				'label' => 'Foto',
				'rules'	=> 'required|callback_verify_image',
				'errors'=> array(
					'required' => 'Anda belum mengambil foto.',
					'verify_image' => 'Foto tidak valid.'
				)
			),
		);

		return $rules;
	}

	public function keluar()
	{
		if(isset($_POST['submit']))
		{
			$status = 0;
			$post = $this->input->post(null, TRUE);

			$this->form_validation->set_rules('token_tamu', 'Token Tamu', 'required|numeric|exact_length[6]');
			if ($this->form_validation->run() == TRUE) 
			{
				$tamu = $this->tamu_m->checkToken($post['token_tamu']);

				if($tamu->num_rows() > 0)
				{
					$tamu 	= $tamu->row();

					$status = ($this->tamu_m->tamuKeluar($tamu->visitor_hash) == true) ? 1 : 0;
					$msg 	= ($status === 1) ? 'Anda telah checkout.' : 'Gagal melakukan checkout.';

					if($status === 1)
					{
						$log_message = $tamu->nama_tamu . " telah melakukan checkout pada " . indonesian_date(date('Y-m-d H:i:s'), true, true).'.';

						/**
						 * Kirim email ke user yang mengaktifkan notifikasi
						 * 
						*/
						$userEmail = $this->user_m->getUserEmail();

						$from = $this->config->item('smtp_user');
						
						if(!empty($userEmail))
						{
							foreach ($userEmail as $email) {
								
								$this->load->library('email');
								$this->email->from($from, $this->app->app_title);
								$this->email->to($email->user_email);
								
								$this->email->subject('NOTIFIKASI '.$this->app->app_title);
								$this->email->message($log_message);
								$this->email->send();
							}
						}

						//-------------------------------------------------
						
						/**
						 * Buat log sistem
						 * 
						*/
						$config = array(
							'log_timestamp' => date('Y-m-d H:i:s'),
							'log_message' => $log_message
						);
						$this->load->library('logging');
						$this->logging->initialize($config);
						$this->logging->insertLog();
					}
				}
				else
				{
					$msg 	= 'Token tidak valid.';
				}
			} 
			else 
			{
				$msg 	= validation_errors();
			}

			$token = $this->security->get_csrf_hash();
			$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min'
			);

			$this->_module 	= 'tamu/keluar_view';
			
			$this->js 		= 'halaman/tamu_keluar';

			$this->_data 	= array(
				'title' 	=> 'Buku Tamu - Tamu Keluar'
			);

			$this->load_view();
		}
	}
}

/* End of file Tamu_masuk.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/controllers/Tamu_masuk.php */