### Place-API

Essa é uma API que permite ao usuário realizar operações basicas de CRUD em locais, como listar locais pelo nome, criar um local, detalhar um local, atualizar o local ou excluir um local.

# Requerimentos
* Docker
* Docker compose

# Instalação

1. Instalar as dependências do projeto
```
docker compose up -d
```

2. Acessar o container da aplicação
```
docker exec -it sgbr-api ash
```

3. No container da aplicação instalar as dependencias do projeto
```
composer install
```

4. Execute as migrations
```
php artisan migrate --seed
```

# Documentação
1. Acesse a documentação dos endpoints em
```
http://localhost/swagger
```

## Testes
1. Acessar o container da aplicação
```
docker exec -it sgbr-api ash
```

2. Executar o comando de testes
```
php artisan test --env=testing
```
