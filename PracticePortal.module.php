<?php
#-------------------------------------------------------------------------
# Module: PracticePortal - A portal allowing patients of Nicky Snazell's Pain Relief Clinic to select their best practitioner based on their insurance choices and medical conditions, and then proceed to book an appointment and pay for it on-line.
# Version: 0.1, Tom Price
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2012 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
# This file originally created by ModuleMaker module, version 0.3.2
# Copyright (c) 2012 by Samuel Goldstein (sjg@cmsmadesimple.org) 
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

#-------------------------------------------------------------------------
# For Help building modules:
# - Read the Documentation as it becomes available at
#   http://dev.cmsmadesimple.org/
# - Check out the Skeleton Module for a commented example
# - Look at other modules, and learn from the source
# - Check out the forums at http://forums.cmsmadesimple.org
# - Chat with developers on the #cms IRC channel
#-------------------------------------------------------------------------
class PracticePortal extends CMSModule
{

	function GetName()
	{
		return 'PracticePortal';
	}

	/*---------------------------------------------------------
	   GetFriendlyName()
	   This can return any string, preferably a localized name
	   of the module. This is the name that's shown in the
	   Admin Menus and section pages (if the module has an admin
	   component).
	   
	   See the note on localization at the top of this file.
	  ---------------------------------------------------------*/
	function GetFriendlyName()
	{
		return $this->Lang('friendlyname');
	}

	
	/*---------------------------------------------------------
	   GetVersion()
	   This can return any string, preferably a number or
	   something that makes sense for designating a version.
	   The CMS will use this to identify whether or not
	   the installed version of the module is current, and
	   the module will use it to figure out how to upgrade
	   itself if requested.	   
	  ---------------------------------------------------------*/
	function GetVersion()
	{
		return '0.2';
	}

	/*---------------------------------------------------------
	   GetHelp()
	   This returns HTML information on the module.
	   Typically, you'll want to include information on how to
	   use the module.
	   
	   See the note on localization at the top of this file.
	  ---------------------------------------------------------*/
	function GetHelp()
	{
		return $this->Lang('help');
	}

	/*---------------------------------------------------------
	   GetAuthor()
	   This returns a string that is presented in the Module
	   Admin if you click on the "About" link.
	  ---------------------------------------------------------*/
	function GetAuthor()
	{
		return 'Tom Price';
	}

	/*---------------------------------------------------------
	   GetAuthorEmail()
	   This returns a string that is presented in the Module
	   Admin if you click on the "About" link. It helps users
	   of your module get in touch with you to send bug reports,
	   questions, cases of beer, and/or large sums of money.
	  ---------------------------------------------------------*/
	function GetAuthorEmail()
	{
		return 'tom@codedinternet.com';
	}

	/*---------------------------------------------------------
	   GetChangeLog()
	   This returns a string that is presented in the module
	   Admin if you click on the About link. It helps users
	   figure out what's changed between releases.
	   See the note on localization at the top of this file.
	  ---------------------------------------------------------*/
	function GetChangeLog()
	{
		return $this->Lang('changelog');
	}

	/*---------------------------------------------------------
	   IsPluginModule()
	   This function returns true or false, depending upon
	   whether users can include the module in a page or
	   template using a smarty tag of the form
	   {cms_module module='PracticePortal' param1=val param2=val...}
	   
	   If your module does not get included in pages or
	   templates, return "false" here.
	  ---------------------------------------------------------*/
	function IsPluginModule()
	{
		return true;
	}

	/*---------------------------------------------------------
	   HasAdmin()
	   This function returns a boolean value, depending on
	   whether your module adds anything to the Admin area of
	   the site. For the rest of these comments, I'll be calling
	   the admin part of your module the "Admin Panel" for
	   want of a better term.
	  ---------------------------------------------------------*/
	function HasAdmin()
	{
		return true;
	}


	/*---------------------------------------------------------
	   GetAdminSection()
	   If your module has an Admin Panel, you can specify
	   which Admin Section (or top-level Admin Menu) it shows
	   up in. This method returns a string to specify that
	   section. Valid return values are:

	   main        - the Main menu tab.
	   content     - the Content menu
	   layout      - the Layout menu
	   usersgroups - the Users and Groups menu
	   extensions  - the Extensions menu (this is the default)
	   siteadmin   - the Site Admin menu
	   viewsite    - the View Site menu tab
	   logout      - the Logout menu tab
	   
	   Note that if you place your module in the main,
	   viewsite, or logout sections, it will show up in the
	   menus, but will not be visible in any top-level
	   section pages.
	  ---------------------------------------------------------*/
	function GetAdminSection()
	{
		return 'content';
	}


