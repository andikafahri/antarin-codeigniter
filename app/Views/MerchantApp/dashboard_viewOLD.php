<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title;?></title>
</head>
<body>
	<?= $this->renderSection('header_component') ?>

	
	<div id='data'></div>
	<input type="file" id="image">
	<button id='add'>ADD</button>

	<script src="/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getMenu()

			function getMenu(){
				$.ajax({
					type: 'GET',
					url: '<?=site_url('getMenu');?>',
					dataType: 'JSON',
					headers: {
						'Authorization': localStorage.getItem('token')
					},
					beforeSend: function(){

					},
					success: function(data){
						console.log(data)
					}
				})

				return false
			}

			$('#add').click(function(){
				let formData = new FormData();
				var data = {
					name: 'Test CI',
					detail: '',
					id_category: 1,
					price: '10000',
					is_ready: true
				};

				Object.entries(data).forEach(([key, value]) => {
					formData.append(key, value)
				});

				formData.append('image', document.querySelector('#image').files[0])
				formData.append('variants', JSON.stringify([]))

				$.ajax({
					type: 'POST',
					url: '<?=site_url('addMenu');?>',
					// dataType: 'JSON',
					data: formData,
					contentType: false,
					processData: false,
					headers: {
						'Authorization': localStorage.getItem('token')
					},
					beforeSend: function(){

					},
					success: function(res){
						// $('#data').text(JSON.stringify(res))
						let message = '';
						if(!res.errors){
							alert(res.message)
						}else{
							if(typeof res.errors === 'object'){
								for(const key in res.errors){
									message += `${res.errors[key]}\n`;
								}	
							}else{
								message = res.errors
							}
							alert(message);	
						}
					}
					// error: function(xhr){
					// 	$('#data').text(JSON.stringify(res))
					// }
				})
				console.log([...formData.entries()])

				return false
			})
		})
	</script>
</body>
</html>