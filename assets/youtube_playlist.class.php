<?php

 require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
 Zend_Loader::loadClass('Zend_Gdata_YouTube'); 

/**
 * Adds Foo_Widget widget.
 */
class SWD_YouTube_Playlists_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'SWD_YouTube_Playlists_Widget', // Base ID
			__('You Tube Playlist', 'SWD_TL'), // Name
			array( 'description' => __( 'This widget will allow the admnistrator to add his/her playlists from youtube to a sidebar', 'SWD_TL' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$playlist_url = apply_filters( 'widget_title', $instance['playlist_url'] );

		// assuming $yt is a fully authenticated service object, set the version to 2
		// to retrieve additional metadata such as yt:uploaded and media:credit
		$options = get_option( 'you_tube_options', array() );
		$options = empty($options) ? 'YouTube' : $options['username'];
		$you_tube = new Zend_Gdata_YouTube();
		$you_tube->setMajorProtocolVersion(2);
		$playlistListFeed = $you_tube->getPlaylistListFeed($options);

		foreach ($playlistListFeed as $playlistListEntry) {
			if( $playlistListEntry->getPlaylistVideoFeedUrl() == $playlist_url){
				echo '<h1>' . $playlistListEntry->title->text . "</h1>";
				echo '<p>' . $playlistListEntry->description->text . "</p>";
				$playlistVideoFeed = $you_tube->getPlaylistVideoFeed($playlistListEntry->getPlaylistVideoFeedUrl());

				// Print out metadata for each video in the playlist
				echo '<ul class="tl_youtube_single_playlist">';
				foreach ($playlistVideoFeed as $playlistVideoEntry) {
					echo '<li>';
					$videoThumbnails = $playlistVideoEntry->getVideoThumbnails();
					echo '<a href="http://www.youtube.com/watch?v=' . $playlistVideoEntry->getVideoId() . '" 
					rel="wp-video-lightbox" title="' . $playlistVideoEntry->getVideoDescription() . '"><img src="' . $videoThumbnails[2]['url'] . '"/></a> </p>';
					echo '</li>';
				}
				echo '</ul>';
				echo '<hr>';
			}
		}
	    
	    
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'playlist_url' ] ) ) {
			$playlist_url = $instance[ 'playlist_url' ];
		}
		else {
			$playlist_url = __( 'New title', 'SWD_TL' );
		}
		$options = get_option( 'you_tube_options', array() );
		$options = empty($options) ? 'YouTube' : $options['username'];
		$you_tube = new Zend_Gdata_YouTube();
		$you_tube->setMajorProtocolVersion(2);
		$playlistListFeed = $you_tube->getPlaylistListFeed($options);  ?>

		<p>
		<label for="<?php echo $this->get_field_id( 'playlist_url' ); ?>"><?php _e( 'Playlist' ); ?></label> 
		<select  id="<?php echo $this->get_field_id( 'playlist_url' ); ?>" name="<?php echo $this->get_field_name( 'playlist_url' ); ?>" style="width:175px;"><?php
			
		    foreach ($playlistListFeed as $playlistListEntry) {
		      // This function is defined in the next section
		      
		      $selected = $playlistListEntry->getPlaylistVideoFeedUrl() == $playlist_url ? 'selected="selected"' : "";
		      echo '<option ' . $selected . ' value="' . $playlistListEntry->getPlaylistVideoFeedUrl() . '">';
		      echo $playlistListEntry->title->text;
		      echo '</option>';
		      # code...
		   	} ?>
		</select>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['playlist_url'] = ( ! empty( $new_instance['playlist_url'] ) ) ? strip_tags( $new_instance['playlist_url'] ) : '';
		return $instance;
	}

} // class Foo_Widget

?>