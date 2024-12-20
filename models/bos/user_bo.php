<?php
/* ********************************************************
 * ********************************************************
 * ********************************************************/
class UserBo extends AbstractBo {
	
	const SECRET_BLACK_MAGIC = "MarMegintDuhbeJovunk";

	protected $dao;

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function __construct($actor_name) {
		$this->actor_name = 'user';
		$this->dao = new UserDao(new DatabaseConnectionBo());
		$this->do_factory = new DoFactory();
	}
  
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function getHashFromPassword(UserDo $do) {
		return md5($do->password . self::SECRET_BLACK_MAGIC);
	}

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function isRegistrationValid(UserDo $do) {
		$is_registration_valid = true;

		if ($do->name == '') {
			LogHelper::addWarning(
				"A \"Felhasználónév\" mező nem lehet üres!"
			);

			$is_registration_valid = false;
		}
		
		if ($do->email == '') {
			LogHelper::addWarning(
				"Az \"Email-cím\" mező nem lehet üres!"
			);
			
			$is_registration_valid = false;
		}

		if (!($this->isUserEmailUnique($do->email))) {
			LogHelper::addWarning(
				"Az ön által megadott Email címmel már regisztráltak!"
			);
			
			$is_registration_valid = false;
		}
		
		if (!filter_var($do->email, FILTER_VALIDATE_EMAIL)) {
			LogHelper::addWarning(
				"Az \"Email-cím\" mező formailag nem felel meg!"
			);
			
			$is_registration_valid = false;
		}

		$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/"; //hossz: minimum 8, legalább egy nagy, kis betű és legalább egy szám
		
		if ($do->password == '') {
			LogHelper::addWarning(
				"A \"Jelszó\" mező nem lehet üres!"
			);
			
			$is_registration_valid = false;
		}
		
		if ($do->password === NULL) {
			LogHelper::addWarning(
				"A \"Jelszó\" mező nem lehet NULL!"
			);

			$is_registration_valid = false;
		}
		else {
			if (!preg_match_all($password_regex, $do->password)) {
				LogHelper::addWarning(
					"A \"Jelszó\" mező nem felel meg a formai követelményeknek!"
				);
				
				$is_registration_valid = false;
			}
		}
		
		if ($do->password_again == '') {
			LogHelper::addWarning(
				"A \"Jelszó újra begépelve\" mező nem lehet üres!"
			);
			
			$is_registration_valid = false;
		}
		
		if ($do->password !== $do->password_again) {
			LogHelper::addWarning(
				"A megadott jelszó és annak ismétlése nem egyezik!"
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
				$do->name,
                $do->email,
				$do->password_hash,
                $do->phone,
                $do->role,
			]
		);
	}
  
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	public function isUserEmailUnique($email) {
		return count(($this->dao)->isUserEmailUnique([$email])) === 0;
	}

	/* ********************************************************
	* ********************************************************
	* ********************************************************/
	public function login(AbstractDo $do) {
		$this->validateDoForLogin($do);

		if (!$this->isDoValidForLogin($do)) {
			return false;
		}

		$password_hash_to_verify = $do->password_hash;
		$do = $this->do_factory->get($this->actor_name, $this->dao->getByEmail([$do->email]));
		$password_hash_to_compare = $do->password_hash;

		if (isset($do->id)) {
			LogHelper::addMessage('Found user with id: #' . $do->id);

			if (                    
				$password_hash_to_verify === $password_hash_to_compare
			) {
				LogHelper::addConfirmation('Login successfull!');
				
				LogHelper::addConfirmation('Generating session...');
				//session_regenerate_id(true);
				$_SESSION['user_id']        = $do->id;
				$_SESSION['user_name']      = $do->name;
				$_SESSION['is_logged_in']   = true;

				LogHelper::addConfirmation('Generating cookie...');
				setcookie(
					'user_id', 
					$do->id, 
					time() + (86400 * 30), // 30 days expiration time
					"/", 
					"", 
					true, // Secure flag: only send over HTTPS
					true // HttpOnly flag: JavaScript cannot access the cookie
				);
				//TODO: This does not create the COOKIE with user_id ... :(
				/*setcookie(
					'user_id',
					$do->id,
					[
						'expires' => time() + (86400 * 30), // 30 days expiration time,
						'path' => '/',
						'domain' => '*.unithe.hu',
						'secure' => true, // Secure flag: only send over HTTPS
						'httponly' => true, // HttpOnly flag: JavaScript cannot access the cookie
						'samesite' => 'None',
					]
				);*/

				if (in_array("Login successfull!", LogHelper::getConfirmations(), true)) {
					header("Location: " . RequestHelper::$url_root . '/' . RequestHelper::$actor_name . '/' . 'view/' . $do->id);
				}
			}
			else {
				LogHelper::addWarning('Incorrect password!');
			}
		}
		else {
			LogHelper::addWarning('Was not able to find account for: ' . $_POST['email']);
		}
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
	public function getListByRole($role) {
		$do_list = [];
			
		$records = $this->dao->getListByRole([$role]);
		
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
	public function update(AbstractDo $do) {
		return ($this->dao)->update(
			[
				$do->name,
				$do->id,
			]
		);
	}

	
}
?>