<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webradio</title>
    <link rel="stylesheet" href="/lib/materialize/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }
        
        .control-icon {
            background: red;
        }
    </style>
<body>
    <nav>
        <div class="nav-wrapper teal lighten-1">
          <a href="#!" class="brand-logo">Webradio</a>
        </div>
    </nav>

    <div id="switchStation" class="modal">
        <div class="modal-content">
          <h4>Radiostation auswählen</h4>
          <h5 style="margin-top: 40px;">Radiostation suchen</h5>
          <div class="input-field">
            <input id="search-and-play-input" type="text" class="validate">
            <label for="search-and-play-input">Name der Radiostation</label>
            <a class="waves-effect waves-light btn" onclick="play_by_name()">suchen & spielen</a>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Schließen</a>
        </div>
      </div>    

    <div class="row">
        <div class="card col-sm-4">
            <div class="card-image">
              <img id="radio-station-picture" alt="Kein Bild gefunden" height="512">
              <h1 class="card-title" id="radio-station-time"></h1>
              <a class="btn-floating btn-large halfway-fab waves-effect waves-light red modal-trigger" href="#switchStation"><i class="material-icons">radio</i></a>
            </div>
            <div class="card-content">
                <h5 id="radio-station-song"></h5>
                <h6 id="radio-station-name"></h6>
                <p class="range-field">
                    <input type="range" id="volume-slider" min="0" max="100" />
                </p>

                <div class="row">
                    <a class="btn-floating btn-large waves-effect waves-light green col-sm-6" onclick="resume()"><i class="material-icons">play_arrow</i></a>
                    <a class="btn-floating btn-large waves-effect waves-light red col-sm-6" onclick="stop()"><i class="material-icons">stop</i></a>
                </div>
            </div>
        </div>
    </div>

    <script src="/lib/jquery/jquery.js"></script>
    <script src="/lib/materialize/js/materialize.js"></script>
    <script src="index.js"></script>
</body>
</html>