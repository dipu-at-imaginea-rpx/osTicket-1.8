<?php
/*********************************************************************
    logo.php

    Simple logo to facilitate serving a customized client-side logo from
    osTicet. The logo is configurable in Admin Panel -> Settings -> Pages

    Peter Rotich <peter@osticket.com>
    Jared Hancock <jared@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/

// Don't update the session for inline image fetches
if (!function_exists('noop')) { function noop() {} }
session_set_save_handler('noop','noop','noop','noop','noop','noop');
define('DISABLE_SESSION', true);

require('client.inc.php');

//------------------ Imaginea Starts-----------------------

/**
 *  Imaginea created new if condition(currently that is in first place).
 *  Chenged previous if condition to elseif condition
 */
if($thisclient && is_object($thisclient) && $thisclient->isValid())
{ 
    $org = $thisclient->getOrganization();
    if($org)
    {
        if('premium' === (string) $org->getVar('org_supportplan'))
        {
            $logo = $ost->getConfig()->getPremiumUserLogo();
        }else
        {   
            $logo = $ost->getConfig()->getClientLogo();
        }
    }else
    {   
            $logo = $ost->getConfig()->getClientLogo();
    }
        
    $logo->no_cache_mode_display();
}elseif (($logo = $ost->getConfig()->getClientLogo())) {
    //$logo->display(); //This function call was default, Imaginea commented it for avoiding logo cache
    $logo->no_cache_mode_display();//Calling function which won't set cache
//------------------ Imaginea Ends----------------------- 
} else {
    header('Location: '.ASSETS_PATH.'images/logo.png');
}

?>
