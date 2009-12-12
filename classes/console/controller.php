<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Console Controller.
 * Use this to take a look at your logs instead of having to get on the server.
 *
 * @package		Console
 * @author		Dave Widmer
 * @copyright	2009 (c) Dave Widmer
 */
class Console_Controller extends Kohana_Controller_Template
{
	// Sets the template variable
	public $template = 'console/template';

	/**
	 * Checks for a media file
	 */
	public function before()
	{
		if( $this->request->action == 'media' ) $this->auto_render = FALSE;
		parent::before();
	}

	/**
	 * Main console page.
	 */
	public function action_index()
	{
		$file = $this->request->param('file');
		$this->template->title = 'Console';
		$this->template->headline = $this->headline( $file );
		$this->template->content = $this->log( $file );
		$this->template->right = $this->build_directory( $file );
	}

	/**
	 * Gets the log file.
	 *
	 * @param	string	Log file path
	 * @return	string
	 */
	protected function log( $file )
	{
		if( $file )
		{
			$path = pathinfo($file);
			$file = Kohana::find_file('logs', $path['dirname'] . '/' . $path['filename'], $path['extension'] );

			if( $file )
			{
				$content = file_get_contents( $file );
				return $this->parse( $content );
			}
			else
			{
				return Kohana::message( 'console', 'not_found' );
			}

		}
		else
		{
			return Kohana::message( 'console', 'directions');
		}

	}

	/**
	 * Parses the log file
	 *
	 * @param	string	Log Text
	 * @return	string
	 */
	protected function parse( $text )
	{
		// Remove the first to lines
		$log = explode( "\n", $text );
		$log = array_slice( $log, 2 );

		return  View::factory('console/entry')->set('log', $log)->render();
	}

	/**
	 * Builds the Log Directory tree
	 *
	 * @param	string	Active file
	 * @return	string
	 */
	protected function build_directory( $file )
	{
		$logs = Kohana::list_files('logs');

		if( $logs )
		{
			// Create directory array
			$dir = array();

			// Get the active file info
			$active = ($file) ? pathinfo( $file ) : NULL;

			krsort($logs);

			foreach( $logs as $years => $months )
			{
				krsort( $months );

				foreach( $months as $path => $files )
				{
					krsort($files);

					foreach( $files as $file => $path )
					{
						list( $logs, $year, $month, $fn ) = explode( '/', $file );
						$day = explode('.', $fn);
						$dir[$year][$month][$day[0]] = str_replace('logs/', '', $file);
					}

				}

			}

			return View::factory('console/directory')->set('dir', $dir)->set('active', $active)->render();
		}

	}

	/**
	 * Gets the headline (Usually just formatting the log date)
	 *
	 * @param	string	Filename
	 * @return	string	Formatted Date
	 */
	protected function headline( $file )
	{
		if( ! $file )
		{
			return 'Welcome to Console!';
		}
		else
		{
			$path = pathinfo($file);
			list( $year, $month ) = explode( '/', $path['dirname'] );
			$day = $path['filename'];

			return sprintf( '%s %s, %s', Console::get_month($month), $day, $year );
		}
	}

	/**
	 * Displays media files
	 */
	public function action_media()
	{
		// Get the file path from the request
		$file = $this->request->param('file');

		// Find the file extension
		$path = pathinfo($file);
		// Array ( [dirname] => css [basename] => reset.css [extension] => css [filename] => reset )
		$file = Kohana::find_file('media', $path['dirname'] . '/' . $path['filename'], $path['extension']);

		if ($file)
		{
			// Send the file content as the response
			$this->request->response = file_get_contents($file);
		}
		else
		{
			// Return a 404 status
			$this->request->status = 404;
		}

		// Set the content type for this extension
		$this->request->headers['Content-Type'] = File::mime_by_ext($path['extension']);
	}

}