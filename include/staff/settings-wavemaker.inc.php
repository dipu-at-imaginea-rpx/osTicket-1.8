<?php
if(!defined('OSTADMININC') || !$thisstaff || !$thisstaff->isAdmin() || !$config) die('Access Denied');

?>
<h2><?php echo __('WaveMaker Custom Settings'); ?></h2>
<form action="settings.php?t=wavemaker" method="post" id="save"
    enctype="multipart/form-data">
<?php csrf_token(); ?>
<input type="hidden" name="t" value="wavemaker" >
<table class="form_table settings_table" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th colspan="2">
                <h4><?php echo __('Premium Contact Details'); ?></h4>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="220" class="required"><?php echo __('Phone Number'); ?>:</td>
            <td>
                <span>
                <input type="text" name="premium_contact_number" id="premium_contact_number" value="<?php echo isset($config['premium_contact_number'])?$config['premium_contact_number']:'';?>">&nbsp;<font class="error">*&nbsp;<?php echo $errors['premium_contact_number']; ?></font>
                <i class="help-tip icon-question-sign" href="#premium_contact_number"></i>
                </span>
            </td>
        </tr>
    </tbody>
</table>
<?php
ob_start();
foreach (AttachmentFile::allLogos() as $logo) 
{
    echo "<option value='".$logo->getId()."'>".$logo->getName()."</option>";    
}
$option_logos = ob_get_clean();

$current_team_logos = json_decode($ost->getConfig()->getTeamLogo(), true);

?>
<table class="form_table settings_table" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th colspan="2">
                <h4><?php echo __('Team Icons'); ?></h4>
            </th>
        </tr>
    </thead>
    <tbody>
<?php
    $sel_query  = "SELECT team_id, name FROM ost_team WHERE isenabled=1";
    $res        = db_query($sel_query);
    if(0 == db_num_rows($res))
    {
?>
        <tr>
            <td colspan="2">
                <?php echo __('No teams found'); ?>
            </td>
        </tr>
<?php
    }else
    {
        while ($row = db_fetch_array($res)) 
        {
?>
            <tr>
                <td width="220" class="required">
                    <?php echo $row['name'];?>
                    <input type="hidden" name="team_ids[]" value="<?php echo $row['team_id'];?>">
                </td>
                <td>
                    <select name="team_logo_ids[]" id="team_logo_id_<?php echo $row['team_id'];?>" class="select-team-logo">
                        <option value="0">Select Logo</option>
                        <?php echo $option_logos;?>
                    </select>
                    <img src="" id="team_logo_<?php echo $row['team_id'];?>">
                    <input type="hidden" name="selected_team_logo_ids[]" value="<?php echo isset($current_team_logos[$row['team_id']])?$current_team_logos[$row['team_id']]:0;?>" id="selected_team_logo_id_<?php echo $row['team_id'];?>">
                </td>
            </tr>   
<?php       
        } 
    }
?>
    </tbody>
</table>
<table class="form_table settings_table" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th colspan="2">
                <h4><?php echo __('Premium User Logos'); ?>
                    <i class="help-tip icon-question-sign" href="#premium_user_logos"></i>
                    </h4>
                <em><?php echo __('System Default Logo'); ?></em>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td colspan="2">
