<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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

	}

	public function create_menu() {
		if ( is_child_theme() ) {
			$theme = wp_get_theme()->parent();
		} else {
			$theme = wp_get_theme();
		}

		/* translators: %s: Theme Name. */
		$theme_page_name = sprintf( esc_html__( '%s Options', 'flash' ), $theme->Name );

		$page = add_theme_page(
			$theme_page_name,
			$theme_page_name,
			'edit_theme_options',
			'flash-options',
			array(
				$this,
				'option_page',
			)
		);

	}

	public function option_page() {
		if ( is_child_theme() ) {
			$theme = wp_get_theme()->parent();
		} else {
			$theme = wp_get_theme();
		}
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
				<h2>
					<?php
					/* translators: %s: Theme Name. */
					echo sprintf( esc_html__( 'Welcome to %s!', 'flash' ), $theme->Name );
					?>
				</h2>
				<p class="about-description">
					<?php
					/* translators: %s: Theme Name. */
					echo sprintf( esc_html__( 'Important links to get you started with %s', 'flash' ), $theme->Name );
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
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-layout">' . esc_html__( 'Starter Demos', 'flash' ) . '</a>', esc_url( 'https://themegrilldemos.com/flash-demos/' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-migrate">' . esc_html__( 'Premium Version', 'flash' ) . '</a>', esc_url( 'http://themegrill.com/themes/flash' ) ); ?></li>
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
