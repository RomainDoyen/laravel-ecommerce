<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
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
				<form action="{{ route('client.login.post') }}" method="POST">
					@csrf
					@method('POST')
					<h3>Se connecter</h3>
					@error('email')
						<div style="color: red;">{{ $message }}</div>
					@enderror
					<div class="form-wrapper">
						<input type="text" name="email" placeholder="Adresse email" class="form-control">
						<i class="zmdi zmdi-email"></i>
					</div>
					<div class="form-wrapper">
						<input type="password" name="password" placeholder="Mot de passe" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<button>
						Se connecter <i class="zmdi zmdi-arrow-right"></i>
					</button>
                    <br>
                    <div class="links">
                        <a href="{{ route('client.register') }}" class="bottom-text-w3ls">Pas de compte ? S'inscrire maintenant.</a>
                    </div>
                </form>
			</div>
		</div>
	</body>
</html>
