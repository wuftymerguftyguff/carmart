<?php
/**
 * recent5.php
 *
 * Displays the recent 5 photo ads
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
?>

<link rel="stylesheet" href="components/com_marketplace/marketplace.css" type="text/css" />


<?php
    global $database;

    $Itemid       = intval( mosGetParam( $_REQUEST, 'Itemid', '0' ) );


    // recent5 can act as a plugin for other extensions so include the language here, too
    if(file_exists($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php')) {
        require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php');
    }
    else {
        require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/english.php');
    }



    $database->setQuery("SELECT a.id, a.category, a.ad_headline, a.ad_condition, date_format( a.date_created, '%d.%m.%Y' ) AS af_date, b.name"
			. "\n FROM #__marketplace_ads AS a, "
			. "\n #__marketplace_categories AS b WHERE b.published='1' AND a.published='1' AND a.category = b.id AND a.ad_image > '0'"
			. "\n ORDER BY a.id DESC "
			. "\n LIMIT 5 ");

    $meslist = $database->loadObjectList();


	echo "<table class='jooRecent5' cellspacing='1'>";

   	  echo "<tr>";
    	    echo "<th width='100%' bgcolor='#DDDDDD' colspan='5'>";
   	            echo JOO_RECENT5;
    	    echo "</th>";
  	  echo "</tr>";

	  echo "<tr>";

	    foreach ($meslist as $mes){

	      echo "<td width='20%' valign='top' >";

	      echo "<center>";
		  echo "<table width='100' height='75' border='0'>";
		    echo "<tr>";
		      echo "<td width='100' height='75' align='center'>";
		      
				echo "<a href=".sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_ad&amp;catid=$mes->category&amp;adid=$mes->id&amp;Itemid=$Itemid").">";

					$a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."a_t.jpg";
					$a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."a_t.png";
					$a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."a_t.gif";

					$b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."b_t.jpg";
					$b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."b_t.png";
					$b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."b_t.gif";

					$c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."c_t.jpg";
					$c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."c_t.png";
					$c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$mes->id."c_t.gif";


					$boolPicFound = 0;
					if ( file_exists( $a_pic_jpg)) {
						echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."a_t.jpg"."' align='center' border='0'>";
						$boolPicFound = 1;
					}
					else {
						if ( file_exists( $a_pic_png)) {
							echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."a_t.png"."' align='center' border='0'>";
							$boolPicFound = 1;
						}
						else {
							if ( file_exists( $a_pic_gif)) {
								echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."a_t.gif"."' align='center' border='0'>";
								$boolPicFound = 1;
							}
						}
					}


					if ( $boolPicFound == 0) {
						if ( file_exists( $b_pic_jpg)) {
							echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."b_t.jpg"."' align='center' border='0'>";
							$boolPicFound = 1;
						}
						else {
							if ( file_exists( $b_pic_png)) {
								echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."b_t.png"."' align='center' border='0'>";
								$boolPicFound = 1;
							}
							else {
								if ( file_exists( $b_pic_gif)) {
									echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."b_t.gif"."' align='center' border='0'>";
									$boolPicFound = 1;
								}
							}
						}
					}


					if ( $boolPicFound == 0) {
						if ( file_exists( $c_pic_jpg)) {
							echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."c_t.jpg"."' align='center' border='0'>";
						}
						else {
							if ( file_exists( $c_pic_png)) {
								echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."c_t.png"."' align='center' border='0'>";
							}
							else {
								if ( file_exists( $c_pic_gif)) {
									echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$mes->id."c_t.gif"."' align='center' border='0'>";
								}
							}
						}
					}

		        echo "</a>";

		      echo "</td>";
		    echo "</tr>";
		  echo "</table>";

		echo "<a href=".sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_ad&amp;catid=$mes->category&amp;adid=$mes->id&amp;Itemid=$Itemid").">";
		  if ( strlen($mes->ad_headline)>30){
		    echo substr( $mes->ad_headline, 0, 27)."...";
		  }
		  else {
		    echo $mes->ad_headline;
		  }
		echo "</a>";



		echo "<br>";
		echo $mes->name." (".$mes->af_date.")";

      	}
	      echo "</center>";

	      echo "</td>";

	    echo "</tr>";
	  echo "</table>";

?>


