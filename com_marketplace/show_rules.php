<?php
/**
 * show_rules.php
 *
 * Displays the rules defined in the language file as JOO_RULES_TEXT
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


	// set page title
	$mainframe->SetPageTitle( JOO_TITLE." - " .JOO_RULES );



	echo "<table width='100%'>";
	
		echo "<tr>";
		
			echo "<td align='left'>";

				include($mosConfig_absolute_path.'/components/com_marketplace/topmenu.php');

				echo JOO_RULES_TEXT;

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

