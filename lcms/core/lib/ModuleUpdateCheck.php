<?php
/**
 * This class tests if any updates exist for the requested module.
 */
class ModuleUpdateCheck{
	
	
	public function getVersionArray($ap){
		$req = "";
			
		for($i = 0;$i < count($ap); $i++){
			
			if($i!=0)
				$req .= "|";
				
			$req .= $ap[$i];
		}
		
		//Return the module update
		return $this->checkForModuleUpdate($req);
	}
	
	/**
	 * This function checks for an update for a particular module at the lotuscms website.
	 */
	protected function checkForModuleUpdate($req){
		if(isset($_SESSION['MOD_LCMS_ORG_RESPONSE'])){
			return $_SESSION['MOD_LCMS_ORG_RESPONSE'];
		}else{
		    include_once("core/lib/RemoteFiles.php");
		    include_once("core/lib/ModuleInfo.php");
		    
		    //Get information on update status of each plugin.
		    
		    //Setup remote file requestor
		    $rf = new RemoteFiles();
		    
		    //Get site version
		    $version = file_get_contents("data/config/site_version.dat");
		    
		    $data = "";
		    
		    if(isset($_SESSION['MOD_LCMS_ORG_RESPONSE_URL'])){	  
		    	    if(!empty($_SESSION['MOD_LCMS_ORG_RESPONSE_URL'])){
		    	    	    $data = $_SESSION['MOD_LCMS_ORG_RESPONSE_URL'];
		    	    }
		    }
		    
		    if(empty($data))
		    {
		    	    //Collect information on module updates.
		    	    $data = $rf->getURL("http://cdn.modules.lotuscms.org/lcms-3-series/versioncontrol/allversioncheck.php?m=$req&v=$version");
		    }
		    	    
		    //Output
		    $out = "";
		    
		    $modArray = array();
		    
		    //Get list of plugins
		    $m = explode("|", $data);
		    
		    //Loop through each update response.
		    for($i = 0;$i < count($m); $i++)
		    {
		    	//Split name & version number
		    	$getFull = explode(":", $m[$i]);
		    		
		    	//Get full number of plugin
		    	$nv = (float)$getFull[1];
		    	
		    	//Get current version
		    	include_once("modules/".$getFull[0]."/".$getFull[0]."ModuleInfo.php");
		    	
		    	$name = $getFull[0]."ModuleInfo";
		    	
		    	//Load info class
		    	$info = new $name();
		    	
		    	//Load info
		    	$info->ModuleInfo();
		    	
		    	//Get current version number
		    	$cv = (float)$info->getVersion();
		    	
		    	//If new version is actually newer than installed.
		    	if($cv<$nv){
		    		$modArray[$getFull[0]] = true; 
		    	}else{
		    		$modArray[$getFull[0]] = false; 
		    	}
		    }
		    
		    //Response
		    $_SESSION['MOD_LCMS_ORG_RESPONSE'] = $modArray;
		    
		    return $modArray;
		}
	}
}
 
?>