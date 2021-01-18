<?php if ( ! defined( 'WP_DEBUG' ) ) {
	die( 'Direct access forbidden.' );
}

function the_core_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'the_core_theme_enqueue_styles' );

class HNB_mobile_custom_menu extends Walker
{
	public function walk($elements)
    {
		$list = array();
		foreach ($elements as $item)
		{
			if($item->url == "#")
                $list[] = '<h2>' . $item->title . '</h2>';
            else
                $list[] = '<a href="' . $item->url . '">' . $item->title . '</a>';
        }
		return join(" ", $list);
    }
}


function replace_mobile_menu()
{
	$HNB_wp_menu = '<div id="hnbmobilemenu"><img src="//assets/images/logo-white-h.png" alt="HNB"><br/><a href="/index.html">Home</a>' . wp_nav_menu(
		array(
			'menu' => 'HNBpages',
			'walker' => new HNB_mobile_custom_menu,
			'container'=> false,
			'items_wrap' => '%3$s',
			'item_spacing' => 'discard',
			'echo' => false
		)
	) . '</div>';
	
	$HNB_wp_menu = str_replace("'", "&apos;", $HNB_wp_menu); 

?>
	<script>	  
		jQuery(window).load(function() {
        	document.getElementById('mobile-menu').innerHTML = '<?php echo $HNB_wp_menu; ?>' ;
		});
	</script>

<?php }

add_action( 'wp_head', 'replace_mobile_menu');

add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

