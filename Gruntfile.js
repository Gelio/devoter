module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        autoprefixer: {
            build: {
                files: {
                    'assets/styles/style.css': 'assets/styles/style.css'
                }
            }
        },

        jshint: {
            all: ['Gruntfile.js', 'assets/js/*.js']
        },

        clean: {
            css: ['assets/styles/style.css']
        },

        cssmin: {
            options: {
                sourceMap: true
            },

            build: {
                files: {
                    'assets/styles/style.min.css': 'assets/styles/style.css'
                }
            }
        },

        sass: {
            options: {
                sourceMap: true
            },

            build: {
                files: {
                    'assets/styles/style.css': 'assets/styles/style.scss'
                }
            }
        },

        scsslint: {
            allFiles: [
                'assets/styles/style.scss'
            ],

            options: {
                colorizeOutput: true
            }
        },

        watch: {
            js: {
                files: ['Gruntfile.js', 'assets/js/*.js'],
                tasks: ['process-js'],

                options: {
                    spawn: false
                }
            },

            scss: {
                files: ['assets/styles/*.scss'],
                tasks: ['compile-scss'],

                options: {
                    spawn: false
                }
            }
        }
    });




    grunt.registerTask('process-js', ['jshint']);
    grunt.registerTask('compile-scss', ['scsslint', 'clean', 'sass', 'autoprefixer', 'cssmin']);
    grunt.registerTask('setup', ['process-js', 'compile-scss']);


    grunt.registerTask('default', ['setup']);
};