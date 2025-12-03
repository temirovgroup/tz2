up:
	docker-compose up -d

down:
	docker-compose down

restart:
	make down && make up

test:
	docker-compose exec fpm php yii_test migrate --interactive=0 && \
    docker-compose exec fpm codecept run --skip=acceptance

test-acc:
	docker-compose exec fpm codecept run --skip=unit --skip=functional

bash:
	docker-compose exec fpm bash

bd:
	 docker exec -it tz2_db_1 bash

migrate:
	docker-compose exec php php yii migrate/up

composer:
	docker-compose exec fpm composer install

cs:
	docker-compose exec fpm composer cs:fix

rector:
	docker-compose exec fpm composer rector:fix

ci:
	docker-compose exec fpm composer ci

prune:
	@echo "Cleaning local branches..."
	@git fetch --prune --quiet
	@git branch -v --format "%(refname:short) %(upstream:track)" | \
		awk '$$2 == "[gone]" {print $$1}' | \
		while read -r branch; do \
			if [ "$$branch" != "$(git symbolic-ref --short HEAD)" ]; then \
				git branch -D "$$branch" 2>/dev/null && \
				echo "Deleted branch: $$branch"; \
			else \
				echo "Skipping current branch: $$branch"; \
			fi; \
		done
	@echo "Done"
