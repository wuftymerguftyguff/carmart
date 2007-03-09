<?php
/**
 * show_ad.php
 *
 * Displays the single ad and its details
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

<script language="JavaScript">
<!--
function jooImage(pic,w,h) {
    var win;
    var parms;

    w=w+20;
    h=h+30;

    parms="width="+w+",height="+h+",screenX=50,screenY=50,resizeable=yes,locationbar=no,status=no,menubar=no";
    win=window.open( pic, "imagePopup", parms);
}

-->
</script>



<?php
global $database;

$Itemid  = intval( mosGetParam( $_REQUEST, 'Itemid', '0' ) );
$catid   = intval( mosGetParam( $_REQUEST, 'catid', '0' ) );
$adid    = intval( mosGetParam( $_REQUEST, 'adid', '0' ) );


// set page title
if ( $catid > 0) {
        // get category-name: #__marketplace_category
        $database->setQuery( "SELECT name FROM #__marketplace_categories WHERE published='1' AND id=$catid");
        $tcatname = $database->loadResult();

        $database->setQuery( "SELECT ad_headline FROM #__marketplace_ads WHERE published='1' AND id=$adid");
        $tadsubject = $database->loadResult();

        $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_CATEGORY." - ".$tcatname." - ".$tadsubject );
}
else {
        $mainframe->SetPageTitle( JOO_TITLE." - " .JOO_MY_ADS." - ".$tadsubject );
}




$database->setQuery( "SELECT ad_contact_registered_only FROM #__marketplace_config");
$ad_contact_registered_only = $database->loadResult();

// get configuration data
$database->setQuery("SELECT * FROM #__marketplace_config LIMIT 1");
$config = $database->loadObjectList();

$use_surname    = $config[0]->use_surname;
$use_street     = $config[0]->use_street;
$use_zip        = $config[0]->use_zip;
$use_city       = $config[0]->use_city;
$use_state      = $config[0]->use_state;
$use_country    = $config[0]->use_country;
$use_web        = $config[0]->use_web;
$use_phone1     = $config[0]->use_phone1;
$use_phone2     = $config[0]->use_phone2;
$use_condition  = $config[0]->use_condition;

$use_primezilla             = $config[0]->use_primezilla;
$use_primezillaforcontact   = $config[0]->use_primezillaforcontact;



echo "<table width='100%' border='0'>";
echo "<tr>";
echo "<td align='left'>";

include($mosConfig_absolute_path.'/components/com_marketplace/topmenu.php');

include($mosConfig_absolute_path.'/components/com_marketplace/recent5.php');

echo "<br>";
echo "<br>";


//$username=strtolower($my->username);
$userid=$my->id;


// get category-name: #__marketplace_category
if ( $catid > 0) {
    // get category-name: #__marketplace_category
    $database->setQuery("SELECT name, description, image FROM #__marketplace_categories WHERE published='1' AND id=$catid");
    $rows_categories = $database->loadObjectList();

    $cat_name 		 = $rows_categories[0]->name;
    $cat_description = $rows_categories[0]->description;
    $cat_image 		 = $rows_categories[0]->image;
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
echo "<br>";
echo "<br>";



// build ad-page: marketplace_ads

$database->setQuery("SELECT id, userid, user, name, surname, street, zip, city, state, country, phone1, phone2, email, web, ad_type, ad_headline, ad_text, ad_condition, ad_price, ad_image, date_format(date_created, '%d.%m.%Y' ) as date_cr, flag_featured, flag_top, flag_commercial FROM #__marketplace_ads WHERE id=$adid");

$rows = $database->loadObjectList();

$ad_id    		    = $rows[0]->id;
$ad_userid		    = $rows[0]->userid;
$ad_user     	    = $rows[0]->user;
$ad_name     	    = $rows[0]->name;
$ad_surname    	    = $rows[0]->surname;
$ad_street 		    = $rows[0]->street;
$ad_zip 		    = $rows[0]->zip;
$ad_city 		    = $rows[0]->city;
$ad_state 	        = $rows[0]->state;
$ad_country 	    = $rows[0]->country;
$ad_phone1 		    = $rows[0]->phone1;
$ad_phone2 		    = $rows[0]->phone2;
$ad_email 		    = $rows[0]->email;
$ad_web 		    = $rows[0]->web;
$ad_type 	        = $rows[0]->ad_type;
$ad_headline 	    = $rows[0]->ad_headline;
$ad_text 		    = $rows[0]->ad_text;
$ad_text 		    = nl2br($ad_text);
$ad_condition 	    = $rows[0]->ad_condition;
$ad_price 		    = $rows[0]->ad_price;
$ad_image 		    = $rows[0]->ad_image;
$date_created	    = $rows[0]->date_cr;
$flag_featured      = $rows[0]->flag_featured;
$flag_top           = $rows[0]->flag_top;
$flag_commercial    = $rows[0]->flag_commercial;


// get ad type from db
$database->setQuery( "SELECT name FROM #__marketplace_types WHERE id='$ad_type'");
$sAdType = $database->loadResult();



echo "<br />";


echo "<table class=\"jooTable\" cellspacing='1'>";

    echo "<tr>";

        echo "<th width='20%' style='text-align: center;'>";
            echo "<b>".$sAdType."</b>";
        echo "</th>";

        echo "<th width='15%' style='text-align: center;'>";
            if ( $flag_commercial) {
                    echo "<b>".JOO_COMMERCIAL."</b>";
            }
            else {
                    echo "<b>".JOO_PRIVATE."</b>";
            }
        echo "</th>";

        echo "<th width='15%' style='text-align: center;'>";
            echo "Id: <b>".$ad_id."</b>";
        echo "</th>";

        echo "<th width='20%' style='text-align: center;'>";
            echo $date_created;
        echo "</th>";

        echo "<th width='30%' style='text-align: center;'>";

                        echo "<center>";
							echo "<table border='0' cellspacing='0' cellpadding='0'>";
								echo "<tr>";

									echo "<td align='left' valign='center' style='font-weight: bold;'>";
										echo JOO_FROM."&nbsp;";
									echo "</td>";

									echo "<td align='left' valign='center' style='font-weight: bold;'>";
										echo $ad_user."&nbsp;&nbsp;";
									echo "</td>";

									if ( $my->id > 0 && $use_primezilla == true) {  // logged in and primezilla=true

                                        $sAltTag = JOO_PM_SEND_TO." ";
                                        $sSubject = JOO_PM_SUBJECT_PREFIX.$ad_headline;

                                        $database->setQuery( "SELECT id FROM #__menu WHERE link LIKE '%com_primezilla%' AND published='1' ");
                                        $pzItemid = $database->loadResult();
                                        if ( strlen( $pzItemid) > 0 ) {
                                            $pzItemidLink = "&amp;Itemid=".$pzItemid;
                                        }
                                        else {
                                            $pzItemidLink = "";
                                        }

									   echo "<td align='left' valign='center' >";
									       // call to primezilla private messaging
									       $linkPrimezilla = sefRelToAbs( "index.php?option=com_primezilla&amp;page=write&amp;uname=".$ad_user."&amp;subject=".$sSubject.$pzItemidLink);
										   echo " <a href='".$linkPrimezilla."'>";
										   echo "<img src='".$mosConfig_live_site."/components/com_primezilla/images/messagenew.gif' align='center' border='0' alt='$sAltTag $ad_user' title='$sAltTag $ad_user' >";
										   echo "</a>";
									   echo "</td>";
									}

								echo "</tr>";
							echo "</table>";
                        echo "</center>";

        echo "</th>";

    echo "</tr>";



    if ( $flag_commercial) {
        $sClassId = "class=\"jooCommercial\" id=\"jooAdHeader\"";
    }
    else {
        if( $flag_featured) {
            $sClassId = "class=\"jooFeatured\" id=\"jooAdHeader\"";
        }
        else {
            $sClassId = "class=\"jooNormal\" id=\"jooAdHeader\"";
        }
    }

    echo "<tr>";
        echo "<td colspan='5' ".$sClassId." >";
            echo  htmlspecialchars ($ad_headline);
        echo "</td>";
    echo "</tr>";



    echo "<tr>";
        echo "<td width='70%' colspan='4' class='jooNormal' id='jooAdText'>";
            echo $ad_text;
        echo "</td>";
        echo "<td width='30%' rowspan='3' class='jooNormal' id='jooAdImage'>";
            if ( $ad_image > 0) {
                echo "<font size='-2'>";
                echo JOO_CLICKONIMAGE;
                echo "</font>";
                echo "<br>";
                echo "<br>";

                $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.jpg";
                $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.png";
                $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a_t.gif";

                $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.jpg";
                $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.png";
                $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b_t.gif";

                $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.jpg";
                $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.png";
                $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c_t.gif";

                if ( file_exists( $a_pic_jpg)) {
                    $a_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a.jpg";
                    $a_img = ImageCreateFromJpeg( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a.jpg");
                    $a_img_width  = ImageSx( $a_img);
                    $a_img_height = ImageSy( $a_img);
                    echo "<a href=javascript:jooImage('$a_piclink',$a_img_width,$a_img_height);>";
                    echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.jpg' align='center' border='0'>";
                    echo "</a>";
                    echo "<br>";
                    echo "<br>";
                }
                else {
                    if ( file_exists( $a_pic_png)) {
                        $a_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a.png";
                        $a_img = ImageCreateFromPng( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a.png");
                        $a_img_width  = ImageSx( $a_img);
                        $a_img_height = ImageSy( $a_img);
                        echo "<a href=javascript:jooImage('$a_piclink',$a_img_width,$a_img_height);>";
                        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.png' align='center' border='0'>";
                        echo "</a>";
                        echo "<br>";
                        echo "<br>";
                    }
                    else {
                        if ( file_exists( $a_pic_gif)) {
                            $a_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a.gif";
                            $a_img = ImageCreateFromGif( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."a.gif");
                            $a_img_width  = ImageSx( $a_img);
                            $a_img_height = ImageSy( $a_img);
                            echo "<a href=javascript:jooImage('$a_piclink',$a_img_width,$a_img_height);>";
                            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."a_t.gif' align='center' border='0'>";
                            echo "</a>";
                            echo "<br>";
                            echo "<br>";
                        }
                    }
                }

                if ( file_exists( $b_pic_jpg)) {
                    $b_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b.jpg";
                    $b_img = ImageCreateFromJpeg( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b.jpg");
                    $b_img_width  = ImageSx( $b_img);
                    $b_img_height = ImageSy( $b_img);
                    echo "<a href=javascript:jooImage('$b_piclink',$b_img_width,$b_img_height);>";
                    echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.jpg' align='center' border='0'>";
                    echo "</a>";
                    echo "<br>";
                    echo "<br>";
                }
                else {
                    if ( file_exists( $b_pic_png)) {
                        $b_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b.png";
                        $b_img = ImageCreateFromPng( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b.png");
                        $b_img_width  = ImageSx( $b_img);
                        $b_img_height = ImageSy( $b_img);
                        echo "<a href=javascript:jooImage('$b_piclink',$b_img_width,$b_img_height);>";
                        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.png' align='center' border='0'>";
                        echo "</a>";
                        echo "<br>";
                        echo "<br>";
                    }
                    else {
                        if ( file_exists( $b_pic_gif)) {
                            $b_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b.gif";
                            $b_img = ImageCreateFromGif( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."b.gif");
                            $b_img_width  = ImageSx( $b_img);
                            $b_img_height = ImageSy( $b_img);
                            echo "<a href=javascript:jooImage('$b_piclink',$b_img_width,$b_img_height);>";
                            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."b_t.gif' align='center' border='0'>";
                            echo "</a>";
                            echo "<br>";
                            echo "<br>";
                        }
                    }
                }

                if ( file_exists( $c_pic_jpg)) {
                    $c_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c.jpg";
                    $c_img = ImageCreateFromJpeg( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c.jpg");
                    $c_img_width  = ImageSx( $c_img);
                    $c_img_height = ImageSy( $c_img);
                    echo "<a href=javascript:jooImage('$c_piclink',$c_img_width,$c_img_height);>";
                    echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.jpg' align='center' border='0'>";
                    echo "</a>";
                    echo "<br>";
                    echo "<br>";
                }
                else {
                    if ( file_exists( $c_pic_png)) {
                        $c_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c.png";
                        $c_img = ImageCreateFromPng( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c.png");
                        $c_img_width  = ImageSx( $c_img);
                        $c_img_height = ImageSy( $c_img);
                        echo "<a href=javascript:jooImage('$c_piclink',$c_img_width,$c_img_height);>";
                        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.png' align='center' border='0'>";
                        echo "</a>";
                        echo "<br>";
                        echo "<br>";
                    }
                    else {
                        if ( file_exists( $c_pic_gif)) {
                        $c_piclink 	= $mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c.gif";
                        $c_img = ImageCreateFromGif( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad_id."c.gif");
                        $c_img_width  = ImageSx( $c_img);
                        $c_img_height = ImageSy( $c_img);
                        echo "<a href=javascript:jooImage('$c_piclink',$c_img_width,$c_img_height);>";
                        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$ad_id."c_t.gif' align='center' border='0'>";
                        echo "</a>";
                        echo "<br>";
                        echo "<br>";
                    }
                }
            }


        } // if image > 0
        else {
            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/system/nopic.gif' align='center' border='0'>";
        }

        echo "</td>";
    echo "</tr>";


    echo "<tr>";
        echo "<td colspan='4' class='jooNormal' id='jooAdInfo' >";
            if ($use_condition) {
                echo "<b>";
                echo JOO_FORM_CONDITION.": ".$ad_condition;
                echo "</b>";
                echo "<br />";
                echo "<br />";
            }

            echo "<b>";
            echo JOO_PRICE.": ".$ad_price;
            echo "</b>";
        echo "</td>";
    echo "</tr>";


    echo "<tr>";
        echo "<td colspan='4' class='jooNormal' id='jooAdInfo' >";
            echo "<b>";
            echo JOO_CONTACT.": ";
            echo "</b>";

            echo "<br />";
            if ($use_surname) {
                echo $ad_surname." ";
            }
            echo $ad_name;
            echo "<br />";

            if ($use_street) {
                echo $ad_street;
                echo "<br />";
            }

            if ($use_zip) {
                echo $ad_zip." ";
            }
            if ($use_city) {
                echo $ad_city;
                echo "<br />";
            }

            if ($use_state) {
                echo $ad_state;
                echo "<br />";
            }

            if ($use_country) {
                echo $ad_country;
                echo "<br />";
            }

            echo "<br />";

            if ( $use_primezillaforcontact == true) {  // logged in and primezillaforcontact=true

			     if ( $my->id > 0 && $use_primezilla == true) {  // logged in and primezilla=true
			        echo "<table>";
					   echo "<tr>";
				        echo "<td align='left' valign='center' >";
					       // call to primezilla private messaging
						   $linkPrimezilla = sefRelToAbs( "index.php?option=com_primezilla&amp;page=write&amp;uname=".$ad_user."&amp;subject=".$sSubject.$pzItemidLink);
						   echo " <a href='".$linkPrimezilla."'>";
					       echo "<img src='".$mosConfig_live_site."/components/com_primezilla/images/messagenew.gif' align='center' border='0' alt='$sAltTag $ad_user' title='$sAltTag $ad_user' >";
					       echo "</a>";
					   echo "</td>";
				       echo "<td align='left' valign='center' >";
					       // call to primezilla private messaging
						   echo " <a href='".$linkPrimezilla."'>";
					       echo "&nbsp;".JOO_PM_SEND_TO." ".$ad_user;
					       echo "</a>";
					   echo "</td>";


					   echo "</tr>";
			        echo "</table>";
				 }
				 else {
					   echo JOO_PM_LOGIN." ".$ad_user;
                       echo "<br />";
				 }


            }
            else {

                if ( $ad_contact_registered_only==1 && $my->id==0) {
                    echo JOO_CONTACT_DETAILS;
                    echo "<br />";
                }
                else {
                    if ($use_phone1) {
                        echo JOO_FORM_PHONE1.": ".$ad_phone1;
                        echo "<br />";
                    }
                    if ($use_phone2) {
                        echo JOO_FORM_PHONE2.": ".$ad_phone2;
                        echo "<br />";
                    }
                    if ( strlen($ad_phone1) > 3 || strlen($ad_phone2) > 3) {
                        echo "<br />";
                    }


                    echo "<table border='0' cellpadding='5' cellspacing='0'>";
                        echo "<tr>";
                            echo "<td>";
                                echo JOO_FORM_EMAIL.": ";
                            echo "</td>";
                            echo "<td>";
                                echo "&nbsp;<a href='mailto:".$ad_email."'>".$ad_email."</a>";
                            echo "</td>";
                        echo "<tr>";

                        if ($use_web) {
                            echo "<tr>";
                                echo "<td>";
                                    echo JOO_FORM_WEB.": ";
                                echo "</td>";
                                echo "<td>";
                                    echo "&nbsp;<a href='http://".str_replace("http://", "", $ad_web)."' target='_blank'>".str_replace("http://", "", $ad_web)."</a>";
                                echo "</td>";
                            echo "</tr>";
                        }

                    echo "</table>";

                }
            }

            echo "</td>";
        echo "</tr>";


// start user/admin-Toolbar
$database->setQuery( "SELECT admin_userid FROM #__marketplace_config");
$admin_userid = $database->loadResult();

switch ($userid) {

  case $admin_userid:
  case $ad_userid: {

        echo "<tr>";
            echo "<td colspan='5' class='jooNormal' id='jooAdToolbar' >";

    $linkEditAd    = sefRelToAbs( "index.php?option=com_marketplace&amp;page=write_ad&amp;adid=".$ad_id."&amp;Itemid=".$Itemid);
    $linkDeleteAd  = sefRelToAbs( "index.php?option=com_marketplace&amp;page=delete_ad&amp;adid=".$ad_id."&amp;Itemid=".$Itemid);

    ?>

    <table width="50%" cellspacing="0">
    <tr>

       <?php
       echo "<td valign=\"center\">";
           echo "<a href=".$linkEditAd.">";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/editad.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_AD_EDIT;
             echo "</span>";

           echo "</a>";
       echo "</td>";

       echo "<td valign=\"center\">";
           echo "<a href=".$linkDeleteAd.">";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/deletead.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_AD_DELETE;
             echo "</span>";

           echo "</a>";
       echo "</td>";

    echo "</tr>";
    echo "</table>";


    break;
  }

            echo "</td>";
        echo "</tr>";

}
// end user/admin-toolbar




    echo "</table>";







// increment views. views from ad author are not counted to prevent highclicking views of own ad
if ( $userid <> $ad_userid) {
    $sql = "UPDATE #__marketplace_ads SET views = LAST_INSERT_ID(views+1) WHERE id = $adid";
    $database->setQuery( $sql);

    if ($database->getErrorNum()) {
        echo $database->stderr();
    } else {
        $database->query();
    }
}


// -------------------------------------------------------------------------------
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