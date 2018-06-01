<div style="background-color: #67b365;margin: 16px;padding:2px;box-shadow: -3px -3px 3px rgba(0,0,0,0.5);border-radius: 8px; font-family: PT Sans, sans-serif;">
    <div style="margin: 8px">
        <a href="<?php echo $this->input->self_url; ?>" style="border:none;text-decoration: none;">
            <img src="<?php echo $this->input->self_url; ?>/img/logo_transp_white_h64.png" alt="Well Fed Foundation"/>
        </a>                
    </div>
    <div style="min-height: 160px;background-color: white;margin: 0px 8px;padding:16px 32px;border-radius: 4px;">
        <?php echo $body; ?>
    </div>
    <div style="min-height: 64px;margin: 0px;text-align: center;font-size: 12px;font-style: italic;color: white">
        <br>
        <br>
        <strong>Well Fed Foundation</strong> Registered Charity No: 1167863
        <span style="float: right;margin-right: 12px;margin-top: -12px">
            <?php if ($facebook = $this->db_settings->get('contact_facebook', false)) { ?>
                <a href="<?php echo $facebook; ?>" target="_blank" style="text-decoration: none;border:none">
                    <img src="<?php echo $this->input->self_url; ?>/img/fb.png" style="width: 36px;height: 36px;" alt="Facebook"/>
                </a>            
            <?php } ?>
            <?php if ($twitter = $this->db_settings->get('contact_twitter', false)) { ?>
                <a href="<?php echo $twitter; ?>" target="_blank" style="text-decoration: none;border:none">
                    <img src="<?php echo $this->input->self_url; ?>/img/tweet.png" style="width: 36px;height: 36px;" alt="Twitter"/>
                </a>            
            <?php } ?>
            <?php if ($instagram = $this->db_settings->get('contact_instagram', false)) { ?>
                <a href="<?php echo $instagram; ?>" target="_blank" style="text-decoration: none;border:none">
                    <img src="<?php echo $this->input->self_url; ?>/img/inst.png" style="width: 36px;height: 36px;" alt="Instagram"/>
                </a>            
            <?php } ?>
        </span>
    </div>
</div>