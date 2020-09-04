<?php
    include( 'cards.php' );
    $cards = new cards();
    $cards->set_font( 'AdobeGothicStd-Bold.otf' );
    $cards->set_save_in( __DIR__ . "/images/" );
    $cards->set_nums( range( 1, 10 ) );
    $cards->add_filledellipse( 500, 200 );    
    $cards->add_color( 'red', 220, 10, 10 );
    $cards->add_color( 'blue', 10, 10, 220 );
    $cards->add_text( 'Text', 1 );
    $cards->make();
    echo "<pre>" . print_r( $cards->files, true ) . "</pre>";
    $cards->make_tabletop_simulator();
    echo "<pre>" . print_r( $cards->files_tt, true ) . "</pre>";