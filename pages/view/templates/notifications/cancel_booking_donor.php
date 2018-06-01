<div>
    Dear <?php echo $donation['donor_user']; ?>,<br><br>
    This email is to inform you that the booking of <strong><?php echo $donation['title']; ?></strong> has been canceled by the recipient. <br>
    You can find the data below : <br>
    <div style="margin-left: 16px;">
        <strong>Recipient name</strong> <?php echo $recipient['user_name']; ?><br>
        <strong>Recipient e-mail </strong> <a style="font-weight: bold" href="mailto:<?php echo $recipient['email']; ?>" target="_blank"><?php echo $recipient['email']; ?></a><br>
        <strong>Phone</strong> <?php echo $recipient['phone']; ?><br>
        <br>
    </div>
    The canceled quantity is freed in our system, and now it's available to be booked by someone else.<br>
    <br>
    Thank you for using Well Fed Foundation, we truly appreciate your support.<br>
    <hr>    
    Regards, <br>
    Well Fed Foundation Team.
</div>