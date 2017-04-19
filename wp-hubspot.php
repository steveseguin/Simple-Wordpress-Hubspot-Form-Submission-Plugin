<?php
/*
Plugin Name: HubSpot Contact API
*/

function my_custom_redirect ($data) {
	 $arr = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value' => $data['email']
                ),
                array(
                    'property' => 'firstname',
                    'value' => $data['firstname']
                ),
                array(
                    'property' => 'lastname',
                    'value' => $data['lastname']
                ),
                array(
                    'property' => 'phone',
                    'value' => $data['telephone']
                )
            )
        );
        $post_json = json_encode($arr);
        $hapikey = "xxxxxxxx-xxxx-xxxx-xxxxx-xxxxxxxxxxxxxxxxxx";
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $hapikey;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
	echo $status_code;
	exit();
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'hscontact/v1', '/create', array(
    'methods' => 'POST',
    'callback' => 'my_custom_redirect',
  ) );
} );

