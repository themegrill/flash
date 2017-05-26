/* jshint node:true */
module.exports = function( grunt ){
	'use strict';

	grunt.initConfig({

		// Setting folder templates.
		dirs: {
			js: 'js',
			css: 'sass'
		},

		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= dirs.js %>/*.js',
				'!<%= dirs.js %>/*.min.js',
				'!<%= dirs.js %>/swiper.jquery.js',
				'!<%= dirs.js %>/swiper.jquery.min.js',
				'!<%= dirs.js %>/flash.js',
				'<%= dirs.js %>/customizer.js'
			]
		},

		// Minify all .js files.
		uglify: {
			 options: {
        		preserveComments: /(?:^!|@(?:license|preserve|cc_on))/
			},
			frontend: {
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>/',
					src: [
						'flash.js'
					],
					dest: '<%= dirs.js %>/',
					ext: '.min.js'
				}]
			},
			vendor: {
				files: {
					//'<%= dirs.js %>/swiper.jquery.min.js': ['<%= dirs.js %>/swiper.jquery.js'],
				}
			}
		},

		// Compile all .scss files.
		sass: {
			options: {
				sourcemap: 'none',
				loadPath: require( 'node-bourbon' ).includePaths
			},
			compile: {
				files: [{
					expand: true,
					cwd: '<%= dirs.css %>/',
					src: ['*.scss'],
					dest: '',
					ext: '.css'
				}]
			}
		},

		// Watch changes for assets.
		watch: {
			css: {
				files: [
					'<%= dirs.css %>/*.scss',
					'<%= dirs.css %>/**/*.scss'
				],
				tasks: ['sass']
			},
			js: {
				files: [
					'<%= dirs.js %>/*.js',
					'!<%= dirs.js %>/*.min.js'
				],
				tasks: ['jshint', 'uglify']
			}
		},

		// Generate POT files.
		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'themegrill@gmail.com',
					'language-team': 'ThemeGrill <themegrill@gmail.com'
				}
			},
			dist: {
				options: {
					potFilename: 'flash.pot',
					exclude: [
						'deploy/.*' // Exclude deploy directory
					]
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options: {
				text_domain: 'flash',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src: [
					'**/*.php',
					'!node_modules/**'
				],
				expand: true
			}
		},

		// Compress files and folders.
		compress: {
			options: {
				archive: 'flash.zip'
			},
			files: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!*.zip',
					'!.*/**',
					'!Gruntfile.js',
					'!package.json',
					'!node_modules/**',
					'!sass/**',
					'README.md'
				],
				dest: 'flash',
				expand: true
			}
		},

		// Copy
		copy: {
			facss: {
				files: [{
					cwd: 'bower_components/font-awesome/css',  // set working folder / root to copy
					src: '**/*.css',           // copy all files and subfolders
					dest: 'css/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			fafonts: {
				files: [{
					cwd: 'bower_components/font-awesome/fonts',  // set working folder / root to copy
					src: '**/*',           // copy all files and subfolders
					dest: 'fonts/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			counterup: {
				files: [{
					cwd: 'bower_components/jquery.counterup/',  // set working folder / root to copy
					src: '**/*.js',           // copy all files and subfolders
					dest: 'js/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			isotope: {
				files: [{
					cwd: 'bower_components/isotope/dist/',  // set working folder / root to copy
					src: '**/*.js',           // copy all files and subfolders
					dest: 'js/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			swipercss: {
				files: [{
					cwd: 'bower_components/swiper/dist/css/',  // set working folder / root to copy
					src: '**/*.js',           // copy all files and subfolders
					dest: 'css/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			swiperjs: {
				files: [{
					cwd: 'bower_components/swiper/dist/js/',  // set working folder / root to copy
					src: ['**/*.js', '!maps/*.js', '!swiper.jquery.umd.js', '!swiper.jquery.umd.min.js', '!swiper.js', '!swiper.min.js' ],           // copy all files and subfolders
					dest: 'js/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
		},
		bower: {
			update: {
				//just run 'grunt bower:install' and you'll see files from your Bower packages in lib directory
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
    grunt.loadNpmTasks( 'grunt-contrib-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-bower-task');

	// Register tasks
	grunt.registerTask( 'default', [
		'css',
		'jshint',
		'uglify'
	]);

	grunt.registerTask( 'css', [
		'sass'
	]);

	grunt.registerTask( 'update', [
		'bower',
		'copy',
	]);

	grunt.registerTask( 'dev', [
		'default',
		'makepot'
	]);

	grunt.registerTask( 'potfile', [
		'makepot'
	]);

	grunt.registerTask( 'deploy', [
		'dev',
		'clean',
		'copy'
	]);
};
