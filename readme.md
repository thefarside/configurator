# Configurator

### Overview

Configurator is essentially a "code snippets" plugin for developers.

It's designed to be an [respectable solution](https://en.wikipedia.org/wiki/Module_pattern) to storing single-use functions and singletons that would otherwise clutter a large WordPress install while utilizing modern design practices such as version control and testing.

Under the hood the plugin itself is a simple autoloader that hooks the initialize method of static classes to the end of `muplugins_loaded`.

> Autoloading follows a mix of [WordPress](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/#naming-conventions) and [PSR-4](https://www.php-fig.org/psr/psr-4/#2-specification) naming specifications.

Modules follow a "static class" design where the `initialize()` method is typically used to hook member functions as callbacks. Ultimately every `.php` file in the `configurator` directory is a module and the only validation is that it follows proper naming conventions and contains a public static method named `initialize`.

It's also worth noting that this plugin and supplied modules don't contain any telemetry, advertisements, branding or 3rd party libraries. Everything is coded following [WordPress coding standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards) and works on a [recommended install](https://make.wordpress.org/hosting/handbook/server-environment/#php-extensions). Above all else, everything included is the full source offered completely for free!

## Requirements

 + PHP 8.3.12
 + Wordpress 6.6.2

### Compatibility

 + Multisite
 + Gutenberg + FSE
 + WooCommerce 9.3.3

## Installation

 + Upload
	+ `mu-plugins` → `wp-content`
 + Upload desired modules
	+ `examples\modules` → `wp-content\mu-plugins\configurator\modules`
 + Upload required dependencies
	+ `examples\helpers` → `wp-content\mu-plugins\configurator\helpers`
 + Upload necessary configurations
	+ `examples\settings\class-my-settings.php` → `wp-content\mu-plugins\configurator\settings`

> *See `examples\settings\class-example.php` for example module configurations.*

## License: GPLv2

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

> This is the minimum license that's inherited from WordPress.