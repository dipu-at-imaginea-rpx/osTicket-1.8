        </div>
    </div>
    <div id="footer">
    <?php 
        //--------------------------Imaginea Starts-----------------------
        if($thisclient && is_object($thisclient) && $thisclient->isValid())
        {
            if('premium' === (string)$thisclient->getVar('supportplan'))
            {
                if($cfg)
                {
                    $preminum_support_number = $cfg->getPremiumSupportPhoneNumber();
                    if('' != trim($preminum_support_number))
                    {
    ?>
                        <div>
                            Premium Support Number : <?php echo $preminum_support_number;?>
                        </div>
    <?php
                    }
                }
            }
        }
        //--------------------------Imaginea Ends-----------------------
    ?>
        <p>Copyright &copy; <?php echo date('Y'); ?> <?php echo (string) $ost->company ?: 'osTicket.com'; ?> - All rights reserved.</p>
        <a id="poweredBy" href="http://osticket.com" target="_blank"><?php echo __('Helpdesk software - powered by osTicket'); ?></a>
    </div>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
</body>
</html>
