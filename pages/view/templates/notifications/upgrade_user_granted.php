<div>
    Dear <?php echo $user_name; ?>,<br><br>
    <p>
        Your request to have your account upgraded to allow donations has been approved.<br>
        Please ensure you are familiar with our Legal Terms as follows :<br>
    <ol>
        <?php foreach ($this->config->legal as $key => $value) {?>
        <li>
            <a href="<?php echo $this->input->self_url.'/'.$key; ?>" target="_blank"><?php echo $value; ?></a>
        </li>
        <?php } ?>
    </ol>
        If you have any questions, please contact us at <a href="mailto:admin@wellfedfoundation.org" target="_blank">admin@wellfedfoundation.org</a>.
    </p>
    <p>
        Thank you for using Well Fed Foundation, we truly appreciate your support. 
    </p>
    <hr>
    Regards,<br>
    Well Fed Foundation Team

</div>