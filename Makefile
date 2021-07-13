.PHONY: up down watch

up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

watch:
	./vendor/bin/sail npm run watch

