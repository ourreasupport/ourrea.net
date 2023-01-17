<?php 
/* 
Plugin Name: 按照用户注册时间排序 
Plugin URI: http://blog.wpjam.com/m/order-by-user-registered-time/ 
Description: 显示用户注册时间，并按照用户注册时间排序。 
Version: 0.1 
Author: Denis 
Author URI: http://blog.wpjam.com/ 
*/ 
add_filter('manage_users_columns', function($column_headers){
	$column_headers['registered'] = '注册时间';
	return $column_headers;
});

add_filter('manage_users_custom_column', function($value, $column_name, $user_id){
	if($column_name=='registered'){
		$user = get_userdata($user_id);
		return get_date_from_gmt($user->user_registered);
	}else{
		return $value;
	}
},11,3);


add_filter('manage_users_sortable_columns', function($sortable_columns){
	$sortable_columns['reg_time'] = 'reg_time';
	return $sortable_columns;
});

add_action('pre_user_query', function($query){
	if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='reg_time' ){
		if( !in_array($_REQUEST['order'],array('asc','desc')) ){
			$_REQUEST['order'] = 'desc';
		}
		$query->query_orderby = "ORDER BY user_registered ".$_REQUEST['order']."";
	}
});