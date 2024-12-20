<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class DatetimeHelper {

		/* ********************************************************
         * ********************************************************
         * ********************************************************/
        public static function groupUserDOsByMonth($do_list) {
            $birthdays_by_month = [];
        
            foreach ($do_list as $do) {
                if (!empty($do->birthday_at)) {
                    $birthdays_by_month[date("F", strtotime($do->birthday_at))][] = $do;
                }
            }
        
            return $birthdays_by_month;
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public static function formatToBirthday($input_string) {
            // Convert input string into a DateTime object
            $date = new DateTime($input_string);
            
            // Subtract one day
            $date->modify('-1 day');

            // Format the new date to "F j" (e.g., "July 17")
            return $date->format('F j');
        }

    }