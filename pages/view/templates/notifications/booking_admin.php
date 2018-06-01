<div>
    Dear Admin,<br><br>
    <strong><?php echo $recipient['user_name']; ?></strong> has reserved <strong><?php echo $qty; ?></strong> units of <strong><?php echo $donation['title']; ?></strong> at <strong><?php echo $date_booked; ?></strong> (UTC time) from :<br>
    <div style="margin-left: 16px;">
        <strong>Donor name</strong> <?php echo $donation['donor_name']; ?><br>
        <strong>Address </strong> <?php echo $donation['donor_address']; ?><br>
        <strong>Phone</strong> <?php echo $donation['donor_phone']; ?><br>
        <br>
    </div>
    <hr>
    Recipient <strong><?php echo $delivery; ?></strong> requested delivery.<br>
    They have until <strong><?php echo $date_expire; ?></strong>(UTC time) to pick the food.<br>
    Recipient email address is <a style="font-weight: bold" href="mailto:<?php echo $recipient['email']; ?>" target="_blank"><?php echo $recipient['email']; ?></a>, <br>
    and phone number : <strong><?php echo $recipient['phone']; ?></strong><br>
    <br>
    Regards, <br>
    Well Fed Foundation Team.
</div>