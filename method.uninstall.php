<?php
if (!isset($gCms)) exit;

	/*---------------------------------------------------------
	   Uninstall()
	   Sometimes, an exceptionally unenlightened or ignorant
	   admin will wish to uninstall your module. While it
	   would be best to lay into these idiots with a cluestick,
	   we will do the magnanimous thing and remove the module
	   and clean up the database, permissions, and preferences
	   that are specific to it.
	   This is the method where we do this.
	  ---------------------------------------------------------*/

		/*
		// Typical Database Removal
		$db =& $gCms->GetDb();
		
		// remove the database table
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_practiceportal" );
		$dict->ExecuteSQLArray($sqlarray);

		// remove the sequence
		$db->DropSequence( cms_db_prefix()."module_practiceportal_seq" );
		*/
		
		// remove the permissions
		$this->RemovePermission('Edit Practitioners');
$this->RemovePermission('View Finance Details');
$this->RemovePermission('Edit Conditions');
$this->RemovePermission('Practice Portal');

		
		// put mention into the admin log
		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

?>