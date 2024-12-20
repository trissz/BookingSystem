<?php
/* ********************************************************
 * ********************************************************
 * ********************************************************/
class CurrencyBo extends AbstractBo {

	protected $dao;

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function __construct($actor_name) {
		$this->actor_name = 'currency';
		$this->dao = new CurrencyDao(new DatabaseConnectionBo());
		$this->do_factory = new DoFactory();
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function create(AbstractDo $do) {
		return ($this->dao)->create(
			[
				$do->currency_name,
			]
		);
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

	
}
?>