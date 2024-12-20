<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
    //TODO: do this!!!
	class BoFactory {
		const USER 	  			= "User";
		const APARTMENT 		= "Apartment";
		const APARTMENT_IMAGE 	= "ApartmentImage";
		const BOOKING			= "Booking";
		const REVIEW			= "Review";

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function get(string $class_actor, $attributes = null) {
			$class_name = $class_actor . "Bo";
			
			return new $class_name($attributes, strtolower($class_actor));
		}
		
		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public function getActorList() {
			return [
				self::USER,
				self::APARTMENT,
				self::APARTMENT_IMAGE,
				self::BOOKING,
				self::REVIEW
			];
		}
	}
?>