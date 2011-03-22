<?php
/**
 * Dynamic Content Widget class.
 *
 * @since 0.1
 * 
 * Copyright (C) 2011  Dikhoff Software
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 */

require_once("fv-common.php");

class fv_Dynamic_Content_Widget extends WP_Widget {

	/**
	 * Widget constructor.
	 */
	function fv_Dynamic_Content_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Dynamic Content Widget', 'description' => __('A widget that renders content with a template.', 'dynamic content') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'fv-dynamic-content-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fv-dynamic-content-widget', __('Dynamic Content Widget', 'dynamic content'), $widget_ops, $control_ops );
	}

	/**
	 * Display widget in area.
	 * @see WP_Widget::widget()
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$dcw_slug = $instance['slug'];
		$dcw_template = $instance['subtemplate'];
		
		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;

		if ( $dcw_slug ) {
		    if (is_numeric($dcw_slug)) {
		    	$dcw_id = (int) $dcw_slug;
		    } else {
				$dcw_id = fv_get_ID_by_slug($dcw_slug);
		    }
			if (isset($dcw_id)) {
				$content = new WP_Query();
				$content->query('p=' . $dcw_id . '&post_type=any');
				
				if (!$content->have_posts()) {
					echo "No content found. You probably got the id wrong.";
				}

				while ($content->have_posts()) {
					$content->the_post();
					get_template_part($dcw_template);
				}
			} else {
				echo "No content found. You probably got the slug wrong.";
			}
		}

		echo $after_widget;
	}

	/**
	 * Update fields.
	 * @see WP_Widget::update()
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['slug'] = strip_tags( $new_instance['slug'] );
		$instance['subtemplate'] = strip_tags( $new_instance['subtemplate'] );

		return $instance;
	}

	/**
	 * Display form.
	 * @see WP_Widget::form()
	 */
	function form( $instance ) {
		$defaults = array( 'title' => __('Dynamic content', 'dynamic content'),
		                   'slug' => __('about', 'about'), 
		                   'subtemplate' => ''
		                   );
		$instance = wp_parse_args( (array) $instance, $defaults );
		 ?>
<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
<input id="<?php echo $this->get_field_id( 'title' ); ?>"
	name="<?php echo $this->get_field_name( 'title' ); ?>"
	value="<?php echo $instance['title']; ?>" style="width: 100%;" /></p>

<p><label for="<?php echo $this->get_field_id( 'slug' ); ?>"><?php _e('Slug or id:', 'slug'); ?></label>
<input id="<?php echo $this->get_field_id( 'slug' ); ?>"
	name="<?php echo $this->get_field_name( 'slug' ); ?>"
	value="<?php echo $instance['slug']; ?>" style="width: 100%;" /></p>

		<?php fv_write_subtemplates($this, $instance) ?>

<?php
	}
}
?>