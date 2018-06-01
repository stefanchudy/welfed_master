<div>
    Dear <?php echo $recipient['user_name']; ?>,<br><br>
    This email is confirming the booking of <strong><?php echo $donation['title']; ?></strong> has been canceled upon your request.<br>
    If you have canceled it by mistake, you can order it again, if there is still enough quantity to be booked.<br>
    <div style="margin-left: 16px;">
        <strong>Donor name</strong> <?php echo $donation['donor_name']; ?><br>
        <strong>Address </strong> <?php echo $donation['donor_address']; ?><br>
        <strong>Phone</strong> <?php echo $donation['donor_phone']; ?><br>
        <br>
    </div>    
        
    <hr>
    Thank you for using Well Fed Foundation. <br>
    <br>
    Regards, <br>
    Well Fed Foundation Team.
</div>