<?php
/**
 * toolbar.marketplace.html.php
 *
 * Displays the toolbar for marketplace backend
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

class menuMarketplace{

    function DEFAULT_MENU() {
        mosMenuBar::startTable();
        mosMenuBar::publish('publish');
        mosMenuBar::unpublish('unpublish');
        mosMenuBar::divider();
        mosMenuBar::addNew('new');
        mosMenuBar::editList('edit', 'Edit');
        mosMenuBar::deleteList( ' ', 'delete', 'Remove' );
        mosMenuBar::endTable();
    }
    function EDIT_MENU() {
        mosMenuBar::startTable();
        mosMenuBar::back();
        mosMenuBar::spacer();
        mosMenuBar::save('save');
        mosMenuBar::endTable();
    }
    function CONFIGURE_MENU() {
        mosMenuBar::startTable();
        mosMenuBar::save('save');
        mosMenuBar::endTable();
    }
    function CATEGORIES_MENU() {
        mosMenuBar::startTable();
        mosMenuBar::publish('publish');
        mosMenuBar::unpublish('unpublish');
        mosMenuBar::divider();
        mosMenuBar::addNew('new');
        mosMenuBar::editList('edit', 'Edit');
        mosMenuBar::deleteList( ' ', 'delete', 'Remove' );
        mosMenuBar::endTable();
    }
    function ADS_MENU() {
        mosMenuBar::startTable();
        mosMenuBar::publish('publish');
        mosMenuBar::unpublish('unpublish');
        mosMenuBar::divider();
        mosMenuBar::addNew('new');
        mosMenuBar::editList('edit', 'Edit');
        mosMenuBar::deleteList( ' ', 'delete', 'Remove' );
        mosMenuBar::endTable();
    }

}

?>