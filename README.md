# 🥗 SENACFOOD

## 1. Instalação e Execução
```
git clone https://github.com/seuRepo/sportfinderbackend
cd sportFinderBackend
composer install //instalar dependências
cp .env.example .env
php artisan key:generate
php artisan migrate //para gerar a database e as tabelas
```

## 2. Verificação
- Verifique se o .env foi criado e esta correto
- Verifique se as tabelas foram criadas corretamente

## 3. Rotas para teste
- Praticamente todas as rotas estão protegidas para serem acessadas apenas com login.
```
http://localhost/api/register
{
	"name": "usuario",
	"email": "usuario@gmail",
	"password": "123456789",
	"password_confirmation": "123456789"
}
--
http://localhost/api/login
{
	"email": "usuario@gmail",
	"password": "123456789"
}

```
para acessar a seguinte rota, deve consumir o Token disponibilizado pela rota de login
http://localhost/api/users