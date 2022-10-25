<?php
define('BASEPATH',TRUE);
include dirname(__FILE__).'/app/config/constants.php';
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

ini_set('display_errors', 0);

if (version_compare(PHP_VERSION, '5.3', '>='))
{
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}

/*
|--------------------------------------------------------------------------
| Application Installer Status
|--------------------------------------------------------------------------
|
*/
define('ERR_DB_CONN', 'Gagal terkoneksi dengan database. Periksa kembali DB Host/DB User atau DB Password.');
define('ERR_DB_NOT_FOUND', 'Database tidak ada. Silakan buat terlebih dahulu.');
define('ERR_HOST', 'DB Host tidak valid. Karakter yang diizinkan hanya alfanumerik, titik, dan dash.');
define('ERR_USER', 'DB User tidak valid. Karakter yang diizinkan hanya alfanumerik dan underscore.');
define('ERR_DB_NAME', 'Nama DB tidak valid. Karakter yang diizinkan hanya alfanumerik dan underscore.');
define('ERR_TABLE', 'Gagal Membuat table SQL');
define('ERR_FILE_CFG', 'Gagal Membuat File Konfigurasi Database');
define('INSTALL_SUCCESS', 'Proses Instalasi Berhasil. Mengalihkan ke halaman konfigurasi...');

$protocol = (isset($_SERVER['HTTPS']) &&
	            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
	            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
	            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://';

define('BASE_URL', $protocol . $_SERVER['SERVER_NAME'] . WEBPORT . WEBDIR);

function checkDB()
{
	include dirname(__FILE__).'/app/config/database.php';
	$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
	if(!$conn->connect_error){
		return $conn->select_db($db['default']['database']) ? true : false;
	}
}

if(checkDB()) {
	header('Location:'.BASE_URL);
	exit();
}

class App_installer
{
	public $db_host = 'localhost';

	public $db_user = '';

	public $db_password = '';

	public $db_name = '';

	public $message = '';

	protected $_conn;

	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function __construct($config = array())
	{
		empty($config) OR $this->initialize($config, FALSE);
		// foreach ($config as $key => $value) {
		// 	$this->$key = $value;
		// }
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @param	bool	$reset
	 * @return	Secure_upload
	 */
	public function initialize(array $config = array(), $reset = TRUE)
	{
		$reflection = new ReflectionClass($this);

		if ($reset === TRUE)
		{
			$defaults = $reflection->getDefaultProperties();
			foreach (array_keys($defaults) as $key)
			{
				if ($key[0] === '_')
				{
					continue;
				}

				if (isset($config[$key]))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($config[$key]);
					}
					else
					{
						$this->$key = $config[$key];
					}
				}
				else
				{
					$this->$key = $defaults[$key];
				}
			}
		}
		else
		{
			foreach ($config as $key => &$value)
			{
				if ($key[0] !== '_' && $reflection->hasProperty($key))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($value);
					}
					else
					{
						$this->$key = $value;
					}
				}
			}
		}

		return $this;
	}

	//--------------------------------------------------------------------

	private function _hostValidation()
	{
		return (bool) preg_match("/^[a-z0-9\-.]*$/", $this->db_host);
	}

	private function _userValidation()
	{
		return (bool) preg_match("/^[a-z0-9_]*$/", $this->db_user);
	}

	private function _dbNameValidation()
	{
		return (bool) preg_match("/^[a-z0-9_]*$/", $this->db_name);
	}

	public function doValidate()
	{
		if(!$this->_hostValidation()){
			$this->message = ERR_HOST;
			return FALSE;
		}

		if(!$this->_userValidation()){
			$this->message = ERR_USER;
			return FALSE;
		}

		if(!$this->_dbNameValidation()){
			$this->message = ERR_DB_NAME;
			return FALSE;
		}

		return true;
	}

	private function _connectDB()
	{
		$this->_conn = new mysqli($this->db_host, $this->db_user, $this->db_password);
		if($this->_conn->connect_error){
			$this->message = ERR_DB_CONN;
		}
		else
		{
			return true;
		}
	}

	private function _useDB()
	{
		return $this->_conn->select_db($this->db_name) ? true : false;
	}

	private function _createTables()
	{
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_buku_tamu.sql';
		$query = '';
		$sqlScript = file($path);
		foreach ($sqlScript as $line)	{
			
			$startWith = substr(trim($line), 0 ,2);
			$endWith = substr(trim($line), -1 ,1);
			
			if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
				continue;
			}
				
			$query = $query . $line;
			if ($endWith == ';') {
				$this->_conn->query($query);
				if($this->_conn->error){
					$this->message = $this->_conn->error;
					return false;
				}
				$query= '';		
			}
		}
	}

	private function _createCfgFile()
	{
		$db_file  		= dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
		$database_cfg 	= fopen($db_file, "w");

$txt = '<?php
defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

$active_group = \'default\';
$query_builder = TRUE;

$db[\'default\'] = array(
	\'dsn\'	=> \'\',
	\'hostname\' => '.'"'.$this->db_host.'"'.',
	\'username\' => '.'"'.$this->db_user.'"'.',
	\'password\' => '.'"'.$this->db_password.'"'.',
	\'database\' => '.'"'.$this->db_name.'"'.',
	\'dbdriver\' => \'mysqli\',
	\'dbprefix\' => \'\',
	\'pconnect\' => FALSE,
	\'db_debug\' => (ENVIRONMENT == \'production\'),
	\'cache_on\' => FALSE,
	\'cachedir\' => \'\',
	\'char_set\' => \'utf8\',
	\'dbcollat\' => \'utf8mb4_general_ci\',
	\'swap_pre\' => \'\',
	\'encrypt\' => FALSE,
	\'compress\' => FALSE,
	\'stricton\' => FALSE,
	\'failover\' => array(),
	\'save_queries\' => TRUE
);';
	
		if(is_writable($db_file))
		{
			fwrite($database_cfg, $txt);
			fclose($database_cfg);
			return true;
		}
	}

	public function doInstall()
	{
		if($this->_connectDB() == true)
		{
			if($this->_useDB())
			{
				if($this->_createCfgFile() == true) 
				{
					if($this->_createTables() !== false)
					{
						$this->message = INSTALL_SUCCESS;
						return true;
					}
				}
				else
				{
					$this->message = ERR_FILE_CFG;
				}
			}
			else
			{
				$this->message = ERR_DB_NOT_FOUND;
			}
		}
	}

	public function showMessage()
	{
		return $this->message;
	}
}

