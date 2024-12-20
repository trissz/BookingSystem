<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ReviewDao extends AbstractDao {

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function create(array $parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
                INSERT INTO
                    booking_system.reviews
                SET
                    apartment_id            = ?,
					user_id                 = ?,
					rating        			= ?,
                    comment                 = ?,
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
					rating,
					comment
				FROM
					booking_system.reviews
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

		 public function getListByApartmentId(array $parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					id,
                    apartment_id,
                    user_id,
                    rating,
                    comment,
					is_active,
					created_at,
					updated_at
				FROM
					booking_system.reviews REVIEWS
				WHERE
					REVIEWS.apartment_id = ?
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
				
				return $statement->fetchAll(PDO::FETCH_ASSOC); //We need this: [0] or not? NO TRISZ I WON'T DELETE THIS COMMENT ;)
			}
			catch(Exception $exception) {
				LogHelper::addError('Error: ' . $exception->getMessage());

				return false;
			}
		}
	}
?>
