<?php
/**
 * show_category.php
 *
 * Displays the selected category as a listing with thumbnails of ad images
 *
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

$Itemid     	= intval( mosGetParam( $_REQUEST, 'Itemid', '0' ) );
$catid      	= intval( mosGetParam( $_REQUEST, 'catid', '0' ) );

$nn         	= intval( mosGetParam( $_REQUEST, 'nn', '0' ) );

$ad_type        = intval( mosGetParam( $_REQUEST, 'ad_type', '0' ) );

$searchtext     = strval( mosGetParam( $_REQUEST, 'searchtext', '' ) );


// set page title
if ( $catid > 0) {
        // get category-name: #__marketplace_category
        $database->setQuery( "SELECT name FROM #__marketplace_categories WHERE published='1' AND id=$catid");
        $tcatname = $database->loadResult();

        $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_CATEGORY." - ".$tcatname );
}
else {
        $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_MY_ADS );
}



// get language for marketplace
if(file_exists($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php')) {
  require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php');
}
else {
  require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/english.php');
}



echo "<table width='100%'>";
echo "<tr>";
echo "<td align='left'>";

include($mosConfig_absolute_path.'/components/com_marketplace/topmenu.php');


$username=$my->username;
$userid=$my->id;

if ( $catid == "0" && $userid == "0") {
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
    echo JOO_MY_ADS_NOTALLOWED;
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

    include($mosConfig_absolute_path.'/components/com_marketplace/recent5.php');

    echo "<br>";
    echo "<br>";


    if ( $catid > 0) {
        // get category-name: #__marketplace_category
        $database->setQuery("SELECT name, description, image FROM #__marketplace_categories WHERE published='1' AND id=$catid");
        $rows_categories = $database->loadObjectList();

        $cat_name 		= $rows_categories[0]->name;
        $cat_description  = $rows_categories[0]->description;
        $cat_image 		= $rows_categories[0]->image;
    }
    else { // catid=0 -> my ads
        $cat_name 			= JOO_MY_ADS;
        $cat_description 	= JOO_MY_ADS_TEXT;
        $cat_image 			= "default.gif";
    }

    $linkTarget = sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_category&amp;catid=".$catid."&amp;Itemid=".$Itemid);


    echo "<table width='100%' border='0'>";
        echo "<tr>";

            echo "<td align='center' valign='top' width='20'>";
                echo "<a href=".$linkTarget.">";
                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/categories/".$cat_image."' align='center' border='0'>";
                echo "</a>";
            echo "</td>";

            echo "<td width='5' align='left' valign='center'>";
                echo "&nbsp;";
            echo "</td>";

            echo "<td align='left' valign='center'>";
                echo "<b>";
                echo "<a href=".$linkTarget.">";
                echo $cat_name;
                echo "</a>";
                echo "</b>";
                echo "<font size='-2'>";
                echo "<br>".$cat_description;
                echo "</font>";
            echo "</td>";

        echo "</tr>";
    echo "</table>";


    if (!isset( $ad_type)) {
        $ad_type = "0";
    }


    // cut whitespaces from searchtext
    $searchtext = trim( $searchtext);


    echo "<br />";
    echo "<table id=\"select_table\" border=\"0\">";
    echo "<tr>";

    echo "<form class=\"marketplace\" action=\"".$mosConfig_live_site."/index.php?option=com_marketplace&page=show_category&catid=$catid&Itemid=$Itemid\" method=\"post\" name=\"adsearch\">";

      echo "<td width=\"100\">";
        echo "<input class='marketplace_search' id='searchtext' type='text' name='searchtext' value=\"".$searchtext."\">";
      echo "</td>";
      echo "<td width=\"100\">";
        echo "<input class='button' type='submit' name='submit_search' value=\"".JOO_FORM_SUBMIT_SEARCH_TEXT."\">";
      echo "</td>";

      echo "<input type='hidden' name='ad_type' value='$ad_type'>";
    echo "</form>";


      echo "<td>";
        echo "&nbsp;";
      echo "</td>";


    echo "<form class=\"marketplace\" action=\"".$mosConfig_live_site."/index.php?option=com_marketplace&page=show_category&catid=$catid&Itemid=$Itemid\" method=\"post\" name=\"adselect\">";
      echo "<td  width=\"100\">";

        // get ad types
        $database->setQuery("SELECT id, name FROM #__marketplace_types WHERE published='1' ORDER BY sort_order");
        $rows_type = $database->loadObjectList();

        echo "<select name='ad_type'>";
            echo "<option value='0' selected>".JOO_ALL."</option>";
            foreach( $rows_type as $rowtype) {
                if( $rowtype->id == $ad_type) {
                    echo "<option value='$rowtype->id' selected>$rowtype->name</option>";
                }
                else {
                    echo "<option value='$rowtype->id'>$rowtype->name</option>";
                }
            }
		echo "</select>";
      echo "</td>";
      echo "<td width=\"100\" align=\"right\">";
		echo " <input class='button' type='submit' name='submit_refresh' value=\"".JOO_FORM_SUBMIT_REFRESH_TEXT."\">";
      echo "</td>";

      echo "<input type='hidden' name='searchtext' value='$searchtext'>";
    echo "</form>";

    echo "</tr>";
    echo "</table>";
    echo "<br />";


    $database->setQuery( "SELECT ads_per_page FROM #__marketplace_config");
    $count = $database->loadResult();


    $limit = $count;
    $limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
    $pos = $limitstart;


    // count entries
    if($pos==0) {

        if ($catid > 0) { // "normal" ads

            if ($ad_type=="0") {
                if ( strlen( $searchtext) < 1) { // no search text
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE category=$catid AND published='1'");
                }
                else {
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE category=$catid AND published='1' AND
			   							       (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							           OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')");
                }
            }
            else {
                if ( strlen( $searchtext) < 1) { // no search text
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE category=$catid AND ad_type='$ad_type' AND published='1'");
                }
                else {
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE category=$catid AND ad_type='$ad_type' AND published='1' AND
			   							       (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							           OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')");
                }
            }

        }
        else {  // my ads

            if ($ad_type=="0") {
                if ( strlen( $searchtext) < 1) { // no search text
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE userid=$userid AND published='1'");
                }
                else {
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE userid=$userid AND published='1' AND
			   							       (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							           OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')");
                }
            }
            else {
                if ( strlen( $searchtext) < 1) { // no search text
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE userid=$userid AND ad_type='$ad_type' AND published='1'");
                }
                else {
                    $database->setQuery( "SELECT COUNT(*) FROM #__marketplace_ads WHERE userid=$userid AND ad_type='$ad_type' AND published='1' AND
			   							       (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							           OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')");
                }
            }

        }
        $total = $database->loadResult();
        if ($total <= $limit) {
                $limitstart = 0;
                $pos = 0;
        }
    }


    require_once("includes/pageNavigation.php");
    $pageNav = new mosPageNav( $total, $limitstart, $limit );


    if ($catid > 0) { // "normal" ads

        if ($ad_type=="0") {

          if ( strlen( $searchtext) < 1) { // no search text
            $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE category=$catid AND published='1'
			   							ORDER BY flag_top desc, id DESC
			   							LIMIT $pos, $count");
          }
          else { // search text entered
            $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE category=$catid AND published='1' AND
			   							   (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							       OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')
			   							ORDER BY flag_top desc, id DESC
			   							LIMIT $pos, $count");
          }



        }
        else {  // ad_type <> 0 (all)
          if ( strlen( $searchtext) < 1) { // no search text
            $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE category=$catid AND ad_type='$ad_type' AND published='1'
			   							ORDER BY flag_top desc, id DESC
			   							LIMIT $pos, $count");
          }
          else { // search text entered
            $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE category=$catid AND ad_type='$ad_type' AND published='1' AND
			   							   (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							       OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')
			   							ORDER BY flag_top desc, id DESC
			   							LIMIT $pos, $count");
          }
        }
    }
    else {  // my ads

        if ($ad_type=="0") {
            if ( strlen( $searchtext) < 1) { // no search text
                $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE userid=$userid
			   							ORDER BY id DESC
			   							LIMIT $pos, $count");
            }
            else {
                $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE userid=$userid AND
			   							   (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							       OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')
			   							ORDER BY id DESC
			   							LIMIT $pos, $count");
            }
        }
        else {
            if ( strlen( $searchtext) < 1) { // no search text
                $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE userid=$userid AND ad_type='$ad_type'
			   							ORDER BY id DESC
			   							LIMIT $pos, $count");
            }
            else {
                $database->setQuery("SELECT id, user, ad_type, ad_headline, ad_text, ad_image, ad_price,
				  								date_format(date_created, '%d.%m.%Y' ) as date_created, views,
				  								flag_featured, flag_top, flag_commercial
			   							FROM #__marketplace_ads
			   							WHERE userid=$userid AND ad_type='$ad_type' AND
			   							   (ad_headline LIKE '%$searchtext%' OR ad_text LIKE '%$searchtext%'
			   							       OR city LIKE '%$searchtext%' OR zip LIKE '%$searchtext%' OR country LIKE '%$searchtext%')
			   							ORDER BY id DESC
			   							LIMIT $pos, $count");

            }
        }

    }

    $rows = $database->loadObjectList();
    $nn = count($rows);


    echo "<br>";
    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
    echo "<tr>";
    echo "<td align='left'>";
    if ( $total > 0) {
        echo "&nbsp;".JOO_ENTRIES1." ".($pos+1)." ".JOO_ENTRIES2." ".($pos+$nn)." ".JOO_ENTRIES3." ".$total;
    }
    else {
        echo "&nbsp;".JOO_NOENTRIES;
    }
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br>";



    echo "<table class=\"jooTable\" cellpadding='0' cellspacing='1'>";

    echo "<tr>";
        echo "<th width='50%' style='text-align: left;'>".JOO_AD."</th>";
        echo "<th width='5%'  style='text-align: center;'>".JOO_VIEWS."</th>";
        echo "<th width='8%'  style='text-align: center;'>".JOO_PRICE."</th>";
        echo "<th width='7%'  style='text-align: center;'>".JOO_TYPE."</th>";
        echo "<th width='15%' style='text-align: center;'>".JOO_DATE."</th>";
    echo "</tr>";

    $boolTopStart = 1;
    $boolLastTop = 0;

    foreach($rows as $row) {

        $boolFeatured 	= $row->flag_featured;
        $boolTop 		= $row->flag_top;
        $boolCommercial	= $row->flag_commercial;

        // top-ad handling
        if ( $catid > 0) { // don't show when displaying "my ads"
            if ( $boolTop == 1) {
                if ( $boolTopStart == 1) {
                    echo "<tr>";
                        echo "<td id=\"jooTopTextTop\" colspan='5'>";
                            echo "<br />";
                            echo JOO_TOPAD;
                        echo "</td>";
                    echo "</tr>";
                }
                $boolLastTop = 1;
            }
            else {
                if ( $boolLastTop == 1) {
                    echo "<tr>";
                        echo "<td id='jooTopTextBottom' colspan='5'>";
                            echo JOO_TOPAD_TEXT;
                            echo "<br />";
                            echo "<br />";
                        echo "</td>";
                    echo "</tr>";
                }
                $boolLastTop = 0;
            }
        }


        $linkTarget = sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_ad&amp;catid=".$catid."&amp;adid=".$row->id."&amp;Itemid=".$Itemid);

        echo "<tr>";


            // first decide what kind of ad it is
            if ($boolCommercial == 1) { // commercial ad
              //echo "<div class='jooCommercial'>";
              $sDiv = "<div class='jooCommercial'>";
            }
            else { // private ad
                if ($boolFeatured == 1) { // featured ad
                    //echo "<div class='jooFeatured'>";
                    $sDiv = "<div class='jooFeatured'>";
                }
                else { // normal ad
                    //echo "<div class='jooNormal'>";
                    $sDiv = "<div class='jooNormal'>";
                }
            }
            echo "<td colspan='5'>";

            echo $sDiv;
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
            echo "<tr>";



        echo "<td width='50%' valign='top' align='left'>";


        echo "<table width='100%' border='0'>";
        echo "<tr>";
        echo "<td align='center' valign='top' width='100'>";
          echo "<center>";

        if ( $row->ad_image > 0) {

            $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."a_t.jpg";
            $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."a_t.png";
            $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."a_t.gif";

            $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."b_t.jpg";
            $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."b_t.png";
            $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."b_t.gif";

            $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."c_t.jpg";
            $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."c_t.png";
            $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$row->id."c_t.gif";


            $boolPicFound = 0;
            if ( file_exists( $a_pic_jpg)) {
                echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."a_t.jpg"."' align='center' border='0'></a>";
                $boolPicFound = 1;
            }
            else {
                if ( file_exists( $a_pic_png)) {
                    echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."a_t.png"."' align='center' border='0'></a>";
                    $boolPicFound = 1;
                }
                else {
                    if ( file_exists( $a_pic_gif)) {
                        echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."a_t.gif"."' align='center' border='0'></a>";
                        $boolPicFound = 1;
                    }
                }
            }


            if ( $boolPicFound == 0) {
                if ( file_exists( $b_pic_jpg)) {
                    echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."b_t.jpg"."' align='center' border='0'></a>";
                    $boolPicFound = 1;
                }
                else {
                    if ( file_exists( $b_pic_png)) {
                        echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."b_t.png"."' align='center' border='0'></a>";
                        $boolPicFound = 1;
                    }
                    else {
                        if ( file_exists( $b_pic_gif)) {
                            echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."b_t.gif"."' align='center' border='0'></a>";
                            $boolPicFound = 1;
                        }
                    }
                }
            }


            if ( $boolPicFound == 0) {
                if ( file_exists( $c_pic_jpg)) {
                    echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."c_t.jpg"."' align='center' border='0'></a>";
                }
                else {
                    if ( file_exists( $c_pic_png)) {
                        echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."c_t.png"."' align='center' border='0'></a>";
                    }
                    else {
                        if ( file_exists( $c_pic_gif)) {
                            echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$row->id."c_t.gif"."' align='center' border='0'></a>";
                        }
                    }
                }
            }

        }
        else {
            echo "<a href=".$linkTarget."><img src='".$mosConfig_live_site."/components/com_marketplace/images/system/nopic.gif' align='center' border='0'></a>";
        }

        echo "</center>";

        echo "</td>";

        echo "<td width='5' align='left' valign='center'>";
        echo "&nbsp;";
        echo "</td>";

        echo "<td align='left' valign='top'>";
        echo "<a href=".$linkTarget.">".$row->ad_headline."</a><br>";
        echo "<font size='-2'>";
        $af_text = htmlspecialchars (substr($row->ad_text, 0, 100)."...");
        echo $af_text;
        echo "</font>";
        echo "</td>";

        echo "</tr>";
        echo "</table>";


        echo "</td>";


        echo "<td width='5%' valign='center' style='text-align: center;'>";
                echo $row->views;
        echo "</td>";


        echo "<td width='8%' align='center' valign='center'>";
            echo "<center>";
                echo $row->ad_price;
            echo "</center>";
        echo "</td>";


        echo "<td width='7%' align='center' valign='center'>";
            // get ad type from db
            $database->setQuery( "SELECT name FROM #__marketplace_types WHERE id='$row->ad_type'");
            $sAdType = $database->loadResult();

            echo "<center>";
                echo "<div id='jooAdType$row->ad_type'>";
                    echo $sAdType;
                echo "</div>";
            echo "</center>";
        echo "</td>";


        echo "<td width='15%' valign='center'>";
            echo "<center>";
            echo $row->date_created;
            echo "<br />";
            echo "<font size='-2'>";
            echo JOO_FROM;
            echo "<b>".$row->user."</b>";
            echo "</font>";
            echo "</center>";
        echo "</td>";

echo "</tr>";
echo "</table>";
echo "</div>";

echo "</td>";


        echo "</tr>";  // tr loop

        $boolTopStart = 0;

    }

    echo "</table>";
    echo "<br />";



    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
    echo "<tr>";
    echo "<td align='left'>";
    if ( $total > 0) {
        echo "&nbsp;".JOO_ENTRIES1." ".($pos+1)." ".JOO_ENTRIES2." ".($pos+$nn)." ".JOO_ENTRIES3." ".$total;
    }
    else {
        echo "&nbsp;".JOO_NOENTRIES;
    }
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<br />";


    echo "<center>";
    	$pageNav->writePagesCounter();
    	if ( strlen( $searchtext) >= 1) {
    		echo $pageNav->writePagesLinks("index.php?option=com_marketplace&amp;page=show_category&amp;catid=$catid&amp;Itemid=$Itemid&amp;total=$total&amp;ad_type=$ad_type&amp;searchtext=$searchtext");
    	}
    	else {
    		echo $pageNav->writePagesLinks("index.php?option=com_marketplace&amp;page=show_category&amp;catid=$catid&amp;Itemid=$Itemid&amp;total=$total&amp;ad_type=$ad_type");
    	}
    echo "</center>";



}


echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='small' align='center'>";
echo "<br>";
echo "<br>";
include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
echo "</td>";
echo "</tr>";


echo "</table>";

?>