# WorkTracker

Tracker aplikacji o pracę. Implementacja jest gotowa do sprawdzenia pod linkiem `https://hirelog.space`

Dane użytkownika testowego to login `demo@test.pl` a hasło to `demodemo1`

Tracker pozwala na tworzenie aplikacji (nazwa stanowiska, nazwa firmy, lokalizacja, data złożenia, status) oraz na dodawanie do nich notatek i plików pdf. Został też zaimplementowany dashboard, który pozwala na prowadzenie statystyki utworzonych aplikacji.

## Technologie

- Laravel 12
- FilamentPHP 3.3
- Mariadb 10.11


## Instalacja

```bash
git clone https://github.com/Kapeko1/hirelog.git
cd hirelog
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Development

```bash
composer run dev
```
