<?php


class Htprfb_Widget extends WP_Widget {


	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'my_widget',
			'description' => 'Datenschutzfreundliche Facebook Likebox für deine Fanpage.',
		);
		parent::__construct( 'hootproof_facebook_box', 'HootProof Facebook Box', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

	    echo $args['before_widget'];

		$error = false;

		//Title
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		//Page ID / Slug
		if ( !empty( $instance['page_id'])) {
		    $this->pageID = $instance['page_id'];
		}
		else {
		   echo 'Bitte gib die ID oder den Namen deiner Facebook-Seite im Widget ein. Hier findest du eine Anleitung dazu: https://wordpress.org/plugins/hootproof-like-box';
		   $error = true;
		}

		//App-ID & App-Secret
		if ( !empty( $instance['app_id'] ) && !empty( $instance['app_secret'] ) ) {
		    $this->appID = $instance['app_id'];
		    $this->appSecret = $instance['app_secret'];
		}
		else {
		   echo 'Bitte gib deine App-ID und dein App-Secret im Widget ein. Hier findest du eine Anleitung dazu: https://wordpress.org/plugins/hootproof-like-box';
		   $error = true;
		}

		//Post Limit
		
		if ( !empty( $instance['post_limit'])) {
		    $this->postLimit = intval($instance['post_limit']);
		}
		else {
		   $this->postLimit = 0;
		}
		

		//Max height of the feed container
		if ( !empty( $instance['max_height_feed'])) {
		    $this->maxHeightFeed = $instance['max_height_feed'];
		}
		else {
		   $this->maxHeightFeed = '369';
		}

		//Zeilenumbruch nach Post-Bild?
		if ( !empty( $instance['post_image_row'])) {
		    $this->postImageRow = true;
		}
		else {
		   $this->postImageRow = false;
		}

		if(!$error) {

			//1.: Mittels App-ID und Secret einen Access Token anfragen
			//$accessTokenUrl = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->appID.'%20&client_secret='.$this->appSecret.'&grant_type=client_credentials';
			//$accessToken = wp_remote_retrieve_body( wp_remote_get($accessTokenUrl) );
			$accessToken = 'access_token='.$this->appID.'|'.$this->appSecret;

			//2. die wichtigsten Infos abfragen
			$infoUrl = 'https://graph.facebook.com/v2.8/'.$this->pageID.'?fields=picture,name,cover,link,fan_count&'.$accessToken.'&grant_type=client_credentials';

			$info = wp_remote_retrieve_body( wp_remote_get($infoUrl) );
			$infoJson = json_decode( $info, true );

			echo '<div class="hootproof_like_box">';

			echo '<div class="htpr_page_header" style="background-image: url('.$infoJson['cover']['source'].');">';
			echo '<div class="htpr_page_info">';

			echo '<a href="'.$infoJson['link'].'" target="_blank"><img class="htpr_page_photo" src="'.$infoJson['picture']['data']['url'].'" alt="Profilbild '.$infoJson['name'].'"/></a>';

			echo '<div class="htpr_page_info_inner">';
			echo '<div class="htpr_page_name"><a href="'.$infoJson['link'].'" target="_blank">' . $infoJson['name'] . '</a></div>';


			echo '<div class="htpr_page_likes">' . $infoJson['fan_count'] . ' Likes</div>';


						echo '<div class="htpr_like_button"><a title="Facebook"
				href="' . $infoJson['link'] .'" target="_blank" >
				<img title="Facebook Like Button"
				src="' . HTPRFB_PLUGIN_PATH. '/img/like-button-2015-06.png"
				alt=""
				width="50"
				/>
				</a></div>';


					echo '</div>'; //end htpr_page_info_inner
				echo '</div>'; //end htpr_page_info
				echo '</div>'; //end htpr_page_header

				echo '<div style="clear:both;"></div>';




			/*
			 *  FEED
			 *  2. Mit dem Access Token den Feed abfragen
			 */
			 if($this->postLimit > 0) {

				 echo '<div class="htpr_feed_container" style="max-height: '.$this->maxHeightFeed.'px;">';
				 echo '<h4>Letzte Beiträge auf Facebook:</h4>';

				$feedUrl = 'https://graph.facebook.com/v2.8/' .$this->pageID. '/posts?' . $accessToken . '&limit=' . $this->postLimit . '&fields=link,message,created_time,picture,description';
				$feed = wp_remote_retrieve_body( wp_remote_get($feedUrl) );
				$feedJson = json_decode($feed, true);

				$posts = $feedJson['data'];
				
				try {

				foreach($posts as $post) {

					echo '<div class="htpr_single_post">';


					   //Link-Tags einmalig bauen
					   $linkOpen = ($post['link']) ? '<a href="'.$post['link'].'">' : '';
					   $linkClose = ($post['link']) ? '</a>' : '';

					   if(strlen($post['picture']) > 3) {
						   echo '<div class="htpr_post_image">'.$linkOpen.'<img src="'. $post['picture'] .'" width="130" style="float:left;" alt="Post" />'.$linkClose.'</div>';

						   if($this->postImageRow) echo '<div style="clear:both;"></div>';
					   }

					   $postDate = date('d.m.Y H:i', strtotime($post['created_time']));
					   echo '<strong>' . $linkOpen . $postDate . $linkClose .'</strong>';

					   echo  '<p>'. $post['message'];
					   if($post['link']) echo ' - ' . $linkOpen . 'Zum Link' . $linkClose . ' |';
					   echo ' <a href="'.$infoJson['link'] . 'posts/' . substr(strrchr( $post['id'] , '_' ), 1) .'" target="_blank">Zum Post</a>';
					   echo '</p>';

			 		 	 echo '<div class="clear"></div>';
					echo '</div>';
				}
				
				} catch (Exception $e) {
   					 echo 'Bitte prüfe deine App-ID und App-Secret.';
				}

				echo '</div>'; //htpr_feed_container

			} //end if postLimit > 0

			//Info zum Plugin
			echo '<div class="htpr_widget_info">Plugin von 
			<a href="http://bit.ly/hootprooflikebox" alt="HootProof WordPress Blog" target="_blank" rel="nofollow">HootProof.de</a> 
			<i class="fa fa-info-circle"></i>';


			echo '</div>';


			echo '</div>'; // end <div class="hootproof_like_box">

		} //end if $error
		else {

		   echo '<a href="https://wordpress.org/plugins/hootproof-like-box">' . __('Hier findest du eine Anleitung dazu.', 'htprfb_like_box') . '</a>';
		}


		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$page_id = ! empty( $instance['page_id'] ) ? $instance['page_id'] : 'hootproof';
		$app_id = ! empty( $instance['app_id'] ) ? $instance['app_id'] : '';
		$app_secret = ! empty( $instance['app_secret'] ) ? $instance['app_secret'] : '';
		$post_limit = ! empty( $instance['post_limit'] ) ? $instance['post_limit'] : '0';
		$max_height_feed = !empty( $instance['max_height_feed'] ) ? $instance['max_height_feed'] : '369';
		$post_image_row = !empty( $instance['post_image_row'] ) ? 'true' : 'false';

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Page-ID:' , 'htprfb_like_box'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'page_id' ); ?>" name="<?php echo $this->get_field_name( 'page_id' ); ?>" type="text" value="<?php echo esc_attr( $page_id ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'app_id' ); ?>"><?php _e( 'App-ID:' , 'htprfb_like_box'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'app_id' ); ?>" name="<?php echo $this->get_field_name( 'app_id' ); ?>" type="text" value="<?php echo esc_attr( $app_id ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'app_secret' ); ?>"><?php _e( 'App-Secret:' , 'htprfb_like_box'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'app_secret' ); ?>" name="<?php echo $this->get_field_name( 'app_secret' ); ?>" type="text" value="<?php echo esc_attr( $app_secret ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'post_limit' ); ?>"><?php _e( 'Number of posts to display:' , 'htprfb_like_box'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_limit' ); ?>" name="<?php echo $this->get_field_name( 'post_limit' ); ?>" type="text" value="<?php echo esc_attr( $post_limit ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'max_height_feed' ); ?>"><?php _e( 'Max. height of the feed (in pixels):' , 'htprfb_like_box'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'max_height_feed' ); ?>" name="<?php echo $this->get_field_name( 'max_height_feed' ); ?>" type="text" value="<?php echo esc_attr( $max_height_feed ); ?>">
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'post_image_row' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'post_image_row' ); ?>" name="<?php echo $this->get_field_name( 'post_image_row' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'post_image_row' ); ?>"><?php _e( 'Line break after each post image' , 'htprfb_like_box'); ?></label>
		</p>

		<p><a href="https://hootproof.de/facebook-like-box-alternative/">Mehr Informationen zum Plugin</a></p>
		<p><a href="https://de.wordpress.org/plugins/hootproof-like-box/">Plugin-Seite bei WordPress.org</a></p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['page_id'] = ( ! empty( $new_instance['page_id'] ) ) ? strip_tags( $new_instance['page_id'] ) : '';
		$instance['app_id'] = ( ! empty( $new_instance['app_id'] ) ) ? strip_tags( $new_instance['app_id'] ) : '';
		$instance['app_secret'] = ( ! empty( $new_instance['app_secret'] ) ) ? strip_tags( $new_instance['app_secret'] ) : '';
		$instance['post_limit'] = ( ! empty( $new_instance['post_limit'] ) ) ? strip_tags( $new_instance['post_limit'] ) : '0';
		$instance['max_height_feed'] = ( ! empty( $new_instance['max_height_feed'] ) ) ? strip_tags( $new_instance['max_height_feed'] ) : '';
		$instance['post_image_row'] =  $new_instance['post_image_row'];

		return $instance;
	}
}
