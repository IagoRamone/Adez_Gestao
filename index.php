<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Adez Gestão</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="/assets/img/Foguete amarelo.png"/>
	<link rel="stylesheet" type="text/css" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>
<body>	
		
	<div id="error-popup" class="error-popup hidden">
		<span id="error-message"></span>
		<button onclick="closePopup()">×</button>
	</div>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="/assets/img/Foguete amarelo.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="./assets/backend/auth/login.php" method="post">
					<span class="login100-form-title">
						Admin Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="nome" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" id="senha" name="senha" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<?php if (!empty($error_message)): ?>
					<div class="alert alert-danger" style="text-align: center; margin-bottom: 15px;">
    				<?php echo $error_message; ?>
					</div>
					<?php endif; ?>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn"  type="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="/assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="/assets/vendor/bootstrap/js/popper.js"></script>
	<script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/assets/vendor/select2/select2.min.js"></script>
	<script src="/assets/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		// Função para exibir o pop-up de erro
		function showErrorPopup(message) {
			const popup = document.getElementById("error-popup");
			const errorMessage = document.getElementById("error-message");
			errorMessage.textContent = message;
			popup.classList.remove("hidden");
			setTimeout(() => popup.classList.add("hidden"), 5000); 
		}

		function closePopup() {
			document.getElementById("error-popup").classList.add("hidden");
		}

		<?php if (!empty($_GET['error'])): ?>
			showErrorPopup("<?php echo htmlspecialchars($_GET['error']); ?>");
		<?php endif; ?>
	</script>

	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="/assets/js/main.js"></script>

</body>
</html>




