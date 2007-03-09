<?php
/**
 * admin.marketplace.php
 *
 * Backend administration
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
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');


// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_marketplace' ))) {
    mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$id = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $id )) {
    $id = array(0);
}


switch($act)
{
    case "configuration": {
        switch($task) {
            case "save": {
                saveConfiguration($option);
                break;
            }

            default: {
                listConfiguration($option);
                break;
            }
        }
        break;
    }

    case "categories": {
        switch($task) {
            case "listCategories" : {
                listCategories($option);
                break;
            }
            case "edit" : {
                editCategory( $option, $id );
                break;
            }
            case "new" : {
                $id = '';
                editCategory( $option, $id);
                break;
            }
            case "save" : {
                saveCategory($option);
                break;
            }
            case "delete" : {
                deleteCategory($option, $id);
                break;
            }
            case "publish" : {
                publishCategory($option, '1', $id);
                break;
            }
            case "unpublish" : {
                publishCategory($option, '0', $id);
                break;
            }
            default: {
                listCategories($option);
                break;
            }
        }
        break;
    }

    case "ads": {
        switch($task) {
            case "new" : {
                editad( $option, '' );
                break;
            }
            case "edit" : {
                editad( $option, $id );
                break;
            }
            case "save" : {
                saveAd($option);
                break;
            }
            case "delete" : {
                deleteAd($option, $id);
                break;
            }
            case "publish" : {
                publishAd($option, '1', $id);
                break;
            }
            case "unpublish" : {
                publishAd($option, '0', $id);
                break;
            }
            default: {
                listAds($option);
                break;
            }
        }
        break;
    }

    case "types": {
        switch($task) {
            case "listTypes" : {
                listTypes($option);
                break;
            }
            case "edit" : {
                editType( $option, $id );
                break;
            }
            case "new" : {
                $id = '';
                editType( $option, $id);
                break;
            }
            case "save" : {
                saveType($option);
                break;
            }
            case "delete" : {
                deleteType($option, $id);
                break;
            }
            case "publish" : {
                publishType($option, '1', $id);
                break;
            }
            case "unpublish" : {
                publishType($option, '0', $id);
                break;
            }
            default: {
                listTypes($option);
                break;
            }
        }
        break;
    }


    default: {
        switch ($task) {

            case "listAds" : {
                listAds($option);
                break;
            }
        }
        break;
    }

}


function saveConfiguration($option) {
    global $database;
    $row = new marketplaceConf($database);


    // bind it to the table
    if (!$row -> bind($_POST)) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    // store it in the db
    if (!$row -> store()) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    mosRedirect("index2.php?option=$option&act=configuration", "Configuration Saved");
}



function listConfiguration($option) {
    global $database;

    $database->setQuery("SELECT * FROM #__marketplace_config"  );
    $rows = $database -> loadObjectList();
    if ($database -> getErrorNum()) {
        echo $database -> stderr();
        return false;
    }
    HTML_marketplace::listConfiguration($option, $rows);
    return true;
}
/********************************************************************************************************/

function listCategories($option) {
    global $database, $mosConfig_absolute_path, $mosConfig_list_limit, $mainframe;;

    $option = mosGetParam( $_REQUEST, 'option');

    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

    $database->setQuery("SELECT count(*) FROM #__marketplace_categories"  );
    $rowcount = $database->loadResult();

    if ($database -> getErrorNum()) {
        echo $database -> stderr();
        return false;
    }

    require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $rowcount, $limitstart, $limit);

    $database->setQuery( "SELECT * FROM #__marketplace_categories ORDER BY sort_order LIMIT ".$limitstart.", ".$limit);
    $rows = $database->loadObjectList();

    HTML_marketplace::listCategories($option, $rows, $pageNav);
    return true;
}



function publishCategory( $option, $publish=1 ,$cid )
{
    global $database;

    if (!is_array( $cid ) || count( $cid ) < 1) {
        $action = $publish ? 'publish' : 'unpublish';
        echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode( ',', $cid );

    $database->setQuery( "UPDATE #__marketplace_categories SET published='$publish'"
    . "\nWHERE id IN ($cids)"
    // AND (checked_out=0 OR (checked_out='$my->id')
    );
    if (!$database->query()) {
        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        exit();
    }

    mosRedirect( "index2.php?option=$option&act=categories" );

}






function saveCategory($option) {
    global $database;
    $row = new marketplaceCategory($database);

    // bind it to the table
    if (!$row -> bind($_POST)) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    // store it in the db
    if (!$row -> store()) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }
    mosRedirect("index2.php?option=$option&act=categories", "Category Saved");
}



