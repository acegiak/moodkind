<?php


/*
    Plugin Name: MoodKind
    Plugin URI: https://github.com/acegiak/
    Description: Just adds a mood tracking kind to post-kinds
    Version: 1.1.1
    Author: Ashton McAllan
    Author URI: http://www.acegiak.net
    License: GPLv2
*/

/*  Copyright 2011 Ashton McAllan (email : acegiak@machinespirit.net)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/



add_filter('kind_strings','moodkind_strings_filter');

function moodkind_strings_filter($strings){
	$strings['mood'] = _x('Mood','Post kind');
	return $strings;
}
add_filter('kind_strings_plural','moodkind_strings_plural_filter') ;

function moodkind_strings_plural_filter($strings){ 
        $strings['mood'] = _x('Moods','Post kind');
	return $strings;
}

add_filter('kind_verbs','moodkind_verbs_filter') ;

function moodkind_verbs_filter($strings){ 
        $strings['mood'] = _x('Felt','Post kind');
	return $strings;
}

add_filter('kind_properties','moodkind_properties_filter') ;

function moodkind_properties_filter($strings){ 
        $strings['mood'] = 'mood';
	return $strings;
}

add_filter('kind-icon','moodkind_icon_filter',10,2);

function moodkind_icon_filter($icon,$slug){
	if($slug == 'mood'){
	$icon = '<span class="kind-icon">' . wp_remote_retrieve_body( wp_remote_get( plugin_dir_url( __FILE__) . 'svg/' . $slug . '.svg' ) ) . '</span>';
	}
return $icon;
}

add_filter ('kind-response-display','moodkind_response_display_filter',10,2);

function moodkind_response_display_filter($content, $post_ID){

$moodvalue = get_post_meta($post_ID,'mf2_moodvalue',true);
if($moodvalue < 1){
	$moodvalue = $moodvalue * 100;
}
$content = preg_replace('`h-cite response`', 'h-cite response p-mood',$content);
$content = preg_replace('`</a>`', '</a>('.print_r($moodvalue,true).'%)',$content);


return $content;
}

