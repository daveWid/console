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
	 * Parses the content of a log file.
	 *
	 * @param   string   The log file path
	 * @return  View     The view for the parsed content
	 */
	public static function parse($file)
	{
		// Get the log file and remove the first 2 lines
		$log = explode("\n", file_get_contents($file));
		$log = array_slice($log, 2);

		return View::factory('console/entry')->set('log', $log);
	}

	/**
	 * Parses the passed in file into an array (or null if no file)
	 *
	 * @param   string   The file to parse
	 * @return  mixed    An array with year, month, day properties or null
	 */
	public static function parse_file($file)
	{
		if ( ! $file)
		{
			return null;
		}

		$path = pathinfo($file);
		list( $year, $month ) = explode( '/', $path['dirname'] );

		return array(
			'year' => $year,
			'month' => $month,
			'day' => $path['filename']
		);
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

		return ($active['year'] == $year AND $active['month'] == $month AND $active['day'] == $day);
	}

}