<table style="width:100%">
    <thead><tr>
        <th>Premium Logo</th>
        <th>Logo</th>
    </tr></thead>
    <tbody>
        <tr>
            <td>
                <input type="radio" name="selected-premium-user-logo" value="0"
                    style="margin-left: 1em"
                    <?php if (!$ost->getConfig()->getClientLogoId())
                        echo 'checked="checked"'; ?>/>
            </td><td>
                <img src="<?php echo ROOT_PATH; ?>assets/default/images/logo.png"
                    alt="Default Logo" valign="middle"
                    style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                        margin: 0.5em; height: 5em;
                        vertical-align: middle"/>
                <img src="<?php echo ROOT_PATH; ?>scp/images/ost-logo.png"
                    alt="Default Logo" valign="middle"
                    style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                        margin: 0.5em; height: 5em;
                        vertical-align: middle"/>
            </td>
        </tr>
        <tr><th colspan="2">
            <em><?php echo __('Use a custom logo'); ?>&nbsp;<i class="help-tip icon-question-sign" href="#upload_a_new_logo"></i></em>
        </th></tr>
    <?php
    $current_premium_user_logo = $ost->getConfig()->getPremiumUserLogoId();
    $current = $ost->getConfig()->getClientLogoId();
    $currentScp = $ost->getConfig()->getStaffLogoId();

    foreach (AttachmentFile::allLogos() as $logo) { ?>
        <tr>
            <td>
                <input type="radio" name="selected-premium-user-logo"
                    style="margin-left: 1em" value="<?php
                    echo $logo->getId(); ?>" <?php
                    if ($logo->getId() == $current_premium_user_logo)
                        echo 'checked="checked"'; ?>/>
            </td><td>
                <img src="<?php echo $logo->getDownloadUrl(); ?>"
                    alt="Custom Logo" valign="middle"
                    style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                        margin: 0.5em; height: 5em;
                        vertical-align: middle;"/>
                <?php echo $logo->getName(); ?>
                <?php if ($logo->getId() != $current_premium_user_logo and $logo->getId() != $current and $logo->getId() != $currentScp and !in_array($logo->getId(), $current_team_logos)) { ?>
                    <label>
                    <input type="checkbox" name="delete-logo[]" value="<?php
                        echo $logo->getId(); ?>"/> <?php echo __('Delete'); ?>
                    </label>
                <?php } ?>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table>
            <b><?php echo __('Upload a new logo'); ?>:</b>
            <input type="file" name="logo[]" size="30" value="" />
            <font class="error"><br/><?php echo $errors['logo']; ?></font>
        </td>
        </tr>
    </tbody>
</table>
<p style="padding-left:250px;">
    <input class="button" type="submit" name="submit-button" value="<?php
    echo __('Save Changes'); ?>">
    <input class="button" type="reset" name="reset" value="<?php
    echo __('Reset Changes'); ?>">
</p>
</form>

<div style="display:none;" class="dialog" id="confirm-action">
    <h3><?php echo __('Please Confirm'); ?></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr/>
    <p class="confirm-action" id="delete-confirm">
        <font color="red"><strong><?php echo sprintf(
        __('Are you sure you want to DELETE %s?'),
        _N('selected logo', 'selected logos', 2)); ?></strong></font>
        <br/><br/><?php echo __('Deleted data CANNOT be recovered.'); ?>
    </p>
    <div><?php echo __('Please confirm to continue.'); ?></div>
    <hr style="margin-top:1em"/>
    <p class="full-width">
        <span class="buttons pull-left">
            <input type="button" value="<?php echo __('No, Cancel'); ?>" class="close">
        </span>
        <span class="buttons pull-right">
            <input type="button" value="<?php echo __('Yes, Do it!'); ?>" class="confirm">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript">
$(function() {
    $('#save input:submit.button').bind('click', function(e) {
        var formObj = $('#save');
        if ($('input:checkbox:checked', formObj).length) {
            e.preventDefault();
            $('.dialog#confirm-action').undelegate('.confirm');
            $('.dialog#confirm-action').delegate('input.confirm', 'click', function(e) {
                e.preventDefault();
                $('.dialog#confirm-action').hide();
                $('#overlay').hide();
                formObj.submit();
                return false;
            });
            $('#overlay').show();
            $('.dialog#confirm-action .confirm-action').hide();
            $('.dialog#confirm-action p#delete-confirm')
            .show()
            .parent('div').show().trigger('click');
            return false;
        }
        else return true;
    });
});
$( document ).ready(function() {
    var selected_team_logo_ids = jQuery( "[name='selected_team_logo_ids[]']" );
    for (var i = 0; i < selected_team_logo_ids.length; i++) {
        // console.log(jQuery(selected_team_logo_ids[i]).attr('id').split('_').pop());
        jQuery('#team_logo_id_'+jQuery(selected_team_logo_ids[i]).attr('id').split('_').pop()).val(jQuery(selected_team_logo_ids[i]).val());
    };

});
</script>
