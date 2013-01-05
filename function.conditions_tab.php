<?php
// Smarty housekeeping
$smarty->assign('addlink', $this->CreateLink($id, 'addcondition', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addcondition'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addcondition', $returnid, $this->Lang('addcondition'), array(), '', false, false, 'class="pageoptions"'));

// Establish variables to be assigned to smarty later
$errors = array();
$conditions = array();
$practitioners = array();

// Fetch all practitioners from the database and add them to an array for later
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_practitioners";
$dbresult = $db->Execute($sql);
while($dbresult && $row = $dbresult->FetchRow()) {
    $practitioners[$row['idpractitioners']] = $row;
}

// Fetch all conditions from the database ordered by name
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_conditions ORDER BY conditionname";
$dbresult = $db->Execute($sql);

// Take each practitioners and add them each to an array for later
while ($dbresult && $row = $dbresult->FetchRow()) {
    $row['editlink'] = $this->CreateLink($id, 'editcondition', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('idconditions'=>$row['idconditions']));
    $row['deletelink'] = $this->CreateLink($id, 'deletecondition', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('idconditions'=>$row['idconditions']), $this->Lang('areyousure'));
    $qualified = json_decode($row['idpractitioners'], true);
    $practitionernames = "";
    foreach($qualified as $position => $idpractitioners) {
        $practitioner = $practitioners[$idpractitioners];
        $practitionernames .= '<p>'.$position.': '.$practitioner['title'].' '.$practitioner['firstname'].' '.$practitioner['lastname'].'</p>';
    }
    $row['practitioners'] = $practitionernames;
    $conditions[$row['idconditions']] = $row;
}

if(empty($conditions)) {
    array_push($errors, $this->Lang('error_noconditions'));
}


// Reassing the variables to smarty and process the template file to return it to the caller
$smarty->assign('errors', $errors);
$smarty->assign('conditions', $conditions);
return $this->ProcessTemplate('conditions_tab.tpl');
?>