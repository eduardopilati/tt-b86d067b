# Teste Técnico e4d6768c

[O link do desafio pode ser encontrado clicando aqui](https://github.com/eduardopilati/tt-b86d067b/blob/main/README.md)

## Considerações

> Criar um Job e programá-lo para execução duas vezes por dia. O método handle do Job pode permanecer vazio.

Usando o docker-compose o Job nunca irá rodar pois não foi feito o setup do job cron no Dockerfile. O Job está registrado e se fizer o setup conforme documentação oficial irá funcionar perfeitamente.

> Deve ser utilizado o Laravel Mix para compilação de dependências.

Laravel mix não é usado mais desde a versão 8 do Laravel. Preferi manter no padrão e usar o Vite.

> Utilizar o sistema de autenticação do próprio Laravel.

Modifiquei para remover as rotas e campos não utilizados. ver abaixo instrução para criar um usuário

## Rodando o projeto

Para executar o projeto é necessário apenas executar o comando:

```bash
sudo docker compose up -d
```

Para criar o primeiro usuário será necessário executar o comando:

```bash
sudo docker exec -it e4d6768c_laravel php artisan make:user
```

Para criar dados fictícios pode-se executar o comando:

```bash
sudo docker exec -it e4d6768c_laravel php artisan tinker
```

e no shell do php executar qualquer desses comandos:

```php
User::factory()->create()
User::factory()->count(10)->create()
Car::factory()->create()
Car::factory()->count(10)->create()
```

Não é recomendável criar Reservas por comandos por:
- Caso seja fixo o `car_id` sempre vai dar conflito
- Caso não for fixo sempre irá criar um carro diferente para cada reserva
