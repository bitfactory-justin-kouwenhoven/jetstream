.PHONY: up down watch-poll

up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

watch:
	./vendor/bin/sail npm run watch