<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');
$section = 'downloads';
$nav->setActiveNav('downloads');
require(CLIENTINC_DIR.'header.inc.php');
?>
<div id="landing_page">
    <h1>Welcome to the Support Portal Home</h1>
    <p>
        This page will display download pages of our support portal.
    </p>
    

    

   
</div>

</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
