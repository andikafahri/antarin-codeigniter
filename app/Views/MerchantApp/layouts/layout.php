<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/MerchantApp/layout.css">
	<link rel="stylesheet" type="text/css" href="css/MerchantApp/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/MerchantApp/modals/modal_add_menu.css">
	<title><?=$title;?></title>
</head>
<body>
	<div class='header_header'>
		<div class='header_logo'>
			<a href='/'>
				<img src='/img/Logo Antarin.png' />
			</a>
		</div>
		<div class='header_operational'>
			<!-- <div role='button' class='header_operationalContainer notHighlight'>
				<div class='header_left'>
					<label class='header_time'>Senin | 11:34</label>
					<label class='header_statusOperational'>BUKA</label>
				</div>
				<div class='header_right'>
					<i class="fas fa-chevron-down"></i>
				</div>
			</div> -->
		</div>
		<div class='header_menuBar notHighlight' id="btnSideMenu">
			<i class='fas fa-bars'></i>
		</div>
	</div>

	<div class='sidemenu_box' id="sideMenu">
		<div class='sidemenu_boxProfile'>
			<img src="/img/no-image.jpg" id='profileImage' alt="" />
			<div class='sidemenu_info'>
				<h1 id="profileName"></h1>
			</div>
		</div>
		<div class='sidemenu_menu'>
			<a href='<?=site_url('/menu');?>' class='sidemenu_row sidemenu_active'>Kelola Menu</a>
		</div>
		<div class='sidemenu_bottom'>
			<button class='sidemenu_btnLogout' id="btnLogout">LOGOUT</button>
		</div>
	</div>

	<?= $this->renderSection('content') ;?>

	<script src="/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			const apiBaseURL = '<?=esc(apiBaseURL());?>'
			getProfile()

			function decodeJWT(token) {
				try {
        		// Split token menjadi 3 bagian
					const base64Url = token.split('.')[1];
        		// Ganti karakter khusus Base64Url
					const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        		// Decode Base64
					const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
						return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
					}).join(''));

					return JSON.parse(jsonPayload);
				} catch (e) {
					console.error('Error decoding token:', e);
					return null;
				}
			}

			function getProfile(){
				var idMerchant = decodeJWT(localStorage.getItem('token')).id

				$.ajax({
					type: 'GET',
					url: '<?=site_url('getProfile');?>',
					dataType: 'JSON',
					headers: {
						'Authorization': localStorage.getItem('token')
					},
					beforeSend: function(){

					},
					success: function(result){
						var data = result.data
						$('#profileImage').attr('src', apiBaseURL+'/img/merchant/'+idMerchant+'/'+data.image)
						$('#profileName').text(data.name)
					}
				})
			}

			$('#btnSideMenu').click(function(){
				if($('#sideMenu').hasClass('sidemenu_open')){
					$('#sideMenu').removeClass('sidemenu_open')
				}else{
					$('#sideMenu').addClass('sidemenu_open')
				}
			})

			$('#btnLogout').click(function(){
				localStorage.removeItem('token')
				window.location.href = '<?=site_url('/');?>'
			})
		})
	</script>
	
	<?= $this->renderSection('script') ;?>
</body>
</html>