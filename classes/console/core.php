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
	 * @var   string   The regex to pull a date out of the log file
	 */
	public static $date_regex = "/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/";

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
		$delimiter = "***";

		// Get the log file and remove the first 2 lines
		$log = str_replace(Kohana::FILE_SECURITY." ?>".PHP_EOL.PHP_EOL, "", file_get_contents($file));
		$log = preg_replace(self::$date_regex, "$delimiter\\0", $log);
		$log = preg_split('/'.preg_quote($delimiter).'/', ltrim($log, $delimiter));

		$parsed = array();
		for ($i = 0, $len = count($log); $i < $len; $i += 1)
		{
			$row = $log[$i];
			$data = self::split_entry($row);

			// And check for an error (which will have a stack trace)
			if ($data['type'] === 'error')
			{
				// Grab the next element in the array which contains the stack trace
				$i += 1;
				$strace = self::split_entry($log[$i]);

				list($row, $trace) = explode("--".PHP_EOL, $strace['log']);
				$data['stacktrace'] = explode(PHP_EOL, rtrim($trace, PHP_EOL));
			}

			$last_type = $data['type'];

			// And set the message
			$data['message'] = $data['log'];

			$parsed[] = $data;
		}

		return View::factory('console/entry')->set('log', $parsed);
	}

	/**
	 * Takes a log entry and splits it into a manageable array.
	 *
	 * @param   string    The log entry
	 * @return  array     Assoc array of (date =>, type =>, log => )
	 */
	public static function split_entry($row)
	{
		// Get the date
		preg_match(self::$date_regex, $row, $matches);
		$data = array(
			'date' => $matches[0],
		);

		// Trim off the date and ---
		$row = str_replace($data['date']." --- ", "", $row);

		// Now get the type
		preg_match("/^\w+/", $row, $matches);
		$data['type'] = strtolower($matches[0]);
		$data['log'] = $row;

		return $data;
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