<?php
/**
 * topmenu.php
 *
 * Included by all frontend files,
 * displays the marketplace main menue
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


  $linkOverview = sefRelToAbs( "index.php?option=com_marketplace&amp;Itemid=".$Itemid);
  $linkAddAd    = sefRelToAbs( "index.php?option=com_marketplace&amp;page=write_ad&amp;Itemid=".$Itemid);
  $linkMyAds    = sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_category&amp;catid=0&amp;Itemid=".$Itemid);
  $linkRules    = sefRelToAbs( "index.php?option=com_marketplace&amp;page=show_rules&amp;Itemid=".$Itemid);
  ?>


  <div style="background:lightgrey; margin-bottom: 20px;">

  <table class="jooTopmenu" cellspacing="1">
    <tr>

       <?php
       echo "<td valign=\"center\">";
         echo "<div style='width:100%; height:100%; vertical-align: center;'>";
           echo "<a href=".$linkOverview." style='display: block;'>";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/home.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_OVERVIEW;
             echo "</span>";

           echo "</a>";
         echo "</div>";
       echo "</td>";

       echo "<td valign=\"center\">";
         echo "<div style='width:100%; height:100%; vertical-align: center;'>";
           echo "<a href=".$linkAddAd." style='display: block;'>";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/writead.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_WRITE_AD;
             echo "</span>";

           echo "</a>";
         echo "</div>";
       echo "</td>";

       echo "<td valign=\"center\">";
         echo "<div style='width:100%; height:100%; vertical-align: center;'>";
           echo "<a href=".$linkMyAds." style='display: block;'>";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/myads.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_MY_ADS;
             echo "</span>";

           echo "</a>";
         echo "</div>";
       echo "</td>";

       echo "<td valign=\"center\">";
         echo "<div style='width:100%; height:100%; vertical-align: center;'>";
           echo "<a href=".$linkRules." style='display: block;'>";

             echo "<span>";
               echo "<img src=\"".$mosConfig_live_site."/components/com_marketplace/images/system/rules.gif\" border=\"0\" align=\"top\" >";
             echo "</span>";

             echo "<span>";
               echo "&nbsp;&nbsp;&nbsp;".JOO_RULES;
             echo "</span>";

           echo "</a>";
         echo "</div>";
       echo "</td>";

       ?>

     </tr>
  </table>

  </div>


