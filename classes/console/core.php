<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Console Class.
 * Helper functions for the console
 *
 * @package		Console
 * @author		Dave Widmer
 * @copyright	2009 (c) Dave Widmer
 */
class Console_Core
{
	/**
	 * Gets the current month with the given number
	 *
	 * @param	string	Month
	 * @return	string	Month name
	 */
	public static function get_month( $month )
	{
		$months = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);

		return $months[$month];
	}

	/**
	 * Is the date that is being processed the active day?
	 *
	 * @param    array   The active day
	 * @param    string   The year (4 digit)
	 * @param    string   The month (2 digit)
	 * @param    string   The day  (2 digit)
	 * @return   boolean
	 */
	public static function is_active($active, $year, $month, $day)
	{
		if ($active === null)
		{
			return false;
		}

		return ($active AND $year.'/'.$month === $active['dirname'] AND $day === $active['filename']);
	}

}