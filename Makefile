dev-install:
	cp git/hooks/pre-commit .git/hooks/pre-commit

php-cs-fixer:
	composer install
	./vendor/bin/php-cs-fixer fix
