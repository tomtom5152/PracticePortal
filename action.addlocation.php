<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("Edit Locations"))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

if( isset($params['cancel'])) {
    $params = array('active_tab' => 'locations');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

// Fetch the variables from input
$name  = isset($params['name']) ? $params['name'] : '';
$posx = isset($params['posx']) ? $params['posx'] : '0';
$posy = isset($params['posy']) ? $params['posy'] : '0';

if( isset($params['submit'])) {
    $error = FALSE;
    
    // Check required values are set
    if(empty($name)) $error = $this->ShowErrors($this->Lang('noname'));
    if(empty($posx) || empty($posy)) $error = $this->ShowErrors($this->Lang('nocoord'));
    
    if($error !== FALSE) {
        echo $error;
    } else {
        // Yay, no errors        
        $idlocations = $db->GenID(cms_db_prefix().'module_practiceportal_locations_seq');
        $sql = 'INSERT INTO '.cms_db_prefix().'module_practiceportal_locations '
                .'(idlocations, locationname, posx, posy) '
                .'VALUES (?,?,?,?)';
        $dbr = $db->Execute($sql, array($idlocations, $name, $posx, $posy));
        
        if( !$dbr )
	  {
	    echo "DEBUG: SQL = ".$db->sql."<br/>";
	    die($db->ErrorMsg());
	  }
        
        $params = array('tab_message'=> 'addsuccessful', 'active_tab' => 'locations');
        $this->Redirect($id, 'defaultadmin', $returnid, $params);
    }
}

// Misc smarty
$smarty->assign('title_locations', $this->Lang('title_locations_add'));
$smarty->assign('posx', $posx);
$smarty->assign('posy', $posy);
$smarty->assign('treatmentman', $this->GetModuleURLPath().'/images/treatment-man.svg');

// Build the form
$smarty->assign('startform', $this->CreateFormStart($id, 'addlocation', $returnid));
$smarty->assign('nametext', $this->Lang('location_name'));
$smarty->assign('nameinput',
        $this->CreateInputText($id, 'name',$name,30,80,
                'placeholder="'.$this->Lang('location_name_placeholder').'"'));
$smarty->assign('posxtext', $this->Lang('xcoord'));
$smarty->assign('posxinput',
        $this->CreateInputNumber($id,'posx',$posx,'min="0" max="120" data-coord="x"'));
$smarty->assign('posytext', $this->Lang('ycoord'));
$smarty->assign('posyinput',
        $this->CreateInputNumber($id,'posy',$posy,'min="0" max="320" data-coord="y"'));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('endform', $this->CreateFormEnd());;

// Finsih off with the template
echo $this->ProcessTemplate('stylesheet.tpl');
echo $this->ProcessTemplate('location_form.tpl');
?>