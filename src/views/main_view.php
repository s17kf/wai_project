<!doctype html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <title>Gry planszowe i karciane</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
<div id="wrapper">
  <header>
    <h1>Gry planszowe i karciane</h1>
  </header>
  <div id="content">
    <svg width="165" height="124" id="svg-dice">
      <g>
        <title>Layer 1</title>
        <rect stroke-width="2" id="svg_1" height="90" width="99" y="31.34895" x="2.03576" stroke="#b3d4fc"
              fill="#293124"/>
        <ellipse stroke-width="2" ry="9.5" rx="9.5" id="svg_2" cy="73.91159" cx="49.6587" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <line stroke-width="2" id="svg_6" y2="2.34895" x2="163.18471" y1="31.34895" x1="101.18471" stroke="#b3d4fc"
              fill="none"/>
        <line stroke-width="2" id="svg_7" y2="92.55961" x2="163.61023" y1="121.55961" x1="101.61023" stroke="#b3d4fc"
              fill="none"/>
        <line stroke-width="2" id="svg_8" y2="2.34895" x2="64.03576" y1="31.34895" x1="2.03576" stroke="#b3d4fc"
              fill="none"/>
        <line stroke-width="2" id="svg_12" y2="2.03555" x2="163.36221" y1="2.03555" x1="63.76371" stroke="#b3d4fc"
              fill="none"/>
        <line stroke-width="2" id="svg_13" y2="93.10226" x2="162.91033" y1="2.28247" x1="162.91033" stroke="#b3d4fc"
              fill="none"/>
        <ellipse stroke-width="2" ry="9.5" rx="9.5" id="svg_14" cy="102.84708" cx="82.42388" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="9.5" id="svg_15" cy="50.9334" cx="21.57424" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="9.5" id="svg_16" cy="105.82574" cx="19.02112" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="9.5" id="svg_17" cy="51.71614" cx="81.99836" stroke="b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="7.15963" id="svg_20" cy="30.50835" cx="147.316" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" transform="rotate(-35.9357, 82.6994, 16.1119)" ry="7.44663" rx="9.57424" id="svg_23"
                 cy="16.11193" cx="82.69944" stroke="#b3d4fc" fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="7.15963" id="svg_24" cy="63.09493" cx="131.99721" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
        <ellipse stroke-width="2" ry="9.5" rx="7.15963" id="svg_25" cy="95.79181" cx="114.97633" stroke="#b3d4fc"
                 fill="#b3d4fc"/>
      </g>
    </svg>
    <h1>Wstęp</h1>
    <p>
      Strona prezentuje wybrane gry planszowe i karciane.
      Do każdej gry dołączony jest krótki opis, podstawowe informacje
      (np.: liczba graczy, ich wiek, szacowany czas rozgrywki)
      oraz link do oferty na zakup danej gry.
    <div>
      <h1>Spis gier </h1>
      <table class="bordered">
        <tr>
          <th>Nazwa</th>
          <th>Wiek</th>
          <th>L. graczy</th>
          <th>Czas (min)</th>
        </tr>
        <tr>
          <td>Catan</td>
          <td>10+</td>
          <td>3-4</td>
          <td>75</td>
        </tr>
        <tr>
          <td>Cytadela</td>
          <td>10+</td>
          <td>2-8</td>
          <td>30-60</td>
        </tr>
        <tr>
          <td>Terraformacja Marsa</td>
          <td>12+</td>
          <td>1-5</td>
          <td>90-120</td>
        </tr>
        <tr>
          <td>Odjechane jednorożce</td>
          <td>10+</td>
          <td>2-8</td>
          <td>30-60</td>
        </tr>
      </table>
    </div>
    <h1>Polecane strony</h1>
    <ul>
      <li>
        <a href="https://www.rebel.pl/" target="_blank">rebel.pl</a> - sklep z bogatą ofertą gier planszowych i ich
        dokładnymi opisami.
      </li>
      <li>
        <a href="https://boardgamearena.com/" target="_blank">board game arene</a> - storna posiadającą całkiem sporą
        bibliotekę gier planszowych online.
      </li>
    </ul>
  </div>

  <?php dispatch($routing, '/nav') ?>

</div>
<footer id="foot">
  <div id="date"></div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="js/navigation_dynamic.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function (ev) {
    console.log("DOM fully loaded and parsed");
    addMouseHoverEffect();
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
