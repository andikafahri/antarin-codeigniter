<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/MerchantApp/login.css">
</head>
<body>
	<div class='box'>
		<div class='top'>
			<h1>Login</h1>
			<div class='logo'>
				<img src="/img/Logo Antarin.png" alt="" />
			</div>
		</div>
		<div class='middle'>
			<div class='form'>
				<span>Username<i class='required'> *</i></span>
				<input type="text" id="username" placeholder="Masukkan Username" autoCapitalize="none" />
			</div>
			<div class='form'>
				<span>Password<i class='required'> *</i></span>
				<input type="password" id="password" placeholder="Masukkan Password" autoCapitalize="none" />
			</div>
			<button id='btnLogin'>LOGIN</button>
		</div>
		<div class='bottom'>
			Belum punya akun?&nbsp;<a href='/merchant/register'>Daftar Sekarang</a>
		</div>
	</div>

	<script src="/js/jquery.min.js"></script>
	<script type="text/javascript">
		$('#btnLogin').click(function(){
			var username = $('#username').val();
			var password = $('#password').val();

			$.ajax({
				type: 'POST',
				url: '<?=site_url('reqLogin');?>',
				dataType: 'JSON',
				data: {username: username, password: password},
				beforeSend: function(){
					$('#btnLogin').prop('disabled', true);
				},
				success: function(result){
					// if(result.status === 200){
					// 	alert('Login Sukses');
					// 	localStorage.setItem('token', result.data.token)
					// 	window.location.href='<?=site_url('dashboard');?>'
					// }else{
					// 	let message = '';

					// 	if(typeof result.data.errors === 'object'){
					// 		for(const key in result.data.errors){
					// 			message += `${result.data.errors[key]}\n`;
					// 		}	
					// 	}else{
					// 		message = result.data.errors
					// 	}

					// 	alert(message);
					// }

					let message = '';
					if(!result.errors){
						// alert('Login Sukses')
						localStorage.setItem('token', result.token)
						console.log(result.token)
						window.location.href='<?=site_url('menu');?>'
					}else{
						if(typeof result.errors === 'object'){
							for(const key in result.errors){
								message += `${result.errors[key]}\n`;
							}	
						}else{
							message = result.errors
						}
						alert(message);	
					}

					$('#btnLogin').prop('disabled', false)
				}
			})

			return false
		})
	</script>
</body>
</html>