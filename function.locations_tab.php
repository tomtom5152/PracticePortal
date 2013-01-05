<?php
// Smarty housekeeping
$smarty->assign('addlink', $this->CreateLink($id, 'addlocation', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addlocation'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addlocation', $returnid, $this->Lang('addlocation'), array(), '', false, false, 'class="pageoptions"'));

// Establish variables to be assigned to smarty later
$errors = array();
$locations = array();

// Fetch all pracitioners from the database
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_locations";
$dbresult = $db->Execute($sql);

// Take each practitioners and add them each to an array for later
while ($dbresult && $row = $dbresult->FetchRow()) {
    $row['edithref'] = $this->CreateLink($id, 'editlocation', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('idlocations'=>$row['idlocations']),'',true);
    $row['editlink'] = $this->CreateLink($id, 'editlocation', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('idlocations'=>$row['idlocations']));
    $row['deletelink'] = $this->CreateLink($id, 'deletelocation', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('idlocations'=>$row['idlocations']), $this->Lang('areyousure'));
    $locations[$row['idlocations']] = $row;
}

if(empty($locations)) {
    array_push($errors, $this->Lang('error_nolocations'));
}

// Reassing the variables to smarty and process the template file to return it to the caller
$smarty->assign('errors', $errors);
$smarty->assign('locations', $locations);
$smarty->assign('treatmentman', $this->GetModuleURLPath().'/images/treatment-man.svg');
echo $this->ProcessTemplate('stylesheet.tpl');
return $this->ProcessTemplate('locations_tab.tpl');
?>
