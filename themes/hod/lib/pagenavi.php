<?php

$statement_meta = null;

function remove_post_navigation_above() {
        remove_all_actions('thematic_navigation_above');
}
add_action('init', 'remove_post_navigation_above');

function wp_pagenavi($before = '', $after = '') {
	global $wpdb, $wp_query, $pageposts, $querystr;
	if (is_single()) return;

	$page_list_text = __('');
	$next_page_text = __('Neste &raquo;');
	$prev_page_text = __('&laquo; Forrige');
	$first_page_text = "&laquo; Første";
	$last_page_text = "Siste &raquo;";
	
	if ($querystr) {
		$querystr = substr($querystr, 0, strpos($querystr, "ORDER"));
		$navposts = $wpdb->get_results($querystr, OBJECT);
		
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = sizeof($navposts);
		$max_page = ceil($numposts / $posts_per_page);
	}
	else {
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
	}
	
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 10;
	$larger_page_to_show = 3;
	$larger_page_multiple = 10;
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	$larger_per_page = $larger_page_to_show*$larger_page_multiple;
	$larger_start_page_start = (n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
	$larger_start_page_end = n_round($start_page, 10) + $larger_page_multiple;
	$larger_end_page_start = n_round($end_page, 10) + $larger_page_multiple;
	$larger_end_page_end = n_round($end_page, 10) + ($larger_per_page);
	if($larger_start_page_end - $larger_page_multiple == $start_page) {
		$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
		$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
	}
	if($larger_start_page_start <= 0) {
		$larger_start_page_start = $larger_page_multiple;
	}
	if($larger_start_page_end > $max_page) {
		$larger_start_page_end = $max_page;
	}
	if($larger_end_page_end > $max_page) {
		$larger_end_page_end = $max_page;
	}
	if ($max_page > 1) {
		echo $before.'<div class="wp-pagenavi">'."\n";

		echo '<div class="legend">';
		echo '<span class="desc">Sidenavigering</span> ';
		echo '<span class="pages">('.$max_page.' sider)</span>';
		echo '</div>';
		
		echo '<ul class="navbar">';
		
		// First page
		echo '<li class="first">';
		if ($paged != 1) {
			echo '<a href="'.get_pagenum_url().'" title="'.$first_page_text.'">'.$first_page_text.'</a>';
		}
		echo '</li>';
		
		// Previous page
		$prevpage = intval($paged) - 1;
		echo '<li class="previous">';
		if ($prevpage > 0) {
			echo '<a href="'.get_pagenum_url($prevpage).'" title="'.$prev_page_text.'">'.$prev_page_text.'</a>';
		}
		echo '</li>';
		
		// Page list
		if ($start_page >= 2 && $pages_to_show < $max_page) {
			echo '<li class="extend">&hellip;</li>';
		}
		if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
			for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
				$page_text = $page_list_text.number_format_i18n($i);
				echo '<li><a href="'.get_pagenum_url($i).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
			}
		}
		for($i = $start_page; $i  <= $end_page; $i++) {						
			if($i == $paged) {
				$current_page_text = $page_list_text.number_format_i18n($i);
				echo '<li class="current">'.$current_page_text.'</li>';
			} else {
				$page_text = $page_list_text.number_format_i18n($i);
				echo '<li><a href="'.get_pagenum_url($i).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
			}
		}
		if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
			for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
				$page_text = $page_list_text.number_format_i18n($i);
				echo '<li><a href="'.get_pagenum_url($i).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
			}
		}
		if ($end_page < $max_page) {
			echo '<li class="extend">&hellip;</li>';
		}
		
		// Next page
		$nextpage = intval($paged) + 1;
		echo '<li class="next">';
		if ($nextpage <= $max_page) {
			echo '<a href="'.get_pagenum_url($nextpage).'" title="'.$next_page_text.'">'.$next_page_text.'</a>';
		}
		echo '</li>';
		
		// Last page
		echo '<li class="last">';
		if ($paged < $max_page) {
			echo '<a href="'.get_pagenum_url($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a>';
		}
		echo '</li>';
		
		echo '</ul></div>'.$after."\n";
	}
}

function get_pagenum_url($i=1) {
	global $post, $wp_query, $statement_meta;
	if (strpos($_SERVER['REQUEST_URI'], '/'.get_theme_option('slug_statements').'/') !== false) {
		if (!$statement_meta) $statement_meta = get_statement_meta($post->ID);
		
		if ($_SERVER['QUERY_STRING']) $qs = "?".$_SERVER['QUERY_STRING'];
		return $statement_meta->topic_url.get_theme_option('slug_statements')."/side/".$i."/".$qs;
	}
	return esc_url(get_pagenum_link($i));
}

### Function: Round To The Nearest Value
function n_round($num, $tonearest) {
   return floor($num/$tonearest)*$tonearest;
}

?>