<?php
/*
 * Template Name: [[post-name]] Index
 */

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$fields = get_acf_fields();
$smarty->assign('fields', $fields);

//--Get Post Args

//--Taxonomy Query

$posts = load_posts($args);
$smarty->assign('posts', $posts);

$args['paged']++;
$has_more = (int) (bool) load_posts($args);
$smarty->assign('has_more', $has_more);

$smarty->assign('index_page_url', get_permalink());

$smarty->assign('months', get_months());
//--Get Post Years

//--Assign Taxonomy Filters

//--Assign Post Type

get_header();

$smarty->display('pages/page-[[post-type]].tpl');

get_footer();
