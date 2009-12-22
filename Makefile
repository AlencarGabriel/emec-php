#
# Makefile
#

PREFIX=/usr/local/emec-php
SRC_DIR=./

install:
	cp -r $(SRC_DIR) $(PREFIX)

remove:
	rm -rf $(PREFIX)
