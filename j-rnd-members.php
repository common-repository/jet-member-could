<?php
/*
Plugin Name: Jet Random Members Widget
URI: http://milordk.ru
Author: Jettochkin
Author URI: http://milordk.ru
Plugin URI: http://milordk.ru/r-lichnoe/opyt-l/cms/prodolzhaem-widget-o-stroenie-jet-random-members-widget.html
Donate URI: http://milordk.ru/uslugi.html
Description: ru-Вывод случайных пользователей в виде аватар. en-Provides random avatart members.  For BuddyPress 1.2.5.x use: <a href="http://wordpress.org/extend/plugins/jet-unit-site-could/">Jet Site Unit Could</a>
Tags: BuddyPress, Wordpress MU, meta, members, widget
Version: 1.3
*/
?>
<?php

class JetRandomMMetaList extends WP_Widget {
	function JetRandomMMetaList() {
		parent::WP_Widget(false, $name = __('Jet Random Members Meta List','jetrandommmetalist') );
	}

	function widget($args, $instance) {
		extract( $args );
		echo $before_widget;
		$keytitle = $instance['jmtitle']; ?>
<?php if ( $keytitle ) { ?>
		<a href="<?php echo get_option('home') ?>/<?php echo BP_MEMBERS_SLUG ?>" title="<?php _e( 'Members', 'buddypress' ) ?>">
<?php } ?>
		<?php echo $before_title.$instance['title'].$after_title; ?>
<?php if ($keytitle ) { ?>
		</a>
<?php } ?>
		<?php $argj = 'type=random&max='.$instance["number"];
		    $keytitle = $instance["keytitle"]
		 ?>
<?php if (BP_VERSION == '1.1.3') { ?>
		 <?php if ( bp_has_site_members( $argj ) ) : ?>
			<div class="avatar-block">
					<?php while ( bp_site_members() ) : bp_the_site_member(); ?>

							<span class="item-avatar">
							<a href="<?php bp_the_site_member_link() ?>" title="<?php bp_the_site_member_name() ?>"><?php bp_the_site_member_avatar() ?></a>
							</span>
					<?php endwhile; ?>	
			</div>
				<?php do_action( 'bp_directory_members_featured' ) ?>	
				
			<?php else: ?>

				<div id="message" class="info">
					<p><?php _e( 'There are not enough members to feature.', 'buddypress' ) ?></p>
				</div>

			<?php endif; ?>
<?php } ?>
<?php if (BP_VERSION == '1.2.3'){ ?>

			<?php if ( bp_has_members( $argj ) ) : ?>
				<div class="avatar-block">
					<?php while ( bp_members() ) : bp_the_member(); ?>

							<span class="item-avatar">
							<a href="<?php bp_member_link() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar() ?></a>
							</span>

					<?php endwhile; ?>	
				</div>							
				<?php do_action( 'bp_directory_members_featured' ) ?>	
				
			<?php else: ?>

				<div id="message" class="info">
					<p><?php _e( 'There are not enough members to feature.', 'buddypress' ) ?></p>
				</div>

			<?php endif; ?>

<?php } ?>			

<?php if ((BP_VERSION == '1.2.4.1') || (BP_VERSION == '1.2.5')) { ?>

			<?php if ( bp_has_members( $argj ) ) : ?>
				<div class="avatar-block">
					<?php while ( bp_members() ) : bp_the_member(); ?>

							<span class="item-avatar">
							<a href="<?php bp_member_link() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar('type=thumb&width=50&height=50') ?></a>
							</span>

					<?php endwhile; ?>	
				</div>							
				<?php do_action( 'bp_directory_members_featured' ) ?>	
				
			<?php else: ?>

				<div id="message" class="info">
					<p><?php _e( 'There are not enough members to feature.', 'buddypress' ) ?></p>
				</div>

			<?php endif; ?>

<?php } ?>

<?
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['jmtitle'] = strip_tags($new_instance['jmtitle']);	
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number'=>''));
		$title = strip_tags( $instance['title']); 
		$number = strip_tags( $instance['number']);
		$jmtitle = strip_tags( $instance['jmtitle']); ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'buddypress'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo attribute_escape( stripslashes( $title ) ); ?>" /></label></p>
		<p><?php 
		if (WPLANG == 'ru_RU' or WPLANG == 'ru_RU_lite' ) { echo 'Количество пользователей для отображения:'; } else { echo 'Members count for show:'; }
		?></p>
		<p><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo attribute_escape( stripslashes( $number ) ); ?>" /></label></p>
<p><?php if ( WPLANG == 'ru_RU' or WPLANG == 'ru_RU_litle') { 
            echo 'Использовать ссылку на всех пользователей:';
        }else{
                echo 'To use the link for the all users:';
        } ?>&nbsp;
		<input class="checkbox" type="checkbox" <?php if ($jmtitle) {echo 'checked="checked"';} ?> id="<?php echo $this->get_field_id('jmtitle'); ?>" name="<?php echo $this->get_field_name('jmtitle'); ?>" value="1" /></p>

<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("JetRandomMMetaList");'));

?>