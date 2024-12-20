<?php
/* ********************************************************
 * ********************************************************
 * ********************************************************/
class BookingBo extends AbstractBo {

	protected $dao;

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function __construct($actor_name) {
		$this->actor_name = 'booking';
		$this->dao = new BookingDao(new DatabaseConnectionBo());
		$this->do_factory = new DoFactory();
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function isRegistrationValid(BookingDo $do) {
		$is_registration_valid = true;

		if (!isset($do->start_date)) {
			LogHelper::addWarning(
				"A \"Kezdő dátum\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->end_date)) {
			LogHelper::addWarning(
				"Az \"Befejező dátum\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}

		if (!isset($do->number_of_guests)) {
			LogHelper::addWarning(
				"A \"Vendégek száma\" mező nem lehet üres!"
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
				$do->start_date,
                $do->end_date,
                $do->number_of_guests,
                $do->total_price,
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
	public function getBookingsByUserId($id) {
		$do_list = [];
		
		$records = $this->dao->getBookingsByUserId([$id]);
		
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