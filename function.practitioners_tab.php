<?php
// Smarty housekeeping
$smarty->assign('addlink', $this->CreateLink($id, 'addpractitioner', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addpractitioner'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addpractitioner', $returnid, $this->Lang('addpractitioner'), array(), '', false, false, 'class="pageoptions"'));

// Establish variables to be assigned to smarty later
$errors = array();
$practitioners = array();

// Fetch all pracitioners from the database
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_practitioners";
$dbresult = $db->Execute($sql);

// Take each practitioners and add them each to an array for later
while ($dbresult && $row = $dbresult->FetchRow()) {
    $row['editlink'] = $this->CreateLink($id, 'editpractitioner', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('idpractitioners'=>$row['idpractitioners']));
    $row['deletelink'] = $this->CreateLink($id, 'deletepractitioner', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('idpractitioners'=>$row['idpractitioners']), $this->Lang('areyousure'));
    $practitioners[$row['idpractitioners']] = $row;
}

if(empty($practitioners)) {
    array_push($errors, $this->Lang('error_nopractitioners'));
}

// Reassing the variables to smarty and process the template file to return it to the caller
$smarty->assign('errors', $errors);
$smarty->assign('practitioners', $practitioners);
return $this->ProcessTemplate('practitioners_tab.tpl');
?>
