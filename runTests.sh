#!/bin/sh

ABSPATH=$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd)

docker run -v "$ABSPATH"/src/:/app -w "/app" --rm epcallan/php7-testing-phpunit:7.2-phpunit7 phpunit --bootstrap App/autoload.php tests
