<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sparks
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		CodeIgniter Reactor Dev Team
 * @author      Kenny Katzgrau <katzgrau@gmail.com>
 * @since		CodeIgniter Version 1.0
 * @filesource
 */

/**
 * Loader Class
 *
 * Loads views and files
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		CodeIgniter Reactor Dev Team
 * @author      Kenny Katzgrau <katzgrau@gmail.com>
 * @category	Loader
 * @link		http://codeigniter.com/user_guide/libraries/loader.html
 */

require 'vendor/autoload.php';

use Illuminate\View;
use Illuminate\Events;
use Illuminate\Filesystem;

class MY_Loader extends CI_Loader
{
    /**
     * Keep track of which sparks are loaded. This will come in handy for being
     *  speedy about loading files later.
     *
     * @var array
     */
    protected $_ci_loaded_sparks = array();
    private $phpcrypt;

    /**
     * Constructor. Define SPARKPATH if it doesn't exist, initialize parent
     */
    function __construct()
    {
        if(!defined('SPARKPATH'))
        {
            define('SPARKPATH', APPPATH.'sparks/');
        }
        $CI =& get_instance();
        $CI->config->load('encrypt', true);

        $this->phpcrypt = new \PHPEncryptData\Simple(
            $CI->config->item('encrypt_key', 'encrypt'),
            $CI->config->item('encrypt_mac', 'encrypt')
        );
        parent::__construct();
    }

    // ecription
    public function encrypt($data = '')
    {
        return $this->phpcrypt->encrypt($data);
    }

    public function decrypt($data = '')
    {
        return $this->phpcrypt->decrypt($data);
    }

    public function blade($view, array $parameters = array())
    {
        $CI =& get_instance();
        $CI->config->load('blade', true);
        $CI->load->driver('session');
        $parameters['controller_name'] = $CI->router->fetch_class();
        $parameters['action_name'] = $CI->router->fetch_method();
        $parameters['uri_1'] = $CI->uri->segment(1);
        $parameters['base_url'] = $CI->config->base_url();

        if ($CI->session->has_userdata('logged_in'))
        {
            $parameters['current_user'] = Model_User::find_by_user_id($CI->session->userdata('user_id'));
        }

        // Get paths from configuration
        $viewsPaths = $CI->config->item('views_paths', 'blade');
        $cachePath = $CI->config->item('cache_path', 'blade');

        // Create the file system objects
        $fileSystem = new Filesystem\Filesystem();
        $fileFinder = new View\FileViewFinder($fileSystem, $viewsPaths);

        // Create the Blade engine and register it
        $bladeEngine = new View\Engines\CompilerEngine(
            new View\Compilers\BladeCompiler($fileSystem, $cachePath)
        );

        $engineResolver = new View\Engines\EngineResolver();
        $engineResolver->register('blade', function() use ($bladeEngine) {
            return $bladeEngine;
        });

        // Create the environment object
        $environment = new View\Environment(
            $engineResolver,
            $fileFinder,
            new Events\Dispatcher()
        );

        // Create the view
        return new View\View(
            $environment,
            $bladeEngine,
            $view,
            $fileFinder->find($view),
            $parameters
        );
    }


    /**
	* Load a spark by it's path within the sparks directory defined by
	* SPARKPATH, such as 'markdown/1.0'
	* @param string $spark The spark path withint he sparks directory
	* @param <type> $autoload An optional array of items to autoload
	* in the format of:
	* array (
	* 'helper' => array('somehelper')
	* )
	* @return void
	*/
    function spark($spark, $autoload = array())
    {
        if(is_array($spark))
        {
            foreach($spark as $s)
            {
                $this->spark($s);
            }
        }

        $spark = ltrim($spark, '/');
        $spark = rtrim($spark, '/');

        $spark_path = SPARKPATH . $spark . '/';
        $parts = explode('/', $spark);
        $spark_slug = strtolower($parts[0]);

        # If we've already loaded this spark, bail
        if(array_key_exists($spark_slug, $this->_ci_loaded_sparks))
        {
            return true;
        }

        # Check that it exists. CI Doesn't check package existence by itself
        if(!file_exists($spark_path))
        {
            show_error("Cannot find spark path at $spark_path");
        }

        if(count($parts) == 2)
        {
            $this->_ci_loaded_sparks[$spark_slug] = $spark;
        }

        $this->add_package_path($spark_path);

        foreach($autoload as $type => $read)
        {
            if($type == 'library')
                $this->library($read);
            elseif($type == 'model')
                $this->model($read);
            elseif($type == 'config')
                $this->config($read);
            elseif($type == 'helper')
                $this->helper($read);
            elseif($type == 'view')
                $this->view($read);
            else
                show_error ("Could not autoload object of type '$type' ($read) for spark $spark");
        }

        // Looks for a spark's specific autoloader
        $this->_ci_autoloader($spark_path);
    }


	/**
	* Autoloader
	*
	* The config/autoload.php file contains an array that permits sub-systems,
	* libraries, and helpers to be loaded automatically.
	*
	* @param string Optional. The path of the package to be autoloaded.
	* Default to the appplication path.
	* @return void
	*/
	protected function _ci_autoloader($package_path = NULL)
	{
        $autoload_base = APPPATH;

        if ($package_path !== NULL)
        {
            $autoload_base = rtrim($package_path, ',') . '/';
        }

        if (defined('ENVIRONMENT') AND file_exists($autoload_base.'config/'.ENVIRONMENT.'/autoload.php'))
        {
            include($autoload_base.'config/'.ENVIRONMENT.'/autoload.php');
        }
        else if(file_exists($autoload_base.'config/autoload.php'))
        {
            include($autoload_base.'config/autoload.php');
        }

		if ( ! isset($autoload))
		{
			return FALSE;
		}

		// Autoload packages
		if (isset($autoload['packages']))
		{
			foreach ($autoload['packages'] as $package_path)
			{
				$this->add_package_path($package_path);
			}
		}

		        // Autoload sparks
		if (isset($autoload['sparks']))
		{
			foreach ($autoload['sparks'] as $spark)
			{
				$this->spark($spark);
			}
		}

		// Autoload helpers and languages
		// load before config, in case config needs helper or language
		foreach (array('helper', 'language') as $type)
		{
			if (isset($autoload[$type]) && count($autoload[$type]) > 0)
			{
				$this->$type($autoload[$type]);
			}
		}

		// Load any custom config file
		if (isset($autoload['config']) && count($autoload['config']) > 0)
		{
			$CI =& get_instance();
			foreach ($autoload['config'] as $key => $val)
			{
				$CI->config->load($val);
			}
		}

		// Load libraries
		if (isset($autoload['libraries']) && count($autoload['libraries']) > 0)
		{
			// Load the database driver.
			if (in_array('database', $autoload['libraries']))
			{
				$this->database();
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			// Load all other libraries
			foreach ($autoload['libraries'] as $item)
			{
				$this->library($item);
			}
		}

		// Autoload models
		if (isset($autoload['model']))
		{
		$this->model($autoload['model']);
		}
	}

}