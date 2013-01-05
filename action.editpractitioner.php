<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess('Edit Practitioners'))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

if( isset($params['cancel'])) {
    $params = array('active_tab' => 'practitioners');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

$flds = array('title',
    'firstname',
    'lastname',
    'bio',
    'youtube',
    'appointmentfee');

foreach($flds as $key) {
    $smarty->assign('practitioner_'.$key, $this->Lang('practitioner_'.$key));
}

// Assign the variables to either submitted values or null
$idpractitioners = isset($params['idpractitioners']) ? $params['idpractitioners'] : $this->Redirect($id, 'addpractitioner', $returnid);
$title  = isset($params['title']) ? $params['title'] : '';
$firstname  = isset($params['firstname']) ? $params['firstname'] : '';
$lastname  = isset($params['lastname']) ? $params['lastname'] : '';
$bio  = isset($params['bio']) ? $params['bio'] : '';
$youtube  = isset($params['youtube']) ? $params['youtube'] : '';
$appointmentfee  = isset($params['appointmentfee']) ? $params['appointmentfee'] : '';

if( isset($params['submit'])) {
    $error = FALSE;
    
    // Do no null validation
    if(empty($title)) $error = $this->ShowErrors($this->Lang('notitle'));
    if(empty($firstname)) $error = $this->ShowErrors($this->Lang('nofirstname'));
    if(empty($lastname)) $error = $this->ShowErrors($this->Lang('nolastname'));
    if(empty($bio)) $error = $this->ShowErrors($this->Lang('nobio'));
    if(empty($youtube)) $error = $this->ShowErrors($this->Lang('noyoutube'));
    if(empty($appointmentfee)) $error = $this->ShowErrors($this->Lang('noappointmentfee'));
    
    if($error !== FALSE) {
        echo $error;
    } else {
        // Yay, no errors
        $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_practitioners '
            .'SET title=?, firstname=?, lastname=?, bio=?, youtube=?, appointmentfee=? '
            .'WHERE idpractitioners=?;';
        $dbr = $db->Execute($sql, array($title,$firstname,$lastname,$bio,$youtube,$appointmentfee,$idpractitioners));
        
        if( !$dbr )
	  {
            // Check and echo errors with SQL
	    echo "DEBUG: SQL = ".$db->sql."<br/>";
	    die($db->ErrorMsg());
	  }
    }
    
    // Return to previous tab
    $params = array('tab_message'=> 'editsuccessful', 'active_tab' => 'practitioners');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
} else {
    // Else load from the database
    $sql = "SELECT * FROM ".cms_db_prefix()."module_practiceportal_practitioners WHERE idpractitioners = ?";
    $row = $db->GetRow($sql, array($idpractitioners));

    if($row) {
        // Reassign the variables to either database values or the submited values if set
        $title  = isset($params['title']) ? $params['title'] : $row['title'];
        $firstname  = isset($params['firstname']) ? $params['firstname'] : $row['firstname'];
        $lastname  = isset($params['lastname']) ? $params['lastname'] : $row['lastname'];
        $bio  = isset($params['bio']) ? $params['bio'] : $row['bio'];
        $youtube  = isset($params['youtube']) ? $params['youtube'] : $row['youtube'];
        $appointmentfee  = isset($params['appointmentfee']) ? $params['appointmentfee'] : $row['appointmentfee'];
    }
}

$smarty->assign('title_practitioners', $this->Lang('title_practitioners_edit').' - '.$title.' '.$firstname.' '.$lastname);

// Build the form
$smarty->assign('startform', $this->CreateFormStart($id, 'editpractitioner', $returnid));
$smarty->assign('hidden', $this->CreateInputHidden($id, 'idpractitioners', $idpractitioners));
$smarty->assign('titleinput', 
        $this->CreateInputText($id, 'title',$title,10,10,
                'placeholder="'.$this->Lang('practitioner_title_placeholder').'"'));
$smarty->assign('firstnameinput', 
        $this->CreateInputText($id, 'firstname',$firstname,30,80,
                'placeholder="'.$this->Lang('practitioner_firstname_placeholder').'"'));
$smarty->assign('lastnameinput', 
        $this->CreateInputText($id, 'lastname',$lastname,30,80,
                'placeholder="'.$this->Lang('practitioner_lastname_placeholder').'"'));
$smarty->assign('bioinput', 
        $this->CreateTextArea($this->GetPreference('allow_summary_wysiwyg',1),
                $id, $bio, 'bio', '', '', '', '', '80', '3', '', '', 
                'placeholder="'.$this->Lang('practitioner_bio_placeholder').'"'));
$smarty->assign('youtubeinput', 
        $this->CreateInputText($id, 'youtube',$youtube,15,20,
                'placeholder="'.$this->Lang('practitioner_youtube_placeholder').'"'));
$smarty->assign('appointmentfeeinput', 
        $this->CreateInputText($id, 'appointmentfee',$appointmentfee,15,20,
                'placeholder="'.$this->Lang('practitioner_appointmentfee_placeholder').'"'));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('endform', $this->CreateFormEnd());

echo $this->ProcessTemplate('practitioner_form.tpl');

?>