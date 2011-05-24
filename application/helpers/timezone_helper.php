<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Timezone Helpers
 *
 * @package		TimeZone
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Stephen Brown
 */

// ------------------------------------------------------------------------

/**
 * Get "now" time
 *
 * Returns time() or its GMT equivalent based on the config file preference
 *
 * @access	public
 * @return	integer
 */
if ( ! function_exists('convert_to_utc'))
{
	function convert_to_utc($strDate)
	{
		$date = new DateTime($strDate);
		$date->setTimezone(new DateTimeZone('UTC'));
		return $date->format('y-m-d h-i-s');
	}
}

/* End of file timezone_helper.php */
/* Location: ./application/helpers/timezone_helper.php */
