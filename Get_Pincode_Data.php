<?php 

$pincode = $_POST['pincode'];

$data = file_get_contents('http://postalpincode.in/api/pincode/'.$pincode);

$data = json_decode($data);

if(isset($data->PostOffice['0'])){

	$arr['City'] = $data->PostOffice['0']->Taluk;
	$arr['State'] = $data->PostOffice['0']->State;

	echo json_encode($arr);

}else{

	echo "no";
}

?>