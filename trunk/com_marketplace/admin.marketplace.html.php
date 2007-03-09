<?php
/**
 * admin.marketplace.html.php
 *
 * Backend administration HTML
 *
 * @package com_marketplace
 * @subpackage backend
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

class HTML_marketplace{


    function listConfiguration($option, $rows) {
        global $mosConfig_absolute_path;
        ?>

    <table class="adminheading">
       <tr>
          <th>Marketplace Configuration</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm">

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

	<?php
	$row = $rows[0];
	?>


	<tr>
		<td>Admin userid</td>
		<td><input type="text" name="admin_userid" value=<?php echo $row->admin_userid ?> /></td>
		<td>This user can edit/delete ads in the frontend</td>
	</tr>

	<tr>
		<td>Duration</td>
		<td><input type="text" name="duration" value=<?php echo $row->duration ?> /></td>
		<td>Days until ads are deleted automatically</td>
	</tr>

	<tr>
		<td>Ads per page</td>
		<td><input type="text" name="ads_per_page" value=<?php echo $row->ads_per_page ?> /></td>
		<td>Ads showed in list</td>
	</tr>

	<tr>
		<td>Max image size</td>
		<td><input type="text" name="max_image_size" value=<?php echo $row->max_image_size ?> /></td>
		<td>maximum image size in bytes</td>
	</tr>

	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>

	<tr>
		<td>Publish ad by default</td>
		<td><?php echo mosHTML::yesnoSelectList( "ad_default", "", $row->ad_default ); ?></td>
		<td>Set to <b>Yes</b> will publish the ad immediatly after user writes it, set to <b>No</b> will require Admin publishing</td>
	</tr>

	<tr>
		<td>Show contact details to logged in users only</td>
		<td><?php echo mosHTML::yesnoSelectList( "ad_contact_registered_only", "", $row->ad_contact_registered_only ); ?></td>
		<td>Set to <b>Yes</b> will display the contact information to logged in users only, set to <b>No</b> will display it to the public</td>
	</tr>

	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>

	<tr>
		<td>Use Surname</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_surname", "", $row->use_surname ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Street</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_street", "", $row->use_street ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use ZIP</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_zip", "", $row->use_zip ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use City</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_city", "", $row->use_city ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use State</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_state", "", $row->use_state ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Country</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_country", "", $row->use_country ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Phone1</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_phone1", "", $row->use_phone1 ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Phone2</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_phone2", "", $row->use_phone2 ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Web</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_web", "", $row->use_web ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td>Use Condition</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_condition", "", $row->use_condition ); ?></td>
		<td>Set to <b>Yes</b> will display this field when writing/editing an ad</td>
	</tr>

	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>

	<tr>
		<td>Use Primezilla</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_primezilla", "", $row->use_primezilla ); ?></td>
		<td>Set to <b>Yes</b> will enable Primezilla Private Messaging support for Marketplace</td>
	</tr>

	<tr>
		<td>Use Primezilla for contact</td>
		<td><?php echo mosHTML::yesnoSelectList( "use_primezillaforcontact", "", $row->use_primezillaforcontact ); ?></td>
		<td>Set to <b>Yes</b> will display Primezilla Private Messaging link instead of email-address in contact-field</td>
	</tr>


	</table>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value=<?php echo $row->id ?> />
	<input type="hidden" name="act" value="configuration" />

	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }



    function listCategories($option, $rows, $pageNav) {
        global $mosConfig_absolute_path;
	?>

	<table class="adminheading">
       <tr>
          <th>Marketplace Categories</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

	<tr>
	<th class="title" width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>

	<th class="title" width="5%">Id</th>
	<th class="title" width="5%">Parent</th>

	<th class="title" width="20%">Category</th>
	<th class="title" width="30%">Description</th>

	<th class="title" width="10%">Image</th>
	<th class="title" width="10%">Has Entries</th>
	<th class="title" width="10%">Sort Order</th>


	<th width="5%">Published</th>
	</tr>


	<?php
	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	    $row = $rows[$i];

    	if($row->parent==0){?>
       		<tr bgcolor="#E5EEFF"><?php
    	}else{?>
			<tr class="<?php echo "row$k"; ?>">
    	<?php }?>

		<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>

		<td><?php echo $row->id; ?></td>
		<td><?php echo $row->parent; ?></td>


		<td><a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')"><?php echo $row->name; ?></a></td>

		<td><?php echo $row->description; ?></td>

		<td><?php echo $row->image; ?></td>

    	<td><?php echo ($row->has_entries==1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"); ?></td>

		<td><?php echo $row->sort_order; ?></td>


		<td align="center">
   		<?php
   		if ($row->published == "1") {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','unpublish')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
   		} else {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','publish')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
   		}
   		?>
		</td>
		<?php $k = 1 - $k; ?>
		</tr>
	<?php }

	?>
	</table>

	<?php echo $pageNav->getListFooter(); ?>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="act" value="categories" />
	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include( $mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }



    function editCategory( $option, $row ) {
        global $database, $mosConfig_absolute_path;

        $categories = array();
        $categories[] = mosHTML::makeOption( '0', 'Top' );
        $database->setQuery( "SELECT id AS value, name AS text FROM #__marketplace_categories WHERE parent=0" );
        $categories = array_merge( $categories, $database->loadObjectList() );
	?>

    <table class="adminheading">
       <tr>
          <th>Marketplace Categories</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">


	<tr>
	<td>Parent: </td>
	<td><?php

	if( $row->id > 0) {
	    $select_id=$row->parent;
	}
	else {
	    $select_id=0;
	}

	$html = mosHTML::selectList( $categories, 'parent', 'size="1" class="inputbox"', 'value', 'text', $select_id);
	echo $html;
 	?></td>
	<td>Parent Category, 'Top' if it has no parent</td>
	</tr>

	<tr>
	<td>Has Entries: </td>
	<td><?php echo mosHTML::yesnoSelectList( "has_entries", "", $row->has_entries ); ?></td>
	<td>Set to 'No' for Category without ads (container for other categories), 'Yes' for normal categories with ads</td>
	</tr>


	<tr>
	<td>Name: </td>
	<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo $row->name; ?>" /></td>
	<td>The name of the category</td>
	</tr>

	<tr>
	<td>Description: </td>
	<td><input size="50" name="description" value="<?php echo $row->description; ?>"></td>
	<td>The description of the category</td>
	</tr>

	<tr>
	<td>Image: </td>
	<td><input size="50" name="image" value="<?php echo $row->image; ?>"></td>
	<td>Set to 'default.gif' for standard folder symbol</td>
	</tr>

	<tr>
	<td>Sort Order: </td>
	<td><input size="10" name="sort_order" value="<?php echo $row->sort_order; ?>"></td>
	<td>Category list is sorted by this field</td>
	</tr>

	</table>

	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="act" value="categories" />

	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }




    function listAds($option, $rows, $pageNav) {
        global $database, $mosConfig_absolute_path;
	?>

    <table class="adminheading">
       <tr>
          <th>Marketplace Ads</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

	<tr>
	<th class="title" width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>

	<th class="title" width="5%">Id</th>

	<th class="title" width="30%">Headline</th>
	<th width="15%">Category</th>
	<th width="5%">Images</th>
	<th width="10%">Type</th>

	<th width="5%">Created</th>
	<th width="5%">LastModified</th>

	<th width="5%">Top</th>
	<th width="5%">Featured</th>
	<th width="5%">Commercial</th>
	<th width="5%">Published</th>
	</tr>


	<?php
	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	    $row = $rows[$i]; ?>

			<tr class="<?php echo "row$k"; ?>">

		<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>

		<td><?php echo $row->id; ?></td>

		<td><a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')"><?php echo $row->ad_headline; ?></a></td>

		<?php
		$database->setQuery( "SELECT name FROM #__marketplace_categories WHERE id='$row->category'");
		$afCategory = $database->loadResult();
        ?>

		<td align="center"><?php echo $afCategory; ?></td>

		<td align="center"><?php echo $row->ad_image; ?></td>

		<td align="center">
			<?php
            // get ad type from db
            $database->setQuery( "SELECT name FROM #__marketplace_types WHERE id='$row->ad_type'");
            $sAdType = $database->loadResult();
            echo $sAdType;
            ?>
        </td>

		<td align="center"><?php echo $row->date_created; ?></td>

		<td align="center"><?php echo $row->date_lastmodified; ?></td>

    	<td align="center"><?php echo ($row->flag_top==1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"); ?></td>

    	<td align="center"><?php echo ($row->flag_featured==1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"); ?></td>

    	<td align="center"><?php echo ($row->flag_commercial==1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"); ?></td>


		<td align="center">
   		<?php
   		if ($row->published == "1") {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','unpublish')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
   		} else {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','publish')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
   		}
   		?>
		</td>
		<?php $k = 1 - $k; ?>
		</tr>

		<?php }

	   ?>
	</table>

	<?php echo $pageNav->getListFooter(); ?>


	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="act" value="ads" />
	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }




    function editAd( $option, $row ) {

        global $database, $mosConfig_absolute_path, $mosConfig_live_site, $my;

        if ($row->id == '') {
            $database->setQuery( "SELECT CURRENT_DATE()");
            $date_created = $database->loadResult();
        }
        $database->setQuery( "SELECT CURRENT_DATE()");
        $date_lastmodified = $database->loadResult();

        // get configuration data
        $database->setQuery("SELECT * FROM #__marketplace_config LIMIT 1");
        $config = $database->loadObjectList();

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

        $categories = array();
        $database->setQuery( "SELECT id AS value, name AS text FROM #__marketplace_categories WHERE has_entries > 0 ORDER BY sort_order" );
        $categories = array_merge( $categories, $database->loadObjectList() );

        // get ad types
        $database->setQuery("SELECT id, name FROM #__marketplace_types WHERE published='1' ORDER BY sort_order");
        $rows_type = $database->loadObjectList();

        $types = array();
        foreach( $rows_type as $rowtype) {
            $types[] = mosHTML::makeOption( $rowtype->id, $rowtype->name );
        }

	?>

    <table class="adminheading">
       <tr>
          <th>Marketplace Ads</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" name="adminForm" method="post" enctype="multipart/form-data">

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

	<tr>
	<td>Id: </td>
	<td>
		<?php
		echo "<b>".$row->id."</b>";
 		?>
 	</td>
	<td>Ad Id</td>
	</tr>

	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>

	<tr>
	<td>Top Ad: </td>
	<td><?php echo mosHTML::yesnoSelectList( "flag_top", "", $row->flag_top ); ?></td>
	<td>Top Ads are always listed first - before the "normal" Ads</td>
	</tr>

	<tr>
	<td>Featured Ad: </td>
	<td><?php echo mosHTML::yesnoSelectList( "flag_featured", "", $row->flag_featured ); ?></td>
	<td>Featured Ads are displayed in a special way (configurable in CSS)</td>
	</tr>

	<tr>
	<td>Commercial Ad: </td>
	<td><?php echo mosHTML::yesnoSelectList( "flag_commercial", "", $row->flag_commercial ); ?></td>
	<td>Commercial Ads are displayed in a special way (configurable in CSS)</td>
	</tr>

	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>


	<tr>
	<td>Userid / User: </td>
	<td>
	<?php
	if( $row->userid == '') {
	?>
	   <input type="text" size="5" maxsize="10" name="userid" value="<?php echo $my->id; ?>" />
	   &nbsp;&nbsp;
	   <input type="text" size="40" maxsize=40" name="user" value="<?php echo $my->username; ?>" />
	<?php
	}
	else {
	?>
	   <input type="text" size="5" maxsize="10" name="userid" value="<?php echo $row->userid; ?>" />
	   &nbsp;&nbsp;
	   <input type="text" size="40" maxsize=40" name="user" value="<?php echo $row->user; ?>" />
	<?php
	}
	?>
	</td>
	<td>Userid and Username</td>
	</tr>


	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>

	<tr>
	<td>Name: </td>
	<td><input type="text" size="50" maxsize="50" name="name" value="<?php echo $row->name; ?>" />&nbsp;(required)</td>
	<td>Name</td>
	</tr>

	<?php
	if ($use_surname) {
	?>
	   <tr>
	   <td>Surname: </td>
	   <td><input type="text" size="50" maxsize="50" name="surname" value="<?php echo $row->surname; ?>" /></td>
	   <td>Surname</td>
	   </tr>
	<?php
	}
	?>


	<?php
	if ($use_street) {
	?>
	<tr>
	<td>Street: </td>
	<td><input type="text" size="50" maxsize="50" name="street" value="<?php echo $row->street; ?>" /></td>
	<td>Street</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_zip) {
	?>
	<tr>
	<td>Zip: </td>
	<td><input type="text" size="5" maxsize="10" name="zip" value="<?php echo $row->zip; ?>" /></td>
	<td>Zip</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_city) {
	?>
	<tr>
	<td>City: </td>
	<td><input type="text" size="50" maxsize="50" name="city" value="<?php echo $row->city; ?>" /></td>
	<td>City</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_state) {
	?>
	<tr>
	<td>State: </td>
	<td><input type="text" size="50" maxsize="50" name="state" value="<?php echo $row->state; ?>" /></td>
	<td>state</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_country) {
	?>
	<tr>
	<td>Country: </td>
	<td><input type="text" size="50" maxsize="50" name="country" value="<?php echo $row->country; ?>" /></td>
	<td>Country</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_phone1) {
	?>
	<tr>
	<td>Phone1: </td>
	<td><input type="text" size="50" maxsize="50" name="phone1" value="<?php echo $row->phone1; ?>" /></td>
	<td>First Phone Number</td>
	</tr>
	<?php
	}
	?>


	<?php
	if ($use_phone2) {
	?>
	<tr>
	<td>Phone2: </td>
	<td><input type="text" size="50" maxsize="50" name="phone2" value="<?php echo $row->phone2; ?>" /></td>
	<td>Second Phone Number</td>
	</tr>
	<?php
	}
	?>


	<tr>
	<td>Email: </td>
	<td><input type="text" size="50" maxsize="50" name="email" value="<?php echo $row->email; ?>" />&nbsp;(required)</td>
	<td>Contact Email</td>
	</tr>


	<?php
	if ($use_web) {
	?>
	<tr>
	<td>Web: </td>
	<td><input type="text" size="50" maxsize="80" name="web" value="<?php echo $row->web; ?>" /></td>
	<td>Contact Web-Address</td>
	</tr>
	<?php
	}
	?>


	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>


	<tr>
	<td>Category: </td>
	<td>
	<?php
	$html = mosHTML::selectList( $types, 'ad_type', 'size="1" class="inputbox"', 'value', 'text', $row->ad_type);
	echo $html;
	?>

	&nbsp;&nbsp;

	<?php
	if( $row->category > 0) {
	    $select_id=$row->category;
	}
	else {
	    $select_id=0;
	}

	$html = mosHTML::selectList( $categories, 'category', 'size="1" class="inputbox"', 'value', 'text', $select_id);
	echo $html;
	?>
	</td>
	<td>Ad Category</td>
	</tr>


	<tr>
	<td>Headline: </td>
	<td><input type="text" size="50" maxsize="80" name="ad_headline" value="<?php echo htmlspecialchars($row->ad_headline, ENT_QUOTES); ?>" />&nbsp;(required)</td>
	<td>Ad Headline</td>
	</tr>


	<tr>
	<td align="left" valign="top">Text: </td>
	<td align="left" valign="top">
		<?php
		echo "<textarea name='ad_text' cols='60' rows='10' wrap='VIRTUAL'>$row->ad_text</textarea>";
		?>
		&nbsp;(required)
	</td>
	<td align="left" valign="top">Ad Text</td>
	</tr>


	<?php
	if ($use_condition) {
	?>
	<tr>
	<td>Condition: </td>
	<td><input type="text" size="50" maxsize="80" name="ad_condition" value="<?php echo $row->ad_condition; ?>" /></td>
	<td>Condition</td>
	</tr>
	<?php
	}
	?>


	<tr>
	<td>Price: </td>
	<td><input type="text" size="50" maxsize="50" name="ad_price" value="<?php echo $row->ad_price; ?>" /></td>
	<td>Price</td>
	</tr>


	<tr>
		<td colspan="3">
			<br />
		</td>
	</tr>


	<tr>
	<td valign="top">Image1: </td>
	<td>

	   <?php
	   $imageid=$row->id;
	   ?>

			<!-- image1 -->
                <input class="marketplace" id="ad_picture1" type="file" name="ad_picture1">
				<?php

				if ($imageid <> '') { // update
				    $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.jpg";
				    $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.png";
				    $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.gif";

				    if ( file_exists( $a_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."a_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image1' value='delete'>"." Delete";
				    }
				    else {
				        if ( file_exists( $a_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."a_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image1' value='delete'>"." Delete";
				        }
				        else {
				            if ( file_exists( $a_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."a_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image1' value='delete'>"." Delete";
				            }
				        }
				    }
				}
				?>
			<!-- image1 -->
	</td>
	</tr>


	<tr>
	<td valign="top">Image2: </td>
	<td>
			<!-- image2 -->
                <input class="marketplace" id="ad_picture2" type="file" name="ad_picture2">
				<?php
				if ($imageid <> '') { // update
				    $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.jpg";
				    $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.png";
				    $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.gif";

				    if ( file_exists( $b_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."b_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image2' value='delete'>"." Delete";
				    }
				    else {
				        if ( file_exists( $b_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."b_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image2' value='delete'>"." Delete";
				        }
				        else {
				            if ( file_exists( $b_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."b_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image2' value='delete'>"." Delete";
				            }
				        }
				    }
				}
				?>
			<!-- image2 -->
	</td>
	</tr>


	<tr>
	<td valign="top">Image3: </td>
	<td>
			<!-- image3 -->
                <input class="marketplace" id="ad_picture3" type="file" name="ad_picture3">
				<?php
				if ($imageid <> '') { // update
				    $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.jpg";
				    $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.png";
				    $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.gif";

				    if ( file_exists( $c_pic_jpg)) {
				        echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."c_t.jpg' align='top' border='0'>";
				        echo "<input type='checkbox' name='cb_image3' value='delete'>"." Delete";
				    }
				    else {
				        if ( file_exists( $c_pic_png)) {
				            echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."c_t.png' align='top' border='0'>";
				            echo "<input type='checkbox' name='cb_image3' value='delete'>"." Delete";
				        }
				        else {
				            if ( file_exists( $c_pic_gif)) {
				                echo "<img src='".$mosConfig_live_site."/components/com_marketplace/images/entries/".$imageid."c_t.gif' align='top' border='0'>";
				                echo "<input type='checkbox' name='cb_image3' value='delete'>"." Delete";
				            }
				        }
				    }
				}
				?>
			<!-- image3 -->

	</td>
	</tr>






	</table>

	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="act" value="ads" />
	<input type="hidden" name="imageid" value="<?php echo $imageid; ?>" />

	<?php
	if ($row->id == '') {
	?>
	   <input type="hidden" name="date_created" value="<?php echo $date_created; ?>" />
	<?php
	}
	?>
	<input type="hidden" name="date_lastmodified" value="<?php echo $date_lastmodified; ?>" />
	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }




    function listTypes($option, $rows, $pageNav) {
        global $mosConfig_absolute_path;
	?>

	<table class="adminheading">
       <tr>
          <th>Marketplace Types</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

	<tr>
	<th class="title" width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>

	<th class="title" width="5%">Id</th>

	<th class="title" width="80%">Name</th>
	<th class="title" width="10%">Sort Order</th>

	<th width="5%">Published</th>
	</tr>


	<?php
	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	    $row = $rows[$i];
        ?>

		<tr class="<?php echo "row$k"; ?>">


		<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>

		<td><?php echo $row->id; ?></td>

		<td><a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')"><?php echo $row->name; ?></a></td>

		<td><?php echo $row->sort_order; ?></td>


		<td align="center">
   		<?php
   		if ($row->published == "1") {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','unpublish')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
   		} else {
   		    echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','publish')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
   		}
   		?>
		</td>
		<?php $k = 1 - $k; ?>
		</tr>
	<?php }

	?>
	</table>

	<?php echo $pageNav->getListFooter(); ?>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="act" value="types" />
	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include( $mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }



    function editType( $option, $row ) {
        global $database, $mosConfig_absolute_path;

	?>

    <table class="adminheading">
       <tr>
          <th>Marketplace Types</th>
       </tr>
    </table>
	<br />

	<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">


	<tr>
	<td>Name: </td>
	<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo $row->name; ?>" /></td>
	<td>The name of the Type</td>
	</tr>


	<tr>
	<td>Sort Order: </td>
	<td><input size="10" name="sort_order" value="<?php echo $row->sort_order; ?>"></td>
	<td>Type list is sorted by this field</td>
	</tr>

	</table>

	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="act" value="types" />

	</form>

	<br />

	<?php
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	include($mosConfig_absolute_path.'/components/com_marketplace/footer.php');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
    }




}
?>
