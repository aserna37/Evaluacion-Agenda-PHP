<?php

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

session_start();
if ($_SESSION['isLogin']) {
	require ('lib.php');

	$con = new ConectorBD('localhost', 'root', '');
	$response['conexion'] = $con -> initConexion('agenda');
	if ($response['conexion'] == 'OK') {
		if(validateDate($_POST['start_date'], 'Y-m-d'))
			$datos['start'] = $_POST['start_date'];
		if(validateDate($_POST['start_hour'], 'H:i:s'))
			$datos['horai'] = $_POST['start_hour'];
		if(validateDate($_POST['end_date'], 'Y-m-d'))
			$datos['end'] = $_POST['end_date'];
		if(validateDate($_POST['end_hour'], 'H:i:s'))
			$datos['horaf'] = $_POST['end_hour'];
		
		if ($con -> actualizarRegistro('Eventos', $datos, 'id = ' . $_POST['id']))
			$response['msg'] = 'OK';
		else
			$response['msg'] = 'Se ha producido un error al guardar el evento'. $_POST['id'];
	} else
		$response['msg'] = 'Problemas con la conexión a la base de datos';
} else
	$response['msg'] = 'Debe iniciar sesión';

echo json_encode($response);
?>

