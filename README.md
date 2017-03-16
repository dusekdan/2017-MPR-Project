# Postup instalace
- Pomocí composeru si stáhněte potřebné balíčky 
    ```sh 
    $ composer update
    ``` 
- Pak už si jen nastavit databázi
    - Databáze (tabulky/entity)
        - Přihlašovací údaje k localhostu `app/config/config.local.neon`
        - `app/model/entities/*` - zde jsou tabulky jako objekty. Je použita               - Doctrina dokumentace
    - Migrace dokumentace (sql scripty, práce s databází)
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