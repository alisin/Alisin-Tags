<?php
/*
Plugin Name: Sliding Tags
Version: 1.0
Description: Widget which displays tags
*/

define("NUMBERTAGS", "20"); // default number of tags to show
define("CODFRONT_PACK_VERSION", "1.0"); // plugin version

class Sliding_TagsTagCloudWidget extends WP_Widget {

	function Sliding_TagsTagCloudWidget()
	{
		parent::WP_Widget( false, 'Sliding Tags',  array('description' => 'Sliding Tags Widget') );
	}

	function widget($args, $instance)
	{
		global $CodFront_TagsTagCloud;
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo $CodFront_TagsTagCloud->GetCodFront_TagsTagCloud(  empty( $instance['ShowPosts'] ) ? NUMBERTAGS : $instance['ShowPosts'], empty( $instance['ColorsArray'] ) ? "#0033CC, #000000, #00FFFF, #FF3300, #C2C2A3, #CC0098, #990033, maroon, #6600FF, #009932, #FFCCCC, #006666, #336600, #66FF32, #999966, #996633" : $instance['ColorsArray'] );
		echo $args['after_widget'];
	}

	function update($codfront_instance)
	{
		return $codfront_instance;
	}

	function form($instance)
	{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php  echo 'Title:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('ShowPosts'); ?>"><?php  echo 'Number of Tags to show:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('ShowPosts'); ?>" id="<?php echo $this->get_field_id('ShowPosts'); ?>" value="<?php if ( empty( $instance['ShowPosts'] ) ) { echo esc_attr(DefNoOfPosts); } else { echo esc_attr($instance['ShowPosts']); } ?>" size="3" />
		</p>
		<?php
	}

}

class Sliding_TagsTagCloud {

	function GetSliding_TagsTagCloud($noofposts, $colorsarray)
	{

		?>
		<?php

		$terms = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $noofposts));
		$html = '<div class="tagscloud"><ul>';

		foreach ($terms as $term) {
			$tag_link = get_tag_link($term->term_id);
			$jslink = 'javascript:document.location.href=';
			$count = $tag->count;
			$html .= "<li class='{$term->slug}-tag'><a onclick='{$jslink}&apos;{$tag_link}&apos;' href='{$tag_link}' title='{$term->name}' class='codfront-tag'>";
			$html .= "<span class='tag_name'>{$term->name}</span> <span class='tag_count'>{$term->count}</span></a></li>";
			}

		$html .= '</ul></div>';
		echo $html;
	}
}

$Sliding_TagsTagCloud = new Sliding_TagsTagCloud();

function sliding_frontend_scripts()
{
	wp_enqueue_style( 'tags-styles', plugins_url() . '/codfront-tags/assets/css/tags-styles.css');	
	wp_enqueue_script( 'tags-script',  plugins_url() .'/codfront-tags/assets/js/tags-script.js', array( 'jquery' ), CODFRONT_PACK_VERSION, true );
}

function CodFront_TagsTagCloud_widgets_init()
{
	register_widget('Sliding_TagsTagCloudWidget');
	add_action( 'wp_enqueue_scripts', 'codfront_frontend_scripts');
}

add_action('widgets_init', 'Sliding_TagsTagCloud_widgets_init');

?>
