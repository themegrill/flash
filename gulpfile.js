/**
 * Gulp workflow for WordPress
 *
 * @author Sanjeev Shrestha
 * @version 1.0.0
 */

/**
 * Load Plugins
 *
 * Load gulp and it's plugin.
 */
var gulp = require( 'gulp' );

// CSS Plugins
var autoprefixer = require( 'gulp-autoprefixer' ); // Prefixes CSS.
var uglifycss = require( 'gulp-uglifycss' ); // Minifies CSS.
var rtlcss = require( 'gulp-rtlcss' ); // Generates RTL CSS.
var sass = require( 'gulp-sass' ); // Compiles sass into CSS.

// JS Plugins
var uglify = require( 'gulp-uglify' ); // Minify JS.

// Utility Plugins
var browserSync = require( 'browser-sync' ).create(); // Reloads browser.
var imagemin = require( 'gulp-imagemin' ); // Minifies Images.
var rename = require( 'gulp-rename' ); // Renames files.
var wpPot = require( 'gulp-wp-pot' ); // Generates translation file.
var zip = require( 'gulp-zip' ); // Compresses into zip file.
var notify = require( 'gulp-notify' ); // Sends notification.

// Linter Plugins
var stylelint = require( 'gulp-stylelint' ); // Checks for the CSS errors.
var eslint = require( 'gulp-eslint' ); // Checks for the JS errors.
var phpcs = require( 'gulp-phpcs' ); //Checks for the php errors and WordPress standards.


/**
 * Project information.
 */
var info = {
	name: 'Flash',
	slug: 'flash',
	url: 'https://themegrill.com/themes/flash/',
	author: 'ThemeGrill',
	authorUrl: 'https://themegrill.com/',
	authorEmail: 'themegrill@gmail.com',
	teamEmail: '',
	localUrl: 'flash.local'
};

/**
 * Defines paths
 */
var paths = {
	scss: {
		src: './assets/sass/**/*.scss',
		dest: './'
	},

	css: {
		src: [ './assets/css/*.css', '!./assets/css/*.min.css' ],
		dest: './assets/css'
	},

	rtlcss: {
		src: [ './style.css' ],
		dest: './'
	},

	prefixStyles: {
		src: './*.css',
		dest: './'
	},

	lintFiles: {
		php: [
			'./*.php',
			'./inc/**/*.php',
			'!./inc/kirki/**',
			'!./inc/tgm-plugin-activation/**',
			'./inc/widgets/*.php',
			'./template-parts/**/*.php'
		],
		styles: [ './assets/sass/**/*.scss' ],
		js: [ './assets/js/*-custom.js', '!./assets/js/*.min.js' ]
	},

	js: {
		src: [ './assets/js/*.js', '!./assets/js/*.min.js' ],
		dest: './assets/js/'
	},

	php: {
		src: [
			'./*.php',
			'./inc/*.php',
			'./inc/customizer/**/*.php',
			'./template-parts/**/*.php'
		]
	},

	img: {
		src: [ './assets/img/**' ],
		dest: './assets/img'
	},

	zip: {
		src: [
			'**',
			'!vendor',
			'!vendor/**',
			'!node_modules',
			'!node_modules/**',
			'!assets/sass',
			'!assets/sass/**',
			'!dest.xml',
			'!dist',
			'!dist/**',
			'!*.json',
			'!*.md',
			'!gulpfile.js',
			'!composer.lock',
			'!phpcs.xml'
		],
		dest: './dist'
	}
};

/**
 * Gulp Series Tasks
 *
 * Run task on series.
 */

//  Style tasks
var styles = gulp.series( compileSass, prefixStyles, generateRTLCSS, browserSyncStream );

// Start a front-end development server.
var server = gulp.series( browserSyncStart, watch );

// Test code
var test = gulp.series( lintPHP, lintJS, lintStyle );

// Build
var build = gulp.series( test, minifyCSS, minifyJs, minifyImg, generatePotFile, compressZip );

// Start browserSync
function browserSyncStart( cb ) {
	browserSync.init(
		{
			proxy: info.localUrl
		},
		cb
	);
}

// Reloads the browser
function browserSyncReload( cb ) {
	browserSync.reload();
	cb();
}

// Streams the browser.
function browserSyncStream( cb ) {
	browserSync.stream();
	cb();
}

// Compiles SCSS into CSS.
function compileSass() {
	return gulp
		.src( paths.scss.src )
		.pipe(
			sass( {
				indentType: 'tab',
				indentWidth: 1,
				outputStyle: 'expanded'
			} )
		)
		.pipe( gulp.dest( paths.scss.dest ) )
		.on( 'error', notify.onError() );
}

