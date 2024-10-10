module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // read the package.json file so we know what packages we have
    pkg: grunt.file.readJSON('package.json'),
    // config options used in the uglify task to minify scripts
    uglify: {
      options: {
        // this adds a message at the top of the file with todays date to indicate build date
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        assets: ['assets/js/*.js'],
        dest: 'assets/js/app.min.js', // Corrected to a single output file
      }
    },
    // config options for the cssmin task to minify stylesheets
    cssmin: {
      minify: {
        files: {
          'assets/css/style.min.css': 'assets/css/style.css', // Compile SCSS to CSS
          'assets/css/fonts.min.css': 'assets/css/fonts.css' // Compile SCSS to CSS
        }
      }
    },
    sass: {
      dist: {
        options: {
          implementation: require('sass'), // Specify the Sass implementation
          style: 'expanded'
        },
        files: {
          'assets/css/style.css': 'assets/css/style.scss', // Compile SCSS to CSS
          'assets/css/fonts.css': 'assets/css/fonts.scss' // Compile SCSS to CSS
        }
      }
    },
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        assets: ['assets/js/*.js'],
        dest: 'assets/js/app.concat.js', // Corrected to a single output file
      }
    },
    jshint: {
      files: ['Gruntfile.js', 'assets/js/*.js', 'test/**/*.js'],
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    watch: {
      css: {
        files: ['assets/css/*.scss'],
        tasks: ['sass', 'cssmin']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-sass');


  // Register tasks
  grunt.registerTask('default', ['uglify', 'sass', 'cssmin', 'watch']);

};
