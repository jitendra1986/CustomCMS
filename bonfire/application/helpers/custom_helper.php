<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    KeyideasGlobal Developer Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */
/**
 * Application Helpers
 *
 * Pulls together various helper functions from across the core modules
 * to ease editing and minimize physical files that need loaded.
 *
 * @package    Bonfire
 * @subpackage Helpers
 * @category   Helpers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/application_helpers.html
 *
 */
if (!function_exists('CurrentMysqlDate')) {

    function CurrentMysqlDate($zone = 'Asia/Calcutta') {
        date_default_timezone_set($zone);
        return date('Y-m-d', time());
    }

}
if (!function_exists('CurrentMysqlDateTime')) {

    function CurrentMysqlDateTime($zone = 'Asia/Calcutta') {
        date_default_timezone_set($zone);
        return date('Y-m-d H:i:s', time());
    }

}
if (!function_exists('ConvertTime')) {

    function ConvertTime($date = '') {
        if ($date) {
            return date("h : i A", strtotime($date));
        }
    }

}
if (!function_exists('ConvertDate')) {

    function ConvertDate($date = '') {
        if ($date) {
            return date("d-M-Y", strtotime($date));
        }
    }

}
if (!function_exists('ConvertDateMysqlFromDT')) {

    function ConvertDateMysqlFromDT($datetime = '') {
        if ($datetime) {
            return date("Y-m-d", strtotime($datetime));
        }
    }

}
if (!function_exists('ConvertTimeMysqlFromDT')) {

    function ConvertTimeMysqlFromDT($datetime = '') {
        if ($datetime) {
            return date("H:i:s", strtotime($datetime));
        }
    }

}

if (!function_exists('ConvertDateMysql')) {

    function ConvertDateMysql($date = '') {
        if ($date) {
            return date("Y-m-d", strtotime($date));
        }
    }

}

if (!function_exists('ConvertDateTime')) {

    function ConvertDateTime($datetime = '') {
        if ($datetime) {
            return date("d-M-Y h:i:s A", strtotime($datetime));
        }
    }

}

if (!function_exists('ConvertDateTimeMysql')) {

    function ConvertDateTimeMysql($datetime = '') {
        if ($datetime) {
            return date("Y-m-d H:i:s", strtotime($datetime));
        }
    }

}

if (!function_exists('GetSiteSetting')) {

    function GetSiteSetting($para) {
        $ci = &get_instance();
        $records = $ci->db
                ->select('site_setting_value')
                ->from('fds_site_setting')
                ->where('site_setting_name', $para)
                ->get()
                ->result();
        return $records[0]->site_setting_value;
    }

}
if (!function_exists('qtypricetotal')) {

    function qtyprilcetotal() {
        $ci = &get_instance();
        $qty = 0;
        $price = 0.00;
        {
            foreach ($ci->cart->contents() as $cart) {

                $qty+=$cart['qty'];
                $price+=$cart['subtotal'];
            }
            echo "(" . $qty . ") items in cart | Rs." . number_format($price, 2);
        }
    }

}
if (!function_exists('Getpages')) {

    function Getpages($option) {
        $ci = &get_instance();
        if ($option === "Header") {
            $ci->db->select('pages_page_title,pages_page_slug');
            $ci->db->from('fds_pages');
            $ci->db->where('pages_header', 'Yes');
            $ci->db->order_by('pages_order');
            $query = $ci->db->get();
            return $query->result();
        } else {
            $ci->db->select('pages_page_title,pages_page_slug');
            $ci->db->from('fds_pages');
            $ci->db->where('pages_footer', 'Yes');
            $ci->db->order_by('pages_order');
            $query = $ci->db->get();
            return $query->result();
        }
    }

}


if (!function_exists('Getresid')) {

    function Getresid() {
        $ci = &get_instance();
        $ci->db->where('id', $ci->session->userdata('user_id'));
        $ci->db->from('fds_users');
        $query = $ci->db->get()->row();
        return $query->restaurant_id;
//       //var_dump($query);
        //var_dump( $ci->session->userdata('user_id')); 
    }

}
//if (!function_exists('Getrestype')) {
//
//    function Getrestype() {
//        $ci = &get_instance();
//        //$ci->db->where('id', $ci->session->userdata('user_id'));
//        $ci->db->from('fds_restaurant');
//        $query = $ci->db->get()->row();
//        $query->restaurant_type;
//       
//        
//    }
//
//}
if (!function_exists('Getuser')) {

    function Getuser() {
        $ci = &get_instance();
        $ci->db->where('id', $ci->session->userdata('user_id'));
        $ci->db->from('fds_users');
        $query = $ci->db->get();
        return $query->result();
      // var_dump($ci->session->all_userdata());
    }

}
?>