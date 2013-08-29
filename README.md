# Sblog

Sample blog source code for slim framework

This code doesn't work at all.
This code is now going to adapt to new system.

This source code is not for production use yet.


## Install Composer

If you have not installed Composer, do that now.
I prefer to install Composer globally in `/usr/local/bin`,
but you may also install Composer locally in your current working directory.
For this tutorial, I assume you have installed Composer locally.

<http://getcomposer.org/doc/00-intro.md#installation>

and update with 'php composer.phar update'


## Default user

- user id: admin
- password: admin


## Feature

- view blog post
- post comments
- login/logout
- admin
-- create a new blog post
-- delete a blog post
-- edit a blog post

## Composer

- Slim\Twig
- Respect\Validation


## requirement

- PHP 5.3.+
- MySQL 5.+
- composer


## TODO

### Refactoring

- move routing code from index.php to /routes/ directory
- use Slim's config
- use Slim's DI container

### New feature
- layout.html for Admin Menu
- Ajax for Admin Panel
- reply to comments
- pager
- blog category
- user registration
- user profile page
- title, meta description
- beforefilter, afterfilter
- anti-spam
- captcha
- search
- trackback
- ping
- theme system
- plugin system
- widget system
- auto update


## License

MIT


