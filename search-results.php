<?php

/**
 * Keep listing with search results
 */
if (isset($_POST['search'])) {

    $data = $_POST; 
    unset($data['search']);
    unset($data['submit']);
    include 'includes/booking.php';
    $booking = new Booking();

    $data['dest_type'] = 'city';
    $data['order_by'] = 'popularity';
    $data['filter_by_currency'] = 'AED';
    $data['units'] = 'metric';
    $response = $booking->request('/hotels/search', $data);
    
    $hotels = json_decode($response);
    $adults_number = $_POST['adults_number'];
    $days = date_diff(date_create($_POST['checkin_date']),date_create($_POST['checkout_date']))->format('%a');
    
    //if has records
    if ($hotels->primary_count > 0):
        
        foreach ($hotels->result as $hotel) {
            ?>
            <div class="p-card">
                <div class="row">
                    <div class="col-3">
                        <img src="<?= $hotel->max_photo_url ?>" alt="<?= $hotel->hotel_name ?>" />
                    </div>
                    <div class="col-6">
                        <h3 class="title"><a href="<?= $hotel->url ?>" target="_blank" class="is-inline"><?= $hotel->hotel_name ?></a>  </h3>   
                        <small><?= $hotel->distance_to_city_centre_formatted ?> from center</small>
                        <p class="p-heading--5"><?= $hotel->address ?>, <?= $hotel->city_name_en ?>, <?= $hotel->country_trans ?></p>
                        <span><?= $hotel->unit_configuration_label ?></span>
                    </div>
                    <div class="col-3 u-align-text--right">
                        <div class="p-chip"> <?= $hotel->review_score_word ?> &nbsp;<span class="p-badge"><?= $hotel->review_score ?></span></div>
                        <p>
                            <small><?= $adults_number ?> adults, <?= $days ?> nights </small> <br/>
                            <span class="price"><?= $hotel->currency_code ?> <?= $hotel->min_total_price ?></span>
                        </p>                         
                        <a href="<?= $hotel->url ?>" target="_blank" class="p-button"><span>See Availability <i class="p-icon--external-link"></i></span></a>
                    </div>
                </div>
            </div>
            <?php
        }
    else:
        echo 'No Matching found. Please try differant location!';
    endif;
}


