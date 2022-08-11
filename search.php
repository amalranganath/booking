<?php
/**
 * Ajax request location search
 */
if (isset($_REQUEST['q'])) {
    $curl = curl_init();
    $search = trim(stripslashes(htmlspecialchars($_REQUEST['q'])));
    include 'includes/booking.php';
    $booking = new Booking();
    //call API
    $response = $booking->request('/hotels/locations', ['name' => $search]);
    $data = json_decode($response);
    
    //loop through the records and find locations
    foreach ($data as $rec) {
        //var_dump($rec);
        $names[] = ['value' => $rec->dest_id,'label' => $rec->name];
    }
    
    //var_dump($names);
    echo json_encode($names);
}


