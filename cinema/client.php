<?php 
	require_once("../lib/nusoap.php");
	$client = new nusoap_client('http://127.0.0.1/soa2/cinema/server.php',false);
	
	// $client = new SoapClient("server.php", array('soap_version'=>SOAP_1_1 ));
	session_start();
?>

<!DOCTYPE html>
<html>
<body>
<head>
	<title>Latihan</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="mdl/material.min.css">
	<script src="mdl/material.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<style>


	.demo-layout-transparent {
	background: url('../assets/demos/transparent.jpg') center / cover;
	}
	.demo-layout-transparent .mdl-layout__header,
	.demo-layout-transparent .mdl-layout__drawer-button {
	/* This background is dark, so we set text to white. Use 87% black instead if
	 your background is light. */
	color: white;
	}
  .demo-card-square.mdl-card {
    width: 320px;
    height: 320px;
    float: left;
    margin: 1rem;
    position: relative;
  }
  
  .demo-card-square.mdl-card:hover {
    box-shadow: 0 8px 10px 1px rgba(0, 0, 0, .14), 0 3px 14px 2px rgba(0, 0, 0, .12), 0 5px 5px -3px rgba(0, 0, 0, .2);
  }
  
 /* .demo-card-square > .mdl-card__title {
    color: #fff;
    background-image: url('transformer.jpg');
  }*/
  

.demo-layout-waterfall .mdl-layout__header-row .mdl-navigation__link:last-of-type  {
  padding-right: 0;
}

.demo-card-wide.mdl-card {
  width: 512px;
}
 .demo-card-square.mdl-card {
    width: 320px;
    height: 320px;
    float: left;
    margin: 1rem;
  }
/*.demo-card-wide > .mdl-card__title {
  color: #fff;
  height: 176px;
  background: url('slide02.jpg') center / cover;
}*/
.demo-card-wide > .mdl-card__menu {
  color: #fff;
}

.box1{
	background-color: yellow
}
  
  body {
    background-image: url('slide01.jpg');
    position: relative;
  }
