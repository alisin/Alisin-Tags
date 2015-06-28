<?php
/**
 * @package sliding_tags
 * @version 1.8
 */
/*
Plugin Name: Sliding Tags
Version: 1.8
Description: Sliding Tags Widget.
Author: Alexander Lisin
Author URI: http://alisin.ru/
*/

define("NUMBERTAGS", "20"); // default number of tags to show
define("VERSION", "1.8"); // plugin version

class TagsTagCloudWidget extends WP_Widget {

	function TagsTagCloudWidget()
	{
		parent::WP_Widget( false, 'Sliding Tags',  array('description' => 'Sliding Tags Widget') );
	}

	function widget($args, $instance)
	{
		global $TagsTagCloud;
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo $TagsTagCloud->GetTagsTagCloud( empty( $instance['ShowTags'] ) ? NUMBERTAGS : $instance['ShowTags'] );
		echo $args['after_widget'];
	}

	function update($sliding_instance, $instance)
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
			<label for="<?php echo $this->get_field_id('ShowTags'); ?>"><?php  echo 'Number of Tags to show:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('ShowTags'); ?>" id="<?php echo $this->get_field_id('ShowTags'); ?>" value="<?php if ( empty( $instance['ShowTags'] ) ) { echo esc_attr(NUMBERTAGS); } else { echo esc_attr($instance['ShowTags']); } ?>" size="3" />
		</p>
		<?php
	}

}

class TagsTagCloud {

	function GetTagsTagCloud($noofposts)
	{
		$terms = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $noofposts));
		$html = '<div class="tagscloud"><ul>';

		foreach ($terms as $term) {
			$tag_link = get_tag_link($term->term_id);
			$jslink = 'javascript:document.location.href=';
			$count = $term->count;
			$html .= "<li class='{$term->slug}-tag'><a onclick='{$jslink}&apos;{$tag_link}&apos;' href='{$tag_link}' title='{$term->name}' class='sliding-tag'>";
			$html .= "<span class='tag_name'>{$term->name}</span><span class='tag_count'>{$term->count}</span></a></li>";
			}

		$html .= '</ul></div>';
		echo $html;
	}

}

$TagsTagCloud = new TagsTagCloud();

function frontend_scripts()
{
	wp_enqueue_style( 'tags-styles', plugin_dir_url( __FILE__ ) . 'assets/css/styles.css');	
	wp_enqueue_script( 'tags-script',  plugin_dir_url( __FILE__ ) .'assets/js/scripts.js', array( 'jquery' ), VERSION, true );
}

function TagsTagCloud_widgets_init()
{
	register_widget('TagsTagCloudWidget');
	add_action( 'wp_enqueue_scripts', 'frontend_scripts');
}

add_action('widgets_init', 'TagsTagCloud_widgets_init');
?>