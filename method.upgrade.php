<?php
if (!isset($gCms)) exit;

	/*---------------------------------------------------------
	   Upgrade()
	   If your module version number does not match the version
	   number of the installed module, the CMS Admin will give
	   you a chance to upgrade the module. This is the function
	   that actually handles the upgrade.
	   Ideally, this function should handle upgrades incrementally,
	   so you could upgrade from version 0.0.1 to 10.5.7 with
	   a single call. For a great example of this, see the News
	   module in the standard CMS install.
	  ---------------------------------------------------------*/

        // Database
        $gtn = cms_db_prefix()."module_practiceportal_"; // Global Table Name

        $db =& $gCms->GetDb();

        $taboptarray = array('mysql' => 'TYPE=MyISAM');
        $dict = NewDataDictionary($db);
                
		$current_version = $oldversion;
		switch($current_version)
		{
			case "0.1":
               // table settings
           $flds = "
                       `key` C(80) KEY,
                       value X
                       ";
                $sqlarray = $dict->CreateTableSQL($gtn."settings",
                       $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                 
                 // Insert required settings
                $sql = 'INSERT INTO '.$gtn.'settings (`key`, `value`) VALUES (?, ?)';
                $db->Execute($sql, array('introbody','<p>Welcome to our practice portal, designed to help you find the information you need as quickly as possible.</p><p>To start, please select the location with which you are having difficulty on the outline on the right.</p>'));
                $db->Execute($sql, array('mainttile','<h3>Practice Portal</h3>'));
                $db->Execute($sql, array('conditionknown','I already know my condition'));
			    break;
			case "0.2":
                break;
		}
		
		// put mention into the admin log
		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));

?>