if(isset($_POST['install']))
{
	$config = array(
		'db_host' => strtolower($_POST['db_host']),
		'db_user' => $_POST['db_user'],
		'db_password' => $_POST['db_passwd'],
		'db_name' => $_POST['db_name'] 
	);

	$DB = new App_installer();
	$DB->initialize($config);
	if($DB->doValidate())
	{
		$status = ($DB->doInstall() == true) ? 1 : 0;
	}

	echo json_encode(array('result' => $status, 'msg' => $DB->showMessage()));
}
else
{
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buku Tamu - Instalasi</title>

    <link rel="icon" href="_/images/bukutamu_logo.png">

    <!-- Custom fonts for this template-->
    <link href="_/vendors/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="_/css/style.css" rel="stylesheet">
    <link href="_/css/app-dev.css" rel="stylesheet">

    <link href="_/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="row w-100 m-0">
				<div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
					<div class="card bg-transparan text-muted col-lg-4 mx-auto">
						<div class="card-body px-4 py-4">
			
							<div class="text-center mb-4">
								<img class="w-50" src="_/images/bukutamu_logo.png" alt="Logo Buku Tamu">
								<h1 class="h4 mt-3">Versi <?= APP_VERSION ?></h1>
								<small>Konfigurasi Database</small>
							</div>
							<div id="msg_db" class="alert d-none">
								<small class="msg_db"></small>
							</div>

							<form action="" id="db_config" method="post" class="login-form">

								<label>Database Host *</label>
								<input type="text" id="db_host" name="db_host" value="localhost" placeholder="DB Host" class="form-control" required="required"/>

								<label>Database User *</label>
								<input type="text" id="db_user" name="db_user" placeholder="DB User" class="form-control" required="required"/>

								<label>Database Password</label>
								<input type="password" id="db_passwd" name="db_passwd" placeholder="DB Password" class="form-control" />

								<label>Database Name *</label>
								<input type="text" id="db_name" name="db_name" placeholder="DB Name" class="form-control mb-3" required="required"/>

								<small class="text-danger">* Wajib Diisi</small>
								<button type="submit" id="install" class="btn btn-block btn-primary mt-3 p-3" name="install"><i class="fas fa-arrow-circle-right"></i>Install!</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- Bootstrap core JavaScript-->
    <script src="_/js/core.min.js"></script>
    <script src="_/vendors/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>
    $("#db_config").on('submit', function() {
        var formAction = $("#db_config").attr('action');
        var dataDB = {
            db_host: $("#db_host").val(),
            db_user: $("#db_user").val(),
            db_passwd: $("#db_passwd").val(),
            db_name: $("#db_name").val(),
            install: $("#install").val(),
        };

        Swal.fire({
        	title : 'Tunggu...', 
        	text: 'Sedang Membuat Tabel. Jangan tutup atau refresh halaman!', 
        	type: 'info',
        	showConfirmButton: false
        }).then(setTimeout(() =>
        
	        $.ajax({
	            type: "POST",
	            url: formAction,
	            data: dataDB,
	            dataType: 'json',
	            success: function(data) {
	                
	                if (data.result == 1) {
	                    Swal.fire('Berhasil!', data.msg, 'success');
	                    setTimeout(function () { window.location.href = "<?= BASE_URL.'/masuk';?>";}, 3000);
	                } else {
	                    Swal.fire('Gagal!', data.msg, 'error');
	                }
	            }
	        })

	    ,1000))
        return false;
    });
    </script>
</body>

</html>
<?php } ?>
