# publiccode

```shell
docker compose pull
docker compose up --detach --build
docker compose exec phpfpm composer install

open "http://$(docker compose port nginx 8080)/admin"
```

Create and edit `.env.local` and set your GitHub API token:

```dotenv
# https://docs.github.com/en/rest/guides/getting-started-with-the-rest-api?apiVersion=2022-11-28
# https://github.com/settings/tokens?type=beta
GITHUB_TOKEN=""
```

Copy `publishers.dist.yml` to `publishers.yml` and edit.

```shell
docker compose run crawler
```

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
