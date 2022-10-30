
# FitnessCraft

A brief description of what this project does and who it's for


## Tech Stack

PHP 8.1
Symfony 6


## Run Locally

Clone the project

```bash
  git clone https://github.com/Thioni/FitnessCraft.git
```

Go to the project directory

```bash
  cd FitnessCraft
```

Install dependencies

```bash
  composer install
```

Start your DBMS (mariadb was used for the development)

Create the database

```bash
  php bin/console doctrine:database:create
```

Create the tables

```bash
  php bin/console doctrine:migrations:migrate
```

Create an admin user

```bash
  php bin/console dbal:run-sql "INSERT INTO user(email, roles, password, new_account) VALUES ('fitnesscraft@example.fr','[\"ROLE_ADMIN\"]','\$argon2i\$v=19\$m=16,t=2,p=1\$WWxjS081WG1IN25ka041Ng\$dpvcUbIrwJwuhqxJFbxtJA', 0)"
```

Start the server

```bash
  symfony serve
```

You can now log in using

```bash
  id: fitnesscraft@example.fr
  password: Fm1!rt25
```



