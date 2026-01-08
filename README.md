# Sistema de Autenticacao Laravel com Docker

Sistema basico de cadastro e autenticacao de usuarios utilizando Laravel, MySQL e Docker.

## Visao Geral da Arquitetura

Este projeto utiliza uma arquitetura de microservicos containerizada com Docker, composta por quatro containers:

1. **app (PHP-FPM)**: Container da aplicacao Laravel com PHP 8.2 e todas as extensoes necessarias
2. **webserver (Nginx)**: Servidor web que recebe as requisicoes HTTP e as encaminha para o PHP-FPM
3. **db (MySQL 8.0)**: Banco de dados relacional para persistencia dos dados
4. **phpmyadmin**: Interface web para gerenciamento do banco de dados MySQL

### Diagrama da Arquitetura

```
                    +------------------+
                    |    Navegador     |
                    +--------+---------+
                             |
                             | HTTP (porta 8080)
                             v
                    +------------------+
                    |     Nginx        |
                    |   (webserver)    |
                    +--------+---------+
                             |
                             | FastCGI (porta 9000)
                             v
                    +------------------+
                    |    PHP-FPM       |
                    |     (app)        |
                    +--------+---------+
                             |
                             | MySQL (porta 3306)
                             v
                    +------------------+
                    |     MySQL        |
                    |      (db)        |
                    +------------------+
```

## Estrutura de Pastas

```
laravel-auth-docker/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   ├── LoginController.php      # Controller de login/logout
│   │       │   └── RegisterController.php   # Controller de cadastro
│   │       ├── Controller.php               # Controller base
│   │       └── DashboardController.php      # Controller do dashboard
│   └── Models/
│       └── User.php                         # Model do usuario
├── config/                                  # Configuracoes do Laravel
├── database/
│   └── migrations/                          # Migrations do banco de dados
├── docker/
│   ├── nginx/
│   │   └── nginx.conf                       # Configuracao do Nginx
│   └── php/
│       └── Dockerfile                       # Dockerfile da aplicacao
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php              # Pagina de login
│       │   └── register.blade.php           # Pagina de cadastro
│       ├── layouts/
│       │   └── app.blade.php                # Layout base
│       └── dashboard.blade.php              # Pagina do dashboard
├── routes/
│   └── web.php                              # Rotas da aplicacao
├── .env.example                             # Exemplo de variaveis de ambiente
├── docker-compose.yml                       # Orquestracao dos containers
└── README.md                                # Este arquivo
```

## Requisitos

- Docker (versao 20.10 ou superior)
- Docker Compose (versao 2.0 ou superior)

**Nota**: Nao e necessario ter PHP, Composer ou MySQL instalados localmente.

## Instalacao e Execucao

### Passo 1: Clonar o repositorio

```bash
git clone <url-do-repositorio>
cd laravel-auth-docker
```

### Passo 2: Configurar variaveis de ambiente

```bash
cp .env.example .env
```

O arquivo `.env` ja vem configurado com os valores padrao para o ambiente Docker.

### Passo 3: Iniciar os containers

```bash
docker-compose up -d --build
```

Este comando ira:
- Construir a imagem Docker da aplicacao
- Iniciar os containers do MySQL, PHP-FPM e Nginx
- Configurar a rede entre os containers

### Passo 4: Instalar dependencias do Composer

```bash
docker-compose exec app composer install
```

### Passo 5: Gerar a chave da aplicacao

```bash
docker-compose exec app php artisan key:generate
```

### Passo 6: Executar as migrations

Aguarde alguns segundos para o MySQL inicializar completamente, depois execute:

```bash
docker-compose exec app php artisan migrate
```

### Passo 7: Acessar a aplicacao

Abra o navegador e acesse: http://localhost:8080

## Comandos Uteis

### Gerenciamento dos Containers

```bash
# Iniciar os containers
docker-compose up -d

# Parar os containers
docker-compose down

# Ver logs dos containers
docker-compose logs -f

# Ver logs de um container especifico
docker-compose logs -f app
docker-compose logs -f webserver
docker-compose logs -f db

# Reiniciar os containers
docker-compose restart
```

