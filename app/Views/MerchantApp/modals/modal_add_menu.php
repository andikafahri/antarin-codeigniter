<div class='mam_modal' id='modal_add_menu'>
	<div class='mam_box'>
		<h1 class='mam_title'>Tambah Menu</h1>
		<span class='notHighlight handleCloseModal'><i class='fas fa-close'></i></span>
		<div class='mam_body'>
			<div class='mam_left'>
				<div class='mam_picture' id="image_review">
					<!-- <img src='' alt="" /> -->
				</div>
				<label class='mam_btnUpload notHighlight'>
					<input type="file" id="image" />
					Unggah Gambar
				</label>
				<span>Ketersediaan Menu</span>
				<input type="checkbox" name='is_ready' id='is_ready' checked />
				<label class='mam_isReady notHighlight' for='is_ready'></label>
			</div>
			<div class='mam_right'>
				<div class='mam_inputGroup'>
					<label>Nama<i class='required'> *</i></label>
					<input type="text" id='name' placeholder="Cth: Nasi Goreng"/>
				</div>
				<div class='mam_inputGroup'>
					<label>Detail</label>
					<textarea rows='4' id='detail' placeholder="Cth: Nasi goreng dengan isian ayam suwir, telur orak-arik, dan sosis."></textarea>
				</div>
				<div class='mam_inputGroup'>
					<label>Kategori<i class='required'> *</i></label>
					<!-- <SelectComponent styling={{height: '30px'}} stylingValue={{fontSize: '1rem'}} defaultValue={'Pilih Kategori'} handle={handleCategoryDropdown} isOpen={isOpenCategoryDropdown} isLoading={loadingCategory} data={dataCategory} selected={request?.category ?? ''} onSelect={newCategory => setRequest({...request, category: newCategory})} /> -->
						<select id='id_category'>
							<option value="1">Makanan</option>
							<option value="2">Minuman</option>
						</select>
					</div>
					<div class='mam_inputGroup'>
						<label>Harga<i class='required'> *</i></label>
						<input type="number" id="price" style="text-align: right;" placeholder="Cth: 10000"/>
					</div>
				</div>
			</div>
			<div class='mam_footer'>
				<button class='btn-second handleCloseModal' id='btnCancel'>BATAL</button>
				<button class='btn-primary' id='btnSave'>SIMPAN</button>
			</div>
		</div>
	</div>