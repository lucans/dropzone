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

		while (false !== ($file = readdir($dir))) {
			// echo file_get_contents('C:\xampp\htdocs\dropzone\imagens/' . $file);
	        $final_file .= file_get_contents('C:\xampp\htdocs\dropzone\imagens/' . $file);	        
	    }

	    $final_file = strip_tags($final_file);
		$final_file = str_replace(' ', '', $final_file);

		// remmove comments
	    $final_file = preg_replace('#/\*.*?\*/#s', '', $final_file);

	    // Remove whitespace
	    $final_file = preg_replace('/\s*([{}|:;,])\s+/', '$1', $final_file);

	    // Remove trailing whitespace at the start
	    $final_file = preg_replace('/\s\s+(.*)/', '$1', $final_file);
	    
	    // Remove unnecesairy ;'s
	    $final_file = str_replace(';}', '}', $final_file);

		echo $final_file;
	}
	
}

?>