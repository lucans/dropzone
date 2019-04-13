<?

error_reporting(false);

extract($_REQUEST);

$postdata = file_get_contents("php://input");
$aDados = json_decode($postdata);


switch ($func) {
	case 'upload':
		Css::upload();
		break;
	case 'crushFiles':
		Css::crushFiles();
		break;	
	case 'crushText':	
		Css::crushText($aDados->text);
		break;	
	case 'clearAll':	
		Css::clearAll();
		break;
	default:
		echo "default ma friend";
		break;
}

class Css{


	public function log($tipo, $conteudo = '', $porcentagem_salva = 0){

		if ($_SERVER['DOCUMENT_ROOT'] == 'C:/Users/Lucas/Documents/GitHub') {				
		    $link = mysqli_connect("192.168.10.20","root","proxy","db_minify");
		} else if ($_SERVER['DOCUMENT_ROOT'] == 'C:/xampp/htdocs') {
		    $link = mysqli_connect("localhost","root","","db_minify");
		} else {
		    $link = mysqli_connect('mysql.hostinger.com.br','u709177649_minif','bTt3pMBIGlo6','u709177649_minif');
		}

		$sSql = "INSERT INTO log (conteudo, tipo, dt, ip, porcentagem_salva) VALUES ('" . $conteudo . "', '" . $tipo. "', NOW(),'" . $_SERVER["REMOTE_ADDR"] . "', '" . $porcentagem_salva . "')";
		// die($sSql);

		mysqli_query($link, $sSql);	
	}
		

	public function upload(){

		chmod('C:\xampp\htdocs\dropzone\css_uploaded', 0777);

		move_uploaded_file($_FILES['file']['tmp_name'], 'C:\xampp\htdocs\dropzone\css_uploaded/' . $_FILES['file']['name']);

		self::log('upload_file');

		echo "success";
	}	


	public function crushText($text){

	    $aResult = array();
		
	    $aResult['final_string'] = strip_tags($text);

		// remmove comments
	    $aResult['final_string'] = preg_replace('#/\*.*?\*/#s', '', $aResult['final_string']);

	    // Remove whitespace
	    $aResult['final_string'] = preg_replace('/\s*([{}|:;,])\s+/', '$1', $aResult['final_string']);

	    // Remove trailing whitespace at the start
	    $aResult['final_string'] = preg_replace('/\s\s+(.*)/', '$1', $aResult['final_string']);
	    
	    // Remove unnecesairy ;'s
	    $aResult['final_string'] = str_replace(';}', '}', $aResult['final_string']);
	    
	    	 
	    $aResult['antes'] =  strlen($text);
	    $aResult['depois'] = strlen($aResult['final_string']);    

	    
	    $aResult['percent'] = round((($aResult['antes'] - $aResult['depois']) / $aResult['antes']) * 100, 2);


	    self::log('crush_text',  substr($aResult['final_string'], 0, 50), $aResult['percent']);

		echo json_encode($aResult);
		
	}


	public function crushFiles(){

		$dir = opendir('C:\xampp\htdocs\dropzone\css_uploaded/');

		$arquivo = readdir($dir);
	    
	    $aResult = array();

		while (false !== ($file = readdir($dir))) {		
	        $aResult['total_string'] .= file_get_contents('C:\xampp\htdocs\dropzone\css_uploaded/' . $file);	
	        $aResult['final_string'] .= file_get_contents('C:\xampp\htdocs\dropzone\css_uploaded/' . $file);	 

	        unlink('C:\xampp\htdocs\dropzone\css_uploaded/' . $file);

	    }	    

	    $aResult['final_string'] = strip_tags($aResult['final_string']);

		// remmove comments
	    $aResult['final_string'] = preg_replace('#/\*.*?\*/#s', '', $aResult['final_string']);

	    // Remove whitespace
	    $aResult['final_string'] = preg_replace('/\s*([{}|:;,])\s+/', '$1', $aResult['final_string']);

	    // Remove trailing whitespace at the start
	    $aResult['final_string'] = preg_replace('/\s\s+(.*)/', '$1', $aResult['final_string']);
	    
	    // Remove unnecesairy ;'s
	    $aResult['final_string'] = str_replace(';}', '}', $aResult['final_string']);
	    

	    $aResult['antes'] =  strlen($aResult['total_string']);
	    $aResult['depois'] = strlen($aResult['final_string']);    

	    
	    $aResult['percent'] = round((($aResult['antes'] - $aResult['depois']) / $aResult['antes']) * 100, 2);

	    self::log('crush_file', substr($aResult['total_string'], 0, 50), $aResult['percent']);

		echo json_encode($aResult);

	}


	public function clearAll(){

		$dir = opendir('C:\xampp\htdocs\dropzone\css_uploaded/');

		$arquivo = readdir($dir);
	    
	    $aResult = array();

		while (false !== ($file = readdir($dir))) {			      
	        unlink('C:\xampp\htdocs\dropzone\css_uploaded/' . $file);
	    }	 

	    echo "true";

	}
	
}

?>