function deleteCategory($option, $cid) {
    global $database;
    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
        exit();
    }

    if (count($cid))
    {
        $ids = implode(',', $cid);
        $database->setQuery("DELETE FROM #__marketplace_categories \nWHERE id IN ($ids)");
    }
    if (!$database->query()) {
        echo "<script> alert('"
        .$database -> getErrorMsg()
        ."'); window.history.go(-1); </script>\n";
    }
    mosRedirect("index2.php?option=$option&act=categories", "Category Deleted");
}



function editCategory($option, $uid) {
    global $database;

    $row = new marketplaceCategory($database);
    if($uid){
        $row -> load($uid[0]);
    }

    HTML_marketplace::editCategory($option, $row);
}
/********************************************************************************************************/

function listAds($option) {
    global $database, $mosConfig_absolute_path, $mosConfig_list_limit, $mainframe;
    $option = mosGetParam( $_REQUEST, 'option');

    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

    $database->setQuery("SELECT count(*) FROM #__marketplace_ads"  );
    $rowcount = $database->loadResult();

    if ($database -> getErrorNum()) {
        echo $database -> stderr();
        return false;
    }

    require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $rowcount, $limitstart, $limit);

    $database->setQuery( "SELECT * FROM #__marketplace_ads ORDER BY date_created DESC, id DESC LIMIT ".$limitstart.", ".$limit);
    $rows = $database->loadObjectList();

    HTML_marketplace::listAds($option, $rows, $pageNav);
    return true;
}



