module.exports = function(grunt) {

    function removeExampleExt (string) {
        return string.replace('.example', ''); // ruleset.xml.example ==> ruleset.xml
    }

    //noinspection OctalIntegerJS
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
        },
        mkdir: {
            'create-logs': {
                options: {
                    mode: 0777,
                    create: [
                        'logs/admin',
                        'logs/api',
                        'logs/frontend',
                        'logs/backend'
                    ]
                }
            }
        },
        chmod: {
            'make-editable': {
                options: {
                    mode: '777'
                },
                src: [
                    'app/cache',
                    'app/cache/**',
                    'logs',
                    'logs/**'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-mkdir');
    grunt.loadNpmTasks('grunt-chmod');

    // Run this task after create the project
    grunt.registerTask('init-project', [
        'copy:add-codesniffer-standard',
        'mkdir:create-logs',
        'chmod:make-editable'
    ]);

};