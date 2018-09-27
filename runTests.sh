#!/bin/sh

ABSPATH=$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd)

docker run -v "$ABSPATH"/src/:/app -w "/app" --rm -it epcallan/php7-testing-phpunit:7.2-phpunit7 phpunit --configuration phpunit.xml --testsuite Unit
