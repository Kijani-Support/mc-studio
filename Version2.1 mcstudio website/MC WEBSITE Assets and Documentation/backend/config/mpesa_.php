<?php

return [
    //Specify the environment mpesa is running, sandbox or production
    'mpesa_env' => env('MPESA_ENVIRONMENT') ? env('MPESA_ENVIRONMENT') : 'sandbox' ,
    /*-----------------------------------------
    |The App consumer key
    |------------------------------------------
    */
    'consumer_key'   => env('CONSUMER_KEY') ?  env('CONSUMER_KEY')  : 'aR7R09zePq0OSfOttvuQDrfdM4n37i0C',  

    /*-----------------------------------------
    |The App consumer Secret
    |------------------------------------------
    */                     
    'consumer_secret' => env('CONSUMER_KEY') ? env('CONSUMER_KEY')  : 'F9AebI6azDlRjLiR',     

    /*-----------------------------------------
    |The paybill number
    |------------------------------------------
    */
    'paybill' => env('MPESA_PAYBILL') ? env('CONSUMER_KEY') : 601380 ,

    /*-----------------------------------------
    |The Lipa Na Mpesa Online shortcode
    |------------------------------------------
    */
    'lipa_na_mpesa'  => env('MPESA_O_SHORTCODE') ? env('MPESA_LIPA')  : '174379' 
];