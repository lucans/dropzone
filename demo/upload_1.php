<?php 

session_start();

chmod('C:\xampp\htdocs\dropzone\imagens', 0777);

move_uploaded_file($_FILES['file']['tmp_name'], 'C:\xampp\htdocs\dropzone\imagens/' . $_FILES['file']['name']);



$dir = opendir('C:\xampp\htdocs\dropzone\imagens/');

$arquivo .= readdir($dir);

// $file = file_get_contents($_FILES['file']['name']);

echo $arquivo;

?>