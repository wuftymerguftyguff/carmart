<?php
/**
 * write.php
 *
 * writes and edits ads,
 * uploads and deletes images
 *
 * @package com_marketplace
 * @subpackage frontend
 *
 * @copyright 2005-2006 joomster.com Achim Fischer
 * @author Achim Fischer
 *
 * This file is part of joomster.com Marketplace.
 *
 * Marketplace is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Marketplace is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Marketplace; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>

<link rel="stylesheet" href="components/com_marketplace/marketplace.css" type="text/css" />

<?php
global $database;


$Itemid       = intval( mosGetParam( $_REQUEST, 'Itemid', '0' ) );
$adid         = intval( mosGetParam( $_REQUEST, 'adid', '0' ) );
$isUpdateMode = intval( mosGetParam( $_REQUEST, 'isUpdateMode', '0' ) );
$userid       = intval( mosGetParam( $_REQUEST, 'userid', '0' ) );

$username     = strval( mosGetParam( $_REQUEST, 'username', '' ) );
$mode         = strval( mosGetParam( $_REQUEST, 'mode', '' ) );

$name         = strval( mosGetParam( $_REQUEST, 'name', '' ) );
$surname      = strval( mosGetParam( $_REQUEST, 'surname', '' ) );
$street       = strval( mosGetParam( $_REQUEST, 'street', '' ) );
$zip          = strval( mosGetParam( $_REQUEST, 'zip', '' ) );
$city         = strval( mosGetParam( $_REQUEST, 'city', '' ) );
$state        = strval( mosGetParam( $_REQUEST, 'state', '' ) );
$country      = strval( mosGetParam( $_REQUEST, 'country', '' ) );
$email        = strval( mosGetParam( $_REQUEST, 'email', '' ) );
$web          = strval( mosGetParam( $_REQUEST, 'web', '' ) );
$phone1       = strval( mosGetParam( $_REQUEST, 'phone1', '' ) );
$phone2       = strval( mosGetParam( $_REQUEST, 'phone2', '' ) );

$ad_type      = intval( mosGetParam( $_REQUEST, 'ad_type', '0' ) );
$category     = intval( mosGetParam( $_REQUEST, 'category', '0' ) );

$ad_headline  = strval( mosGetParam( $_REQUEST, 'ad_headline', '' ) );
$ad_text      = strval( mosGetParam( $_REQUEST, 'ad_text', '' ) );
$ad_condition = strval( mosGetParam( $_REQUEST, 'ad_condition', '' ) );
$ad_price     = strval( mosGetParam( $_REQUEST, 'ad_price', '' ) );

$ad_picture1  = strval( mosGetParam( $_REQUEST, 'ad_picture1', '' ) );
$ad_picture2  = strval( mosGetParam( $_REQUEST, 'ad_picture2', '' ) );
$ad_picture3  = strval( mosGetParam( $_REQUEST, 'ad_picture3', '' ) );
$cb_image1    = strval( mosGetParam( $_REQUEST, 'cb_image1', '' ) );
$cb_image2    = strval( mosGetParam( $_REQUEST, 'cb_image2', '' ) );
$cb_image3    = strval( mosGetParam( $_REQUEST, 'cb_image3', '' ) );

$gflag        = intval( mosGetParam( $_REQUEST, 'gflag', '0' ) );



// set page title
if( $adid == "") {
    $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_AD_WRITE );
}
else {
    $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_AD_EDIT );
}


// get configuration data
$database->setQuery("SELECT * FROM #__marketplace_config LIMIT 1");
$config = $database->loadObjectList();

$ad_default    = $config[0]->ad_default;
$use_surname   = $config[0]->use_surname;
$use_street    = $config[0]->use_street;
$use_zip       = $config[0]->use_zip;
$use_city      = $config[0]->use_city;
$use_state     = $config[0]->use_state;
$use_country   = $config[0]->use_country;
$use_web       = $config[0]->use_web;
$use_phone1    = $config[0]->use_phone1;
$use_phone2    = $config[0]->use_phone2;
$use_condition = $config[0]->use_condition;




function ad_image( $adid, $image, $itrail, $mosConfig_absolute_path, $af_info, $database) {

    $af_dir_ads = $mosConfig_absolute_path."/components/com_marketplace/images/entries/";

    // check imagesize
    $database->setQuery( "SELECT max_image_size FROM #__marketplace_config");
    $max_image_size = $database->loadResult();

    $image_too_big = 0;
    if (isset( $_FILES['ad_picture1'])) {
        if ( $_FILES['ad_picture1']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }
    if (isset( $_FILES['ad_picture2'])) {
        if ( $_FILES['ad_picture2']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }
    if (isset( $_FILES['ad_picture3'])) {
        if ( $_FILES['ad_picture3']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }


    if ( $image_too_big == 1) {
        echo "<font color='#CC0000'>";
        echo JOO_IMAGETOOBIG;
        echo "</font>";
        echo "<br>";
        echo "<br>";
    }
    else {
        $af_size = GetImageSize ($_FILES[$image]['tmp_name'], $af_info);


        switch ($af_size[2]) {
                case 1 : {
                    $thispicext = 'gif';
                    break;
                }
                case 2 : {
                    $thispicext = 'jpg';
                    break;
                }
                case 3 : {
                    $thispicext = 'png';
                    break;
                }
        }


        $isNewImage = 1;
        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid.$itrail."_t.gif")) {
            $isNewImage = 0;
        }
        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid.$itrail."_t.jpg")) {
            $isNewImage = 0;
        }
        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid.$itrail."_t.jpg")) {
            $isNewImage = 0;
        }


        if ( $af_size[2] >= 1 && $af_size[2] <= 3) { // GIF, JPG or PNG

            switch ( $itrail) {
                case "a": {
                    $a_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.jpg";
                    if ( file_exists( $a_pict_jpg)) {
                        unlink( $a_pict_jpg);
                    }
                    $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.jpg";
                    if ( file_exists( $a_pic_jpg)) {
                        unlink( $a_pic_jpg);
                    }

                    $a_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.png";
                    if ( file_exists( $a_pict_png)) {
                        unlink( $a_pict_png);
                    }
                    $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.png";
                    if ( file_exists( $a_pic_png)) {
                        unlink( $a_pic_png);
                    }

                    $a_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.gif";
                    if ( file_exists( $a_pict_gif)) {
                        unlink( $a_pict_gif);
                    }
                    $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.gif";
                    if ( file_exists( $a_pic_gif)) {
                        unlink( $a_pic_gif);
                    }
                    break;
                }
                case "b": {
                    $b_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.jpg";
                    if ( file_exists( $b_pict_jpg)) {
                        unlink( $b_pict_jpg);
                    }
                    $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.jpg";
                    if ( file_exists( $b_pic_jpg)) {
                        unlink( $b_pic_jpg);
                    }

                    $b_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.png";
                    if ( file_exists( $b_pict_png)) {
                        unlink( $b_pict_png);
                    }
                    $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.png";
                    if ( file_exists( $b_pic_png)) {
                        unlink( $b_pic_png);
                    }

                    $b_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.gif";
                    if ( file_exists( $b_pict_gif)) {
                        unlink( $b_pict_gif);
                    }
                    $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.gif";
                    if ( file_exists( $b_pic_gif)) {
                        unlink( $b_pic_gif);
                    }
                    break;
                }
                case "c": {
                    $c_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.jpg";
                    if ( file_exists( $c_pict_jpg)) {
                        unlink( $c_pict_jpg);
                    }
                    $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.jpg";
                    if ( file_exists( $c_pic_jpg)) {
                        unlink( $c_pic_jpg);
                    }

                    $c_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.png";
                    if ( file_exists( $c_pict_png)) {
                        unlink( $c_pict_png);
                    }
                    $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.png";
                    if ( file_exists( $c_pic_png)) {
                        unlink( $c_pic_png);
                    }

                    $c_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.gif";
                    if ( file_exists( $c_pict_gif)) {
                        unlink( $c_pict_gif);
                    }
                    $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.gif";
                    if ( file_exists( $c_pic_gif)) {
                        unlink( $c_pic_gif);
                    }
                    break;
                }
            }



            chmod ( $_FILES[$image]['tmp_name'], 0644);

            // copy image
            move_uploaded_file ( $_FILES[$image]['tmp_name'], $af_dir_ads.$adid.$itrail.".".$thispicext);

            // create thumbnail
            switch ($af_size[2]) {
                case 1 : $src = ImageCreateFromGif( $af_dir_ads.$adid.$itrail.".".$thispicext); break;
                case 2 : $src = ImageCreateFromJpeg( $af_dir_ads.$adid.$itrail.".".$thispicext); break;
                case 3 : $src = ImageCreateFromPng( $af_dir_ads.$adid.$itrail.".".$thispicext); break;
            }

            $width_before  = ImageSx( $src);
            $height_before = ImageSy( $src);

            if ( $width_before  >= $height_before) {
                $width_new = min(100, $width_before);
                $scale = $width_before / $height_before;
                $height_new = round( $width_new / $scale);
            }
            else {
                $height_new = min(75, $height_before);
                $scale = $height_before / $width_before;
                $width_new = round( $height_new / $scale);
            }

            $dst = ImageCreateTrueColor( $width_new, $height_new);

            // GD Lib 2
            ImageCopyResampled( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

            // GD Lib 1
            //ImageCopyResized( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

            switch ($af_size[2]) {
                case 1 : ImageGIF( $dst, $af_dir_ads.$adid.$itrail."_t.".$thispicext); break;
                case 2 : ImageJPEG( $dst, $af_dir_ads.$adid.$itrail."_t.".$thispicext); break;
                case 3 : ImagePNG( $dst, $af_dir_ads.$adid.$itrail."_t.".$thispicext); break;
            }

            imagedestroy( $dst);
            imagedestroy( $src);


            // DB updaten
            if ( $isNewImage == 1) {
                $sql = "UPDATE #__marketplace_ads
                     SET ad_image = ad_image + 1, date_lastmodified = CURRENT_DATE()
                     WHERE id = $adid";
            }
            else { // isNewImage==0
                $sql = "UPDATE #__marketplace_ads
                     SET date_lastmodified = CURRENT_DATE()
                     WHERE id = $adid";
            }

            $database->setQuery( $sql);

            if ($database->getErrorNum()) {
                echo $database->stderr();
            } else {
                $database->query();
            }


        }
    }
}



echo "<table width='100%'>";
echo "<tr>";
echo "<td align='left'>";

include($mosConfig_absolute_path.'/components/com_marketplace/topmenu.php');
// -------------------------------------------------------------------------------

$username=$my->username;
$userid=$my->id;

$afNameClass 		= "marketplace_required";
$afEmailClass 		= "marketplace_required";
$afHeadlineClass 	= "marketplace_required";
$afTextClass 		= "marketplace_required";


if ($userid == "0") {
    echo "<br>";
    echo "<br>";

    echo "<table cellspacing=\"10\" cellpadding=\"5\">";
    echo "<tr>";
    echo "<td width=\"20\">";
    echo "&nbsp;";
    echo "</td>";
    echo "<td>";
    echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/warning.gif\" border=\"0\" align=\"center\">";
    echo "</td>";
    echo "<td>";
    echo "<b>";
    echo JOO_ADD_NOTALLOWED;
    echo "</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
}
else {  // user is logged in


    /* input validation */
    if( $mode == "db") {
        $bInputFields = 0;

        if ( strlen ( $name) < 3) {
            $bInputFields = 1;
            $afNameClass = "marketplace_error";
        }
        if ( strlen ( $email) < 7) {
            $bInputFields = 1;
            $afEmailClass = "marketplace_error";
        }
        if ( strlen ( $ad_headline) < 5) {
            $bInputFields = 1;
            $afHeadlineClass = "marketplace_error";
        }
        if ( strlen ( $ad_text) < 5) {
            $bInputFields = 1;
            $afTextClass = "marketplace_error";
        }
    }



    if( $mode == "db" && $bInputFields == 0) {

        if( $isUpdateMode) { // update
            $sql    = "UPDATE #__marketplace_ads
								 SET category          = '$category',
									 name              = '$name',
									 surname           = '$surname',
									 street            = '$street',
									 zip               = '$zip',
									 city              = '$city',
									 state             = '$state',
									 country           = '$country',
									 phone1            = '$phone1',
									 phone2            = '$phone2',
									 email             = '$email',
									 web               = '$web',
									 ad_type           = '$ad_type',
									 ad_headline       = '$ad_headline',
									 ad_text           = '$ad_text',
									 ad_condition      = '$ad_condition',
									 ad_price          = '$ad_price',
									 date_lastmodified = CURRENT_DATE()
								 WHERE id = $adid
							  ";

            $database->setQuery( $sql);

            if ($database->getErrorNum()) {
                echo $database->stderr();
            } else {
                $database->query();
            }


            // image1 delete
            if ( $cb_image1 == "delete") {
                $a_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.jpg";
                if ( file_exists( $a_pict_jpg)) {
                    unlink( $a_pict_jpg);
                }
                $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.jpg";
                if ( file_exists( $a_pic_jpg)) {
                    unlink( $a_pic_jpg);
                }

                $a_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.png";
                if ( file_exists( $a_pict_png)) {
                    unlink( $a_pict_png);
                }
                $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.png";
                if ( file_exists( $a_pic_png)) {
                    unlink( $a_pic_png);
                }

                $a_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.gif";
                if ( file_exists( $a_pict_gif)) {
                    unlink( $a_pict_gif);
                }
                $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.gif";
                if ( file_exists( $a_pic_gif)) {
                    unlink( $a_pic_gif);
                }

                $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $adid";

                $database->setQuery( $sql);

                if ($database->getErrorNum()) {
                    echo $database->stderr();
                } else {
                    $database->query();
                }
            }


            // image2 delete
            if ( $cb_image2 == "delete") {
                $b_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.jpg";
                if ( file_exists( $b_pict_jpg)) {
                    unlink( $b_pict_jpg);
                }
                $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.jpg";
                if ( file_exists( $b_pic_jpg)) {
                    unlink( $b_pic_jpg);
                }

                $b_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.png";
                if ( file_exists( $b_pict_png)) {
                    unlink( $b_pict_png);
                }
                $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.png";
                if ( file_exists( $b_pic_png)) {
                    unlink( $b_pic_png);
                }

                $b_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.gif";
                if ( file_exists( $b_pict_gif)) {
                    unlink( $b_pict_gif);
                }
                $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.gif";
                if ( file_exists( $b_pic_gif)) {
                    unlink( $b_pic_gif);
                }

                $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $adid";

                $database->setQuery( $sql);

                if ($database->getErrorNum()) {
                    echo $database->stderr();
                } else {
                    $database->query();
                }
            }


            // image3 delete
            if ( $cb_image3 == "delete") {
                $c_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.jpg";
                if ( file_exists( $c_pict_jpg)) {
                    unlink( $c_pict_jpg);
                }
                $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.jpg";
                if ( file_exists( $c_pic_jpg)) {
                    unlink( $c_pic_jpg);
                }

                $c_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.png";
                if ( file_exists( $c_pict_png)) {
                    unlink( $c_pict_png);
                }
                $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.png";
                if ( file_exists( $c_pic_png)) {
                    unlink( $c_pic_png);
                }

                $c_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.gif";
                if ( file_exists( $c_pict_gif)) {
                    unlink( $c_pict_gif);
                }
                $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.gif";
                if ( file_exists( $c_pic_gif)) {
                    unlink( $c_pic_gif);
                }

                $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $adid";

                $database->setQuery( $sql);

                if ($database->getErrorNum()) {
                    echo $database->stderr();
                } else {
                    $database->query();
                }
            }



            // image1 upload
            if (isset( $_FILES['ad_picture1']) and !$_FILES['ad_picture1']['error'] ) {
                ad_image( $adid, "ad_picture1", "a", $mosConfig_absolute_path, $af_info, $database);
            }
            // image2 upload
            if (isset( $_FILES['ad_picture2']) and !$_FILES['ad_picture2']['error'] ) {
                ad_image( $adid, "ad_picture2", "b", $mosConfig_absolute_path, $af_info, $database);
            }
            // image3 upload
            if (isset( $_FILES['ad_picture3']) and !$_FILES['ad_picture3']['error'] ) {
                ad_image( $adid, "ad_picture3", "c", $mosConfig_absolute_path, $af_info, $database);
            }


        }
        else { // insert


            // 1. insert ad: mos_marketplace_ads

            $sql = "INSERT INTO #__marketplace_ads (
						category, userid, user, name, surname, street, zip, city, state, country, phone1, phone2, email, web,
						ad_type, ad_headline, ad_text, ad_condition, ad_price, date_created, date_lastmodified, published
						)
						VALUES (
						'$category', '$userid', '$username', '$name', '$surname', '$street', '$zip', '$city', '$state', '$country',
						'$phone1', '$phone2', '$email', '$web', '$ad_type', '$ad_headline', '$ad_text',
						'$ad_condition', '$ad_price', CURRENT_DATE(), CURRENT_DATE(), '$ad_default'
						)";

            $database->setQuery( $sql);

            if ($database->getErrorNum()) {
                echo $database->stderr();
            } else {
                $database->query();
            }


            $adid = mysql_insert_id();


            // image1 upload
            if (isset( $_FILES['ad_picture1']) and !$_FILES['ad_picture1']['error'] ) {
                ad_image( $adid, "ad_picture1", "a", $mosConfig_absolute_path, $af_info, $database);
            }
            // image2 upload
            if (isset( $_FILES['ad_picture2']) and !$_FILES['ad_picture2']['error'] ) {
                ad_image( $adid, "ad_picture2", "b", $mosConfig_absolute_path, $af_info, $database);
            }
            // image3 upload
            if (isset( $_FILES['ad_picture3']) and !$_FILES['ad_picture3']['error'] ) {
                ad_image( $adid, "ad_picture3", "c", $mosConfig_absolute_path, $af_info, $database);
            }



        }
        echo "<br>";
        echo "<br>";


        echo "<table cellspacing=\"10\" cellpadding=\"5\">";
        echo "<tr>";
        echo "<td width=\"20\">";
        echo "&nbsp;";
        echo "</td>";
        echo "<td>";
        echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/success.gif\" border=\"0\" align=\"center\">";
        echo "</td>";
        echo "<td>";
        echo "<b>";
        if( $isUpdateMode) { // update
            echo JOO_UPDATE_SUCCESSFULL;
        }
        else { // insert
            echo JOO_INSERT_SUCCESSFULL;
        }
        echo "</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

    } // mode db && bInputfields==0
    else {

        if( $adid > 0) { // edit ad

            // 1. get data
            $database->setQuery("SELECT * FROM #__marketplace_ads WHERE id=$adid");
            $row = $database->loadObjectList();
            $ad_id          = $row[0]->id;
            $ad_category    = $row[0]->category;
            $ad_user        = $row[0]->user;
            $ad_userid      = $row[0]->userid;
            $ad_name        = $row[0]->name;
            $ad_surname     = $row[0]->surname;
            $ad_street      = $row[0]->street;
            $ad_zip         = $row[0]->zip;
            $ad_city        = $row[0]->city;
            $ad_state       = $row[0]->state;
            $ad_country     = $row[0]->country;
            $ad_phone1      = $row[0]->phone1;
            $ad_phone2      = $row[0]->phone2;
            $ad_email       = $row[0]->email;
            $ad_web         = $row[0]->web;
            $ad_type        = $row[0]->ad_type;
            $ad_headline    = $row[0]->ad_headline;
            $ad_text        = $row[0]->ad_text;
            $ad_condition   = $row[0]->ad_condition;
            $ad_price       = $row[0]->ad_price;


            $database->setQuery( "SELECT admin_userid FROM #__marketplace_config");
            $admin_userid = $database->loadResult();

            switch ($userid) {

                case $admin_userid:
                case $ad_userid: {
                    $isUpdateMode = 1;
                    break;
                }
                default: {
                    $isUpdateMode = 0;
                }
            }

        }
        else { // insert
            $isUpdateMode = 0;
        }


        echo JOO_RULESREAD;

        echo "<br>";
        echo "<br>";


        echo "<table class=\"marketplace_header\">";
        echo "<tr>";
        echo "<td class=\"marketplace_header\" id=\"writead_header1\">";
        echo "&nbsp;";
        echo "</td>";
        echo "<td>";
        echo "&nbsp;".JOO_HEADER1."&nbsp;&nbsp;&nbsp;";
        echo "</td>";

        if ( $bInputFields == 1) { // errorhandling
            echo "<td class=\"marketplace_header\" id=\"writead_header3\">";
            echo "&nbsp;";
            echo "</td>";
            echo "<td>";
            echo "&nbsp;".JOO_HEADER3."&nbsp;&nbsp;&nbsp;";
            echo "</td>";
        }

        echo "<td class=\"marketplace_header\" id=\"writead_header2\">";
        echo "&nbsp;";
        echo "</td>";
        echo "<td>";
        echo "&nbsp;".JOO_HEADER2."&nbsp;&nbsp;&nbsp;";
        echo "</td>";
        echo "</tr>";
        echo "</table>";


        echo "<br>";
        echo "<br>";



        if ( $bInputFields == 1) { // errorhandling
            $ad_name  		= $name;
            $ad_email 		= $email;
            $ad_headline 	= $ad_headline;
            $ad_text 		= $ad_text;
            //$ad_phone1 		= $phone1;
            $ad_type 		= $ad_type;
            $ad_category 	= $category;

        }

	?>


	<fieldset class="marketplace">

        <!-- titel -->
		<legend class="marketplace">
		<?php
		if( $isUpdateMode) {
		    echo JOO_AD_EDIT;
		}
		else {
		    echo JOO_AD_WRITE;
		}
		 ?>
		</legend>
        <!-- titel -->
      
        

    <!-- form -->
    <form class="marketplace" action="<?php echo $mosConfig_live_site;?>/index.php?option=com_marketplace&page=write_ad<?php echo "&Itemid=".$Itemid;?>" method="post" name="write_ad" enctype="multipart/form-data">

			<?php
			if ( $isUpdateMode != 1 && $bInputFields != 1) {
				// get user data and preset name and email field in form
				$database->setQuery("SELECT name, email FROM #__users WHERE id='$my->id' ");
				$dbu = $database->loadObjectList();

				$sDbName    = $dbu[0]->name;
				$sDbEmail   = $dbu[0]->email;
			}
    		?>    
    
			<br />
			<!-- name -->
				<label class="marketplace" for="name"><?php echo JOO_FORM_NAME; ?></label>
				<?php
				if ( $isUpdateMode == 1 || $bInputFields == 1) {
				    echo "<input class='".$afNameClass."' id='name' type='text' name='name' value='$ad_name' >";
				}
				else {					
				    echo "<input class='".$afNameClass."' id='name' type='text' name='name' value='$sDbName' >";
				}
				?>
				<label class="marketplace_right" for="name"><?php echo JOO_FORM_NAME_TEXT; ?></label>
			<!-- name -->


			<!-- surname -->
			<?php
			if ($use_surname) {
	        ?>
			<br />
				<label class="marketplace" for="surname"><?php echo JOO_FORM_SURNAME; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='surname' type='text' name='surname' value='$ad_surname'>";
				}
				else {
				    echo "<input class='marketplace' id='surname' type='text' name='surname'>";
				}
				?>
				<label class="marketplace_right" for="surname"><?php echo JOO_FORM_SURNAME_TEXT; ?></label>
	         <?php
			}
	         ?>
			<!-- surname -->


			<!-- street -->
			<?php
			if ($use_street) {
	        ?>
			<br />
				<label class="marketplace" for="street"><?php echo JOO_FORM_STREET; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='street' type='text' name='street' value='$ad_street'>";
				}
				else {
				    echo "<input class='marketplace' id='street' type='text' name='street'>";
				}
				?>
				<label class="marketplace_right" for="street"><?php echo JOO_FORM_STREET_TEXT; ?></label>
	         <?php
			}
	         ?>
			<!-- street -->


			<!-- zip -->
			<?php
			if ($use_zip) {
	        ?>
			<br />
				<label class="marketplace" for="zip"><?php echo JOO_FORM_ZIP; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='zip' type='text' name='zip' maxlength='10' value='$ad_zip'>";
				}
				else {
				    echo "<input class='marketplace' id='zip' type='text' name='zip' maxlength='10'>";
				}
				?>
				<label class="marketplace_right" for="zip"><?php echo JOO_FORM_ZIP_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- zip -->


			<!-- city -->
			<?php
			if ($use_city) {
	        ?>
			<br />
				<label class="marketplace" for="city"><?php echo JOO_FORM_CITY; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='city' type='text' name='city' value='$ad_city'>";
				}
				else {
				    echo "<input class='marketplace' id='city' type='text' name='city'>";
				}
				?>
				<label class="marketplace_right" for="city"><?php echo JOO_FORM_CITY_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- city -->


			<!-- state -->
			<?php
			if ($use_state) {
	        ?>
			<br />
				<label class="marketplace" for="state"><?php echo JOO_FORM_STATE; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='state' type='text' name='state' value='$ad_state'>";
				}
				else {
				    echo "<input class='marketplace' id='state' type='text' name='state'>";
				}
				?>
				<label class="marketplace_right" for="state"><?php echo JOO_FORM_STATE_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- state -->


			<!-- country -->
			<?php
			if ($use_country) {
	        ?>
			<br />
				<label class="marketplace" for="country"><?php echo JOO_FORM_COUNTRY; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='country' type='text' name='country' value='$ad_country'>";
				}
				else {
				    echo "<input class='marketplace' id='country' type='text' name='country'>";
				}
				?>
				<label class="marketplace_right" for="country"><?php echo JOO_FORM_COUNTRY_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- country -->



			<br />
			<!-- email -->
				<label class="marketplace" for="email"><?php echo JOO_FORM_EMAIL; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='".$afEmailClass."' id='email' type='text' name='email' maxlength='50' value='$ad_email'>";
				}
				else {
				    echo "<input class='".$afEmailClass."' id='email' type='text' name='email' maxlength='50' value='$sDbEmail' >";
				}
				?>
				<label class="marketplace_right" for="email"><?php echo JOO_FORM_EMAIL_TEXT; ?></label>
			<!-- email -->


			<!-- Web -->
			<?php
			if ($use_web) {
	        ?>
			<br />
				<label class="marketplace" for="web"><?php echo JOO_FORM_WEB; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='web' type='text' name='web' value='$ad_web'>";
				}
				else {
				    echo "<input class='marketplace' id='web' type='text' name='web'>";
				}
				?>
				<label class="marketplace_right" for="web"><?php echo JOO_FORM_WEB_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- Web -->


			<!-- phone1 -->
			<?php
			if ($use_phone1) {
	        ?>
			<br />
				<label class="marketplace" for="phone1"><?php echo JOO_FORM_PHONE1; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='phone1' type='text' name='phone1' maxlength='50' value='$ad_phone1'>";
				}
				else {
				    echo "<input class='marketplace' id='phone1' type='text' name='phone1' maxlength='50'>";
				}
				?>
				<label class="marketplace_right" for="phone1"><?php echo JOO_FORM_PHONE1_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- phone1 -->


			<!-- phone2 -->
			<?php
			if ($use_phone2) {
	        ?>
			<br />
				<label class="marketplace" for="phone2"><?php echo JOO_FORM_PHONE2; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='phone2' type='text' name='phone2' maxlength='50' value='$ad_phone2'>";
				}
				else {
				    echo "<input class='marketplace' id='phone2' type='text' name='phone2' maxlength='50'>";
				}
				?>
				<label class="marketplace_right" for="phone2"><?php echo JOO_FORM_PHONE2_TEXT; ?></label>
	         <?php
			}
	         ?>
			 <!-- phone2 -->


			<br />
			<br />
			<br />
			<!-- category -->
				<label class="marketplace" for="ad_type"><?php echo JOO_FORM_CATEGORY; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {

                    // get ad types
                    $database->setQuery("SELECT id, name FROM #__marketplace_types WHERE published='1' ORDER BY sort_order");
                    $rows_type = $database->loadObjectList();

                    echo "<select class='marketplace' id='ad_type' name='ad_type'>";
                        foreach( $rows_type as $rowtype) {
                            if( $rowtype->id == $ad_type) {
                                echo "<option value='$rowtype->id' selected>$rowtype->name</option>";
                            }
                            else {
                                echo "<option value='$rowtype->id'>$rowtype->name</option>";
                            }
                        }
		            echo "</select>";

				    $database->setQuery("SELECT id, name FROM #__marketplace_categories WHERE has_entries > 0 ORDER BY sort_order");
				    $rows = $database->loadObjectList();

				    echo "<select class='marketplace' name='category'>";

				    foreach($rows as $row) {
				        if ( $row->id == $ad_category) {
				            echo "<option value='".$row->id."' selected>".$row->name;
				        }
				        else {
				            echo "<option value='".$row->id."'>".$row->name;
				        }
				    }

				    echo "</select>";

				} // isUpdateMode (insert)
				else {

                    // get ad types
                    $database->setQuery("SELECT id, name FROM #__marketplace_types WHERE published='1' ORDER BY sort_order");
                    $rows_type = $database->loadObjectList();

                    echo "<select class='marketplace' id='ad_type' name='ad_type'>";
                        foreach( $rows_type as $rowtype) {
                            echo "<option value='$rowtype->id'>$rowtype->name</option>";
                        }
		            echo "</select>";

				    echo "&nbsp;&nbsp;&nbsp;";

				    $database->setQuery("SELECT id, name FROM #__marketplace_categories WHERE published='1' AND has_entries>'0' ORDER BY sort_order");
				    $rows = $database->loadObjectList();

				    echo "<select class='marketplace' name='category'>";

				    $afCounter=0;
				    foreach($rows as $row) {
				        if ( $afCounter==0) {
				            echo "<option value='".$row->id."' selected>".$row->name;
				        }
				        else {
				            echo "<option value='".$row->id."'>".$row->name;
				        }
				        $afCounter++;
				    }

				    echo "</select>";

				}
				?>
			<!-- category -->


			<br />
			<br />


			<!-- ad headline -->
				<label class="marketplace" for="ad_headline"><?php echo JOO_FORM_AD_HEADLINE; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='".$afHeadlineClass."' id='ad_headline' type='text' name='ad_headline' maxlength='80' value='".htmlspecialchars($ad_headline, ENT_QUOTES)."'>";
				}
				else {
				    echo "<input class='".$afHeadlineClass."' id='ad_headline' type='text' name='ad_headline' maxlength='80'>";
				}
				?>
				<label class="marketplace_right" for="ad_headline_text"><?php echo JOO_FORM_AD_HEADLINE_TEXT; ?></label>
			<!-- ad headline -->



			<br />
			<!-- ad text -->
				<label class="marketplace" for="ad_text"><?php echo JOO_FORM_AD_TEXT; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<textarea class='".$afTextClass."' id='ad_text' name='ad_text' cols='60' rows='10' wrap='VIRTUAL'>$ad_text</textarea>";
				}
				else {
				    echo "<textarea class='".$afTextClass."' id='ad_text' name='ad_text' cols='60' rows='10' wrap='VIRTUAL'></textarea>";
				}
				?>
			<!-- ad text -->


			<!-- condition -->
			<?php
			if ($use_condition) {
	        ?>
			<br />
				<label class="marketplace" for="ad_condition"><?php echo JOO_FORM_CONDITION; ?></label>
				<?php
				if ($isUpdateMode || $bInputFields == 1) {
				    echo "<input class='marketplace' id='ad_condition' type='text' name='ad_condition' maxlength='50' value='$ad_condition'>";
				}
				else {
				    echo "<input class='marketplace' id='ad_condition' type='text' name='ad_condition' maxlength='50'>";
				}
				?>
				<label class="marketplace_right" for="condition_text"><?php echo JOO_FORM_CONDITION_TEXT; ?></label>
	         <?php
			}
	         ?>
			<!-- condition -->


			<br />
			<!-- price -->
				<label class="marketplace" for="ad_price"><?php echo JOO_FORM_AD_PRICE; ?></label>
				<?php
				if ($isUpdateMode) {
				    echo "<input class='marketplace' id='ad_price' type='text' name='ad_price' size='10' maxlength='10' value='$ad_price'>";
				}
				else {
				    echo "<input class='marketplace' id='ad_price' type='text' name='ad_price' size='10' maxlength='10'>";
				}
				?>
				<label class="marketplace_right" for="ad_price_text"><?php echo JOO_FORM_AD_PRICE_TEXT; ?></label>
			<!-- price -->



			<br />
			<br />
			<br />
			<label class="marketplace" for="ad_image_text1"> </label>
			<label class="marketplace_center" for="ad_image_text2"><?php echo JOO_FORM_AD_IMAGE_TEXT; ?></label>
			<br />
			<br />


			<!-- image1 -->
				<label class="marketplace" for="ad_picture1"><?php echo JOO_FORM_AD_PICTURE1; ?></label>
                <input class="marketplace" id="ad_picture1" type="file" name="ad_picture1">
				<?php
				if ($isUpdateMode) {
				    $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.jpg";
				    $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.png";
				    $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.gif";

				    if ( file_exists( $a_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image1' value='delete'>".JOO_AD_DELETE_IMAGE;
				    }
				    else {
				        if ( file_exists( $a_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image1' value='delete'>".JOO_AD_DELETE_IMAGE;
				        }
				        else {
				            if ( file_exists( $a_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image1' value='delete'>".JOO_AD_DELETE_IMAGE;
				            }
				        }
				    }
				}
				?>
			<!-- image1 -->

			<br />
			<br />
			<!-- image2 -->
				<label class="marketplace" for="ad_picture2"><?php echo JOO_FORM_AD_PICTURE2; ?></label>
                <input class="marketplace" id="ad_picture2" type="file" name="ad_picture2">
				<?php
				if ($isUpdateMode) {
				    $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.jpg";
				    $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.png";
				    $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.gif";

				    if ( file_exists( $b_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image2' value='delete'>".JOO_AD_DELETE_IMAGE;
				    }
				    else {
				        if ( file_exists( $b_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image2' value='delete'>".JOO_AD_DELETE_IMAGE;
				        }
				        else {
				            if ( file_exists( $b_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image2' value='delete'>".JOO_AD_DELETE_IMAGE;
				            }
				        }
				    }
				}
				?>
			<!-- image2 -->

			<br />
			<br />
			<!-- image3 -->
				<label class="marketplace" for="ad_picture3"><?php echo JOO_FORM_AD_PICTURE3; ?></label>
                <input class="marketplace" id="ad_picture3" type="file" name="ad_picture3">
				<?php
				if ($isUpdateMode) {
				    $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.jpg";
				    $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.png";
				    $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.gif";

				    if ( file_exists( $c_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image3' value='delete'>".JOO_AD_DELETE_IMAGE;
				    }
				    else {
				        if ( file_exists( $c_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image3' value='delete'>".JOO_AD_DELETE_IMAGE;
				        }
				        else {
				            if ( file_exists( $c_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image3' value='delete'>".JOO_AD_DELETE_IMAGE;
				            }
				        }
				    }
				}
				?>
			<!-- image3 -->



			<br />
			<br />
			<!-- buttons -->
				<label class="marketplace" for="ad_dummy"> </label>
				<input type="hidden" name="gflag" value="0">
				<?php
				echo "<input type='hidden' name='isUpdateMode' value='$isUpdateMode'>";
				echo "<input type='hidden' name='adid' value='$adid'>";
				echo "<input type='hidden' name='userid' value='$userid'>";
				echo "<input type='hidden' name='username' value='$username'>";
				echo "<input type='hidden' name='mode' value='db'>";
				?>
				<input class="button" type="submit" name="submit" value=<?php echo JOO_FORM_SUBMIT_TEXT; ?>>
			<!-- buttons -->


		  </form>
		  <!-- form -->

		  <br />
		  <br />

	</fieldset>

		<?php
    }

}


echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";


// -------------------------------------------------------------------------------
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='small' align='center'>";
include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
echo "</td>";
echo "</tr>";


echo "</table>";

?>

