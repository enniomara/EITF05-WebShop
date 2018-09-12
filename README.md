# EITF05-WebShop

Course page: https://www.eit.lth.se/index.php?ciuid=1151&coursepage=7434

## Code structure
* `server` - contains configuration files for the webserver
* `src` - contains the php code used in this project

## Getting started

### Via Docker
First of all make sure [Docker](https://docs.docker.com/install/) and [Docker-Compose](https://docs.docker.com/compose/install/) are installed in your system. 

Docker now requires an account to download, so if you don't want to create an account, use one of the accounts listed [here](http://bugmenot.com/view/docker.com).

To run the containers run the following on the folder where `docker-compose.yml` is located:
```
$ docker-compose up
```

### Other methods
An alternative to docker are stacks like [WAMP](http://www.wampserver.com/en/), [MAMP](https://www.mamp.info/en/), or even installinng the services separately.

Make sure the installed php version is 7.2. Then make sure Apache runs with the `server/httpd.conf` configuration and PHP runs with the `server/php.ini` configuration stored in this repository.
