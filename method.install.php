<?php
if (!isset($gCms)) exit;

	/*---------------------------------------------------------
	   Install()
	   When your module is installed, you may need to do some
	   setup. Typical things that happen here are the creation
	   and prepopulation of database tables, database sequences,
	   permissions, preferences, etc.
	   	   
	   For information on the creation of database tables,
	   check out the ADODB Data Dictionary page at
	   http://phplens.com/lens/adodb/docs-datadict.htm
	   
	   This function can return a string in case of any error,
	   and CMS will not consider the module installed.
	   Successful installs should return FALSE or nothing at all.
	  ---------------------------------------------------------*/
		/*
		// Typical Database Initialization
		$db =& $gCms->GetDb();
		
		// mysql-specific, but ignored by other database
		$taboptarray = array('mysql' => 'TYPE=MyISAM');
		$dict = NewDataDictionary($db);
		
        // table schema description
        $flds = "
			id I KEY,
			description C(80)
			";

		// create it. This should do error checking, but I'm a lazy sod.
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_practiceportal",
				$flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		// create a sequence
		$db->CreateSequence(cms_db_prefix()."module_practiceportal_seq");
		*/

                // Database
                $gtn = cms_db_prefix()."module_practiceportal_"; // Global Table Name
                
                $db =& $gCms->GetDb();
                
                $taboptarray = array('mysql' => 'TYPE=MyISAM');
                $dict = NewDataDictionary($db);
                
                // table practitioners
        $flds = "
                        idpractitioners I KEY,
                        title C(10),
                        firstname C(80),
                        lastname C(80),
                        bio X,
                        youtube C(20),
                        appointmentfee N(4.2)
                        ";
        
                $sqlarray = $dict->CreateTableSQL($gtn."practitioners",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                $db->CreateSequence($gtn."practitioners_seq");
                
                // table insurnace
        $flds = "
                        idinsurance I KEY,
                        insurancename C(80),
                        image C(80),
                        maxprice N(4.2)
                        ";
                $sqlarray = $dict->CreateTableSQL($gtn."insurance",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                $db->CreateSequence($gtn."insurance_seq");
                
                // table locations
        $flds = "
                        idlocations I KEY,
                        locationname C(80),
                        posx I,
                        posy I
                        ";
                $sqlarray = $dict->CreateTableSQL($gtn."locations",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                $db->CreateSequence($gtn."locations_seq");
                
                // table conditions
        $flds = "
                        idconditions I KEY,
                        conditionname C(80),
                        content X,
                        idpractitioners C(150)
                        ";
                $sqlarray = $dict->CreateTableSQL($gtn."conditions",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                $db->CreateSequence($gtn."conditions_seq");
                
                // table questions
        $flds = "
                        idquestions I KEY,
                        question C(80),
                        content X,
                        idconditions C(150),
                        idlocations C(150)
                        ";
                $sqlarray = $dict->CreateTableSQL($gtn."questions",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                $db->CreateSequence($gtn."questions_seq");
                
                // table settings
        $flds = "
                        `key` C(80) KEY,
                        value X
                        ";
                $sqlarray = $dict->CreateTableSQL($gtn."settings",
                        $flds, $taboptarray);
                $dict->ExecuteSQLArray($sqlarray);
                
                // Make sure that ID numbers are non-zero
                $db->GenID($gtn."practitioners_seq");
                $db->GenID($gtn."conditions_seq");
                $db->GenID($gtn."locations_seq");
                $db->GenID($gtn."questions_seq");
                $db->GenID($gtn."insurance_seq");
                
                // Insert required settings
                $sql = 'INSERT INTO '.$gtn.'settings (`key`, `value`) VALUES (?, ?)';
                $db->Execute($sql, array('introbody','<p>Welcome to our practice portal, designed to help you find the information you need as quickly as possible.</p><p>To start, please select the location with which you are having difficulty on the outline on the right.</p>'));
                $db->Execute($sql, array('mainttile','<h3>Practice Portal</h3>'));
                $db->Execute($sql, array('conditionknown','I already know my condition'));
		
		// permissions
                $this->CreatePermission('Practice Portal','Practice Portal');
		$this->CreatePermission('Edit Practitioners','Edit Practitioners');
                $this->CreatePermission('Edit Conditions','Edit Conditions');
                $this->CreatePermission('PracticePortalQuestions','Edit Practice Portal Questions');
                $this->CreatePermission('PracticePortalSettings','Edit Practice Portal Settings');
                $this->CreatePermission('PracticePortalFinance','View Finance Details');

		// put mention into the admin log
		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
		
?>