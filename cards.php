<?php
    /**
     * Generates playing cards
     * Make deck formats for tabletop simulator
     *
     * @author Anthony Dewstow
     */
    class cards {
        private $nums = array( );
        private $colors = array( );
        private $text = array( );
        private $w = 410;
        private $h = 585;
        private $cutt = 8;
        private $save_in = './images/';
        private $show = 'images/';
        public $files = array( );
        public $files_tt = array( );
        private $font = 'arial.ttf';
        private $font_size_main = 150;
        private $font_size_small = 120;
        private $font_size_text = 110;
        private $filledellipse = array( );
        /**
         * sets card width
         * @param int $w 
         */
        public function set_width( $w ) {
            $this->w = $w;
        }
        /**
         * sets card height
         * @param int $h 
         */
        public function set_height( $h ) {
            $this->h = $h;
        }
        /**
         * sets card cutt width
         * @param int $cutt 
         */
        public function set_cutt( $cutt ) {
            $this->cutt = $cutt;
        }
        /**
         * sets card numbers
         * @param array $w 
         */
        public function set_nums( $nums ) {
            $this->nums = $nums;
        }
        /**
         * sets card numbers via range
         * @param int $low lowest number 
         * @param int $highe highest  number 
         * @param int $per how often in the range
         */
        public function set_nums_rnage( $low, $highe, $per = 1 ) {
            $this->nums = range( $low, $highe, $per );
        }
        /**
         * Adds color set to numbered cards
         * @param int $r Red
         * @param int $g Green
         * @param int $b Blue
         */
        public function add_color( $name, $r, $g, $b ) {
            $this->colors[ $name ] = array(
                 $r,
                $g,
                $b 
            );
        }
        /**
         * Adds filled ellipse
         * @param int $x x position 
         * @param int $y y position
         */
        public function add_filledellipse( $x, $y ) {
            $this->filledellipse[ ] = array(
                 $x,
                $y 
            );
        }
        /**
         * Set Save location of cards 
         * @param string $save_in full folder location
         */
        public function set_save_in( $save_in ) {
            $this->save_in = $save_in;
        }
        /**
         * Set font file to be used
         * @param string $font full file location
         */
        public function set_font( $font ) {
            $this->font = $font;
        }
        /**
         * Set main font size
         * @param int $font_size_main
         */
        public function set_font_size_main( $font_size_main ) {
            $this->font_size_main = $font_size_main;
        }
        /**
         * Set main font size for corner numbers
         * @param int $font_size_small
         */
        public function set_font_size_small( $font_size_small ) {
            $this->font_size_small = $font_size_small;
        }
        /**
         * Set main font size for text cards
         * @param int $font_size_text
         */
        public function set_font_size_text( $font_size_text ) {
            $this->font_size_text = $font_size_text;
        }
        /**
         * Add Text card
         * @param text $name Text of the card
         * @param int $n Number of them
         * @param array $tc array(red, green, blue) of text color
         * @param array $bg array(red, green, blue) of offset color
         * @param array $cc array(red, green, blue) of background color
         */
        public function add_text( $name, $n, $tc = array( 255, 0, 0 ), $bg = array( 0, 0, 0 ), $cc = array( 255, 255, 255 ) ) {
            $aa                  = array( );
            $aa[ 'num' ]         = $n;
            $aa[ 'tc' ]          = $tc;
            $aa[ 'bg' ]          = $bg;
            $aa[ 'cc' ]          = $cc;
            $this->text[ $name ] = $aa;
        }
        /**
         * Makes all the cards
         */
        public function make( ) {
            $this->make_nums();
            $this->make_texts();
        }
        /**
         * Makes large PNG for Tabletop Simulator's deck format
         */
        public function make_tabletop_simulator( ) {
            //10x7
            $wm             = 10;
            $hm             = 7;
            $w              = 0;
            $h              = 0;
            $img            = null;
            $this->files_tt = array( );
            $fk             = 1;
            foreach ( $this->files as $ff ) {
                if ( $img == null ) {
                    $img   = imagecreatetruecolor( $this->w * $wm, $this->h * $hm );
                    $white = imagecolorallocate( $img, 255, 255, 255 );
                    imagefill( $img, 0, 0, $white );
                    $as = "tt_" . str_pad( $fk, 2, "0", STR_PAD_LEFT ) . ".png";
                    echo "<br>++" . $as;
                }
                //echo "<br>" . $ff ." ".$w.",".$h;
                $from = imagecreatefrompng( $ff );
                imagecopy( $img, $from, $this->w * $w, $this->h * $h, 0, 0, $this->w, $this->h );
                $w++;
                if ( $w >= $wm ) {
                    $h++;
                    $w = 0;
                }
                if ( $h >= $hm ) {
                    $w = 0;
                    $h = 0;
                    $fk++;
                    imagepng( $img, $this->save_in . $as );
                    $this->files_tt[ ] = $as;
                    imagedestroy( $img );
                    echo " <img src='" . $this->show . $as . "' width='" . ( ( $this->w * $wm ) * .3 ) . "px'/>";
                    $img = null;
                }
            }
            if ( $img != null ) {
                imagepng( $img, $this->save_in . $as );
                $this->files_tt[ ] = $as;
                imagedestroy( $img );
                echo " <img src='" . $this->show . $as . "' width='" . ( ( $this->w * $wm ) * .3 ) . "px'/>";
            }
        }
        public function make_nums( ) {
            foreach ( $this->colors as $name => $rgb ) {
                foreach ( $this->nums as $n ) {
                    $code  = $name . "_" . str_pad( $n, 2, "0", STR_PAD_LEFT );
                    $as    = $code . ".png";
                    // echo "<br>" . $as;
                    $img   = imagecreatetruecolor( $this->w, $this->h );
                    $white = imagecolorallocate( $img, 255, 255, 255 );
                    $black = imagecolorallocate( $img, 0, 0, 0 );
                    imagefill( $img, 0, 0, $white );
                    $cc = imagecolorallocate( $img, $rgb[ 0 ], $rgb[ 1 ], $rgb[ 2 ] );
                    foreach ( $this->filledellipse as $e ) {
                        imagefilledellipse( $img, 0, 0, $e[ 0 ], $e[ 1 ], $cc );
                        imagefilledellipse( $img, $this->w, $this->h, $e[ 0 ], $e[ 1 ], $cc );
                    }
                    $font_file = $this->font;
                    if ( !is_file( $this->font ) ) {
                        throw new Exception( "Not a valid file '" . $this->font . "'\n" );
                    }
                    $fzb = 150;
                    //main text
                    $bb  = imagettfbbox( $this->font_size_main, 0, $font_file, $n );
                    $tw  = $bb[ 2 ] - $bb[ 0 ];
                    $th  = $bb[ 7 ] - $bb[ 1 ];
                    $xc  = ( $this->w / 2 ) - ( $tw / 2 );
                    $yc  = ( $this->h / 2 ) - ( $th / 2 );
                    $this->wrap_text( $img, $this->font_size_main, 0, $xc, $yc, 4, $black, $font_file, $n );
                    imagettftext( $img, $this->font_size_main, 0, $xc, $yc, $cc, $font_file, $n );
                    $fz = 40;
                    //top
                    $bb = imagettfbbox( $fz, 0, $font_file, $n );
                    $tw = $bb[ 2 ] - $bb[ 0 ];
                    $th = $bb[ 7 ] - $bb[ 1 ];
                    $xc = 40 - ( $tw / 2 );
                    $yc = 40 - ( $th / 2 );
                    $this->wrap_text( $img, $fz, 0, $xc, $yc, 2, $black, $font_file, $n );
                    imagettftext( $img, $fz, 0, $xc, $yc, $white, $font_file, $n );
                    //
                    //bottom
                    $bb = imagettfbbox( $fz, 180, $font_file, $n );
                    $tw = $bb[ 2 ] - $bb[ 0 ];
                    $th = $bb[ 7 ] - $bb[ 1 ];
                    $xc = $this->w - 40 - ( $tw / 2 );
                    $yc = $this->h - 40 - ( $th / 2 );
                    $this->wrap_text( $img, $fz, 180, $xc, $yc, 2, $black, $font_file, $n );
                    imagettftext( $img, $fz, 180, $xc, $yc, $white, $font_file, $n );
                    //
                    //top
                    imagefilledrectangle( $img, 0, 0, $this->w, $this->cutt, $white );
                    imagefilledrectangle( $img, $this->w, $this->h, $this->w - $this->cutt, 0, $white );
                    imagefilledrectangle( $img, 0, $this->h, $this->cutt, $this->cutt, $white );
                    imagefilledrectangle( $img, 0, $this->h, $this->w, $this->h - $this->cutt, $white );
                    imagepng( $img, $this->save_in . $as );
                    $this->files[ $code ] = $this->save_in . $as;
                    imagedestroy( $img );
                    echo " <img src='" . $this->show . $as . "' width='100px'/>";
                    ob_flush();
                    flush();
                }
            }
        }
        public function make_texts( ) {
            foreach ( $this->text as $n => $tta ) {
                $numm  = $tta[ 'num' ];
                $ns    = substr( $n, 0, 1 );
                $img   = imagecreatetruecolor( $this->w, $this->h );
                $red   = imagecolorallocate( $img, $tta[ 'tc' ][ 0 ], $tta[ 'tc' ][ 1 ], $tta[ 'tc' ][ 2 ] );
                $white = imagecolorallocate( $img, $tta[ 'cc' ][ 0 ], $tta[ 'cc' ][ 1 ], $tta[ 'cc' ][ 2 ] );
                $black = imagecolorallocate( $img, $tta[ 'bg' ][ 0 ], $tta[ 'bg' ][ 1 ], $tta[ 'bg' ][ 2 ] );
                imagefill( $img, 0, 0, $black );
                foreach ( $this->filledellipse as $e ) {
                    imagefilledellipse( $img, 0, 0, $e[ 0 ], $e[ 1 ], $white );
                    imagefilledellipse( $img, $this->w, $this->h, $e[ 0 ], $e[ 1 ], $white );
                }
                $font_file = $this->font;
                $fzb       = $this->font_size_text;
                //main text
                $bb        = imagettfbbox( $fzb, 0, $font_file, $n );
                while ( $bb[ 2 ] > ( $this->w - 40 ) ) {
                    $fzb--;
                    $bb = imagettfbbox( $fzb, 0, $font_file, $n );
                }
                $tw = $bb[ 2 ] - $bb[ 0 ];
                $th = $bb[ 7 ] - $bb[ 1 ];
                $xc = ( $this->w / 2 ) - ( $tw / 2 );
                $yc = ( $this->h / 2 ) - ( $th / 2 );
                $this->wrap_text( $img, $fzb, 0, $xc, $yc, 5, $white, $font_file, $n );
                imagettftext( $img, $fzb, 0, $xc, $yc, $red, $font_file, $n );
                $fz = 40;
                //top
                $bb = imagettfbbox( $fz, 0, $font_file, $ns );
                $tw = $bb[ 2 ] - $bb[ 0 ];
                $th = $bb[ 7 ] - $bb[ 1 ];
                $xc = 40 - ( $tw / 2 );
                $yc = 40 - ( $th / 2 );
                $this->wrap_text( $img, $fz, 0, $xc, $yc, 2, $black, $font_file, $ns );
                imagettftext( $img, $fz, 0, $xc, $yc, $red, $font_file, $ns );
                //
                //bottom
                $bb = imagettfbbox( $fz, 180, $font_file, $ns );
                $tw = $bb[ 2 ] - $bb[ 0 ];
                $th = $bb[ 7 ] - $bb[ 1 ];
                $xc = $this->w - 40 - ( $tw / 2 );
                $yc = $this->h - 40 - ( $th / 2 );
                $this->wrap_text( $img, $fz, 180, $xc, $yc, 2, $black, $font_file, $ns );
                imagettftext( $img, $fz, 180, $xc, $yc, $red, $font_file, $ns );
                //
                //top
                //cutt card
                $cutt_white = imagecolorallocate( $img, 255, 255, 255 );
                imagefilledrectangle( $img, 0, 0, $this->w, $this->cutt, $cutt_white );
                imagefilledrectangle( $img, $this->w, $this->h, $this->w - $this->cutt, 0, $cutt_white );
                imagefilledrectangle( $img, 0, $this->h, $this->cutt, $this->cutt, $cutt_white );
                imagefilledrectangle( $img, 0, $this->h, $this->w, $this->h - $this->cutt, $cutt_white );
                for ( $nkk = 1; $nkk <= $numm; $nkk++ ) {
                    $code = strtolower( $n ) . "_" . str_pad( $nkk, 2, "0", STR_PAD_LEFT );
                    $as   = $code . ".png";
                    imagepng( $img, $this->save_in . $as );
                    $this->files[ $code ] = $this->save_in . $as;
                    echo " <img src='" . $this->show . $as . "' width='100px'/>";
                    ob_flush();
                    flush();
                }
                imagedestroy( $img );
            }
        }
        private function wrap_text( &$img, $font_size, $ang, $x, $y, $px, $cc, $font_file, $text ) {
            for ( $c1 = ( $x - abs( $px ) ); $c1 <= ( $x + abs( $px ) ); $c1++ ) {
                for ( $c2 = ( $y - abs( $px ) ); $c2 <= ( $y + abs( $px ) ); $c2++ ) {
                    $bg = imagettftext( $img, $font_size, $ang, $c1, $c2, $cc, $font_file, $text );
                }
            }
        }
    }