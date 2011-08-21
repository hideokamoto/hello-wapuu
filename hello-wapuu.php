<?php
/*
Plugin Name: Hello Wapuu
Plugin URI: http://wp3.jp/
Description: WordPress Japanese official character "Wapuu" is plugin to speak a message on a dashboard.
Author: Kunitoshi Hoshino
Version: 0.2
Author URI: http://wp3.jp/
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
Wataru Okamoto : I had him teach a source code.
http://wokamoto.wordpress.com/2011/08/19/hello-wapuu/
Hitoshi Omagari : I had him teach a source code.
http://www.warna.info/
Hisayoshi Hattori : I had him teach English.
http://www.odysseygate.com/
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
	wp_add_dashboard_widget( 'wapuu_dashboard_commu1', __('わぷー メッセージ'), 'wapuu_dashboard_commu1' );
}
add_action('wp_dashboard_setup', 'commu_dashboard_widgets');



// This source code is "Wapuu" widget of the dashboard.
function wapuu_dashboard_commu1(){
	$url2 = preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'back-fukidashi-top.jpg';
	$url3 = preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'back-fukidashi-center.jpg';
	$url4 = preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'back-fukidashi-bottom.jpg';
	$url5 = preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'back-wapuu-right.jpg';
?>
<style type="text/css" charset="utf-8">

#wapuu2 {
	width: 70%;
	margin: 0 0 0 0;
	padding: 0 0 0 0;
	background: url( <?php echo esc_url( $url3 ); ?> ) repeat-y left top;
	background-size: contain;
	float: left;
	max-width: 440px;
}

#wapuu3 {
	margin: 0 0 0 0;
	padding: 0 0 0 0;
	height: 100px;
	background: url( <?php echo esc_url( $url2 ); ?> ) no-repeat left top;
	background-size: contain;
	max-width: 440px;
}

#wapuu4 {
	margin: -100px 0 0 0;
	padding: 5% 15% 5% 10%;
	line-height: 160%;
	background: url( <?php echo esc_url( $url4 ); ?> ) no-repeat left bottom;
	background-size: contain;
	max-width: 440px;
}

#wapuu5 {
	margin: -5px 0 0 0;
	padding: 0 0 0 0;
	background: url( <?php echo esc_url( $url5 ); ?> ) no-repeat right top;
	background-size: contain;
	height: 200px;
	float: left;
	width: 30%;
	max-width: 180px;
}

#wapuu6 {
	margin: 0 0 0 0;
	padding: 0 0 0 0;
	clear: both;
}

.wapuu7 {
	margin: 3px 0 3px 0;
	padding: 0 0 0 0;
}

.wapuu8 {
	margin: 8px 0 8px 0;
	padding: 0 0 0 0;
}

.wapuu9 {
	margin: 3px 0 1px 0;
	padding: 0 0 0 0;
}

.wapuu92 {
	margin: 3px 0 8px 0;
	padding: 0 0 0 0;
}

.wapuu10 {
	margin: 10px 0 3px 0;
	padding: 0 0 0 0;
}

</style>

<?php
	
	echo '<div id="wapuu2">';
	echo '<div id="wapuu3">　</div>';
	echo '<div id="wapuu4">';
	
	
	
	echo '<div class="wapuu9">';
	echo '<font size="+1"><b>';
	global $current_user;
	echo $current_user->display_name;
	echo 'さん';
	echo '</b></font>';
	echo '</div>';
	
	
	
	echo '<div class="wapuu92">';
	if (date_i18n("H") > 17) {
	echo '<font size="+1">こんばんわぷー！</font><br />';
	} elseif (date_i18n("H") > 10) {
	echo '<font size="+1">こんにちわぷー！</font><br />';
	} elseif (date_i18n("H") > 3) {
	echo '<font size="+1">おはようわぷー！</font><br />';
	} elseif (date_i18n("H") < 2) {
	echo '<font size="+1">こんばんわぷー！</font><br />';
	} else {
	echo '<font size="+1">夜更かしわぷー！</font><br />';
	}
	echo '</div>';
	
	
	
	echo '<div class="wapuu8">';
	echo '今は<br />';
	$nowtime1 = date_i18n('Y年n月j日');
	$nowtime2 = date_i18n('G時i分s秒');
	
	echo '<font size="+1">' . $nowtime1 . '</font>';
	
	$youbi1 = date_i18n('w');
	
	if ($youbi1 == 0) {
	echo '<font size="+1">(日)</font><br />';
	}
	if ($youbi1 == 1) {
	echo '<font size="+1">(月)</font><br />';
	}
	if ($youbi1 == 2) {
	echo '<font size="+1">(火)</font><br />';
	}
	if ($youbi1 == 3) {
	echo '<font size="+1">(水)</font><br />';
	}
	if ($youbi1 == 4) {
	echo '<font size="+1">(木)</font><br />';
	}
	if ($youbi1 == 5) {
	echo '<font size="+1">(金)</font><br />';
	}
	if ($youbi1 == 6) {
	echo '<font size="+1">(土)</font><br />';
	}
	
	echo '<font size="+1">' . $nowtime2 . '</font><br />';
	
	echo 'だよ。<br />';
	echo '</div>';
	
	
	
	echo '<div class="wapuu7">';
	echo '最後に記事を投稿したのは、<br />';
	echo '<font size="+1">';
	echo mysql2date( 'Y年n月j日', commu_get_last_update() );
	echo '</font><br />';
	echo '</div>';
	
	
	
	$lastdate = mysql2date( 'YmdHi', commu_get_last_update() );
	//echo $lastdate;
	//echo '<br />';
	
	$now = date_i18n('YmdHi');
	//echo $now;
	//echo '<br />';
	
	$lastdatenow = (strtotime($now)-strtotime($lastdate))/(3600*24);
	
	$lastdatenow2 = (strtotime($now)-strtotime($lastdate))/(3600);
	
	$lastdatenow3 = intval($lastdatenow);
	
	$lastdatenow4 = $lastdatenow2 - ($lastdatenow3 * 24);
	
	
	
	echo '<div class="wapuu7">';
	echo '最後に記事を投稿してから、<br />';
	if ($lastdatenow < 1) {
	echo '<font size="+1">' . floor($lastdatenow2) . ' 時間</font><br />';
	} elseif ($lastdatenow < 365) {
	echo '<font size="+1">' . floor($lastdatenow) . ' 日と ' . floor($lastdatenow4) . ' 時間</font><br />';
	} else {
	echo '<font size="+1"><b>１年以上</b></font><br />';
	}
	echo 'が経ったよ。<br />';
	echo '</div>';
	
	
	
	echo '<div class="wapuu10">';
	if ($lastdatenow > 365) {
	echo '<font size="+1">心機一転！<br />１年以上ぶりでもいいじゃない！<br />思い切って記事を書いてみよう！</font><br />';
	} elseif ($lastdatenow > 30) {
	echo '<font size="+1">久しぶりに記事を書いてみよう！<br />思い切って書き始めれば、<br />記事を書くペースもつかめるよ！</font><br />';
	} elseif ($lastdatenow > 7) {
	echo '<font size="+1">１週間以上、空いちゃったね。<br />みんな待ってるよ！<br />また記事を書いてみよう！</font><br />';
	} elseif ($lastdatenow > 1) {
	echo '<font size="+1">いいペースだね！<br />今日も記事を書いてみよう！</font><br />';
	} else {
	echo '<font size="+1">いいペースだね！<br />今日も記事を書いてみよう！</font><br />';
	}
	echo '</div>';
	
	
	
	echo '</div>';
	
	echo '</div>';
	
	echo '<div id="wapuu5">　</div>';
	
	echo '<div id="wapuu6">　</div>';
	
}

