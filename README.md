# Postup instalace
- Naklonovat si tento projekt
- Pomocí composeru si stáhněte potřebné balíčky 
    ```sh 
    $ composer update
    ``` 
- Nastavit databázi v `app/config/config.local.neon`
- Nastavit migrace v `phinx.yml`
- Spustit příkaz
	 ```sh
	$ vendor/bin/phinx migrate
	```

- Rozšiřující info
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