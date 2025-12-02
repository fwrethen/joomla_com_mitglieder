DATE=$(shell LC_ALL=en_GB.utf8 date +'%B %Y')
TAG=$(shell git describe --tags)
VERSION?=$(TAG:v%=%)-dev

ALL: build

.PHONY: clean build package

clean:
	rm -rf build
	rm -rf dist

build: pnpm
	mkdir -p build
	sed -e "s/<version>.*<\/version>/<version>${VERSION}<\/version>/g" \
        -e "s/<creationDate>.*<\/creationDate>/<creationDate>${DATE}<\/creationDate>/g" \
        mitglieder.xml > build/mitglieder.xml
	cp -r administrator/ components/ LICENSE.txt script.php build/

package: build
	mkdir -p dist
	cd build && zip -r ../dist/com-mitglieder-$(VERSION).zip *

release-prep:
ifneq (,$(findstring -dev, $(VERSION)))
	@echo "You need to specify a release version with 'VERSION=a.b.c make release-prep'"
	@exit 1
endif
	sed -i -e "s/<version>.*<\/version>/<version>${VERSION}<\/version>/g" \
        -e "s/<creationDate>.*<\/creationDate>/<creationDate>${DATE}<\/creationDate>/g" \
        mitglieder.xml
	git add mitglieder.xml

release-commit: release-prep
	git commit -m "chore: release ${VERSION}"
	@echo "Created release commit"

pnpm:
	pnpm install
	pnpm build