function publishAd( $option, $publish=1 ,$cid )
{
    global $database;

    if (!is_array( $cid ) || count( $cid ) < 1) {
        $action = $publish ? 'publish' : 'unpublish';
        echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode( ',', $cid );

    $database->setQuery( "UPDATE #__marketplace_ads SET published='$publish'"
    . "\nWHERE id IN ($cids)"
    // AND (checked_out=0 OR (checked_out='$my->id')
    );
    if (!$database->query()) {
        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        exit();
    }

    mosRedirect( "index2.php?option=$option&act=ads" );

}


function editAd($option, $uid) {
    global $database;

    $row = new marketplaceAd($database);
    if($uid){
        $row -> load($uid[0]);
    }

    HTML_marketplace::editAd($option, $row);
}


function saveAd($option) {
    global $database, $imageid;
    $row = new marketplaceAd($database);

    // bind it to the table
    if (!$row -> bind($_POST)) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    // store it in the db
    if (!$row -> store()) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    /* image handling here */
    manageImages( $row->id);

    mosRedirect("index2.php?option=$option&act=ads", "Ad Saved");
}


function deleteAd($option, $adid) {
    global $database;
    if (!is_array($adid) || count($adid) < 1) {
        echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
        exit();
    }

    if (count($adid))
    {
        $ids = implode(',', $adid);
        $database->setQuery("DELETE FROM #__marketplace_ads \nWHERE id IN ($ids)");
    }
    if (!$database->query()) {
        echo "<script> alert('"
        .$database -> getErrorMsg()
        ."'); window.history.go(-1); </script>\n";
    }
    mosRedirect("index2.php?option=$option&act=ads", "Ad Deleted");
}


function manageImages($imageid) {
    global $database, $mosConfig_absolute_path, $cb_image1, $cb_image2, $cb_image3;


    // image1 delete
    if ( $cb_image1 == "delete") {
        $a_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.jpg";
        if ( file_exists( $a_pict_jpg)) {
            unlink( $a_pict_jpg);
        }
        $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.jpg";
        if ( file_exists( $a_pic_jpg)) {
            unlink( $a_pic_jpg);
        }

        $a_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.png";
        if ( file_exists( $a_pict_png)) {
            unlink( $a_pict_png);
        }
        $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.png";
        if ( file_exists( $a_pic_png)) {
            unlink( $a_pic_png);
        }

        $a_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.gif";
        if ( file_exists( $a_pict_gif)) {
            unlink( $a_pict_gif);
        }
        $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.gif";
        if ( file_exists( $a_pic_gif)) {
            unlink( $a_pic_gif);
        }

        $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $imageid";

        $database->setQuery( $sql);

        if ($database->getErrorNum()) {
            echo $database->stderr();
        } else {
            $database->query();
        }
    }


    // image2 delete
    if ( $cb_image2 == "delete") {
        $b_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.jpg";
        if ( file_exists( $b_pict_jpg)) {
            unlink( $b_pict_jpg);
        }
        $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.jpg";
        if ( file_exists( $b_pic_jpg)) {
            unlink( $b_pic_jpg);
        }

        $b_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.png";
        if ( file_exists( $b_pict_png)) {
            unlink( $b_pict_png);
        }
        $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.png";
        if ( file_exists( $b_pic_png)) {
            unlink( $b_pic_png);
        }

        $b_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.gif";
        if ( file_exists( $b_pict_gif)) {
            unlink( $b_pict_gif);
        }
        $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.gif";
        if ( file_exists( $b_pic_gif)) {
            unlink( $b_pic_gif);
        }

        $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $imageid";

        $database->setQuery( $sql);

        if ($database->getErrorNum()) {
            echo $database->stderr();
        } else {
            $database->query();
        }
    }


    // image3 delete
    if ( $cb_image3 == "delete") {
        $c_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.jpg";
        if ( file_exists( $c_pict_jpg)) {
            unlink( $c_pict_jpg);
        }
        $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.jpg";
        if ( file_exists( $c_pic_jpg)) {
            unlink( $c_pic_jpg);
        }

        $c_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.png";
        if ( file_exists( $c_pict_png)) {
            unlink( $c_pict_png);
        }
        $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.png";
        if ( file_exists( $c_pic_png)) {
            unlink( $c_pic_png);
        }

        $c_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.gif";
        if ( file_exists( $c_pict_gif)) {
            unlink( $c_pict_gif);
        }
        $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.gif";
        if ( file_exists( $c_pic_gif)) {
            unlink( $c_pic_gif);
        }

        $sql = "UPDATE #__marketplace_ads
                     			SET ad_image = ad_image - 1, date_lastmodified = CURRENT_DATE()
                     			WHERE id = $imageid";

        $database->setQuery( $sql);

        if ($database->getErrorNum()) {
            echo $database->stderr();
        } else {
            $database->query();
        }
    }



    // image1 upload
    if (isset( $_FILES['ad_picture1']) and !$_FILES['ad_picture1']['error'] ) {
        ad_image( $imageid, "ad_picture1", "a", $mosConfig_absolute_path, $af_info, $database);
    }
    // image2 upload
    if (isset( $_FILES['ad_picture2']) and !$_FILES['ad_picture2']['error'] ) {
        ad_image( $imageid, "ad_picture2", "b", $mosConfig_absolute_path, $af_info, $database);
    }
    // image3 upload
    if (isset( $_FILES['ad_picture3']) and !$_FILES['ad_picture3']['error'] ) {
        ad_image( $imageid, "ad_picture3", "c", $mosConfig_absolute_path, $af_info, $database);
    }

    return true;
}



function ad_image( $imageid, $image, $itrail, $mosConfig_absolute_path, $af_info, $database) {

    $af_dir_ads = $mosConfig_absolute_path."/components/com_marketplace/images/entries/";

    // check imagesize
    $database->setQuery( "SELECT max_image_size FROM #__marketplace_config");
    $max_image_size = $database->loadResult();

    $image_too_big = 0;
    if (isset( $_FILES['ad_picture1'])) {
        if ( $_FILES['ad_picture1']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }
    if (isset( $_FILES['ad_picture2'])) {
        if ( $_FILES['ad_picture2']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }
    if (isset( $_FILES['ad_picture3'])) {
        if ( $_FILES['ad_picture3']['size'] > $max_image_size) {
            $image_too_big = 1;
        }
    }


    if ( $image_too_big == 1) {
        echo "<font color='#CC0000'>";
        echo "Image too big";
        echo "</font>";
        echo "<br>";
        echo "<br>";
    }
    else {

        $af_size = GetImageSize ($_FILES[$image]['tmp_name'], $af_info);

        switch ($af_size[2]) {
            case 1 : {
                $thispicext = 'gif';
                break;
            }
            case 2 : {
                $thispicext = 'jpg';
                break;
            }
            case 3 : {
                $thispicext = 'png';
                break;
            }
        }

        $isNewImage = 1;
        //$thispic = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid.$itrail."_t.".$thispicext;

        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid.$itrail."_t.gif")) {
            $isNewImage = 0;
        }
        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid.$itrail."_t.jpg")) {
            $isNewImage = 0;
        }
        if ( file_exists( $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid.$itrail."_t.jpg")) {
            $isNewImage = 0;
        }



        if ( $af_size[2] >= 1 && $af_size[2] <= 3) { // GIF, JPG or PNG

            switch ( $itrail) {
                case "a": {
                    $a_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.jpg";
                    if ( file_exists( $a_pict_jpg)) {
                        unlink( $a_pict_jpg);
                    }
                    $a_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.jpg";
                    if ( file_exists( $a_pic_jpg)) {
                        unlink( $a_pic_jpg);
                    }

                    $a_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.png";
                    if ( file_exists( $a_pict_png)) {
                        unlink( $a_pict_png);
                    }
                    $a_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.png";
                    if ( file_exists( $a_pic_png)) {
                        unlink( $a_pic_png);
                    }

                    $a_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a_t.gif";
                    if ( file_exists( $a_pict_gif)) {
                        unlink( $a_pict_gif);
                    }
                    $a_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."a.gif";
                    if ( file_exists( $a_pic_gif)) {
                        unlink( $a_pic_gif);
                    }
                    break;
                }
                case "b": {
                    $b_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.jpg";
                    if ( file_exists( $b_pict_jpg)) {
                        unlink( $b_pict_jpg);
                    }
                    $b_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.jpg";
                    if ( file_exists( $b_pic_jpg)) {
                        unlink( $b_pic_jpg);
                    }

                    $b_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.png";
                    if ( file_exists( $b_pict_png)) {
                        unlink( $b_pict_png);
                    }
                    $b_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.png";
                    if ( file_exists( $b_pic_png)) {
                        unlink( $b_pic_png);
                    }

                    $b_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b_t.gif";
                    if ( file_exists( $b_pict_gif)) {
                        unlink( $b_pict_gif);
                    }
                    $b_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."b.gif";
                    if ( file_exists( $b_pic_gif)) {
                        unlink( $b_pic_gif);
                    }
                    break;
                }
                case "c": {
                    $c_pict_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.jpg";
                    if ( file_exists( $c_pict_jpg)) {
                        unlink( $c_pict_jpg);
                    }
                    $c_pic_jpg = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.jpg";
                    if ( file_exists( $c_pic_jpg)) {
                        unlink( $c_pic_jpg);
                    }

                    $c_pict_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.png";
                    if ( file_exists( $c_pict_png)) {
                        unlink( $c_pict_png);
                    }
                    $c_pic_png = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.png";
                    if ( file_exists( $c_pic_png)) {
                        unlink( $c_pic_png);
                    }

                    $c_pict_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c_t.gif";
                    if ( file_exists( $c_pict_gif)) {
                        unlink( $c_pict_gif);
                    }
                    $c_pic_gif = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$imageid."c.gif";
                    if ( file_exists( $c_pic_gif)) {
                        unlink( $c_pic_gif);
                    }
                    break;
                }
            }


            chmod ( $_FILES[$image]['tmp_name'], 0644);

            // copy image
            move_uploaded_file ( $_FILES[$image]['tmp_name'], $af_dir_ads.$imageid.$itrail.".".$thispicext);

            // create thumbnail
            switch ($af_size[2]) {
                case 1 : $src = ImageCreateFromGif( $af_dir_ads.$imageid.$itrail.".".$thispicext); break;
                case 2 : $src = ImageCreateFromJpeg( $af_dir_ads.$imageid.$itrail.".".$thispicext); break;
                case 3 : $src = ImageCreateFromPng( $af_dir_ads.$imageid.$itrail.".".$thispicext); break;
            }

            $width_before  = ImageSx( $src);
            $height_before = ImageSy( $src);

            if ( $width_before  >= $height_before) {
                $width_new = min(100, $width_before);
                $scale = $width_before / $height_before;
                $height_new = round( $width_new / $scale);
            }
            else {
                $height_new = min(75, $height_before);
                $scale = $height_before / $width_before;
                $width_new = round( $height_new / $scale);
            }

            $dst = ImageCreateTrueColor( $width_new, $height_new);

            // GD Lib 2
            ImageCopyResampled( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

            // GD Lib 1
            //ImageCopyResized( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

            switch ($af_size[2]) {
                case 1 : ImageGIF( $dst, $af_dir_ads.$imageid.$itrail."_t.".$thispicext); break;
                case 2 : ImageJPEG( $dst, $af_dir_ads.$imageid.$itrail."_t.".$thispicext); break;
                case 3 : ImagePNG( $dst, $af_dir_ads.$imageid.$itrail."_t.".$thispicext); break;
            }

            imagedestroy( $dst);
            imagedestroy( $src);


            // DB updaten
            if ( $isNewImage == 1) {
                $sql = "UPDATE #__marketplace_ads
                     SET ad_image = ad_image + 1, date_lastmodified = CURRENT_DATE()
                     WHERE id = $imageid";
            }
            else { // isNewImage==0
                $sql = "UPDATE #__marketplace_ads
                     SET date_lastmodified = CURRENT_DATE()
                     WHERE id = $imageid";
            }

            $database->setQuery( $sql);

            if ($database->getErrorNum()) {
                echo $database->stderr();
            } else {
                $database->query();
            }


        }
    }
}

