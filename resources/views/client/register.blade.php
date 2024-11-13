<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Inscription</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="{{ asset('assets/css/form-contact.css') }}">
	</head>
	<body>
		<div class="wrapper" style="background-image: url('{{ asset('assets/images/bg-registration-form-1.jpg') }}');">
			<div class="backhome">
        <a href="{{ route('front.index') }}" class="bottom-text-w3ls">Revenir à la page d'accueil</a>
      </div> 
			<div class="inner">
				<div class="image-holder">
					<img src="{{ asset('assets/images/registration-form-1.jpg') }}" alt="">
				</div>
				<form method="POST" action="{{ route('client.register.post') }}">
					@csrf
					@method('POST')
					<h3>S'Inscrire</h3>
					<div>
						@if (session('status'))
							<div style="color: green;">
								{{ session('status') }}
							</div>
						@elseif (session('error'))
							<div style="color: red;">
								{{ session('error') }}
							</div>
						@endif
					</div>
					<div class="form-group">
						<input type="text" name="prenom" placeholder="Prénom" class="form-control">
						<input type="text" name="nom" placeholder="Nom" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="text" name="email" placeholder="Adresse email" class="form-control">
						<i class="zmdi zmdi-email"></i>
					</div>
					<div class="form-wrapper">
						<input type="password" name="password" placeholder="Mot de passe" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<!-- <div class="form-wrapper">
						<input type="password" placeholder="Confirm Password" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div> -->
					<button>
						S'inscrire <i class="zmdi zmdi-arrow-right"></i>
					</button>
					<br>
					<div class="links">
						<a href="{{ route('client.login') }}" class="bottom-text-w3ls">Vous avez un compte ? Se connecter maintenant.</a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>

