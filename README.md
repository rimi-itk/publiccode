# publiccode

```shell
docker compose pull
docker compose up --build --detach
docker compose exec phpfpm composer install

open "http://$(docker compose port nginx 8080)/admin"
```

Create and edit `.env.local` and set your GitHub API token:

```dotenv
# https://docs.github.com/en/rest/guides/getting-started-with-the-rest-api?apiVersion=2022-11-28
# https://github.com/settings/tokens?type=beta
GITHUB_TOKEN=""
```

Generate a couple of required environment variables, `API_BEARER_TOKEN, and
`PASETO_KEY`, by running

```shell
docker compose exec phpfpm bin/console app:paseto
```

and insert the variables into `.env.local`.

Copy `publishers.dist.yml` to `publishers.yml` and edit appropriately.

Run the crawler:

```shell
docker compose run --rm crawler
```

## Crawler entities

Readonly entities, e.g. `App\Entity\Crawler\Software`, are created for the
`developers-italia-api-db` database.

Use

```shell
docker compose exec developers-italia-api-db pg_dump --dbname="host=developers-italia-api-db user=postgres password=postgres dbname=postgres port=5432" --schema-only --no-privileges --section=pre-data
```

to show the database structure when building or updating the entities.

## API

```shell
open "http://$(docker compose port developers-italia-api 3000)/v1/software"
```

## Coding standards

```shell
docker compose exec phpfpm composer install
docker compose exec phpfpm composer coding-standards-check
```

```shell
docker compose exec phpfpm composer coding-standards-apply
```

```shell
docker compose run --rm node yarn install
docker compose run --rm node yarn coding-standards-check
```

```shell
docker compose run --rm node yarn coding-standards-apply
```

## Production deployment

```shell
docker compose --env-file .env.docker.local --file docker-compose.server.yml --file docker-compose.override.yml up --build --detach
```