/********************************************************************************************************/

function listTypes($option) {
    global $database, $mosConfig_absolute_path, $mosConfig_list_limit, $mainframe;;

    $option = mosGetParam( $_REQUEST, 'option');

    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

    $database->setQuery("SELECT count(*) FROM #__marketplace_types"  );
    $rowcount = $database->loadResult();

    if ($database -> getErrorNum()) {
        echo $database -> stderr();
        return false;
    }

    require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $rowcount, $limitstart, $limit);

    $database->setQuery( "SELECT * FROM #__marketplace_types ORDER BY sort_order LIMIT ".$limitstart.", ".$limit);
    $rows = $database->loadObjectList();

    HTML_marketplace::listTypes($option, $rows, $pageNav);
    return true;
}



function publishType( $option, $publish=1 ,$cid )
{
    global $database;

    if (!is_array( $cid ) || count( $cid ) < 1) {
        $action = $publish ? 'publish' : 'unpublish';
        echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode( ',', $cid );

    $database->setQuery( "UPDATE #__marketplace_types SET published='$publish'"
    . "\nWHERE id IN ($cids)"
    );
    if (!$database->query()) {
        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        exit();
    }

    mosRedirect( "index2.php?option=$option&act=types" );

}






function saveType($option) {
    global $database;
    $row = new marketplaceType($database);

    // bind it to the table
    if (!$row -> bind($_POST)) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }

    // store it in the db
    if (!$row -> store()) {
        echo "<script> alert('"
        .$row -> getError()
        ."'); window.history.go(-1); </script>\n";
        exit();
    }
    mosRedirect("index2.php?option=$option&act=types", "Type Saved");
}



function deleteType($option, $cid) {
    global $database;
    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
        exit();
    }

    if (count($cid))
    {
        $ids = implode(',', $cid);
        $database->setQuery("DELETE FROM #__marketplace_types \nWHERE id IN ($ids)");
    }
    if (!$database->query()) {
        echo "<script> alert('"
        .$database -> getErrorMsg()
        ."'); window.history.go(-1); </script>\n";
    }
    mosRedirect("index2.php?option=$option&act=types", "Type Deleted");
}



function editType($option, $uid) {
    global $database;

    $row = new marketplaceType($database);
    if($uid){
        $row -> load($uid[0]);
    }

    HTML_marketplace::editType($option, $row);
}



?>
