<?php
/* ********************************************************
 * ********************************************************
 * ********************************************************/
class ReviewBo extends AbstractBo {

	protected $dao;

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function __construct($actor_name) {
		$this->actor_name = 'review';
		$this->dao = new ReviewDao(new DatabaseConnectionBo());
		$this->do_factory = new DoFactory();
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function isRegistrationValid(ReviewDo $do) {
		$is_registration_valid = true;

		if (!isset($do->rating)) {
			LogHelper::addWarning(
				"A \"Értékelés\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->comment)) {
			LogHelper::addWarning(
				"Az \"Vélemény\" mező nem lehet üres!"
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
				$do->apartment_id,
                $do->user_id,
				$do->rating,
                $do->comment,
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
	public function getAverageRatingByApartmentId($id) {
		$records = $this->dao->getListByApartmentId([$id]);

		$do_list = [];
		
		if (empty($records)) {
			LogHelper::addWarning('There are no records of: ' . $this->actor_name);
		}
		else {
			foreach ($records as $record) {
				$do_list[] = $this->do_factory->get($this->actor_name, $record);
			}
		}

		$sum = 0;

		foreach($do_list as $do) {
			$sum += $do->rating;
		}

		return sizeof($do_list) != 0 ? $sum / sizeof($do_list) : "-";
		
	}
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function getListByApartmentId($id) {
		$records = $this->dao->getListByApartmentId([$id]);

		$do_list = [];
		
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
}
?>