'use strict';
module.exports = function(grunt) {

    grunt.initConfig({

        // let us know if our JS is sound
        jshint: {
            options: {
                "bitwise": true,
                "browser": true,
                "curly": true,
                "eqeqeq": true,
                "eqnull": true,
                "es5": true,
                "esnext": true,
                "immed": true,
                "jquery": true,
                "latedef": true,
                "newcap": true,
                "noarg": true,
                "node": true,
                "strict": false,
                "undef": true,
                "globals": {
                    "jQuery": true,
                    "alert": true,
                    "google": true,
                    "InfoBox": true,
                    "themeajax": true,
                    "ajaxurl": true,
                    "smoothScroll": true,
					"TimelineLite": true,
					"TimelineMax": true,
					"TweenLite": true,
					"TweenMax": true,
					"Quart": true,
					"Back": true,
					"_": true,
					"skrollr": true,
					"Favico": true
                }
            },
            all: [
                'Gruntfile.js',
                'assets/js/plugins/app.js',
                'assets/js/plugins/admin-meta.js'
            ]
        },

        // concatenation and minification all in one
        uglify: {
            dist: {
                files: {
					'assets/js/admin-meta.min.js': [
						'assets/js/plugins/admin-meta.js'
					],
					'assets/js/vendor.min.js': [
						'assets/js/vendor/*.js'
					]
                }
            },
            app: {
				options: {
					beautify: true,
					mangle: false
				},
				files: {
					'assets/js/app.min.js': [
						'assets/js/plugins/app.js'
					]
				}
            }
        },
		
		concat: {
			options: {
				stripBanners: true
			},
			dist: {
				src: 'assets/js/vendor/*.js',
				dest: 'assets/js/vendor.min.js',
			},
		},
        // style (Sass) compilation via Compass
        compass: {
            dist: {
                options: {
                    sassDir: 'assets/sass',
                    cssDir: 'assets/css',
					noLineComments: true,
                }
            },
			dev: {
				options: {
					sassDir: 'assets/sass',
					cssDir: 'assets/css',
					noLineComments: true
				}
			}
        },

        // watch our project for changes
        watch: {
            compass: {
                files: [
                    'assets/sass/*'
                ],
                tasks: ['compass']
            },
            js: {
                files: [
                    '<%= jshint.all %>'
                ],
                tasks: ['uglify']
            }
        }
    });

    // load tasks
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	
    // register task
    grunt.registerTask('default', [
        'jshint',
        'compass:dev',
        'concat',
        'watch'
    ]);
	
	grunt.registerTask('release', [
        'jshint',
        'compass:dev',
        'uglify',
        'watch'
    ]);
};