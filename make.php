<?php
    include( 'cards.php' );
    $cards = new cards();
    $cards->set_font( 'AdobeGothicStd-Bold.otf' );
    $cards->set_save_in( __DIR__ . "/images/" );
    $cards->set_nums( range( 1, 10 ) );
    $cards->set_font_size_main( 190 );
    $cards->add_filledellipse( 400, 190 );
    $cards->set_cutt( 2 );
    $cards->add_color( 'red', 240, 0, 0 );
    $cards->add_color( 'yellow', 240, 240, 0 );
    $cards->add_color( 'green', 19, 171, 39 );
    $cards->add_color( 'blue', 0, 0, 240 );
    $cards->add_text( 'SKIP', 4 );
    $black = array(
         0,
        0,
        0 
    );
    $white = array(
         255,
        255,
        255 
    );
    $green = array(
         20,
        255,
        20 
    );
    $ca    = array(
         'G' => $green,
        'W' => $white,
        'B' => $black 
    );
    foreach ( $ca as $ka => $la ) {
        foreach ( $ca as $kb => $lb ) {
            foreach ( $ca as $kc => $lc ) {
                if ( !( ( $ka == $kb ) && ( $kb == $kc ) ) ) {
                    $t = $ka . $kb . $kc;
                    $cards->add_text( $t, 1, $la, $lb, $lc );
                }
            }
        }
    }    
    $cards->make();
    echo "<pre>" . print_r( $cards->files, true ) . "</pre>";