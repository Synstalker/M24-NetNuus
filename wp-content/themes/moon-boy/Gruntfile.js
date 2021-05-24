module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      dist: {
        files: {
          'style.css' : 'assets/css/frontend/frontend.scss'
        }
      }
    },
    watch: {
      css: {
        files: '**/*.scss',
        tasks: ['sass','autoprefixer']
      }
    },
    autoprefixer:{
      dist:{
        files:{
          'style.css':'style.css'
        }
      }
    },
    version: {
      project: {
        options: {
          release: 'patch',
          prefix: '\\s*([^\\w][\'"]?[v|V]{1}ersion[\'"]?\\s*[:=]\\s*[\'"]?)'
        },
        src: ['package.json', 'style.css', 'assets/css/frontend/frontend.scss']
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-version');
  grunt.registerTask('default',['sass','autoprefixer']);
}