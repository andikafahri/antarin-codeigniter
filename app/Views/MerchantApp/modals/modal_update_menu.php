<div class='mam_modal' id='modal_update_menu'>
	<div class='mam_box'>
		<h1 class='mam_title'>Tambah Menu</h1>
		<span class='notHighlight handleCloseModal'><i class='fas fa-close'></i></span>
		<div class='mam_body'>
			<input type="hidden" id="id_menu">
			<div class='mam_left'>
				<div class='mam_picture' id="update_image_review">
					<!-- <img src='' alt="" /> -->
				</div>
				<label class='mam_btnUpload notHighlight'>
					<input type="file" id="update_image" />
					Unggah Gambar
				</label>
				<span>Ketersediaan Menu</span>
				<input type="checkbox" name='is_ready' id='update_is_ready' checked />
				<label class='mam_isReady notHighlight' for='update_is_ready'></label>
			</div>
			<div class='mam_right'>
				<div class='mam_inputGroup'>
					<label>Nama<i class='required'> *</i></label>
					<input type="text" id='update_name' placeholder="Cth: Nasi Goreng"/>
				</div>
				<div class='mam_inputGroup'>
					<label>Detail</label>
					<textarea rows='4' id='update_detail' placeholder="Cth: Nasi goreng dengan isian ayam suwir, telur orak-arik, dan sosis."></textarea>
				</div>
				<div class='mam_inputGroup'>
					<label>Kategori<i class='required'> *</i></label>
					<!-- <SelectComponent styling={{height: '30px'}} stylingValue={{fontSize: '1rem'}} defaultValue={'Pilih Kategori'} handle={handleCategoryDropdown} isOpen={isOpenCategoryDropdown} isLoading={loadingCategory} data={dataCategory} selected={request?.category ?? ''} onSelect={newCategory => setRequest({...request, category: newCategory})} /> -->
						<select id='update_id_category'>
							<option value="1">Makanan</option>
							<option value="2">Minuman</option>
						</select>
					</div>
					<div class='mam_inputGroup'>
						<label>Harga<i class='required'> *</i></label>
						<input type="number" id="update_price" style="text-align: right;" placeholder="Cth: 10000"/>
					</div>
				</div>
			</div>
			<div class='mam_footer'>
				<button class='mum_btnDelete' id='btnDelete'>HAPUS</button>
				<button class='btn-primary' id='btnUpdate'>SIMPAN</button>
			</div>
		</div>
	</div>