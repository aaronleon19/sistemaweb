<?php
session_start();
if (isset($_SESSION['admin'])) {
	header('location:home.php');
}
?>
<?php include 'includes/header.php'; ?>

<head>
	<link href="../dist/css/hovertreewelcome.css" type="text/css" rel="stylesheet" />

</head>

<body class="hold-transition login-page">
	<canvas style="position: absolute;left:0;z-index: 1;top:0;" id="canvas" width="100%" height="100vh"></canvas>
	<div id="hovertreecontainer">
		<div class="login-box">
			<div class="box">
				<div class="login_form_container">
					<form action="login.php" method="POST">
						<div class="login_form">
							<h2>Iniciar sesión</h2>
							<div class="input_group inputBox">
								<i class="fa fa-user"></i>
								<input type="text" placeholder="Username" name="username" class="input_text" autocomplete="off" />
							</div>
							<div class="input_group inputBox">
								<i class="fa fa-unlock-alt"></i>
								<input type="password" name="password" placeholder="Password" class="input_text" autocomplete="off" />
							</div>
							<div class="row">
								<div class="col-xs-4 button_group">
									<button type="submit" name="login" class="button_group" id="login_button" value="Entrar" name="signin"><i class="fa fa-sign-in"></i> Entrar</button>
								</div>
							</div>

							<div class="fotter">

								<a>Olvidaste tu contraseña ?</a>

							</div>

						</div>
					</form>
				</div>


			</div>


			<?php
			if (isset($_SESSION['error'])) {
				echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>" . $_SESSION['error'] . "</p> 
			  	</div>
  			";
				unset($_SESSION['error']);
			}
			?>
		</div>
	</div>


	<?php include 'includes/scripts.php' ?>
</body>

</html>