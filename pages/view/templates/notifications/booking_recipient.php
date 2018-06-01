<div>
    Dear <?php echo $recipient['user_name']; ?>,<br><br>
    This email is confirming the booking of <strong><?php echo $qty; ?></strong> units of <strong><?php echo $donation['title']; ?></strong> at <strong><?php echo $date_booked; ?></strong> (UTC time) from :<br>   
    <div style="margin-left: 16px;">
        <strong>Donor name</strong> <?php echo $donation['donor_name']; ?><br>
        <strong>Address </strong> <?php echo $donation['donor_address']; ?><br>
        <strong>Phone</strong> <?php echo $donation['donor_phone']; ?><br>
        <br>
    </div>    
    Please pick up food by <strong><?php echo $date_expire; ?></strong> (UTC time)] or the food will go to waste, and this will be an inconvenience to the supplier and the community as a whole. <br>
    Any request for delivery has no guarantee of being accepted, so please do not depend upon that. Contact the donor or <a style="font-weight: bold;" href="admin@wellfedfoundation.org">admin@wellfedfoundation.org</a> if in doubt. <br>
    <hr>
    Thank you for using Well Fed Foundation. <br>
    <br>
    Regards, <br>
    Well Fed Foundation Team.
</div>