# Sobre

- Repositório responsável pelo projeto missing pets.
- Com o foco em auxiliar as pessoas, aprender e melhorar nas tecnologias:
  ```
  - PHP, 
  - Swoole, 
  - Laravel,
  - Laravel Octane
  - Redis, 
  - Rabbitmq 
  - SQL.
  ```
  
# Hospedagem

- Atualmente o sistema está hospedado em uma vps2 da hostinger sobre o domínio https://www.ejsocial.com/
- Configurações da vps:
    ```
  - Núcleos de CPU: 2
  - Memória: 8 GB
  - Largura de Banda: 8 TB
  - Espaço em disco: 100 GB
    ```
  
# Repositório da Imagem Docker: 

- https://hub.docker.com/repository/docker/jo1opedro/php83-missing-pets-api-2024/general 

# Conteúdo da Imagem Docker

- <b>PHP</b>, e diversas extensões e Libs do PHP, incluindo php-redis, mysql, swoole, memcached.

- <b>Nginx</b>, como proxy reverso/servidor. Por fim de testes é que o Nginx está presente nesta imagem, em um momento de otimização está imagem deixará de ter o Nginx.

- <b>Supervisor</b>, indispensal para executarmos a aplicação PHP e permitir por exemplo a execução de filas e jobs.

- <b>Composer</b>, afinal de contas é preciso baixar as dependências mais atuais toda vez que fomos crontruir uma imagem Docker.

# Passo a Passo para execução

## Certifique-se de estar com o Docker em execução.

```sh
docker ps
```

## Certifique-se de ter o Docker Compose instalado.

```sh
docker compose version
```

A listagem de pastas do projeto deve ficar:

```
    app/
    docker/
    .gitignore
    docker-compose.yml
    readme.md
```

## Certifique-se que sua aplicação Laravel ficou em `./app` e que existe o seguinte caminho: `/app/public/index.php`

## Certifique-se que sua aplicação Laravel possuí um .env e que este .env está com a `APP_KEY=` definida com valor válido.

## Contruir a imagem Docker, execute:

```sh
docker compose build
```

## Caso não queira utilizar o cache da imagem presente no seu ambiente Docker, então execute:

```sh
docker compose build --no-cache
```

## Para subir a aplicação, execute:

```sh
docker compose up
```

- Para rodar o ambiente sem precisar manter o terminar aberto, execute:

```sh
docker compose up -d
```

## Para derrubar a aplicação, execute:

```sh
docker compose down
```

## Para entrar dentro do Container da Aplicação, execute:

```sh
docker exec -it web bash
```

# Solução de Problemas

## Problema de permissão

- Quando for criado novos arquivos, ou quando for a primeira inicialização do container com a aplicação, pode então haver um erro de permissão de acesso as pastas, neste caso, entre dentro do container da aplicação e execeute.

```sh
cd /var/www && \
chown -R www-data:www-data * && \
chmod -R o+w app
```
