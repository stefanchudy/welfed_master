<div>
    Dear <?php echo $donation['donor_user']; ?>,<br><br>
    This email is confirming the booking of <strong><?php echo $qty; ?></strong> units of <strong><?php echo $donation['title']; ?></strong> by: <br>
    <div style="margin-left: 16px;">
        <strong>Recipient name</strong> <?php echo $recipient['user_name']; ?><br>
        <strong>Recipient e-mail </strong> <a style="font-weight: bold" href="mailto:<?php echo $recipient['email']; ?>" target="_blank"><?php echo $recipient['email']; ?></a><br>
        <strong>Phone</strong> <?php echo $recipient['phone']; ?><br>
        <br>
    </div>
    They have up until <strong><?php echo $date_expire; ?></strong>(UTC time) to pick the food, but if any issues, please fell free to contact the recipient directly, or contact admin@wellfedfoundation.org<br>
    <br>
    Thank you for using Well Fed Foundation, we truly appreciate your support.<br>
    <hr>    
    Regards, <br>
    Well Fed Foundation Team.
</div>