<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("PracticePortalSettings"))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

// Fetch the variables from input
$settings = $params['PracticePortalSettings'];

if( isset($params['submit'])) {
    foreach($settings as $key => $value) {
        if(empty($value))
            $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'settings'));
        
        $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_settings '
                .'SET `value` = ? '
                .'WHERE `key` = ?';
        $dbr = $db->Execute($sql, array($value, str_replace("'", "", $key)));

        if( !$dbr )
      {
        echo "DEBUG: SQL = ".$db->sql."<br/>";
        die($db->ErrorMsg());
      }

        $params = array('tab_message'=> 'edidsuccessful', 'active_tab' => 'settings');
        $this->Redirect($id, 'defaultadmin', $returnid, $params);
    }
} else {
    $params = array('active_tab' => 'settings');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}
?>