</style>
<body>

	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
	  <header class="mdl-layout__header">
	    <div class="mdl-layout__header-row">
	      <!-- Title -->
	      <span class="mdl-layout-title">Title</span>
	      <!-- Add spacer, to align navigation to the right -->
	      <div class="mdl-layout-spacer"></div>
	      <!-- Navigation. We hide it in small screens. -->
	      <nav class="mdl-navigation mdl-layout--large-screen-only">
	        <a class="mdl-navigation__link" href="">NOW PLAYING</a>
	        <a class="mdl-navigation__link" href="">THEATERS </a>
	        <a class="mdl-navigation__link" href="user.php">SIGN UP</a>
	     
	        <button class="mdl-button mdl-button--raised mdl-js-button dialog-button" id="show-dialog">Show Dialog</button>

	      </nav>
	    </div>
	  </header>
	  <div class="mdl-layout__drawer">
	    <span class="mdl-layout-title">Title</span>
	    <nav class="mdl-navigation">
	      <a class="mdl-navigation__link" href="">REGISTRATION</a>
	      <a class="mdl-navigation__link" href="">THEATER NEAR YOU</a>
	      <a class="mdl-navigation__link" href="">Link</a>
	      <a class="mdl-navigation__link" href="">Link</a>
	    </nav>
	  </div>
	  <main class="mdl-layout__content">
			<dialog id="dialog" class="mdl-dialog"> <!--modal untuk signin-->
			 <form action="client.php" method="POST">
			  <h3 class="mdl-dialog__title">Sign In</h3>
			  <div class="mdl-dialog__content">
			    <p>
			         	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="username" name="username">
						    <label class="mdl-textfield__label" for="username">Username...</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="password" name="password">
						    <label class="mdl-textfield__label" for="password">Password...</label>
						</div>
					
			    </p>
			  </div>
			  <div class="mdl-dialog__actions">
			    <button type="button" class="mdl-button close">Close</button>
			    <button type="submit" class="mdl-button" name="signin">Sign In</button>
			  </div>
			  </form>
			</dialog>
		  	<?php if(isset($_SESSION['alert'])){?>
				<div class="alert alert-dismissible alert-<?= $_SESSION['alert']['color'] ?>">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong><?= $_SESSION['alert']['status'] ?></strong>
				</div>
			<?php	session_destroy();
			}?>
			<!-- <form action="" method="GET">
				<div class="col-md-3">
					<label>City</label><input type="text" name="city" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Country</label><input type="text" name="country" class="form-control">
				</div>
				<div class="col-md-3">
					<input type="submit" name="submit" value="Submit" class="btn btn-success">
				</div>
			</form> -->

			<?php
				if(isset($_GET['city']) && isset($_GET['country'])){
					$result = $client->call('getCityWeather',array('city'=>$_GET['city'],'country'=> $_GET['country']));
					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							echo "<table class='table'><thead><th>city</th><th>country</th><th>Temperature</th><th>conditions</th><tbody>";
							for($i=0;$i<sizeof($result);$i++){
								echo "<tr><td>".$result[$i]['city']."</td><td>".$result[$i]['country']."</td><td>".$result[$i]['temperature']."</td><td>".$result[$i]['conditions']."</td></tr>";
							}
							echo "</tbody></table>";
						}
					}
				} else if(isset($_GET['city'])){
					$result = $client->call('getCountryWeather',array('city'=>$_GET['city'],'country'=> $_GET['country']));
					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							// var_dump($result);
							echo "<table class='table'><thead><th>city</th><th>country</th><th>Temperature</th><th>conditions</th><tbody>";
							for($i=0;$i<sizeof($result);$i++){
								echo "<tr><td>".$result[$i]['city']."</td><td>".$result[$i]['country']."</td><td>".$result[$i]['temperature']."</td><td>".$result[$i]['conditions']."</td></tr>";
							}
							echo "</tbody></table>";
						}
					}
				}

				else if(isset($_POST['signin'])){
					$result = $client->call('getSignIn',array('username'=>$_POST['username'],'password'=> $_POST['password']));
					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							echo "masuk";
							}
						
					}
				} 

				else if(isset($_POST['btnsearchMovie'])){
					$result = $client->call('getSearchMovie',array('title'=>$_POST['searchMovie']));

					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							// var_dump($result);
							echo "<table class='table'><thead><th>Title</th><tbody>";
							for($i=0;$i<sizeof($result);$i++){
								echo "<tr><td>".$result[$i]['title']."</td></tr>";
							}
							echo "</tbody></table>";
						}
					}
				}

				else{ //untuk keluarin judul filmnya
					$result = $client->call('getMovie'); //berhasil
					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							echo '<div class="container">
  									<div class="row">
  									<div class="col-md-8">
  									<div class="box1">
  									<form action="client.php" method="POST">
  									   	<label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">
									      <i class="material-icons">search</i>
									    </label>
									 	<div class="mdl-textfield mdl-js-textfield">
									    	<input class="mdl-textfield__input" type="text" id="sample1">
									    	<label class="mdl-textfield__label" for="sample1" name-"searchMovie">Search Here...</label>
									  	</div>
									  	<button class="mdl-button mdl-js-button mdl-button--accent" type="submit" name="btnsearchMovie">
										  Search
										</button>
									</form>';
								function limit_words($string, $word_limit){
							    $words = explode(" ",$string);
							    return implode(" ",array_splice($words,0,$word_limit));
								}
								
							for($i=0;$i<sizeof($result);$i++){
							    $word = $result[$i]["synopsis"];
							    $limited_string = limit_words($word, 15);
								echo '
								
										<div class="mdl-card mdl-shadow--2dp demo-card-square" >
										    <div class="mdl-card__title mdl-card__accent mdl-card--expand" style="background: url('.$result[$i]["poster"].');">
										      <h2 class="mdl-card__title-text" style=" color: #fff;">'.$result[$i]["title"].'</h2>
										    </div>
										    <div class="mdl-card__supporting-text">'.$limited_string.'...[more]</div>
										    <div class="mdl-card__actions mdl-card--border">
										      <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
										          Playing At
										      </a>
										    </div>
								  		</div>
								';	
						}
						echo '</div></div></div></div>';
					}
				}

				}?>
	</main>

	  	<footer class="mdl-mega-footer">
  			<div class="mdl-mega-footer__middle-section">
			    <div class="mdl-mega-footer__drop-down-section">
			      <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
			      <h1 class="mdl-mega-footer__heading">Features</h1>
			      <ul class="mdl-mega-footer__link-list">
			        <li><a href="#">About</a></li>
			        <li><a href="#">Terms</a></li>
			        <li><a href="#">Partners</a></li>
			        <li><a href="#">Updates</a></li>
			      </ul>
			    </div>

			    <div class="mdl-mega-footer__drop-down-section">
			      <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
			      <h1 class="mdl-mega-footer__heading">Details</h1>
			      <ul class="mdl-mega-footer__link-list">
			        <li><a href="#">Specs</a></li>
			        <li><a href="#">Tools</a></li>
			        <li><a href="#">Resources</a></li>
			      </ul>
			    </div>

			    <div class="mdl-mega-footer__drop-down-section">
			      <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
			      <h1 class="mdl-mega-footer__heading">Technology</h1>
			      <ul class="mdl-mega-footer__link-list">
			        <li><a href="#">How it works</a></li>
			        <li><a href="#">Patterns</a></li>
			        <li><a href="#">Usage</a></li>
			        <li><a href="#">Products</a></li>
			        <li><a href="#">Contracts</a></li>
			      </ul>
			    </div>

			    <div class="mdl-mega-footer__drop-down-section">
			      <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
			      <h1 class="mdl-mega-footer__heading">FAQ</h1>
			      <ul class="mdl-mega-footer__link-list">
			        <li><a href="#">Questions</a></li>
			        <li><a href="#">Answers</a></li>
			        <li><a href="#">Contact us</a></li>
			      </ul>
			    </div>
  			</div>

			  <div class="mdl-mega-footer__bottom-section">
			    <div class="mdl-logo">Title</div>
			    <ul class="mdl-mega-footer__link-list">
			      <li><a href="#">Help</a></li>
			      <li><a href="#">Privacy & Terms</a></li>
			    </ul>
			  </div>
		</footer>
	</div> <!--tutup div atas md-->

 <script>
   var dialog = document.querySelector('dialog');
    var showDialogButton = document.querySelector('#show-dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener('click', function() {
      dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
      dialog.close();
    });
  </script>
</body>
	<!-- <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>    
   -->
<!-- 		echo "\r\n";
		echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
 -->   
</html>

