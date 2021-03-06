<?php

include_once("core/lib/page.php");

class View extends Page{

	//Controller Variable Local
	protected $con;
	
	/**
	 * Set the local Controller
	 */
	public function setController($con){
		$this->con = $con;
	}
	
	/**
	 * Get the local Controller
	 */
	public function getController(){
		return $this->con;
	}
	
	/**
	 * Gets the locale from the session information.
	 */
	public function getLocale(){
		
		//Returns SESSION locale
		return $this->getController()->getModel()->getInputString("locale","","S");
	}

	/**
	 * Process Blank Request
	 */
	public function noPage(){
		
		//Get the not exist page
		$not_exist = file_get_contents("core/fragments/404.phtml");
		
		//Set the Title
		$this->setContentTitle($this->localize("404 - Page does not Exist"));
				
		//Set the 404 page
		$this->setContent($not_exist);
	}
	
	/**
	* Load the proper language file and return the translated phrase
	*
	* The language file is JSON encoded and returns an associative array
	* Language filename is determined by BCP 47 + RFC 4646
	* http://www.rfc-editor.org/rfc/bcp/bcp47.txt
	*
	* @param string $phrase The phrase that needs to be translated
	* @return string
	*/
	public function localize($phrase) {
	    /* Static keyword is used to ensure the file is loaded only once */
	    static $translations = NULL;
	    
	    /* If no instance of $translations has occured load the language file */
	    if (is_null($translations)) {
	        $lang_file =  'core/lang/' . $this->getLocale() . '.txt';
	        if (!file_exists($lang_file)) {
	            $lang_file = 'core/lang/' . 'en.txt';
	        }
	        $lang_file_content = file_get_contents($lang_file);
	        
	        /* Load the language file as a JSON object and transform it into an associative array */
	        include_once("core/lib/JSON.php");
	        $js = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
	        $translations = $js->decode($lang_file_content );
	    }

	    if(!empty($translations[$phrase])){
	    	return $translations[$phrase];
	    }else{
	    	return $phrase;	
	    }
	}

	/**
	 * A function for the settings file that sets which tab is active
	 */ 
	protected function setTabActive($active = 1, $tabs){
		
		if($active==1){
			$tabs = str_replace("%ONE%", "active", $tabs);
		}else{
			$tabs = str_replace("%ONE%", "inactive", $tabs);
		}
		
		if($active==2){
			$tabs = str_replace("%TWO%", "active", $tabs);
		}else{
			$tabs = str_replace("%TWO%", "inactive", $tabs);
		}
		
		if($active==3){
			$tabs = str_replace("%THREE%", "active", $tabs);
		}else{
			$tabs = str_replace("%THREE%", "inactive", $tabs);
		}
		
		if($active==4){
			$tabs = str_replace("%FOUR%", "active", $tabs);
		}else{
			$tabs = str_replace("%FOUR%", "inactive", $tabs);
		}
		
		return $tabs;
	}
}

?>