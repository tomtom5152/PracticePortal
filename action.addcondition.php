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
    foreach($idpractitioners as $key => $value) {
        if(empty($practitioner[$key]))
                $error = $this->ShowErrors($this->Lang('invalididpractitioners'));
    }
    
    if($error !== FALSE) {
        echo $error;
    } else {
        // Yay, no errors
        $tmp = array_flip($idpractitioners);
        ksort($tmp);
        $idpractitioners = json_encode($tmp); // Serialize idpractitioners array for persistence
        
        $idconditions = $db->GenID(cms_db_prefix().'module_practiceportal_conditions_seq');
        $sql = 'INSERT INTO '.cms_db_prefix().'module_practiceportal_conditions '
                .'(idconditions, conditionname, content, idpractitioners) '
                .'VALUES (?,?,?,?)';
        $dbr = $db->Execute($sql, array($idconditions, $name, $content, $idpractitioners));
        
        if( !$dbr )
	  {
	    echo "DEBUG: SQL = ".$db->sql."<br/>";
	    die($db->ErrorMsg());
	  }
        
        $params = array('tab_message'=> 'addsuccessful', 'active_tab' => 'conditions');
        $this->Redirect($id, 'defaultadmin', $returnid, $params);
    }
}

// Misc smarty
$smarty->assign('title_conditions', $this->Lang('title_conditions_add'));
$smarty->assign('title_practitioners', $this->Lang('title_practitioners'));
$smarty->assign('order', $this->Lang('order'));

// Build the form
$smarty->assign('startform', $this->CreateFormStart($id, 'addcondition', $returnid));
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