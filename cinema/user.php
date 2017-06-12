<?php 
	require_once("../lib/nusoap.php");
	$client = new nusoap_client('http://127.0.0.1/soa2/cinema/server.php',false);
	
	// $client = new SoapClient("server.php", array('soap_version'=>SOAP_1_1 ));
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login | Sign Up</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

	<link rel="stylesheet" href="mdl/material.min.css">
	<script src="mdl/material.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<style type="text/css">
	 body {
    background-image: url('slide03.jpg');
    position: relative;
    -webki
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
	        <a class="mdl-navigation__link" href=""></a>
	        <a class="mdl-navigation__link" href="">Link</a>
	        <a class="mdl-navigation__link" href="user.php">Login</a>
	        <a class="mdl-navigation__link" href="" id="show-dialog" type="button">Link</a>
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
		  	<?php if(isset($_SESSION['alert'])){?>
				<div class="alert alert-dismissible alert-<?= $_SESSION['alert']['color'] ?>">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong><?= $_SESSION['alert']['status'] ?></strong>
				</div>
			<?php 
			session_destroy();
			}?>
			<?php
				if(isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) != NULL){

					$result = $client->call('addMember',array('User' => array('username'=>$_POST['username'], 'password'=>$_POST['password'], 'name'=>$_POST['name'])));
					if($client->fault){
						echo "<strong>Fault: </strong>".$result;
					}else{
						$err = $client->getError();
						if($err){
							echo "<strong>Error: </strong>".$err;
						}else{
							if($result){
								$_SESSION['alert']['status'] = "Success";
								$_SESSION['alert']['color'] = "success";
							}else{
								$_SESSION['alert']['status'] = "Failed";
								$_SESSION['alert']['color'] = "danger";
							}
							header('location:client.php');
						}

					}
				}?>
				<div class="mdl-cell mdl-cell--6-col" style="margin-left: 700px;">
					<form action="user.php" method="POST">
						<div class="demo-card-square mdl-card mdl-shadow--2dp">
						  <div class="mdl-card__title mdl-card--expand">
						    <h2 class="mdl-card__title-text">New to Petra Cinema ? Sign Up!</h2>
						  </div>
						  	<div class="mdl-card__supporting-text">
						    	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								    <input class="mdl-textfield__input" type="text" id="username" name="username">
								    <label class="mdl-textfield__label" for="username">Username...</label>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								    <input class="mdl-textfield__input" type="text" id="name" name="name">
								    <label class="mdl-textfield__label" for="name">Name...</label>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								    <input class="mdl-textfield__input" type="password" id="password" name="password">
								    <label class="mdl-textfield__label" for="name">Password...</label>
								</div>
						  </div>
						  <div class="mdl-card__actions mdl-card--border">
						    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" name="addNew" type="submit">
							  SIGN UP
							</button>
						  </div>
						</div>
					</form>
				</div>
		
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
</body>
</html>