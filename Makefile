# command to run application (containers)
build:
	@docker-compose up -d --build

# command to run application (containers)
up:
	@docker-compose up -d

#command to stop application (containers)
stop:
	@docker-compose stop

# command to stop and destroy all application containers
down:
	@docker-compose down

status:
	@docker-compose ps -a

into-container:
	@docker-compose exec -u application webserver bash

# Command to destroy everything (containers, images, volumes, networks)
destroy:
	@docker system prune -a --volumes
