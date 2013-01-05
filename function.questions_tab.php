<?php
// Smarty housekeeping
$smarty->assign('addlink', $this->CreateLink($id, 'addquestion', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addquestion'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addquestion', $returnid, $this->Lang('addquestion'), array(), '', false, false, 'class="pageoptions"'));

// Establish variables to be assigned to smarty later
$errors = array();
$questions = array();
$locations = array();
$conditions = array();

// Fetch all locations and conditions from database
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_locations";
$dbresult = $db->Execute($sql);
while($dbresult && $row = $dbresult->FetchRow()) {
    $locations[$row['idlocations']] = $row;
}
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_conditions";
$dbresult = $db->Execute($sql);
while($dbresult && $row = $dbresult->FetchRow()) {
    $conditions[$row['idconditions']] = $row;
}

// Fetch all questions from the database
$sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_questions";
$dbresult = $db->Execute($sql);

// Take each questions and add them each to an array for later
while ($dbresult && $row = $dbresult->FetchRow()) {
    $row['editlink'] = $this->CreateLink($id, 'editquestion', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('idquestions'=>$row['idquestions']));
    $row['deletelink'] = $this->CreateLink($id, 'deletequestion', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('idquestions'=>$row['idquestions']), $this->Lang('areyousure'));
    
    $loc = json_decode($row['idlocations']);
    $locationnames = '';
    foreach($loc as $location) {
        $locationnames .= '<p>'.$locations[$location]['locationname'].'</p>';
    }
    $row['locations'] = $locationnames;
    
    $con = json_decode($row['idconditions'], true);
    $conditionnames = '';
    foreach($con as $order => $idconditions) {
        $conditionnames .= '<p>'.$order.': '.$conditions[$idconditions]['conditionname'].'</p>';
    }
    $row['conditions'] = $conditionnames;
    
    $questions[$row['idquestions']] = $row;
}

if(empty($questions)) {
    array_push($errors, $this->Lang('error_noquestions'));
}

// Build Labels
$smarty->assign('question_question', $this->Lang('question_question'));
$smarty->assign('question_content', $this->Lang('question_content'));
$smarty->assign('question_locations', $this->Lang('question_locations'));
$smarty->assign('question_conditions', $this->Lang('question_conditions'));

// Reassing the variables to smarty and process the template file to return it to the caller
$smarty->assign('errors', $errors);
$smarty->assign('questions', $questions);
return $this->ProcessTemplate('questions_tab.tpl');
?>
