<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Devtime
 *
 * Set language code from URI
 * 
 *	lang : refers to lang code (ex : en, es)
 *	language : refers to CI directory within application/language (ex : english, spanish)
 * 
 * @package		Language
 * @author		<share@devtime.com> Devtime and jayalfredprufrock
 * @name		Language.php
 * @link        http://www.devtime.com
 * @version		1.0.0
 */

class Language
{
	/**
	 * The active lang code 
	 * @var string 
	 */
	private $lang = FALSE;
	
	/**
	 * Array of all languages ('code' => 'language')
	 * Defined in config file
	 * @var array
	 */
	private $_languages = array();
	
	/**
	 * Array of all autodetect methods to try (subdomain, uri, browser)
	 * Defined in config file
	 * @var array
	 */
	private $_autodetect = array();


	private $_ci;

    /**
     * Construct with configuration array. Codeigniter will use the config file otherwise
     * @param array $config
     */
    public function __construct($config = array()) {
       
	    $this->_ci = & get_instance();
        
        if (!empty($config)) {
        	
            $this->initialize($config);
        }
        
        log_message('debug', 'Language spark initialized.');
    }
    
    /**
     * Initialize with configuration array
     * @param array $config
     * @return Template
     */
    public function initialize($config = array()) {
    	
        foreach ($config as $key => $val) {
           
		    $this->{'_' . $key} = $val;
        } 
    }
    
	
	public function get($fullname = FALSE)
	{
		if (!$this->lang){
			
			$this->set();
		}	
			
		return $fullname ? $this->_languages[$this->lang] : $this->lang;
	}
	
	
	public function set($language = FALSE)
	{
		
		if ($language){
			
			$this->lang = strlen($language) == 2 && isset($this->_languages[$language]) ? $language
															                            : array_search($language, $this->_languages);
		}
		
		//if manual override language not found, proceed to auto-detect
		if (!$this->lang){
			
			$this->lang = $this->autodetect();
		}
		
		if ($this->lang){
			
			$this->_ci->config->set_item('language', $this->_languages[$this->lang]);
			
			return $this->lang;
		}
		
		return FALSE;
	}
	
	private function autodetect()
	{
		
		foreach($this->_autodetect as $type){
			
			if ($this->lang = $this->{'detect_'.$type}()){
				
				break;
			}
		}
		
		//return autodetected language or default
		return $this->lang ?: array_search($this->_ci->config->item('language'), $this->_languages);
	}
	
	private function detect_subdomain()
	{
		$url = explode('.',$_SERVER['HTTP_HOST']);
		
		return count($url) > 2 && isset($this->_languages[$url[0]]) ? $url[0] : FALSE;
	}
	
	private function detect_uri()
	{
		
		$uri = $this->_ci->uri->segment(1);
		
		return isset($this->_languages[$uri]) ? $uri : FALSE;
	}
	
	private function detect_browser()
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$browser_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach ($browser_langs as $str_lang)
			{
				$lang = substr($str_lang, 0, 2);
				if(isset($this->_languages[$lang]))
				{
					return $lang;
				}
			}
		}
		
		return FALSE;
	}
	
}