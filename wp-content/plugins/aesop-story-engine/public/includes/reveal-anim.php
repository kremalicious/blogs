<?php


/**
 * Output codes for scroll reveal animation, pluggable
 * @since 1.9.4
 */
if ( ! function_exists( 'aesop_scroll_reveal_animation' ) ) {
	function aesop_scroll_reveal_animation($component, $atts, $unique) 
	{  
		switch ($component) {
			case 'image':
				$id = '#aesop-image-component-'.esc_html( $unique );		     
				break;
			case 'quote':
				$id = '#aesop-quote-component-'.esc_html( $unique );		     
				break;
			case 'chapter':
				$id = '#chapter-unique-'.esc_html( $unique );		     
				break;
			case 'video':
				$id = '#aesop-video-'.esc_html( $unique );		     
				break;
			default:
				return;
		}
		?>
		    <script>
			jQuery(document).ready(function(){
				if (!window.sr) {
				   window.sr = ScrollReveal();
				}
		<?php
		switch ($atts['revealfx']) {
			case 'inplace':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '0px', duration: 1000});<?php
				break;
			case 'inplaceslow':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '0px', delay:500, duration: 2000});<?php
				break;
			case 'frombelow':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '200px', duration: 1000});<?php
				break;
			case 'fromleft':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'left', distance: '400px', duration: 1000});<?php
				break;
			case 'fromright':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'right', distance: '400px', duration: 1000});<?php
				break;
		}
		?>
		    });
		    </script>
	    <?php
	}
}


/*
   Aesop reveal animation module
*/

class AesopRevealAnim {

	public function __construct(){
		define( 'PLUGIN_URL', plugins_url( '', __FILE__ ) );
		add_action('aesop_image_inside_top',array($this,'revealfx_image'),10,2);
		add_action('aesop_chapter_inside_top',array($this,'revealfx_chapter'),10,2);
		add_action('aesop_quote_inside_top',array($this,'revealfx_quote'),10,2);
		add_action('aesop_video_inside_top',array($this,'revealfx_video'),10,2);
		
		
		add_filter( 'aesop_avail_components',   array( $this, 'options' ) );
		
	}



	public function revealfx_image($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			
			aesop_scroll_reveal_animation('image', $atts, $unique);
		}	
	}
	
	public function revealfx_video($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			
			aesop_scroll_reveal_animation('video', $atts, $unique);
		}	
	}
	
	public function revealfx_quote($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('quote', $atts, $unique);
		}	
	}
	
	
	public function revealfx_chapter($atts, $unique)
	{	
		if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('chapter', $atts, $unique);
		}	
	}
	
	public function options( $shortcodes ) {
		$custom =  array(
						'type'  => 'select',
						'values'  => array(
						    array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'inplace',
								'name' => __( 'In Place', 'aesop-core' )
							),
							array(
								'value' => 'inplaceslow',
								'name' => __( 'In Place Slow', 'aesop-core' )
							),
							array(
								'value' => 'frombelow',
								'name' => __( 'From Below', 'aesop-core' )
							),
							array(
								'value' => 'fromleft',
								'name' => __( 'From Left', 'aesop-core' )
							),
							array(
								'value' => 'fromright',
								'name' => __( 'From Right', 'aesop-core' )
							)
							
						),
						'default'  => 'off',
						'desc'   => __( 'Reveal Effect', 'aesop-core' ),
						'tip'  => __( 'Animation effect when the component is revealed.', 'aesop-core' )
					
		);
	    $shortcodes['image']['atts']['revealfx'] = $custom ;
		$shortcodes['chapter']['atts']['revealfx'] = $custom ;
		$shortcodes['quote']['atts']['revealfx'] = $custom ;
		$shortcodes['video']['atts']['revealfx'] = $custom ;

		return $shortcodes;

	}

}

new AesopRevealAnim;
