<?php
/**
 * show_index.php
 *
 * Displays the frontend main screen with all available categories
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

$Itemid       = intval( mosGetParam( $_REQUEST, 'Itemid', '0' ) );

$picext = array('gif', 'jpg', 'png');


// set page title
$mainframe->SetPageTitle( JOO_TITLE." - " .JOO_OVERVIEW );



// delete old ads(including images) once a day
$database->setQuery( "SELECT duration FROM #__marketplace_config");
$duration = $database->loadResult();

$database->setQuery( "SELECT date_deleted FROM #__marketplace_config");
$date_deleted = $database->loadResult();

$database->setQuery( "SELECT CURRENT_DATE()");
$date_current = $database->loadResult();

if ( $date_current > $date_deleted) {
    $sql = "SELECT id FROM #__marketplace_ads WHERE date_created < DATE_SUB( '$date_current', INTERVAL $duration DAY)";
    $database->setQuery( $sql);
    $rows = $database->loadObjectList();

    // delete all images from outdated ads
    foreach($rows as $row) {
        $adid = $row->id;
        for($extid = 0, $nbext = sizeof($picext) ; $extid < $nbext ; $extid++) {
            // image1 delete
            $a_pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a_t.".$picext[$extid];
            if ( file_exists( $a_pict)) {
                unlink( $a_pict);
            }
            $a_pic = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."a.".$picext[$extid];
            if ( file_exists( $a_pic)) {
                unlink( $a_pic);
            }
            // image2 delete
            $b_pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b_t.".$picext[$extid];
            if ( file_exists( $b_pict)) {
                unlink( $b_pict);
            }
            $b_pic = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."b.".$picext[$extid];
            if ( file_exists( $b_pic)) {
                unlink( $b_pic);
            }
            // image3 delete
            $c_pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c_t.".$picext[$extid];
            if ( file_exists( $c_pict)) {
                unlink( $c_pict);
            }
            $c_pic = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$adid."c.".$picext[$extid];
            if ( file_exists( $c_pic)) {
                unlink( $c_pic);
            }
        }
    }

    // now delete all outdated ads
    $sql = "DELETE FROM #__marketplace_ads WHERE date_created < DATE_SUB( '$date_current', INTERVAL $duration DAY)";

    $database->setQuery( $sql);

    if ($database->getErrorNum()) {
        echo $database->stderr();
    } else {
        $database->query();
    }

    // set delete marker on today
    $sql = "UPDATE #__marketplace_config SET date_deleted = CURRENT_DATE()";

    $database->setQuery( $sql);
    if ($database->getErrorNum()) {
        echo $database->stderr();
    } else {
        $database->query();
    }
}



echo "<table width='100%'>";
echo "<tr>";
echo "<td align='left'>";

include($mosConfig_absolute_path.'/components/com_marketplace/topmenu.php');

include($mosConfig_absolute_path.'/components/com_marketplace/recent5.php');


echo "<br>";
echo "<br>";


// build index-page: marketplace_categories
$database->setQuery("SELECT * FROM #__marketplace_categories WHERE published='1' ORDER BY sort_order");
$rows = $database->loadObjectList();


echo "<table class=\"jooTable\" cellspacing='1'>";

echo "<tr>";
    echo "<th width='65%'>".JOO_CATEGORY."</th>";
    echo "<th width='10%' style='text-align: center;'>".JOO_ENTRIES."</th>";
    echo "<th width='25%' style='text-align: center;'>".JOO_LASTENTRY."</th>";
echo "</tr>";


foreach($rows as $row) {
    if($row->has_entries == 0) {
        echo "<tr id=\"category_tablerow\">";
    }
    else {
        $linkTarget = sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_category&amp;catid=".$row->id."&amp;Itemid=".$Itemid);
        echo "<tr id=\"category_tablerow\">";
    }

    if($row->has_entries == 0) {
        echo "<td id='index_tablecell_noentries' valign='top' align='left' colspan='3'>";
    }
    else {
        echo "<td id='index_tablecell' valign='top' align='left'>";
    }

    if($row->has_entries == 0) {
        echo "<br>";
        echo "<table width='100%' border='0'>";
        echo "<tr>";
        echo "<td align='left' valign='center'>";
        echo "<b>".$row->name."</b><br>";
        echo "<font size='-2'>";
        echo $row->description;
        echo "</font>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
    else {
        echo "<table width='100%' border='0'>";
            echo "<tr>";

                echo "<td align='center' valign='top' width='20'>";
                    echo "<center>";
                      echo "<a href='$linkTarget'>";
                        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/categories/".$row->image."' align='center' border='0'>";
                      echo "</a>";
                    echo "</center>";
                echo "</td>";

                echo "<td width='5' align='left' valign='center'>";
                    echo "&nbsp;";
                echo "</td>";

                echo "<td align='left' valign='center'>";
                    echo "<a href='$linkTarget'>".$row->name."</a><br>";
                    echo "<font size='-2'>";
                    echo $row->description;
                    echo "</font>";
                echo "</td>";

            echo "</tr>";
        echo "</table>";
    }
    echo "</td>";

    if($row->has_entries > 0) {
        echo "<td id='index_tablecellcenter' valign='center' align='center'>";
        // number of entries
        $database->setQuery("SELECT COUNT(*) AS ad_count
                             				FROM #__marketplace_ads
                             				WHERE category='$row->id' AND published='1'");

        $rows_ads = $database->loadObjectList();

        foreach($rows_ads as $row_ad) {
            $ad_count = $row_ad->ad_count;
        }
        echo $ad_count;
        echo "</td>";
    }

    if($row->has_entries > 0) {
        echo "<td id='index_tablecellcenter' valign='center' align='center'>";
        // last entry
        $database->setQuery("SELECT user, date_format(date_created, '%d.%m.%Y' ) as date_cr
                                                FROM #__marketplace_ads
                             		    WHERE category='$row->id' AND published='1'
				    ORDER BY date_created DESC, id DESC
                                                LIMIT 1");

        $rows_date = $database->loadObjectList();

        $datum = "-";
        foreach($rows_date as $row_date) {
            $datum = $row_date->date_cr;
            $ad_username = $row_date->user;
        }
        echo $datum;

        if ( $ad_count > 0) {
            echo "<br />";
            echo "<font size='-2'>";
            echo JOO_FROM;
            echo "<b>".$ad_username."</b>";
            echo "</font>";
        }
        echo "</td>";
    }

    echo "</tr>";

}

echo "</table>";

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