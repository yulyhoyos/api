<?php
header("Content-Type:application/json");

// validar si los campos existen
if (isset($_POST['email']) && isset($_POST['password'])) {
	// si alguno de los campos viene vacio retornarlo
    if($_POST['email'] == '' || $_POST['password'] == ''){
        return response('200', 'error', 'Campos Vacios');
    }

	// conexion a la db
	include('db.php');
	$email = $_POST['email'];
	$result = mysqli_query(
	$con,
	"SELECT * FROM `users` WHERE email='$email'");
	
	$row = mysqli_fetch_array($result);
	$email = $row['email'];
	$password = $row['password'];

	// validar si la contraña en la db es igual a la enviada por el POST
    if( $password != $_POST['password']){
        return response('200', 'error', 'Contraseña incorrecta');
    }

	response('200','success', 'Ingreso con éxito');
	mysqli_close($con);
	
}else{
	// Retornar error si los campos no existen
    return response('400', 'error', 'Solicitud invalida');
}

function response($code,$status,$message){
	$response['code'] = $code;
	$response['status'] = $status;
	$response['message'] = $message;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>