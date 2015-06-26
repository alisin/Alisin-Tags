<?php
/**
 * @package sliding_tags
 * @version 2.0
 */
/*
Plugin Name: Sliding Tags
Version: 2.0
Description: Widget which display tags.
Author: Alexander Lisin
Author URI: http://alisin.ru/
*/

define("NUMBERTAGS", "10"); // default number of tags to show
define("VERSION", "2.0"); // plugin version

class Sliding_TagsTagCloudWidget extends WP_Widget {

	function Sliding_TagsTagCloudWidget()
	{
		parent::WP_Widget( false, 'Sliding Tags',  array('description' => 'Sliding Tags Widget') );
	}

	function widget($args, $instance)
	{
		global $Sliding_TagsTagCloud;
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo $Sliding_TagsTagCloud->GetSliding_TagsTagCloud( empty( $instance['ShowPosts'] ) ? NUMBERTAGS : $instance['ShowPosts'] );
		echo $args['after_widget'];
	}

	function update($sliding_instance)
	{
		return $sliding_instance;
	}

	function form($instance)
	{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php  echo 'Title:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('ShowPosts'); ?>"><?php  echo 'Number of Tags to show:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('ShowPosts'); ?>" id="<?php echo $this->get_field_id('ShowPosts'); ?>" value="<?php if ( empty( $instance['ShowPosts'] ) ) { echo esc_attr(NUMBERTAGS); } else { echo esc_attr($instance['ShowPosts']); } ?>" size="3" />
		</p>
		<?php
	}

}

class Sliding_TagsTagCloud {

	function GetSliding_TagsTagCloud($noofposts)
	{
		?>
		<?php

		$terms = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $noofposts));
		$html = '<div class="tagscloud"><ul>';

		foreach ($terms as $term) {
			$tag_link = get_tag_link($term->term_id);
			$jslink = 'javascript:document.location.href=';
			$count = $tag->count;
			$html .= "<li class='{$term->slug}-tag'><a onclick='{$jslink}&apos;{$tag_link}&apos;' href='{$tag_link}' title='{$term->name}' class='sliding-tag'>";
			$html .= "<span class='tag_name'>{$term->name}</span><span class='tag_count'>{$term->count}</span></a></li>";
			}

		$html .= '</ul></div>';
		echo $html;
	}
}

$Sliding_TagsTagCloud = new Sliding_TagsTagCloud();

function sliding_frontend_scripts()
{
	wp_enqueue_style( 'tags-styles', plugins_url() . '/sliding-tags/assets/css/tags-styles.css');	
	wp_enqueue_script( 'tags-script',  plugins_url() .'/sliding-tags/assets/js/tags-script.js', array( 'jquery' ), VERSION, true );
}

function sliding_TagsTagCloud_widgets_init()
{
	register_widget('Sliding_TagsTagCloudWidget');
	add_action( 'wp_enqueue_scripts', 'sliding_frontend_scripts');
}

add_action('widgets_init', 'sliding_TagsTagCloud_widgets_init');

?>