module.exports = function(grunt) {

    function removeExampleExt (string) {
        return string.replace('.example', ''); // ruleset.xml.example ==> ruleset.xml
    }

    grunt.initConfig({
        copy: {
            'add-codesniffer-standard': {
                files: [
                    {
                        expand: true,
                        cwd: 'internal/Standard/',
                        src: ['ruleset.xml.example'],
                        dest: 'vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Games/',
                        filter: 'isFile',
                        rename: function (dest, src) {
                            return dest + removeExampleExt(src);
                        }
                    }
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');

    // Run this task after create the project
    grunt.registerTask('init-project', ['copy:add-codesniffer-standard']);

};