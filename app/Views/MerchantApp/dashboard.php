<?= $this->extend('MerchantApp/layouts/layout') ?>

<?= $this->section('content') ?>
<div class='dashboard_container'>
	<h1>Kelola Menu</h1>
	<div class='dashboard_header'>
		<div class='dashboard_searchInput'>
			<input type="text" id="searchInput" placeholder="Cari Menu" />
			<button class="btn-primary dashboard_btnSearch" id="btnSearch">Cari</button>
		</div>
		<div class='dashboard_category' id='categoryList'>
		</div>
	</div>

	<div id='menuList'></div>

	<button class='dashboard_btnAdd btn-primary' id='btnAdd'><i class='fas fa-plus'></i> TAMBAH</button>
</div>

<?=$this->include('MerchantApp/modals/modal_add_menu');?>
<?=$this->include('MerchantApp/modals/modal_update_menu');?>

<?= $this->endSection() ?>

<?=$this->section('script');?>
<script type="text/javascript">
	$(document).ready(function(){
		const apiBaseURL = '<?=esc(env('API_BASE_URL'));?>'
		var searchFilter = ''
		var categoryFilter = ''
		getCategory()
		getMenu()

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

		function closeModal(){
			$('#modal_add_menu').removeClass('mam_open')
			$('#modal_update_menu').removeClass('mam_open')
			$('#image_review').html("<img src='/img/no-image.jpg' alt='' />")
			// var newFileInput = $('#image').clone(true);
			// $('#image').replaceWith(newFileInput);
			$('#is_ready').prop('checked', true)
			$('#name').val('')
			$('#detail').val('')
			$('#id_category').val('')
			$('#id_category').val(1)
			$('#price').val('')

			$('#update_modal_add_menu').removeClass('mam_open')
			$('#update_image_review').html("<img src='/img/no-image.jpg' alt='' />")
			// var newFileInput = $('#update_image').clone(true);
			// $('#update_image').replaceWith(newFileInput);
			$('#update_is_ready').prop('checked', true)
			$('#update_name').val('')
			$('#update_detail').val('')
			$('#update_id_category').val('')
			$('#update_id_category').val(1)
			$('#update_price').val('')
		}

		function getCategory(){
			$.ajax({
				type: 'GET',
				url: '<?=site_url('getCategory');?>',
				dataType: 'JSON',
				headers: {
					'Authorization': localStorage.getItem('token')
				},
				beforeSend: function(){
					var html = '<div class="dashboard_loadingCategory">Memuat kategori . . .</div>'
					$('#categoryList').html(html)
				},
				success: function(result){
					var data = result.data
					var list = ''

					list += "<span class='categoryInput dashboard_active' data-id='all'>Semua</span>"
					for(let i=0; i<data.length; i++){
						list += "<span class='categoryInput' data-id='"+data[i].id+"'>"+data[i].name+"</span>";
					}

					$('#categoryList').html(list)
				}
			})
		}

		$('#btnSearch').click(function(){
			searchFilter = $('#searchInput').val()
			getMenu()
		})

		// $('.categoryInput').click(function(){
		// function setCategoryFilter(idCategory = null){
		$('#categoryList').on('click', '.categoryInput', function(){
			$('.categoryInput').removeClass('dashboard_active')
			$(this).addClass('dashboard_active')
			categoryFilter = $(this).data('id')
			getMenu()
		})
		// }
		// })

		function getMenu(){
			$.ajax({
				type: 'GET',
				url: '<?=site_url('getMenu');?>?search=' + encodeURIComponent(searchFilter) + '&category=' + encodeURIComponent(categoryFilter),
				dataType: 'JSON',
				headers: {
					'Authorization': localStorage.getItem('token')
				},
				beforeSend: function(){
					var html = '<div class="dashboard_loadingMenu">Memuat menu . . .</div>'
					$('#menuList').html(html)
				},
				success: function(data){
					var idMerchant = decodeJWT(localStorage.getItem('token')).id
					var data = data.data

					var listComponent = ''
					if(data.length === 0){
						listComponent = '<div class="dashboard_loadingMenu">Data kosong</div>'
					}else{
						var groupByCategory = {}
						data.map((menu) => {
							const idCategory = menu.category.id

							if(!groupByCategory[idCategory]){
								groupByCategory[idCategory] = {
									id: idCategory,
									name: menu.category.name,
									menus: []
								}
							}

							const {category, ...menuWithoutCategory} = menu
							groupByCategory[idCategory].menus.push(menuWithoutCategory)
						})
						var list = Object.values(groupByCategory)
						console.log(list)

						var itemComponent = []
						for(let i=0; i<list.length; i++){
							itemComponent[i] = ''
							for(let j=0; j<list[i].menus.length; j++){
								var status = ''

								if(list[i].menus[j].is_ready){
									status = "<span class='dashboard_ready'>Tersedia</span>"
								}else{
									status = "<span class='dashboard_notReady'>Tidak Tersedia</span>"
								}

								itemComponent[i] += "<div class='dashboard_card handleUpdate' data-id='"+list[i].menus[j].id+"' data-name='"+list[i].menus[j].name+"' data-detail='"+list[i].menus[j].detail+"' data-id_category='"+list[i].id+"' data-price='"+list[i].menus[j].price+"' data-is_ready='"+list[i].menus[j].is_ready+"' data-image='"+list[i].menus[j].image+"'>"+
								status+
								"<div class='dashboard_picture'>"+
								"<img src='"+apiBaseURL+"/img/merchant/"+idMerchant+"/"+list[i].menus[j].image+"' alt='' />"+
								"</div>"+
								"<div class='dashboard_info'>"+
								"<h2>"+list[i].menus[j].name+"</h2>"+
								"<h3>"+Number(list[i].menus[j].price).toLocaleString('id-ID')+"</h3>"+
								"</div>"+
								"</div>";
							}

							listComponent += "<div class='dashboard_group'>"+
							"<h1>"+list[i].name+"</h1>"+
							"<div class='dashboard_body'>"+
							itemComponent[i]+
							"</div>"+
							"</div>";
						}
					}

					$('#menuList').html(listComponent);
				}
			})
		}

		$('.handleCloseModal').click(function(){
			closeModal()
		})

		$('#btnAdd').click(function(){
			const html = "<img src='/img/no-image.jpg' alt='' />"
			$('#image_review').html(html)
			$('#modal_add_menu').addClass('mam_open')
		})

		$('#image').change(function(e){
			var idMerchant = decodeJWT(localStorage.getItem('token')).id
			const file = e.target.files[0]

			if(file.type.startsWith('image/')){
				const html = "<img src='"+URL.createObjectURL(file)+"' alt='' />"
				$('#image_review').html(html)

			}
		})

		$('#btnSave').click(function(){
			let formData = new FormData();


			formData.append('name', $('#name').val())
			formData.append('detail', $('#detail').val())
			formData.append('id_category', $('#id_category').val())
			formData.append('price', $('#price').val())
			formData.append('is_ready', document.getElementById('is_ready').checked)
			formData.append('image', document.querySelector('#image').files[0])
			formData.append('variants', JSON.stringify([]))



			$.ajax({
				type: 'POST',
				url: '<?=site_url('addMenu');?>',
				dataType: 'JSON',
				data: formData,
				contentType: false,
				processData: false,
				headers: {
					'Authorization': localStorage.getItem('token')
				},
				beforeSend: function(){
					$('#btnCancel').prop('disabled', true)
					$('#btnSave').prop('disabled', true)
				},
				success: function(res){
					// let message = '';
					// if(!res.errors){
					// 	alert(res.message)
					// 	closeModal()
					// 	getMenu()
					// }else{
					// 	if(typeof res.errors === 'object'){
					// 		for(const key in res.errors){
					// 			message += `${res.errors[key]}\n`;
					// 		}	
					// 	}else{
					// 		message = res.errors
					// 	}
					// 	alert(message);
					// }
					alert(res.message)

					$('#btnCancel').prop('disabled', false)
					$('#btnSave').prop('disabled', false)
				},
				error: function(res){
					let message = '';
					const json = JSON.parse(res.responseText)
					if(typeof json.errors === 'object'){
						for(const key in json.errors){
							message += `${json.errors[key]}\n`;
						}	
					}else{
						message = json.errors
					}
					alert(message);	
					$('#btnCancel').prop('disabled', false)
					$('#btnSave').prop('disabled', false)
				}

			})
			console.log([...formData.entries()])

			return false
		})

		$('#menuList').on('click', '.handleUpdate', function(){
			var idMerchant = decodeJWT(localStorage.getItem('token')).id
			const image = $(this).data('image')
			const is_ready = $(this).data('is_ready')

			if(is_ready){
				$('#update_is_ready').prop('checked', true)
			}else{
				$('#update_is_ready').prop('checked', false)
			}

			$('#id_menu').val($(this).data('id'))
			$('#update_image_review').html("<img src='"+apiBaseURL+"/img/merchant/"+idMerchant+"/"+image+"' alt='' />")
			$('#update_name').val($(this).data('name'))
			$('#update_detail').val($(this).data('detail'))
			$('#update_id_category').val($(this).data('id_category'))
			$('#update_price').val($(this).data('price'))

			$('#modal_update_menu').addClass('mam_open')
		})

		$('#update_image').change(function(e){
			var idMerchant = decodeJWT(localStorage.getItem('token')).id
			const file = e.target.files[0]

			if(file.type.startsWith('image/')){
				const html = "<img src='"+URL.createObjectURL(file)+"' alt='' />"
				$('#update_image_review').html(html)

			}
		})

		$('#btnUpdate').click(function(){
			let formData = new FormData();


			formData.append('name', $('#update_name').val())
			formData.append('detail', $('#update_detail').val())
			formData.append('id_category', $('#update_id_category').val())
			formData.append('price', $('#update_price').val())
			formData.append('is_ready', document.getElementById('update_is_ready').checked)

			if(document.getElementById('update_image').files.length !== 0){
				formData.append('image', document.querySelector('#update_image').files[0])
			}



			$.ajax({
				type: 'POST',
				url: '<?=site_url('updateMenu?id=');?>' + $('#id_menu').val(),
					dataType: 'JSON',
				data: formData,
				contentType: false,
				processData: false,
				headers: {
					'Authorization': localStorage.getItem('token')
				},
				beforeSend: function(){
					$('#btnDelete').prop('disabled', true)
					$('#btnUpdate').prop('disabled', true)
				},
				success: function(res){
					// let message = '';
					// if(!res.errors){
					// 	alert(res.message)
					// 	closeModal()
					// 	getMenu()
					// }else{
					// 	if(typeof res.errors === 'object'){
					// 		for(const key in res.errors){
					// 			message += `${res.errors[key]}\n`;
					// 		}	
					// 	}else{
					// 		message = res.errors
					// 	}
					// 	alert(message);	
					// }
					alert(message);	

					$('#btnDelete').prop('disabled', false)
					$('#btnUpdate').prop('disabled', false)
				},
				error: function(res){
					let message = '';
					const json = JSON.parse(res.responseText)
					if(typeof json.errors === 'object'){
						for(const key in json.errors){
							message += `${json.errors[key]}\n`;
						}	
					}else{
						message = json.errors
					}
					alert(message);	
					$('#btnDelete').prop('disabled', false)
					$('#btnUpdate').prop('disabled', false)
				}
			})
			console.log([...formData.entries()])

			return false
		})

		$('#btnDelete').click(function(){
			$.ajax({
				type: 'DELETE',
				url: '<?=site_url('deleteMenu?id=');?>' + $('#id_menu').val(),
				dataType: 'JSON',
				headers: {
					'Authorization': localStorage.getItem('token')
				},
				beforeSend: function(){
					$('#btnDelete').prop('disabled', true)
					$('#btnUpdate').prop('disabled', true)
				},
				success: function(res){
					let message = '';
					if(!res.errors){
						alert(res.message)
						closeModal()
						getMenu()
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

					$('#btnDelete').prop('disabled', false)
					$('#btnUpdate').prop('disabled', false)
				}
			})

			return false
		})

		// ORI
		// $('#btnSave').click(function(){
		// 	let formData = new FormData();
		// 	var data = {
		// 		name: 'Test CI',
		// 		detail: '',
		// 		id_category: 1,
		// 		price: '10000',
		// 		is_ready: true
		// 	};

		// 	Object.entries(data).forEach(([key, value]) => {
		// 		formData.append(key, value)
		// 	});

		// 	formData.append('image', document.querySelector('#image').files[0])
		// 	formData.append('variants', JSON.stringify([]))

		// 	$.ajax({
		// 		type: 'POST',
		// 		url: '<?=site_url('addMenu');?>',
		// 			// dataType: 'JSON',
		// 		data: formData,
		// 		contentType: false,
		// 		processData: false,
		// 		headers: {
		// 			'Authorization': localStorage.getItem('token')
		// 		},
		// 		beforeSend: function(){

		// 		},
		// 		success: function(res){
		// 				// $('#data').text(JSON.stringify(res))
		// 			let message = '';
		// 			if(!res.errors){
		// 				alert(res.message)
		// 			}else{
		// 				if(typeof res.errors === 'object'){
		// 					for(const key in res.errors){
		// 						message += `${res.errors[key]}\n`;
		// 					}	
		// 				}else{
		// 					message = res.errors
		// 				}
		// 				alert(message);	
		// 			}
		// 		}
		// 			// error: function(xhr){
		// 			// 	$('#data').text(JSON.stringify(res))
		// 			// }
		// 	})
		// 	console.log([...formData.entries()])

		// 	return false
		// })
	})
</script>
<?= $this->endSection() ?>