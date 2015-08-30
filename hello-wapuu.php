<?php
/*
Plugin Name: Hello Wapuu
Plugin URI: http://wp3.jp/
Description: Ja.wordpress.org official character "わぷー(Wapuu)" will tell you about your activity on a dashboard.
Author: Kunitoshi Hoshino
Version: 0.2
Author URI: http://wp3.jp/
Text Domain: hello-wapuu
License: GNU General Public License version 2 or any later version.
*/

/*
Copyright (C) 2011 Kunitoshi Hoshino
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

/*
Copyright of WordPress japanese official character "Wapuu" is Kazuko Kaneuchi.
Character License is GNU General Public License version 2 or any later version as well as WordPress software.
URL: http://ja.wordpress.org/2011/08/10/wordpress-japanese-character-name/
*/

/*
Special Thanks
Wataru Okamoto for source code.
http://wokamoto.wordpress.com/2011/08/19/hello-wapuu/
Hitoshi Omagari for source code.
http://www.warna.info/
Hisayoshi Hattori for translation.
http://www.odysseygate.com/
Mayuko Moriyama for translation.
http://blog.mayuko.me/
*/



// This source code outputs a last contribution day.
function commu_get_last_update(){
	global $wpdb;
	$current_user = wp_get_current_user();
	$date = $wpdb->get_results(
		$wpdb->prepare("
		SELECT MAX(post_date) as last
		FROM $wpdb->posts
		WHERE post_status = 'publish'
		AND post_author = %d
	", (int)$current_user->ID
	)
	);
return $date[0]->last;
}



// This source code adds widget of the dashboard.
function commu_dashboard_widgets() {
	wp_add_dashboard_widget( 'wapuu_dashboard_commu1', __('わぷー メッセージ', 'hello-wapuu' ), 'wapuu_dashboard_commu1' );
	wp_enqueue_style( 'hello-wapuu', plugin_dir_url( __FILE__ ) .'/hello-wapuu.css' );
}
add_action( 'wp_dashboard_setup', 'commu_dashboard_widgets');




// This source code is "Wapuu" widget of the dashboard.
function wapuu_dashboard_commu1(){
global $current_user;
$current_user_name = sprintf(__('%s さん', 'hello-wapuu'),$current_user->display_name);

echo '<div class="wapuu-fukidashi">';
echo '<div><span class="user-name">'. $current_user_name .'</span>';
echo '<span class="large">';

		if (date_i18n("H") > 17) {
			echo __('こんばんわぷー！', 'hello-wapuu' );
		} elseif (date_i18n("H") > 10) {
			echo __('こんにちわぷー！', 'hello-wapuu' );
		} elseif (date_i18n("H") > 3) {
			echo __('おはようわぷー！', 'hello-wapuu' );
		} elseif (date_i18n("H") < 2) {
			echo __('こんばんわぷー！', 'hello-wapuu' );
		} else {
			echo __('夜更かしわぷー！', 'hello-wapuu' );
		}

echo '</span></div>';

echo '<div>';

printf(
	__('今は %1$s %2$s だよ。', 'hello-wapuu' ),
		'<span class="large">'. date_i18n(__('Y年n月j日 l', 'hello-wapuu' )) .'</span>',
		'<span class="large">'. date_i18n(__('G時i分s秒', 'hello-wapuu' )) .'</span>'
	);
echo '</div>';

	$lastdate = mysql2date( __('YmdHi', 'hello-wapuu' ), commu_get_last_update() );
	//echo $lastdate;
	//echo '<br />';

	$now = date_i18n(__('YmdHi', 'hello-wapuu' ));
	//echo $now;
	//echo '<br />';

	$lastdatenow = (strtotime($now)-strtotime($lastdate))/(3600*24);

	$lastdatenow2 = (strtotime($now)-strtotime($lastdate))/(3600);

	$lastdatenow3 = intval($lastdatenow);

	$lastdatenow4 = $lastdatenow2 - ($lastdatenow3 * 24);

	if ($lastdatenow < 1) {
	$interval = sprintf(__('%s 時間', 'hello-wapuu'), floor($lastdatenow2));
	} elseif ($lastdatenow < 365) {
	$interval = sprintf(__('%1$s 日と %2$s 時間', 'hello-wapuu'), floor($lastdatenow), floor($lastdatenow4));
	} else {
	$interval = __('1年以上', 'hello-wapuu');
	}
echo '<div>';

printf(
	__('最後に記事を投稿したのは、 %1$s 最後に記事を投稿してから、 %2$s が経ったよ。', 'hello-wapuu'),
		'<span class="large">'. mysql2date( __('Y年n月j日', 'hello-wapuu'), commu_get_last_update() ). '</span>',
		'<span class="large">'.$interval.'</span>');

echo '</div>';

echo '<div><span class="large">';

	if ($lastdatenow > 365) {
	echo '<p>'.__('心機一転！', 'hello-wapuu').'</p><p>';
	echo __('１年以上ぶりでもいいじゃない！','hello-wapuu').'</p><p>';
	echo __('思い切って記事を書いてみよう！','hello-wapuu').'</p>';
	} elseif ($lastdatenow > 30) {
	echo '<p>'.__('久しぶりに記事を書いてみよう！','hello-wapuu').'</p><p>';
	echo __('思い切って書き始めれば、記事を書くペースもつかめるよ！','hello-wapuu').'</p>';
	} elseif ($lastdatenow > 7) {
	echo '<p>'.__('１週間以上、空いちゃったね。','hello-wapuu').'</p><p>';
	echo __('みんな待ってるよ！','hello-wapuu').'</p><p>';
	echo __('また記事を書いてみよう！','hello-wapuu').'</p>';
	} elseif ($lastdatenow > 1) {
	echo '<p>'.__('いいペースだね！','hello-wapuu').'</p><p>';
	echo __('今日も記事を書いてみよう！','hello-wapuu').'</p>';
	} else {
	echo '<p>'.__('いいペースだね！','hello-wapuu').'</p><p>';
	echo __('今日も記事を書いてみよう！','hello-wapuu').'</p>';
	}

echo '</span></div></div>';
echo '<img src="'. plugin_dir_url( __FILE__ ) .'/wapuu.svg">';

}
