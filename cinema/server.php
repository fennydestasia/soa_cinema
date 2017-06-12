<?php
	
require_once("../lib/nusoap.php");
$con = mysqli_connect("127.0.0.1","root","","soa");
$server = new nusoap_server();

$namespace = "http://127.0.0.1/soa2/inventories";
$server->configureWSDL("Cinemas", $namespace);

$server->wsdl->addComplexType(
	'Cinema',
	'complexType',
	'struct',
	'all',
	'',
	array(
			'title' => array('name'=>'title', 'type'=>'xsd:string'),
			'synopsis' => array('name'=>'synopsis','type'=>'xsd:string'),
			'genre' => array('name'=>'genre','type'=>'xsd:string'),
			'duration' => array('name'=>'duration','type'=>'xsd:int'),
			'poster' => array('name'=>'poster','type'=>'xsd:string'),
		)
);

$server->wsdl->addComplexType(
	'User',
	'complexType',
	'struct',
	'sequence',
	'',
	array( 
		'id'=>array('name' => 'id','type'=>'xsd:int'),
		'username'=>array('name' => 'username','type'=>'xsd:string'),
		'password'=>array('name' => 'password','type'=>'xsd:string'),
		'name'=>array('name' => 'name','type'=>'xsd:string')
		)
	);

$server->wsdl->addComplexType(
	'getNowPlayings',
	'complexType',
	'array',
	'all',
	'SOAP-ENC:Array',
	array(),
	array(
		array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:nowPlaying[]')
	), 'tns:Cinema'
);

$server->wsdl->addComplexType( //cuma satu, kalo milih
	'nowPlaying', //nama complexType
	'complexType', //jenisnya
	'struct',
	'sequence',
	'',
	array(
    	'id' => array('name' => 'id', 'type' => 'xsd:int'),
    	'movieID' => array('name' => 'movieID', 'type' => 'xsd:int'),  
    	'studioID' => array('name' => 'studioID', 'type' => 'xsd:int'),
		'priceRuleID' => array('name' => 'priceRuleID', 'type' => 'xsd:int'),
		'start_hour' => array('name' => 'start_hour', 'type' => 'xsd:time'),
    	'date' => array('name' => 'date', 'type' => 'xsd:date')	 
	)
);

$server->register('addMember',
					array('user'=>'tns:User'),
					array('return'=>'xsd:boolean'),
					$namespace);

$server->register('getSignIn',
					array('user'=>'tns:User'),
					array('return'=>'xsd:boolean'),
					$namespace);


// $server->register('getWeather',
// 					array(),
// 					array('return'=>'tns:Cinemas'),
// 					$namespace);

$server->register('getMovie', //berhasil
					array(),
					array('return'=>'tns:getNowPlayings'),
					$namespace);

$server->register('getCityWeather',
					array('inventory'=>'xsd:String'),
					array('return'=>'tns:Cinemas'),
					$namespace);

$server->register('getSearchMovie',
					array('cinema'=>'xsd:String'),
					array('return'=>'tns:getNowPlayings'),
					$namespace);

function addMember($user){
	global $con;
	if($query = mysqli_query($con,"INSERT INTO user VALUES(null,'".$user['username']."','".$user['password']."','".$user['name']."')"))
	{
		return true;
	}
	return false;
}

function getMovie(){
	global $con;
	$query = mysqli_query($con,"SELECT * FROM `movie`");
	while($row = mysqli_fetch_assoc($query)){
		$cinemas[] = array( "title"=>$row['title'], "synopsis"=>$row['synopsis'], "genre"=>$row['genre'], "poster"=>$row['poster'], "duration"=>$row['duration']);
	}
	return $cinemas;
}


function getCityWeather($name,$country){
	global $con;
	$query = mysqli_query($con,"SELECT * FROM weather WHERE city LIKE '%$name%' and country LIKE '%$country%'");
	while($row = mysqli_fetch_assoc($query)){
		$inventories[] = array("city"=>$row['city'], "country"=>$row['country'], "temperature"=>$row['temperature'],"conditions"=>$row['conditions']);
	}
	return $inventories;
}

function getSearchMovie($title){
	global $con;
	$query = mysqli_query($con,"SELECT * FROM movie WHERE title LIKE '%$title%'");
	while($row = mysqli_fetch_assoc($query)){
		$cinemas[] = array("title"=>$row['title']);
	}

	return $cinemas;
}

function getSignIn($username,$password){
	global $con;
	$query = mysqli_query($con,"SELECT * FROM user WHERE username = '%$username%' and password = '%password%'");
	if($query)
	{
		return true;
	}

	return false;
}


$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
	exit();
?>