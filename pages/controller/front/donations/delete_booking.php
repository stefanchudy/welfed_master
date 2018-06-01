<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = Null;

    public function init() {

        if (isset($this->input->get['id']) && $this->user->logged) {
            $id = (int) $this->input->get['id'];
            $this->loadModel('donations');

            if ($donation_id = $this->model_donations->deleteBooking($id)) {
                $this->_sendNotifications($donation_id);
                $this->redirect('donations/edit?id=' . $donation_id);
            } else {
                $this->redirect('profile');
            }
        } else {
            $this->redirect('profile');
        }
    }
    private function _sendNotifications($donation_id){
        $donation = $this->model_donations->getDonation($donation_id);
        
        $donor = $this->user->getUserById($donation['location_data']['user_id']);

//        $this->debug($donor);
        $notification_data = array(
            'recipient' => array(
                'user_name' => $this->user->logged['screen_name'],
                'email' => $this->user->logged['email'],
                'phone' => $this->user->logged['data']['mobile_phone']
            ),
            'donation' => array(
                'title' => $donation['title'],
                'donor_name' => $donation['location_data']['location_title'],
                'donor_address' => $donation['location_data']['location_country'] . '-' . $donation['location_data']['location_city'] . '<br>' . $donation['location_data']['location_address'],
                'donor_phone' => $donation['location_data']['location_phone'],
                'donor_user' => $this->user->getUserNameById($donation['location_data']['user_id'])
            ),
        );
        $notification_admin = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/cancel_booking_admin', $notification_data)));
        $notification_user = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/cancel_booking_recipient', $notification_data)));
        $notification_donor = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/cancel_booking_donor', $notification_data)));
        
        if ($distribution = $this->db_settings->get('distribution_list', FALSE)) {
            $send_admin = clone $this->mailer;
            $distribution_list = explode(',', $distribution);
            $send_admin->Subject = 'Well Fed Foundation : Booking canceled';
            $send_admin->msgHTML($notification_admin);
            $send_admin->ClearAllRecipients();
            foreach ($distribution_list as $value) {
                if($value){
                    $send_admin->addAddress($value);
                }
            }
            $send_admin->send();            
        }

        $send_user = clone $this->mailer;
        $send_user->Subject = 'Well Fed Foundation : Booking canceled';
        $send_user->msgHTML($notification_user);
        $send_user->clearAllRecipients();
        $send_user->addAddress($this->user->logged['email']);
        $send_user->send();
        
        $send_donor = clone $this->mailer;
        $send_donor->Subject = 'Well Fed Foundation : Booking canceled';
        $send_donor->msgHTML($notification_donor);
        $send_donor->clearAllRecipients();
        $send_donor->addAddress($donor['email']);
        $send_donor->send();
        
    }

}
