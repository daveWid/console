<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Console Controller.
 * Use this to take a look at your logs instead of having to get on the server.
 *
 * @package    Console
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2009 - 2011 © Dave Widmer
 */
class Console_Controller extends Kohana_Controller_Template
{
	/**
	 * @var   string   The path to the template view.
	 */
	public $template = 'console/template';

	/**
	 * @var   string   The name of the log directory to search
	 */
	private $dir = 'logs';

	/**
	 * @var   array|null   An array of year,month,day properties of the file to parse
	 */
	private $file = null;

	/**
	 * Checks for a media file
	 */
	public function before()
	{
		if ($this->request->action() === 'media')
		{
			$this->auto_render = FALSE;
		}
		else
		{
			parent::before();

			$this->file = Console::parse_file($this->request->param('file'));
			$this->dir = $this->request->param('dir');

			$route = Route::get('console/media');

			$this->template->set(array(
				'css' => array
				(
					$route->uri(array('file' => 'css/reset.css')) => 'screen',
					$route->uri(array('file' => 'css/console.css')) => 'screen',
				),
				'js' => array
				(
					'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',
					$route->uri(array('file' => 'js/console.js')),
				),
			));
		}
	}

	/**
	 * Main console page.
	 */
	public function action_index()
	{
		$this->template->title = 'Console';
		$this->template->headline = $this->headline($this->file);
		$this->template->content = $this->log($this->file);
		$this->template->right = $this->build_directory($this->file);
	}

	/**
	 * Gets the log file.
	 *
	 * @param	string	Log file path
	 * @return	string
	 */
	protected function log($file)
	{
		if($file)
		{
			$file = Kohana::find_file($this->dir, $file['year'].DIRECTORY_SEPARATOR.$file['month'].DIRECTORY_SEPARATOR.$file['day']);

			return ($file) ?
				Console::parse($file)->render() :
				Kohana::message('console', 'not_found');
		}
		else
		{
			return Kohana::message('console', 'directions');
		}
	}

	/**
	 * Builds the Log Directory tree
	 *
	 * @param	string	Active file
	 * @return	string
	 */
	protected function build_directory($file)
	{
		$logs = Kohana::list_files($this->dir);

		if( $logs )
		{
			// Create directory array
			$dir = array();

			krsort($logs);

			foreach( $logs as $years => $months )
			{
				krsort( $months );

				foreach( $months as $path => $files )
				{
					krsort($files);

					foreach( $files as $file => $path )
					{
						list( $logs, $year, $month, $fn ) = explode( DIRECTORY_SEPARATOR, $file );
						$day = explode('.', $fn);
						$dir[$year][$month][$day[0]] = str_replace($this->dir . DIRECTORY_SEPARATOR, '', $file);
					}

				}

			}

			return View::factory('console/directory')->set('dir', $dir)->set('active', $this->file)->set('base', Kohana::$base_url)->render();
		}

	}

	/**
	 * Gets the headline (Usually just formatting the log date)
	 *
	 * @param	string	Filename
	 * @return	string	Formatted Date
	 */
	protected function headline($file)
	{
		return (! $file) ?
			"Welcome to Console!" :
			sprintf('%s %s, %s', Console::get_month($file['month']), $file['day'], $file['year']);
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
		$file = Kohana::find_file('media', $path['dirname'] . DIRECTORY_SEPARATOR . $path['filename'], $path['extension']);

		if ($file)
		{
			// Send the file content as the response
			$this->response->body(file_get_contents($file));
		}
		else
		{
			// Return a 404 status
			$this->request->status = 404;
		}

		// Set the content type for this extension
		$this->response->headers('Content-Type', File::mime_by_ext($path['extension']));
	}

}
