This file must help to install project Games.

# Phalcon framework

Project Games uses Phalcon Framework:
http://docs.phalconphp.com/en/latest/index.html
This framework must be installed as php extension.


# Composer

Project has php dependencies and uses Composer to manage them:
https://getcomposer.org/doc/00-intro.md

Install composer (globally):
```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

Install all composer-dependencies (run command in project root):
```
composer install
```


# Grunt (npm and nodejs)

Project Games has some additional task and uses Grunt to run them.
But Grunt required NPM, and NPM required Nodejs in your system.

### Nodejs
https://nodejs.org/
Run command:
```
sudo apt-get install nodejs
```

### NPM
https://docs.npmjs.com/getting-started/installing-node
Run command:
```
sudo npm install npm -g
```

### Grunt
http://gruntjs.com/getting-started
Run command:
```
npm install -g grunt-cli
```

Run this command to run preparation task:
```
grunt init-project
```


# IDE

Of course you can use any IDE for development. But I recommend PhpStorm ( https://www.jetbrains.com/phpstorm/ ).
After previous steps you have installed Php CodeSniffer and installed special project's code standard.
So you can configure your IDE to auto-check your code.