<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("PracticePortalQuestions"))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

if( isset($params['cancel'])) {
    $params = array('active_tab' => 'questions');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

// Fetch the variables from input
$question  = isset($params['question']) ? $params['question'] : '';
$content = isset($params['content']) ? $params['content'] : '';
$idlocations = isset($params['idlocations']) ? $params['idlocations'] : array();
$idconditions = isset($params['idconditions']) ? $params['idconditions'] : array();
// Remove unused idconditions
foreach($idconditions as $key => $value) {
    if($value == '0') {
        unset($idconditions[$key]);
    }
}

// Load conditions from database
$conditions;
$sql = 'SELECT * FROM '.cms_db_prefix().'module_practiceportal_conditions';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()){
    $conditions[$row['idconditions']] = $row;
}
// Load locations from database
$locations;
$sql = 'SELECT * FROM '.cms_db_prefix().'module_practiceportal_locations';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()){
    $locations[$row['idlocations']] = $row;
}

if( isset($params['submit'])) {
    $error = FALSE;
    
    // Check required values are set
    if(empty($question)) $error = $this->ShowErrors($this->Lang('noquestion'));
    if(empty($content)) $error = $this->ShowErrors($this->Lang('nocontent'));
    
    // Check that each idlocation submited is valid
    foreach($idlocations as $location) {
        if(empty($locations[$location]))
                $error = $this->ShowErrors($this->Lang('invalididlocations'));
    }    
    // Check that each idconidtion submited is valid
    foreach($idconditions as $key => $value) {
        if(empty($conditions[$key]))
                $error = $this->ShowErrors($this->Lang('invalididconditions'));
    }
    
    if($error !== FALSE) {
        echo $error;
    } else {
        $idlocations = json_encode($idlocations);
        
        // Yay, no errors
        $tmp = array_flip($idconditions);
        ksort($tmp);
        $idconditions = json_encode($tmp); // Serialize idconditions array for persistence
        
        $idquestions = $db->GenID(cms_db_prefix().'module_practiceportal_questions_seq');
        $sql = 'INSERT INTO '.cms_db_prefix().'module_practiceportal_questions '
                .'(idquestions, question, content, idlocations, idconditions) '
                .'VALUES (?,?,?,?,?)';
        $dbr = $db->Execute($sql, array($idquestions, $question, $content, $idlocations, $idconditions));
        
        if( !$dbr )
	  {
	    echo "DEBUG: SQL = ".$db->sql."<br/>";
	    die($db->ErrorMsg());
	  }
        
        $params = array('tab_message'=> 'addsuccessful', 'active_tab' => 'questions');
        $this->Redirect($id, 'defaultadmin', $returnid, $params);
    }
}

// Misc smarty
$smarty->assign('title_questions', $this->Lang('title_questions_add'));
$smarty->assign('title_locations', $this->Lang('title_locations'));
$smarty->assign('title_conditions', $this->Lang('title_conditions'));
$smarty->assign('selected', $this->Lang('selected'));
$smarty->assign('order', $this->Lang('order'));

// Build the form
$smarty->assign('startform', $this->CreateFormStart($id, 'addquestion', $returnid));
$smarty->assign('questiontext', $this->Lang('question_question'));
$smarty->assign('questioninput',
        $this->CreateInputText($id, 'question',$question,30,80,
                'placeholder="'.$this->Lang('question_question_placeholder').'"'));
$smarty->assign('contenttext', $this->Lang('question_content'));
$smarty->assign('contentinput',
        $this->CreateTextArea($this->GetPreference('allow_summary_wysiwyg',1),
                $id, $content, 'content', '', '', '', '', '80', '3', '', '', 
                'placeholder="'.$this->Lang('question_content_placeholder').'"'));
// Build input array for the locations checkbox list
$smarty->assign('locationstext', $this->Lang('question_locations'));
$locationinputs;
foreach($locations as $idlocation => $location) {
    $selected = in_array($idlocation, $idlocations) ? $idlocation : null;
    $i['text'] = $location['locationname'];
    $i['input'] = $this->CreateInputCheckbox($id, 'idlocations[]', $idlocation, $selected);
    $locationinputs[] = $i;
}
$smarty->assign('locationinputs', $locationinputs);
// Build input array for the condition selection list
$smarty->assign('conditionstext', $this->Lang('question_conditions'));
$conditioninputs;
foreach($conditions as $condition) {
    if(empty($idconditions[$condition['idconditions']])) 
        $idconditions[$condition['idconditions']] = '0';
    
    $i['text'] = $condition['conditionname'];
    $i['input'] = $this->CreateInputText($id, 'idconditions['.$condition['idconditions'].']',
            $idconditions[$condition['idconditions']],1,3);
    
    $conditioninputs[] = $i;
}
$smarty->assign('conditioninputs', $conditioninputs);

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('endform', $this->CreateFormEnd());;

// Finsih off with the template
echo $this->ProcessTemplate('question_form.tpl');
?>