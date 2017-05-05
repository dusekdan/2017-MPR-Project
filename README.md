## Potřebné věci
- mít server
- nainstalovat `composer`
- nainstalovat `GIT`

## Postup instalace
- Naklonovat si tento projekt pomocí `GITu`
- Pomocí composeru si stáhněte potřebné balíčky 
    ```sh 
    $ composer update
    ``` 
- Následně mějme dva soubory `app/config/config.local.neon.default` a `phinx.yml.default`, které si zduplikujte (**nemažte**) a u duplikátů smažte koncovku `.default`
- Nastavit databázi v `app/config/config.local.neon` přepsáním nazev_databaze za vlastni a nastavit správně parametr `user` a `password` u `database` a u `doctrine` 
```sh
parameters:
	dbname: nazev_databaze

database:
	dsn: 'mysql:host=127.0.0.1;dbname=%dbname%'
	user: root
	password:
	options:
		lazy: yes

doctrine:
	user: root
	password:
	dbname: %dbname%
	metadata:
		App: %appDir%/Model/Entities
```
- Nastavit migrace přepsáním nazev_databaze za vlastni v `phinx.yml`
```sh
development:
    adapter: mysql
    host: localhost
    name: nazev_databaze
    user: root
    pass: ''
    port: 3306
    charset: utf8
```
- Spustit v příkazové řadce ve složce s projektem příkaz
	```sh
	$ vendor/bin/phinx migrate
	```

## Rozšiřující info
- Databáze (tabulky/entity)
    - Přihlašovací údaje k localhostu `app/config/config.local.neon`
    - `app/model/entities/*` - zde jsou tabulky jako objekty. Je použita               - Doctrina [dokumentace](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html)
- Migrace [dokumentace](http://docs.phinx.org/en/latest/migrations.html) (sql scripty, práce s databází) (sql scripty, práce s databází)
    - `phinx.yml` - pro nastavení databáze pro migrace
    - `migrations/*` - zde jsou vygenerované migrace
        ```sh
        $ vendor/bin/phinx migrate
        $ vendor/bin/phinx rollback
        $ vendor/bin/phinx create NazevSouboru
        ```
    - vygeneruje soubor -> `YYYYMMDDHHMMSS_nazev_souboru.php`
- ACL vrstva
    - `app/components/Acl.php` - nastavení rolí a oprávnění
    - `app/model/entities/User.php` - uživatel