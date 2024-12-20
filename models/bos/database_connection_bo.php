<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class DatabaseConnectionBo {

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function getConnection() {
			$host          = 'localhost';
            $port          = '3306';
			$database_name = 'booking_system';
			$user_name     = 'booking_system_user';
			$user_password = 'ijNX2dE0ZvUUJAkT7UXcQEiq7RaWA6ittgz1pf6k7AI94sq42L';

			try {
				$connection = new PDO(
					'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database_name,
					$user_name,
					$user_password
				);
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $exception) {
				throw new Exception('Connection failed: ' . $exception->getMessage());
			}

			return $connection;
		}
        
	}
?>