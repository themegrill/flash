<?php
/**
 * Flash Admin Class.
 *
 * @author  ThemeGrill
 * @package flash
 * @since   1.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Flash_Admin' ) ) :

/**
 * Flash_Admin Class.
 */
class Flash_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'flash' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'flash' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'flash-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		global $flash_version;

		wp_enqueue_style( 'flash-welcome', get_template_directory_uri() . '/css/welcome.css', array(), $flash_version );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $flash_version, $pagenow;

		wp_enqueue_style( 'flash-message', get_template_directory_uri() . '/css/message.css', array(), $flash_version );


		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'flash_admin_notice_welcome', 1 );
		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'flash_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['flash-hide-notice'] ) && isset( $_GET['_flash_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_flash_notice_nonce'], 'flash_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'flash' ) );
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'flash' ) );
			}
			$hide_notice = sanitize_text_field( $_GET['flash-hide-notice'] );
			update_option( 'flash_admin_notice_' . $hide_notice, 1 );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated flash-message">
			<a class="flash-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'flash-hide-notice', 'welcome' ) ), 'flash_hide_notices_nonce', '_flash_notice_nonce' ) ); ?>"><?php _e( 'Dismiss', 'flash' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing Flash! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'flash' ), '<a href="' . esc_url( admin_url( 'themes.php?page=flash-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=flash-welcome' ) ); ?>"><?php esc_html_e( 'Get started with Flash', 'flash' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $flash_version;
		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $flash_version, 0, 3 );
		?>
		<div class="flash-theme-info">
				<h1>
					<?php esc_html_e('About', 'flash'); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( esc_html__( '%s', 'flash' ), $major_version ); ?>
				</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="flash-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.jpg'; ?>" />
				</div>
			</div>
		</div>

		<p class="flash-actions">
			<a href="<?php echo esc_url( 'http://themegrill.com/themes/flash/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'flash' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'flash_demo_url', 'http://demo.themegrill.com/flash/demos/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'flash' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'flash_rating_url', 'http://wordpress.org/support/view/theme-reviews/flash?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'flash' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'flash-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'flash-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'flash-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'flash' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'flash-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'flash' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'flash' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'flash' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'flash' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'flash' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'flash' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://docs.themegrill.com/flash/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'flash' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'flash' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'flash' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support Forum', 'flash' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'flash' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'flash' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'flash' ); ?></a></p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard flash">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'flash' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'flash' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'flash' ) : esc_html_e( 'Go to Dashboard', 'flash' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'View changelog below.', 'flash' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'flash_changelog_file', get_template_directory() . '/README.md' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}

	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins.', 'flash' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'flash' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'flash'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'flash' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'flash'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'flash' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'flash' ); ?></a></li>
			</ol>

		</div>
		<?php
	}
}

endif;

return new Flash_Admin();
