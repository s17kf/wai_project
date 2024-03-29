<!DOCTYPE html>
<html lang="pl">

<?php require '../routing.php'?>
<head>
  <meta charset="UTF-8">
  <title>Gry planszowe i karciane</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div id="wrapper">
  <header>
    <h1>Gry planszowe i karciane</h1>
  </header>
  <div id="content">
    <button type="button" id="playersButton" style="display: none">Pokaż graczy</button>
    <button type="button" id="ageButton" style="display: none">Pokaż wiek</button>
    <button type="button" id="timeButton" style="display: none">Pokaż czas gry</button>
    <div id="tabs">
      <ul id="gamesList" style="display: none">
        <li><a href="#catan">Catan</a></li>
        <li><a href="#cytadela">Cytadela</a></li>
        <li><a href="#mars-terraformation">Terraformacja Marsa</a></li>
        <li><a href="#unicorns">Odjechane jednorożce</a></li>
      </ul>
      <div id="catan">
        <div class="game-list-grid-container">
          <img src="static/img/catan.png" class="small" alt="Zdjęcie gra Catan">
          <div class="game_description">
            <h1>Catan</h1>
            <p>
              Osadnicy z Catanu (Settlers of Catan) to bardzo popularna na całym świecie gra rodzinno-ekonomiczna o
              bardzo
              dużej "miodności" grania. Teraz prezentujemy jej polską edycję!
              Gracze są osadnikami na niedawno odkrytej wyspie Catan. Każdy z nich przewodzi świeżo założonej kolonii i
              rozbudowuje ją stawiając na dostępnych obszarach nowe drogi i miasta. Każda kolonia zbiera dostępne dobra
              naturalne, które są niezbędne do rozbudowy osiedli.
              Gracz musi rozważnie stawiać nowe osiedla i drogi, aby zapewnić sobie dostateczny, ale zrównoważony dopływ
              zasobów, a jeśli ma ich nadmiar - prowadzić handel z innymi graczami sprzedając im owce, drewno, cegły,
              zboże
              lub żelazo a pozyskując od nich te zasoby, których ciągle mu brakuje.
              Pierwszy z graczy, który uzyska dziesięć punktów z wybudowanych przez siebie dróg, osiedli i specjalnych
              kart
              -
              wygrywa.
            </p>
            <p>Dostępne dodatki do gry Catan</p>
            <ul>
              <li>Miasta i Rycerze</li>
              <li>Odkrywcy i piraci</li>
              <li>Kupcy i Barbarzyńcy</li>
            </ul>
          </div>
        </div>
      </div>
      <div id=cytadela>
        <div class="game-list-grid-container">
          <img src="static/img/cytadela.jpg" class="small" alt="Zdjęcie gra Cytadela">
          <div class="game_description">
            <h1>Cytadela</h1>
            <p>
              Cytadela to nowa edycja strategicznej gry opartej o wymianę kart, w której co rundę korzystamy z pomocy i
              zdolności innych postaci. Każdy mieszkaniec miasta zapewni nam zupełnie inny efekt, a my będziemy musieli
              umiejętnie lawirować między pozyskiwaniem korzyści dla siebie a utrudnianiem rozgrywki przeciwnikom.
            </p>
            <p>
              Rozgrywka w Cytadelę składa się z serii rund. Każda runda rozpoczyna się od fazy wyboru, podczas której
              gracze
              przekazują sobie karty postaci i wybierają po 1 na daną rundę. Wszystkie karty postaci mają specjalne
              zdolności,
              które pozwalają na przykład na kradzież monet czy zburzenie dzielnicy innego gracza.
              <br>
              Po fazie wyboru następuje faza tur graczy, podczas której gracze pobierają zasoby i budują nowe dzielnice
              w
              swoich miastach. W ten sposób rozgrywka toczy się tak długo, aż jeden z uczestników wybuduje w swoim
              mieście
              7.
              dzielnicę.
            </p>
          </div>
        </div>
      </div>
      <div id="mars-terraformation">
        <div class="game-list-grid-container">
          <img src="static/img/terraformacja_marsa.jpg" class="small" alt="Zdjęcie gra Terraformacja Marsa">
          <div class="game_description">
            <h1>Terraformacja Marsa</h1>
            <p>
              W Terraformacji Marsa gracz obejmie kontrolę nad jedną z korporacji i jako jej zarząd będzie kupować i
              zagrywać
              karty opisujące różne projekty inwestycyjne. Zazwyczaj projekty będą bezpośrednio lub pośrednio
              przyczyniać
              się
              do
              procesu terraformacji, mogą też jednak być przedsięwzięciami biznesowymi innego rodzaju.
            </p>
            <p>
              Aby wygrać, gracz musi osiągnąć wysoki Współczynnik Terraformacji (WT) i zdobyć dużo Punktów Zwycięstwa
              (PZ).
              WT
              gracza wzrasta za każdym razem, kiedy podniesie on jeden ze Wskaźników Globalnych (Temperaturę, poziom
              Tlenu
              lub
              liczbę Oceanów). Od WT zależy podstawowy dochód gracza, a także jego podstawowy wynik.
              W miarę przebiegu procesu terraformacji gracze będą mogli realizować coraz większą liczbę projektów.
              Dodatkowe
              PZ można zdobyć za wszystko, co przyczyni się do zwiększenia panowania ludzkości nad Układem Słonecznym,
              na
              przykład za zakładanie miast, budowę infrastruktury lub ochronę środowiska.
            </p>
            <p>
              Czas odmierza się w Pokoleniach.
            </p>
            <ul>
              <li>Gracze rozpoczynają każde Pokolenie od fazy kolejności,</li>
              <li>następnie przechodzą do fazy badań naukowych, podczas której zdobywają nowe karty.</li>
              <li>W fazie akcji gracze wykonują kolejno po 1 albo 2 akcje. Gracze odbywają swoje tury do momentu, aż
                wszyscy
                spasują.
              </li>
              <li>W fazie produkcji gracze produkują Zasoby (zgodnie z poziomami produkcji zaznaczonymi na swoich
                planszach)
                i
                otrzymują dochód wynikający z WT.
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div id="unicorns">
        <div class="game-list-grid-container">
          <img src="static/img/odjechane_jednorozce.jpg" class="small" alt="Zdjęcie gra Odjechane jednorożce">
          <div class="game_description">
            <h1>Odjechane jednorożce</h1>
            <p>
              Odjechane Jednorożce to strategiczna gra karciana pełna śmiechu, destrukcji, interakcji i… jednorożców!
            </p>
            <p>
              Na samym początku otrzymujesz kartę jednorożka. Uroczo, prawda? Ale nie przywiązuj się do niego zbytnio,
              bo
              nie
              o jednorożki chodzi w tej grze. Twoim zadaniem jest zbudowanie unikalnej armii dorosłych jednorożców.

              Zbuduj armię tak szybko, jak to możliwe, albo zgiń z ręki Twoich tak zwanych przyjaciół. Możesz być
              pewien,
              że
              wykorzystają każdą okazję, aby Cię zniszczyć. Sam też możesz to robić, podrzucając im do stajni specjalne
              karty
              kar z nieprzyjemnymi efektami.
            </p>
            <p>
              Zwycięża gracz, który jako pierwszy umieści w swojej stajni wymaganą liczbę jednorożców. Aby wygrać,
              należy
              umiejętnie wywoływać i łączyć ze sobą efekty na kartach, jak również mądrze wybierać cele, które będziemy
              atakowali.
            </p>
            <p>
              Poniżej lista wybranych dodatków dostępnych do tej gry:
            </p>
            <ul>
              <li>Legendarne jednorożce</li>
              <li>Tęczowa apokalipsa</li>
              <li>Koszmary</li>
              <li>Smoki</li>
              <li>Odjechane święta</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php (new Dispatcher($routing))->dispatch('/nav', ['active' => 'games']) ?>

</div>
<footer id="foot">
  <div id="date"></div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="js/navigation_dynamic.js"></script>
<script src="js/additionalInfoButtons.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function (ev) {
    console.log("DOM fully loaded and parsed");
    hideElementOfClass("navMenu", "foldable");
    showAndSetupButtons();
  })
</script>

<script>
  $(function () {
    $("#gamesList").show();
    $("#tabs").tabs();
  })
</script>
<script>
  let dt = new Date();
  let time = ('0' + dt.getDate()).slice(-2) + "." +
    ('0' + (dt.getMonth() + 1)).slice(-2) + "." +
    dt.getFullYear() + " " +
    ('0' + dt.getHours()).slice(-2) + ":" +
    ('0' + dt.getMinutes()).slice(-2) + ":" +
    ('0' + dt.getSeconds()).slice(-2);
  $('#date').text(time)
</script>

</body>
</html>
