# Localhost Looking Good

![Homepage Localhost](http://i.imgur.com/fjfbkgK.png)

Localhost with a looking good and showing the status of the Virtual Hosts.

## Features

+ Display the localhost projects looking good.
+ Show the Virtual Hosts status.
+ Display the subdirectories, that don't have a index file, looking good.
+ Display custom error messages.

## Installing

Clone the repository into localhost root directory:

> git clone https://github.com/andergtk/localhost-looking-good.git /var/www

Make sure that the directory is empty.

Or [download a ZIP](https://github.com/andergtk/localhost-looking-good/archive/master.zip)
and extract the files to the same folder.

## Setup

Requires Apache installed and mod_rewrite enabled.

If you don't have a Virtual Host configured, see a sample in
`.localhost/virtualhost-sample.conf`.

The only file that you need change something is `.localhost/config.php`.

If you have installed Apache in another directory (not in `/etc/apache2`) you should change the value of the constant `APACHE_DIR` to the correct path.

You can add files to be ignored in the localhost page by adding them in `$ignore` array.

## Contributing

Any suggestion or improvement are wellcome.

## License

The [MIT License](LICENSE).
