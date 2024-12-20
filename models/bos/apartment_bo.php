<?php
/* ********************************************************
 * ********************************************************
 * ********************************************************/
class ApartmentBo extends AbstractBo {

	protected $dao;

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function __construct($actor_name) {
		$this->actor_name = 'apartment';
		$this->dao = new ApartmentDao(new DatabaseConnectionBo());
		$this->do_factory = new DoFactory();
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function isRegistrationValid(ApartmentDo $do) {
		$is_registration_valid = true;

		if (!isset($do->host_user_id)) {
			LogHelper::addWarning(
				"A \"Szállásadó felhasználó azonosító\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->name)) {
			LogHelper::addWarning(
				"A \"Szállás név\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->address)) {
			LogHelper::addWarning(
				"A \"Cím\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->price_value)) {
			LogHelper::addWarning(
				"Az \"Árérték\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->price_uom)) {
			LogHelper::addWarning(
				"Az \" Ármértékegység\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->price_currency)) {
			LogHelper::addWarning(
				"Az \"Pénznem\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->description)) {
			LogHelper::addWarning(
				"A \"Leírás\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->max_occupancy)) {
			LogHelper::addWarning(
				"A \"Maximális létszám\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}
		
		return $is_registration_valid;
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function create(AbstractDo $do) {
		return ($this->dao)->create(
			[
				$do->host_user_id,
                $do->name,
				$do->address,
                $do->price_value,
                $do->price_uom,
                $do->price_currency,
                $do->description,
                $do->max_occupancy,
			]
		);
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function getById($id) {
		return $this->dao->getById([$id]);
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function getList() {
		$do_list = [];
			
		$records = $this->dao->getList();
		
		if (empty($records)) {
			LogHelper::addWarning('There are no records of: ' . $this->actor_name);
		}
		else {
			foreach ($records as $record) {
				$do_list[] = $this->do_factory->get($this->actor_name, $record);
			}
		}
		
		return $do_list;
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function getImagesById($id, $image_type_string) {
		$do_list = [];
		$image_dir = RequestHelper::$file_root . '/cdn/apartment_images';
	
		if (is_dir($image_dir)) {
			if ($handle = opendir($image_dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file !== '.' && $file !== '..') {
						$file_path = $image_dir . '/' . $file;
						if (is_file($file_path) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
							$file_parts = explode('_', pathinfo($file, PATHINFO_FILENAME));
							$actor_name = $file_parts[0];
							$apartment_id = $file_parts[1];
							$image_type = $file_parts[2];

							if ( $id == $apartment_id && $image_type == $image_type_string ) {
								$apartment_image = new ApartmentImageDo();
								$apartment_image->apartment_id = $apartment_id;
								$apartment_image->file_path = $file_path;
								$apartment_image->file_name = $file;
	
								$do_list[] = $apartment_image;
							}
						}
					}
				}
				closedir($handle);
			}
		}
	
		return $do_list;
	}	

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function update(AbstractDo $do) {
		return ($this->dao)->update(
			[
				$do->host_user_id,
				$do->id,
			]
		);
	}
	
}
?>