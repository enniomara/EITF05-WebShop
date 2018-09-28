# EITF05-WebShop

Course page: https://www.eit.lth.se/index.php?ciuid=1151&coursepage=7434

## Code structure
* `server` - contains configuration files for the webserver
* `src` - contains the php code used in this project

## Getting started

### Via Docker
First of all make sure [Docker](https://docs.docker.com/install/) and [Docker-Compose](https://docs.docker.com/compose/install/) are installed in your system. 

Docker now requires an account to download, so if you don't want to create an account, use one of the accounts listed [here](http://bugmenot.com/view/docker.com).

Before proceeding with running the webserver, you need to set up certificates for the ssl connection.
The script has been retrieved from [here](https://letsencrypt.org/docs/certificates-for-localhost/).

```
openssl req -x509 -out server/ssl.crt -keyout server/ssl.key \
  -newkey rsa:2048 -nodes -sha256 \
  -subj '/CN=localhost' -extensions EXT -config <( \
   printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth")
```


To run the containers run the following on the folder where `docker-compose.yml` is located:
```
$ docker-compose up
```

#### Tests
The tests available can be run by running the runTests script.
```
$ ./runTests.sh
```

### Other methods
An alternative to docker are stacks like [WAMP](http://www.wampserver.com/en/), [MAMP](https://www.mamp.info/en/), or even installinng the services separately.

Make sure the installed php version is 7.2. Then make sure Apache runs with the `server/httpd.conf` configuration and PHP runs with the `server/php.ini` configuration stored in this repository.
