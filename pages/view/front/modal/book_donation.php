<?php if (isset($modal_mode)) { ?>
    <div class="modal fade" id="new_booking" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form3">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add new booking</h4>
                    </div>
                    <div class="modal-body">
                        <?php if ($modal_mode == 'owner') { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="booking_user_id">Book to user</label>
                                        <?php echo $user_selector; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="booking_qty">Quantity</label>
                                        <input type="number" id="booking_qty" name="booking_qty" value="1" min="1" max="<?php echo $quantity_remain; ?>" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="booking_qty" for="booking_qty">Quantity</label>
                                        <input type="number" id="booking_qty" name="booking_qty" value="1" min="1" max="<?php echo $quantity_remain; ?>" class="form-control"/>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('booking_qty');
                                            ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="user_phone">Confirm your phone number</label>
                                        <input type="text" class="form-control" id="user_phone" name="booking_user_phone" value="<?php echo $this->user['data']['mobile_phone']; ?>"/>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('booking_user_phone');
                                            ?>
                                        </span>
                                    </div>                                    
                                    <div class="form-group">
                                        <input type="hidden" name="request_delivery" value="0"/>
                                        <label class="control-label">
                                            <input type="checkbox" <?php echo ($request_delivery)?' checked="checked"':'' ?> name="request_delivery" value="1" onclick="$('#delivery_address_group').toggleClass('active')"/> Request delivery
                                        </label>                                        
                                        <br>
                                        <em><small>* Well Fed Foundation cannot guarantee delivery, and any delivery will be on the schedule that suits delivery drivers available. You will be notified via email if delivery is possible.</small></em>
                                    </div>
                                    <div class="form-group <?php echo ($request_delivery)?' active"':'' ?>" id="delivery_address_group">
                                        <label class="control-label" for="booking_delivery_address">Delivery address</label>
                                        <textarea class="form-control" id="booking_delivery_address" rows="3" name="booking_delivery_address"><?php echo isset($booking_delivery_address)?$booking_delivery_address:''; ?></textarea>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('booking_delivery_address');
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="booking_accept_terms">
                                <input type="hidden" name="booking_accept_terms" value="0"/>
                                <input type="checkbox" id="booking_accept_terms" name="booking_accept_terms" value="1" <?php echo ((isset($booking_accept_terms) && ($booking_accept_terms == 1)) ? 'checked="checked"' : ''); ?>/>
                                I understand the 
                                <a href="food-recipient-agreement" target="_blank"><b class="theme-color">Food Recipient Agreement</b></a>, 
                                <a href="food-donation-agreement" target="_blank"><b class="theme-color">Food Donation Agreement</b></a>, the
                                <a href="terms-of-website" target="_blank"><b class="theme-color">Terms of Website use</b></a>, the 
                                <a href="privacy-policy" target="_blank"><b class="theme-color">Privacy policy</b></a> and 
                                <a href="food-safety-and-hygiene" target="_blank"><b class="theme-color">Food Safety and Hygiene Policy</b></a> on this website, 
                                and understand I am waiving any right to place any liability for the donations received or donated on either the donor, the receiver or Well Fed Foundation.                                            
                            </label>
                            <span class="small-alert">
                                <?php
                                echo $this->showErrors('booking_accept_terms');
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<style>
    textArea.form-control#booking_delivery_address{
        min-height: auto;
    }
    #delivery_address_group{
        display : none;
    }
    #delivery_address_group.active{
        display : block;
    }
</style>
<?php } ?>
<?php if (isset($this->errors['booking_qty'])|| isset($this->errors['booking_user_phone']) ||isset($this->errors['booking_accept_terms'])) {?>
<script>
    $(document).ready(function(){
        $('#new_booking').modal('show');
    });
</script>
<?php } ?>
