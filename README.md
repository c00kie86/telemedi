# Currency Exchange Table
Symfony + React.js application with NGINX as FastCGI proxy for PHP-FPM

### Info
```bash
# Tabela wymiany walut
- Czytelny i funkcjonalny interfejs do prezentacja danych dla pracowników kantoru wymiany walut

# Frontend
1. Aktualne Kursy
- Listy bieżących kursów sprzedawanych walut:
  - Kod waluty
  - Nazwa waluty
  - Średni kurs
  - Kurs sprzedaży
  - Kurs kupna (jeżli dotyczy)
  - Edycja waluty ???

2. Dodaj walutę
- Pole dodania waluty
  - Określ kod waluty, różnicę sprzedaży oraz różnice kupna jeżeli dotyczy
  - Waluta zostanie dodana do sekcji Aktualne Kursy

3. Kurs historyczny
- Lista ostatnich 14 kursów danej waluty od podanej daty (domyślnie: USD, aktualna data)
- Pole wyboru (wybierz: walute, datę)

# Backend
- Dane w aplikacji pobierane z API Symfony (API platform v2.6.x)
- Dane w API Symfony pobrane z API NBP
- Dane z API NBP zapisane w pliku .json
- Dane z pliku przeliczone i wystawoine w Symfony API
- pre-rendering ??

# Pre-rendering
"Można zapisać do .html zubdowane oraz wyrenderowane szablon (Twig) i komponenty React.js (Webpack Encore) przez Symfony i serwować w NGINX jako statyczne strony i przebudowywać tylko przy aktualizacji kursu"

# Obsługiwane waluty
- Kantor obsługuje waluty:
[EUR, USD, CZK, IDR, BRL]

# Zasady ustalania kursów
- EUR, USD:
średni kurs NBP - 0,15 PLN = kurs kupna
średni kurs NBP + 0,11 PLN = kurs sprzedaży

- CZK, IDR, BRL:
kantor nie skupuje tych walut (brak kursu kupna)
średni kurs NBP + 0,20 PLN  = kurs sprzedaży

# Obsługa błędów
- Brak danych z NBP
- Nieobsługiwana waluta
- Niepoprawna data

# Jak uruchomić aplikacje?
- Zapoznaj się z poniższymi wytycznymi
```

### Git config
```bash
# Źródłowe repozytorium
git clone https://github.com/telemedico/recruitment_task_fullstack.git 

# Fork tego repozytorium
- Zrób Fork >> https://github.com/c00kie86/telemedi.git

# Klonowanie repozytorium
git clone https://github.com/YOUR-USERNAME/telemedi.git

cd telemedi

# Lista zdalnych repozytoriów powiązanych z lokalnym projektem
git remote -v

- Zmień origin url jeżeli jest niepoprawny (np. jak łaczysz się przez SSH)

# Zdalne repozytorium do połączenia przez SSH
git remote set-url origin git@github:/YOUR-USERNAME/telemedi.git

# weryfikacja statusu repozytorium
git status # origin/master

# Zmiany domyślnej gałęzi z `master` na `main`
git branch -m main

# Wypchnij nowy branch do GitHub
git push origin main

# Zmina domyślnego bruncha z master na main 
- Github repo >> Settings >> Change default branch

# Usuń stary branch z GitHub (opcjonalnie)
git push origin --delete master

# Zaktualizuj `origin/main` lokalnie
git fetch origin

# Utwórz i przełącza się na określoną gałąź
git checkout -b develop

# Wypchnij nowy branch do GitHub i ustaw lokalnie jako domyślny
git push -u origin develop

# Wyświetlanie lokalnych gałęzi
git branch

# Wprowadzanie zmian
- Jeżeli wprowdzasz zmiany stosuj się do "Conventional Commits", a komentarze pisz w języku angielskim
```

### Docker setup
```bash
# Docker
- Środowisko do uruchomienia aplikacji wymaga nowej wersji "docker" z "compose"
- Plik "compose.yaml" zawiera dwa kontenery spięte w jedną sieć "telemedi"
- Obraz "symfony" jest budoany z Dockerfile natomiast "nginx" jest pobierany bespośrednio z DockerHub
- Folder "/public/" ma nazwany "volumes" reszta plików i foldery jest mapowana
- Domyślny host # http://localhost

# Symfony (PHP-FPM) + NGINX (fastCGI)
docker compose up -d --build
docker compose down

# Symfony (PHP-FPM)
docker compose up -d --build symfony
docker compose down symfony

docker compose logs symfony

docker exec -it symfony sh

# NGINX (fastCGI)
docker compose up -d nginx
docker compose down symfony

docker compose logs nginx

docker exec -it nginx sh

# Inne
docker compose restart
docker compose stop
docker compose start
```

### Architecture
```bash

# NGINX fastCGI proxy
- NGINX obsługuje żądania HTTP od klienta
- Jeżali to plik ".php" przekazuje go przez fastCGI do PHP-FPM
- Statyczne pliki zwraca od razu

# PHP-FPM
- PHP FastCGI Process Manager działa jako osobny proces
- pozwala NGINX obsługiwać statyczne pliki bez angażowania PHP
- obsługuje żądania przekazane przez NGINX fastCGI
- przekazuje je do interpretera PHP który ładuje pliki do Symfony

# Symfony frontend
- Symfony renderuje szablony na podstawie żądań z PHP-FPM
- Encore Webpack buduje komponenty React.js
- Twig generuje HTML

# Symfony backend
- Obsługuje żadania do API (App_API_Service)
- Wykonuje żądania do API NBP (NBP_API_Service)

# Przepływ żądań
request >> NGINX >> response # .jpg, .css, .js
request >> NGINX >> PHP-FPM >> Symfony >> response # .php
```

### Endpoints
```bash
http://localhost
http://localhost/setup-check

http://localhost/api/setup-check
```