// Prefixes CSS.
function prefixStyles() {
	return gulp
		.src( paths.prefixStyles.src )
		.pipe(
			autoprefixer( {
				browsers: [ 'last 2 versions' ],
				cascade: false
			} )
		)
		.pipe( gulp.dest( paths.prefixStyles.dest ) )
		.pipe( browserSync.stream() )
		.on( 'error', notify.onError() );
}

// Generates RTL CSS file.
function generateRTLCSS() {
	return gulp
		.src( paths.rtlcss.src )
		.pipe( rtlcss() )
		.pipe( rename( { suffix: '-rtl' } ) )
		.pipe( gulp.dest( paths.rtlcss.dest ) )
		.on( 'error', notify.onError() );
}

// Minify css file
function minifyCSS() {
	return gulp
		.src( paths.css.src )
		.pipe( uglifycss() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( paths.css.dest ) );
}

// Runs all the task of style.
function styles() {
	return gulp.series( compileSass, prefixStyles, generateRTLCSS );
}

// Lint php through phpcs and PHPCompatibility
function lintPHP() {
	return gulp
		.src( paths.lintFiles.php )
		.pipe(
			phpcs( {
				bin: 'vendor/bin/phpcs',
				standard: 'phpcs.xml',
				warningSeverity: 0
			} )
		)
		.pipe( phpcs.reporter( 'log' ) )
		.pipe( phpcs.reporter( 'fail', { failOnFirst: false } ) )
		.on( 'error', notify.onError() );
}

// Lint scss,css file through stylelint
function lintStyle() {
	return gulp
		.src( paths.lintFiles.styles )
		.pipe(
			stylelint( {
				failAfterError: true,
				reporters: [ { formatter: 'string', console: true } ]
			} )
		)
		.on( 'error', notify.onError() );
}

// Lint js files through eslint
function lintJS() {
	return gulp
		.src( paths.lintFiles.js )
		.pipe( eslint() )
		.pipe( eslint.format() )
		.on( 'error', notify.onError() );
}

// Minfies image files.
function minifyImg() {
	return gulp
		.src( paths.img.src )
		.pipe( imagemin() )
		.pipe( gulp.dest( paths.img.dest ) )
		.on( 'error', notify.onError() );
}

// Minifies the js files.
function minifyJs() {
	return gulp
		.src( paths.js.src )
		.pipe( uglify() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( paths.js.dest ) )
		.on( 'error', notify.onError() );
}

// Generates translation file.
function generatePotFile() {
	return gulp
		.src( paths.php.src )
		.pipe(
			wpPot( {
				domain: info.slug,
				package: info.name,
				bugReport: info.authorEmail,
				team: info.teamEmail
			} )
		)
		.pipe( gulp.dest( 'languages/' + info.slug + '.pot' ) )
		.on( 'error', notify.onError() );
}

// Compress theme into a zip file.
function compressZip() {
	return gulp
		.src( paths.zip.src )
		.pipe( zip( info.slug + '.zip' ) )
		.pipe( gulp.dest( paths.zip.dest ) )
		.on( 'error', notify.onError() )
		.pipe( notify( {
			message: 'Great! Package is ready',
			title: 'Build successful'
		}
		) );
}

// Watch for file changes
function watch() {
	gulp.watch( paths.scss.src, styles  );
	gulp.watch( [ paths.js.src, paths.php.src ], browserSyncReload );
}


// Builds the package.
function build() {
	return gulp.series(
		lintPHP,
		lintJS,
		lintStyle,
		compileSass,
		prefixStyles,
		generateRTLCSS,
		minifyCSS,
		minifyImg,
		minifyJs,
		generatePotFile,
		compressZip
	);
}

// define tasks
exports.browserSyncStart = browserSyncStart;
exports.browserSyncReload = browserSyncReload;
exports.browserSyncStream = browserSyncStream;
exports.compileSass = compileSass;
exports.prefixStyles = prefixStyles;
exports.generateRTLCSS = generateRTLCSS;
exports.minifyCSS = minifyCSS;
exports.minifyImg = minifyImg;
exports.minifyJs = minifyJs;
exports.generatePotFile = generatePotFile;
exports.lintPHP = lintPHP;
exports.lintStyle = lintStyle;
exports.lintJS = lintJS;
exports.compressZip = compressZip;
exports.watch = watch;
exports.styles = styles;
exports.test = test;
exports.server = server;
exports.test = test;
exports.build = build;
