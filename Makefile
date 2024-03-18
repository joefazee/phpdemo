# Run docker commands

# Run PHPUnit tests
test:
	docker-compose exec app vendor/bin/phpunit

# Generate test coverage report
coverage:
	docker-compose exec app vendor/bin/phpunit --coverage-html coverage/html

# Run PHPStan for static analysis
analyze:
	docker-compose exec app vendor/bin/phpstan analyse

# Check coding standards with PHP_CodeSniffer
check-style:
	docker-compose exec app vendor/bin/phpcs --standard=PSR12 src tests

# Automatically fix coding standards issues with PHP_CodeSniffer
fix-style:
	docker-compose exec app vendor/bin/phpcbf --standard=PSR12 src tests

# Run all checks
check: fix-style test analyze check-style
