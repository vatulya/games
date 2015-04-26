These some rules for CodeSniffer as standard for proejct Games.
Please configure your IDE to use these rules or run sniffer manually.

To add this standard into CodeSniffer standards list you should:

1. Create dir like:
vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Games

2. Create file "ruleset.xml" in new dir with this content:
<?xml version="1.0"?>
<ruleset name="Games">
    <rule ref="../../../../../../internal/Standard/ruleset.xml"/>
</ruleset>


Please check if relative path is correct and CodeSniffer will find real ruleset.xml .