<?

error_reporting(false);

extract($_REQUEST);

switch ($func) {
	case 'upload':
		Css::upload();
		break;
	case 'clean':
		Css::clean();
		break;
	default:
		echo "case def";
		break;
}

class Css{

	public function upload(){

		chmod('C:\xampp\htdocs\dropzone\imagens', 0777);

		move_uploaded_file($_FILES['file']['tmp_name'], 'C:\xampp\htdocs\dropzone\imagens/' . $_FILES['file']['name']);

		echo "success";
	}	

	public function clean(){

		$dir = opendir('C:\xampp\htdocs\dropzone\imagens/');

		$arquivo = readdir($dir);
	    
	    $aResult = array();


		while (false !== ($file = readdir($dir))) {
			// echo file_get_contents('C:\xampp\htdocs\dropzone\imagens/' . $file);
	        $aResult['final_string'] .= file_get_contents('C:\xampp\htdocs\dropzone\imagens/' . $file);	 
	        $aResult['total_size_antes'] +=  number_format(filesize('C:\xampp\htdocs\dropzone\imagens/' . $file), 2, '.', '');
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
	    

	    $arquivo = fopen('C:\xampp\htdocs\dropzone\imagens/' . 'teste.css', 'w');
	    fwrite($arquivo, $aResult['final_string']);
	    $aResult['total_size_depois'] = filesize('C:\xampp\htdocs\dropzone\imagens/' . 'teste.css');

	    
	    // $aResult['percentual_menor'] = ($aResult['total_size_antes'] * 100) / ($aResult['total_size_depois']) / 100; 


		echo json_encode($aResult);
	}
	
}

?>