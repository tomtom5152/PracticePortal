<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("Edit Conditions"))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

if( isset($params['cancel'])) {
    $params = array('active_tab' => 'conditions');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

// Fetch the variables from input
$idconditions = isset($params['idconditions']) ? $params['idconditions'] : $this->Redirect($id, 'addcondition', $returnid);
$name  = isset($params['name']) ? $params['name'] : '';
$content = isset($params['content']) ? $params['content'] : '';
$idpractitioners = isset($params['idpractitioners']) ? $params['idpractitioners'] : array();
// Remove unused idpractitioners
foreach($idpractitioners as $key => $value) {
    if($value == 0) {
        unset($idpractitioners[$key]);
    }
}

// Load practitioners from database
$practitioners;
$sql = 'SELECT * FROM '.cms_db_prefix().'module_practiceportal_practitioners';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()){
    $practitioners[$row['idpractitioners']] = $row;
}

if( isset($params['submit'])) {
    $error = FALSE;
    
    // Check required values are set
    if(empty($name)) $error = $this->ShowErrors($this->Lang('noname'));
    if(empty($content)) $error = $this->ShowErrors($this->Lang('nocontent'));
    
    // Check that each idpractitoner submited is
    foreach($idpractitioners as $practitioner) {
        if(empty($practitioner[$idpractitionerss]))
                $error = $this->ShowErrors($this->Lang('invalididpractitioners'));
    }
    
    if($error !== FALSE) {
        echo $error;
    } else {
        // Yay, no errors
        $tmp = array_flip($idpractitioners);
        ksort($tmp);
        $idpractitioners = json_encode($tmp); // Serialize idpractitioners array for persistence
        
        $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_conditions '
                .'SET conditionname = ?, content = ?, idpractitioners = ? '
                .'WHERE idconditions = ?';
        $dbr = $db->Execute($sql, array( $name, $content, $idpractitioners, $idconditions));
        
        if( !$dbr )
	  {
	    echo "DEBUG: SQL = ".$db->sql."<br/>";
	    die($db->ErrorMsg());
	  }
        
        // Return to previous tab
        $params = array('tab_message'=> 'editsuccessful', 'active_tab' => 'conditions');
        $this->Redirect($id, 'defaultadmin', $returnid, $params);
    }
} else {
    // Load data from database
    $sql = ' SELECT * FROM '.cms_db_prefix().'module_practiceportal_conditions WHERE idconditions=?';
    $row = $db->GetRow($sql, array($idconditions));
    
    if($row) {
        // Reassign the variables to either database values or the submited values if set
        $name  = isset($params['name']) ? $params['name'] : $row['conditionname'];
        $content = isset($params['content']) ? $params['content'] : $row['content'];
        $idpractitioners = isset($params['idpractitioners']) ? $params['idpractitioners'] : array_flip(json_decode($row['idpractitioners'], true));
    }
}

// Misc smarty
$smarty->assign('title_conditions', $this->Lang('title_conditions_edit'));
$smarty->assign('title_practitioners', $this->Lang('title_practitioners'));
$smarty->assign('order', $this->Lang('order'));

// Build the form
$smarty->assign('startform', $this->CreateFormStart($id, 'editcondition', $returnid));
$smarty->assign('hidden', $this->CreateInputHidden($id, 'idconditions', $idconditions));
$smarty->assign('nametext', $this->Lang('condition_name'));
$smarty->assign('nameinput',
        $this->CreateInputText($id, 'name',$name,30,80,
                'placeholder="'.$this->Lang('condition_name_placeholder').'"'));
$smarty->assign('contenttext', $this->Lang('condition_content'));
$smarty->assign('contentinput',
        $this->CreateTextArea($this->GetPreference('allow_summary_wysiwyg',1),
                $id, $content, 'content', '', '', '', '', '80', '3', '', '', 
                'placeholder="'.$this->Lang('condition_content_placeholder').'"'));

// Build input array for the practitioner selection list
$smarty->assign('practitionerstext', $this->Lang('condition_practitioners'));
$practitionerinputs;
foreach($practitioners as $practitioner) {
    if(empty($idpractitioners[$practitioner['idpractitioners']])) 
        $idpractitioners[$practitioner['idpractitioners']] = 0;
    
    $i['text'] = $practitioner['title'].' '.$practitioner['firstname'].' '.$practitioner['lastname'];
    $i['input'] = $this->CreateInputText($id, 'idpractitioners['.$practitioner['idpractitioners'].']',
            $idpractitioners[$practitioner['idpractitioners']],1,3);
    
    $practitionerinputs[] = $i;
}
$smarty->assign('practitionerinputs', $practitionerinputs);

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('endform', $this->CreateFormEnd());;

// Finsih off with the template
echo $this->ProcessTemplate('condition_form.tpl');
?>