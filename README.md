# System komunikacji z zasobem REST API PET

## Wymagania techniczne

1. Composer
2. Apache 2
3. PHP 8.2
4. Laravel 12

## Opis instalacji projektu

Trzeba zainstalować serwer *Apache 2* wraz z serwerem *PHP 8.2*. Najlepiej zainstalować paczkę gotową np. *Xampp*.

Aplikację trzeba umiejscowić w głównym folderze serwera *Apache 2*. Za pomocą *composera* w folderze głównym aplikacji w linii komend trzeba pobrać wersję Laravela 12:

`composer install`

Trzeba skopiować plik z parametrami *.env.example* do pliku *.env* . W pliku *.env* trzeba ustawić parametry:

- *API_KEY* - klucz API do autoryzacji requestów do zasobu REST API
- *PET_REST_API_URL* - adres URL do zasobu REST API
- *APP_NAME* - nazwa aplikacji
- *APP_URL* - adres URL lokalny do aplikacji

## Instrukcja używania aplikacji

W aplikacji możemy dodawać, aktualizować, usuwać i pobierać elementy PET z zasobu REST API. Po wciśnięciu w menu *"Lista elementów PET"* wyświetlą się linki do list zasobów REST API czyli ze statusem:

- available
- pending
- sold

Po wejściu w któryś z linków powyższych wyświetli się lista elementów PET w tabeli zasobu REST API zgodna z wybranym statusem. Tabela listy zawiera na dole paginację z wyświetleniem 10 elementów na stronie. Ilość elementów na stronie można ustawić w pliku *config/pagination.php* w zmiennej *per_page*. Każda lista elementów zasobu REST API ma kolumny:

- Id
- Id kategorii
- Nazwa kategorii
- Nazwa
- Akcje

W kolumnie *"Akcje"* są linki:

- Edytuj
- Usuń

Po wciśnięciu linku *"Edytuj"* wyświetli się formularz edycji elementu danego zasobu REST API. Jeśli danego elementu nie będzie wyświetli się odpowiedni komunikat. W formularzu edycji oprócz pól które były na liście jest jeszcze możliwość aktualizowania tagów elementu zasobu oraz ustawienia statusu. Po wciśnięciu linku *"Usuń"* wyświetli się pytanie czy na pewno usunąć dany element. Po zatwierdzeniu usuwania operacja ta zostanie wykonana.

Po wciśnięciu w menu *"Dodaj element do zasobu PET"* wyświetli się formularz dodawania elementów PET do zasobu REST API. Pola te są identyczne jak w przypadku formularza edycji tych elementów.

Formularze dodawania i edycji elementów do zasobu REST API posiadają walidację z obsługą błędów. Polami obowiązkowymi są pola:

- Nazwa
- Status

Jeśli dodamy tagi w powyższych formularzach przez wciśnięcie przycisku *Dodaj tag* to wtedy każde pole nazwy tagu jest obowiązkowe. 

Gdy podamy w formularzach niewłaściwe dane wyświetli się odpowiedni komunikat.
