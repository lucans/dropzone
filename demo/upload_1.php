<?php 

chmod('C:\xampp\htdocs\dropzone\imagens', 0777);

move_uploaded_file($_FILES['file']['tmp_name'], "C:\xampp\htdocs\dropzone\imagens");

rename('imagens', $_FILES['file']['name']);

$file = file_get_contents(['file']['name']);


?>