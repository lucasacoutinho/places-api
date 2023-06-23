### Place-API

Essa é uma API que permite ao usuário realizar operações basicas de CRUD em locais, como listar locais pelo nome, criar um local, detalhar um local, atualizar o local ou excluir um local.

# Requerimentos
* Docker
* Docker compose

# Instalação

1. Fazer o clone do projeto
```
git clone https://github.com/lucasacoutinho/places-api.git
```

2. Acesse o diretório do projeto
```
cd places-api
```

3. Copie as variaveis de ambiente
```
cp .env.example .env
```

4. Instalar as dependências do projeto
```
docker compose up -d
```

5. Acessar o container da aplicação
```
docker exec -it sgbr-api bash
```

6. Execute as migrations
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
docker exec -it sgbr-api bash
```

2. Executar o comando de testes
```
php artisan test --env=testing
```
