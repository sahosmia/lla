<?php

$siteName = setting('_general.site_name') ? setting('_general.site_name') : env('APP_NAME');

return [

    /*
    |--------------------------------------------------------------------------
    | Tutor Translation Lines
    |--------------------------------------------------------------------------
    |
    | The following tutor translation lines are used during site management for various
    | messages that we need to display to the user. You are free to modify
    | these tutor translation lines according to your application's requirements.
    |
    */
    'thank_you'                    => 'Thank You!',
    'thank_you_page'               => 'Thank You',
    'you_successfully_submitted'   => 'You’ve successfully submitted the order, Please read below further',
    'select_best_tutor'            => 'Select Best Tutor',
    'add_checkout_details'         => 'Add Checkout Details',
    'You_done'                     => 'You’re Done!',
    'thank_You_for_your_order'     => 'Thank You For Your Order',
    'order_reference'              => 'Order Reference #:id',
    'thanks_detail'                => "Thank you for choosing <strong> $siteName </strong> to enhance your learning journey! We’re thrilled to have you onboard and are confident that these sessions will bring valuable insights and skills to your educational goals. Your booking has been successfully processed, and you’ll receive all the necessary details in your account and via email shortly. If you have any questions or need assistance, feel free to reach out to our support team. We’re here to ensure you have an exceptional learning experience. Happy learning 🤗",
    'continue_profile'             => 'Continue to Profile',
    'order_summary'                => 'Order Summary',
    'subtotal'                     => 'Subtotal',
    'grand_total'                  => 'Grand Total',
];
