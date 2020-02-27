<?php

class Flash_Dashboard {
	private static $instance;

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->setup_hooks();
	}

	private function setup_hooks() {
		add_action( 'admin_menu', array( $this, 'create_menu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'flash-admin-dashboard', get_template_directory_uri() . '/inc/admin/css/dashboard.css' );
	}

	public function create_menu() {
		$page = add_theme_page( 'Flash Options', 'Flash Options', 'edit_theme_options', 'flash-options', array(
			$this,
			'option_page'
		) );

		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'flash-dashboard', get_template_directory_uri() . '/inc/admin/css/dashboard.css', array(), FLASH_THEME_VERSION );
	}

	public function option_page() {
		$theme = wp_get_theme();
		?>
		<div class="wrap">
		<div class="flash-header">
			<h1>
				<?php
				/* translators: %s: Theme version. */
				echo sprintf( esc_html__( 'Flash %s', 'flash' ), $theme->Version );
				?>
			</h1>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'Welcome to Flash!', 'flash' ); ?></h2>
				<p class="about-description">
					<?php
					/* translators: %s: Theme Name. */
					echo sprintf( esc_html__( 'Important links to get you started with %s', 'flash' ), esc_html__( 'Flash', 'flash' ) );
					?>
				</p>

				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Get Started', 'flash' ); ?></h3>
						<a class="button button-primary button-hero"
						   href="<?php echo esc_url( 'https://docs.themegrill.com/flash/#section-1' ); ?>"
						   target="_blank"><?php esc_html_e( 'Learn Basics', 'flash' ); ?>
						</a>
					</div>

					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Next Steps', 'flash' ); ?></h3>
						<ul>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-media-text">' . esc_html__( 'Documentation', 'flash' ) . '</a>', esc_url( 'https://docs.themegrill.com/flash' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-layout">' . esc_html__( 'Starter Demos', 'flash' ) . '</a>', esc_url( 'https://demo.themegrill.com/flash-demos' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon welcome-add-page">' . esc_html__( 'Premium Version', 'flash' ) . '</a>', esc_url( 'http://themegrill.com/themes/flash' ) ); ?></li>
						</ul>
					</div>

					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Further Actions', 'flash' ); ?></h3>
						<ul>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-businesswoman">' . esc_html__( 'Got theme support question?', 'flash' ) . '</a>', esc_url( 'https://wordpress.org/support/theme/flash/' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-thumbs-up">' . esc_html__( 'Leave a review', 'flash' ) . '</a>', esc_url( 'https://wordpress.org/support/theme/flash/reviews/' ) ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

Flash_Dashboard::instance();
