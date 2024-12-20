<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class BookingDao extends AbstractDao {

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function create(array $parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
                INSERT INTO
                    booking_system.bookings
                SET
                    apartment_id            = ?,
					user_id                 = ?,
					start_date        	    = ?,
                    end_date                = ?,
					number_of_guests		= ?,
					total_price				= ?,
                    is_active               = 1,
					created_at				= NOW(),
					updated_at 				= NOW()
			";

			try {
				$database_connection = ($this->database_connection_bo)->getConnection();

				$database_connection
					->prepare($query_string)
					->execute(
						(
							array_map(
								function($value) {
									return $value === '' ? NULL : $value;
								},
								$parameters
							)
						)
					)
				;

				return(
					$database_connection->lastInsertId()
				);
			}
			catch(Exception $exception) {
				LogHelper::addError('ERROR: ' . $exception->getMessage());

				return false;
			}
		}
		
		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function getList() {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					apartment_id,
					user_id,
					start_date,
                    end_date,
					number_of_guests,
					total_price
				FROM
					booking_system.bookings
			";

			try {
				$handler = ($this->database_connection_bo)->getConnection();
				$statement = $handler->prepare($query_string);
				$statement->execute();
				
				return $statement->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(Exception $exception) {
				LogHelper::addError('Error: ' . $exception->getMessage());

				return false;
			}
		}

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function getBookingsByUserId(array $parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT 
					BOOKINGS.id, 
					BOOKINGS.apartment_id, 
					BOOKINGS.user_id, 
					BOOKINGS.start_date, 
					BOOKINGS.end_date, 
					BOOKINGS.number_of_guests, 
					BOOKINGS.total_price 
				FROM 
					booking_system.bookings BOOKINGS
				INNER JOIN 
					booking_system.users USERS ON BOOKINGS.user_id = USERS.id
				WHERE 
					USERS.id = ?
					AND USERS.is_active = 1
					AND BOOKINGS.is_active = 1;
			";

			try {
				$handler = ($this->database_connection_bo)->getConnection();
				$statement = $handler->prepare($query_string);
				$statement->execute(
					array_map(
						function($value) {
							return $value === '' ? NULL : $value;
						},
						$parameters
					)
				);
				
				return $statement->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(Exception $exception) {
				LogHelper::addError('Error: ' . $exception->getMessage());

				return false;
			}
		}
	}
?>
