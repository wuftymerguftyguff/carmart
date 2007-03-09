<?php
/**
 * marketplace.class.php
 *
 * The marketplace backend class file
 *
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


class marketplaceConf extends mosDBTable {
	var $id = null;
	var $admin_userid = null;
	var $duration = null;
	var $date_deleted = null;
	var $ads_per_page = null;
	var $max_image_size = null;
	var $ad_default = null;
	var $ad_contact_registered_only = null;
	var $use_surname = null;
	var $use_street = null;
	var $use_zip = null;
	var $use_city = null;
	var $use_state = null;
	var $use_country = null;
	var $use_web = null;
	var $use_phone1 = null;
	var $use_phone2 = null;
	var $use_condition = null;
	var $use_primezilla = null;
	var $use_primezillaforcontact = null;

	function marketplaceConf(&$db){
		$this->mosDBTable('#__marketplace_config', 'id', $db);
	}
}


class marketplaceCategory extends mosDBTable {
	var $id = null;
	var $parent = null;
	var $name = null;
	var $description = null;
	var $image = null;
	var $has_entries = null;
	var $sort_order = null;
	var $published = null;


	function marketplaceCategory(&$db){
		$this->mosDBTable('#__marketplace_categories', 'id', $db);
	}
}


class marketplaceAd extends mosDBTable {
	var $id = null;
	var $category = null;
	var $userid = null;
	var $user = null;
	var $name = null;
	var $surname = null;
	var $street = null;
	var $zip = null;
	var $city = null;
	var $state = null;
	var $country = null;

	var $phone1 = null;
	var $phone2 = null;
	var $email = null;
	var $web = null;

	var $ad_type = null;
	var $ad_headline = null;
	var $ad_text = null;
	var $ad_condition = null;
	var $ad_price = null;

	var $date_created = null;
	var $date_lastmodified = null;

	var $views = null;
	var $duration = null;

	var $flag_featured = null;
	var $flag_top = null;
	var $flag_commercial = null;

	var $published = null;

	function marketplaceAd(&$db){
		$this->mosDBTable('#__marketplace_ads', 'id', $db);
	}
}



class marketplaceType extends mosDBTable {
	var $id = null;
	var $name = null;
	var $sort_order = null;
	var $published = null;


	function marketplaceType(&$db){
		$this->mosDBTable('#__marketplace_types', 'id', $db);
	}
}


?>