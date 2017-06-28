<?

error_reporting(false);

extract($_REQUEST);

$postdata = file_get_contents("php://input");
$aDados = json_decode($postdata);


switch ($func) {
	case 'upload':
		Css::upload();
		break;
	case 'clean_files':
		Css::clean_files();
		break;	
	case 'clean_text':	
		Css::clean_text($aDados->text);
		break;
	default:
		echo "case def";
		break;
}

class Css{

	public function upload(){

		chmod('C:\xampp\htdocs\dropzone\css_uploaded', 0777);

		move_uploaded_file($_FILES['file']['tmp_name'], 'C:\xampp\htdocs\dropzone\css_uploaded/' . $_FILES['file']['name']);

		echo "success";
	}	


	public function clean_text($text){	  	

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

		echo json_encode($aResult);

	}


	public function clean_files(){

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
	    

	    // $arquivo = fopen('C:\xampp\htdocs\dropzone\css_uploaded/' . 'teste.css', 'w');
	    // fwrite($arquivo, $aResult['final_string']);
	    	 
	    $aResult['antes'] =  strlen($aResult['total_string']);
	    $aResult['depois'] = strlen($aResult['final_string']);    

	    
	    $aResult['percent'] = round((($aResult['antes'] - $aResult['depois']) / $aResult['antes']) * 100, 2);

		echo json_encode($aResult);

	}
	
}

?>