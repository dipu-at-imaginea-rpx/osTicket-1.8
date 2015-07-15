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
    <?php 
        if($thisclient && is_object($thisclient) && $thisclient->isValid() && 'premium' === (string)$thisclient->getVar('supportplan'))
        {
    ?>
                <h1>Welcome to the Support Portal Home</h1>
                <p>
                    This page will display download pages of our support portal.
                </p>
    <?php

        }else
        {
    ?>
            You are not allowed to see this page, please go to <a href="<?php echo ROOT_PATH; ?>index.php"
            title="<?php echo __('Support Center'); ?>">Support Center Home</a>
    <?php
        }
    ?> 
</div>

</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