### Comandos do Laravel (Artisan)

```bash
# Executar migrations
docker-compose exec app php artisan migrate

# Reverter migrations
docker-compose exec app php artisan migrate:rollback

# Limpar cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear

# Listar rotas
docker-compose exec app php artisan route:list

# Acessar o Tinker (REPL)
docker-compose exec app php artisan tinker
```

### Comandos do Composer

```bash
# Instalar dependencias
docker-compose exec app composer install

# Atualizar dependencias
docker-compose exec app composer update

# Adicionar pacote
docker-compose exec app composer require nome/pacote
```

## Funcionalidades

### Cadastro de Usuario
- Formulario com campos: Nome, E-mail, Senha e Confirmacao de Senha
- Validacao de dados no backend
- Senha armazenada com hash seguro (bcrypt)
- E-mail unico no sistema

### Login
- Formulario com campos: E-mail e Senha
- Opcao "Lembrar de mim"
- Mensagens de erro amigaveis

### Dashboard
- Pagina protegida por autenticacao
- Exibe informacoes do usuario logado
- Botao de logout

### Protecao de Rotas
- Rotas de login/cadastro acessiveis apenas para visitantes (middleware `guest`)
- Dashboard acessivel apenas para usuarios autenticados (middleware `auth`)

## Variaveis de Ambiente

| Variavel | Descricao | Valor Padrao |
|----------|-----------|--------------|
| APP_NAME | Nome da aplicacao | Laravel Auth |
| APP_ENV | Ambiente da aplicacao | local |
| APP_DEBUG | Modo debug | true |
| APP_URL | URL da aplicacao | http://localhost:8080 |
| DB_CONNECTION | Driver do banco de dados | mysql |
| DB_HOST | Host do banco de dados | db |
| DB_PORT | Porta do banco de dados | 3306 |
| DB_DATABASE | Nome do banco de dados | laravel_auth |
| DB_USERNAME | Usuario do banco de dados | laravel |
| DB_PASSWORD | Senha do banco de dados | secret |

## Portas Mapeadas

| Servico | Porta Host | Porta Container |
|---------|------------|-----------------|
| Nginx (Web) | 8080 | 80 |
| phpMyAdmin | 8081 | 80 |
| MySQL | 3306 | 3306 |

## phpMyAdmin

O phpMyAdmin esta disponivel para gerenciamento visual do banco de dados MySQL.

**Acesso**: http://localhost:8081

**Credenciais**:
- Usuario: laravel (ou o valor de DB_USERNAME no .env)
- Senha: secret (ou o valor de DB_PASSWORD no .env)

Com o phpMyAdmin voce pode:
- Visualizar e editar tabelas
- Executar queries SQL
- Importar e exportar dados
- Gerenciar usuarios do banco de dados

## Expansoes Futuras

Este projeto pode ser expandido com as seguintes funcionalidades:

### Seguranca
- Verificacao de e-mail
- Autenticacao de dois fatores (2FA)
- Recuperacao de senha
- Rate limiting para prevenir ataques de forca bruta

### Performance
- Cache com Redis
- Filas para processamento assincrono
- CDN para assets estaticos

### Testes
- Testes unitarios com PHPUnit
- Testes de integracao
- Testes E2E com Laravel Dusk

### DevOps
- Pipeline de CI/CD com GitHub Actions
- Ambiente de staging
- Monitoramento com Laravel Telescope
- Logs centralizados

### Funcionalidades
- Perfil do usuario editavel
- Upload de avatar
- Historico de login
- Gerenciamento de sessoes ativas

## Solucao de Problemas

### Erro de conexao com o banco de dados

Se voce receber um erro de conexao com o MySQL, aguarde alguns segundos e tente novamente. O MySQL pode demorar para inicializar completamente.

```bash
# Verificar se o MySQL esta pronto
docker-compose exec db mysql -u laravel -psecret -e "SELECT 1"
```

### Permissoes de arquivos

Se houver problemas de permissao, execute:

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Limpar cache

```bash
docker-compose exec app php artisan optimize:clear
```

## Licenca

Este projeto e disponibilizado sob a licenca MIT.
