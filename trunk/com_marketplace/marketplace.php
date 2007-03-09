<?php
/**
 * marketplace.php
 *
 * This file controls the frontend calls
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


$page = strval( mosGetParam( $_REQUEST, 'page', '' ) );



// get language for marketplace
if(file_exists($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php')) {
  require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/'.$mainframe->getCfg('lang').'.php');
}
else {
  require_once($mainframe->getCfg('absolute_path').'/components/com_marketplace/language/english.php');
}



switch ($page) {


  case 'show_category': {
    include($mosConfig_absolute_path.'/components/com_marketplace/show_category.php');
    break;
  }

  case 'show_rules': {
    include($mosConfig_absolute_path.'/components/com_marketplace/show_rules.php');
    break;
  }

  case 'show_ad': {
    include($mosConfig_absolute_path.'/components/com_marketplace/show_ad.php');
    break;
  }

  case 'write_ad': {
    include($mosConfig_absolute_path.'/components/com_marketplace/write_ad.php');
    break;
  }

  case 'delete_ad': {
    include($mosConfig_absolute_path.'/components/com_marketplace/delete_ad.php');
    break;
  }

  default: {
    include($mosConfig_absolute_path.'/components/com_marketplace/show_index.php');
    break;
  }

}

?>

