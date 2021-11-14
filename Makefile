DATE=$(shell LC_ALL=en_GB.utf8 date +'%B %Y')
TAG=$(shell git describe --tags)
VERSION?=$(TAG:v%=%)-dev

ALL: build

.PHONY: clean build package

clean:
	rm -rf build
	rm -rf dist

build: yarn
	mkdir -p build
	sed -e "s/<version>.*<\/version>/<version>${VERSION}<\/version>/g" \
        -e "s/<creationDate>.*<\/creationDate>/<creationDate>${DATE}<\/creationDate>/g" \
        mitglieder.xml > build/mitglieder.xml
	cp -r admin/ components/ LICENSE.txt script.php build/

package: build
	mkdir -p dist
	cd build && zip -r ../dist/com-mitglieder-v$(VERSION).zip *

yarn:
	yarnpkg install
	yarnpkg build