	/*---------------------------------------------------------
	   GetAdminDescription()
	   If your module does have an Admin Panel, you
	   can have it return a description string that gets shown
	   in the Admin Section page that contains the module.
	  ---------------------------------------------------------*/
	function GetAdminDescription()
	{
		return $this->Lang('admindescription');
	}


	/*---------------------------------------------------------
	   VisibleToAdminUser()
	   If your module does have an Admin Panel, you
	   can control whether or not it's displayed by the boolean
	   that is returned by this method. This is primarily used
	   to hide modules from admins who lack permission to use
	   them.
	   
	   Typically, you'll use some permission to set this
	   (e.g., $this->CheckPermission('Some Permission'); )
	  ---------------------------------------------------------*/
	function VisibleToAdminUser()
	{
        return true;
	}
	

	/*---------------------------------------------------------
	   CheckAccess()
	   This wrapper function will check against the specified permission,
	   and display an error page if the user doesn't have adequate permissions.
	  ---------------------------------------------------------*/
	function CheckAccess($perm = 'Practice Portal')
		{
		return $this->CheckPermission($perm);
		}
	
	/*---------------------------------------------------------
	   DisplayErrorPage()
	   This is a simple function for generating error pages.
	  ---------------------------------------------------------*/
    function DisplayErrorPage($id, &$params, $return_id, $message='')
    {
		$this->smarty->assign('title_error', $this->Lang('error'));
		$this->smarty->assign_by_ref('message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }
	


	/*---------------------------------------------------------
	   GetDependencies()
	   Your module may need another module to already be installed
	   before you can install it.
	   This method returns a list of those dependencies and
	   minimum version numbers that this module requires.
	   
	   It should return an hash, eg.
	   return array('somemodule'=>'1.0', 'othermodule'=>'1.1');
	  ---------------------------------------------------------*/
	function GetDependencies()
	{
		return array();
	}

	/*---------------------------------------------------------
	   MinimumCMSVersion()
	   Your module may require functions or objects from
	   a specific version of CMS Made Simple.
	   Ever since version 0.11, you can specify which minimum
	   CMS MS version is required for your module, which will
	   prevent it from being installed by a version of CMS that
	   can't run it.
	   
	   This method returns a string representing the
	   minimum version that this module requires.
	   ---------------------------------------------------------*/
	function MinimumCMSVersion()
	{
		return "1.11";
	}


	/*---------------------------------------------------------
	   MaximumCMSVersion()
	   You may want to prevent people from using your module in
	   future versions of CMS Made Simple, especially if you
	   think API features you use may change -- after all, you
	   never really know how the CMS MS API could evolve.
	   
	   So, to prevent people from flooding you with bug reports
	   when a new version of CMS MS is released, you can simply
	   restrict the version. Then, of course, the onus is on you
	   to release a new version of your module when a new version
	   of the CMS is released...
	   
	   This method returns a string representing the
	   maximum version that this module supports.
	   ---------------------------------------------------------*/
	function MaximumCMSVersion()
	{
		return "1.11.3";
	}


	/*---------------------------------------------------------
	   InstallPostMessage()
	   After installation, there may be things you want to
	   communicate to your admin. This function returns a
	   string which will be displayed.
	  ---------------------------------------------------------*/
	function InstallPostMessage()
	{
		return $this->Lang('postinstall');
	}

	/*---------------------------------------------------------
	   UninstallPostMessage()
	   After removing a module, there may be things you want to
	   communicate to your admin. This function returns a
	   string which will be displayed.
	  ---------------------------------------------------------*/
	function UninstallPostMessage()
	{
		return $this->Lang('postuninstall');
	}




	/**
	 * UninstallPreMessage()
	 * This allows you to display a message along with a Yes/No dialog box. If the user responds
	 * in the affirmative to your message, the uninstall will proceed. If they respond in the
	 * negative, the uninstall will be canceled. Thus, your message should be of the form
	 * "All module data will be deleted. Are you sure you want to uninstall this module?"
	 *
	 * If you don't want the dialog, have this method return a FALSE, which will cause the
	 * module to uninstall immediately if the user clicks the "uninstall" link.
	 */
	function UninstallPreMessage()
	{
		return $this->Lang('really_uninstall');
	}
        
        /**
         * InitializeFrontend()
         * Called from within the constructor, ONLY for frontend module actions.
         * This method should be overridden to create routes, and set handled
         * parameters, and perform other initialization tasks that need to be
         * setup for all frontend actions.
         */
        function InitializeFrontend() {
            parent::InitializeFrontend();
            $this->RegisterModulePlugin();
        }
	
}

?>
