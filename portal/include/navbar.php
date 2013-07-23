<!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <div class="container">
      <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <a href="#" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a> 
          <a href="index.php" class="brand">DOMOTIQUE</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Maison<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li class="disabled">
                    <a href="#">Salon</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Living</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Family room</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Mezzanine</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Chambre parents</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Chambre Fanny</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Chambre Max</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Salle TV</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Salle de jeu</a>
                  </li>
                  <li class="dropdown-submenu">
                    <a href="#" tabindex="-1">Cave à vin</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="chart_sonde.php?sonde_id=1">Température</a>
                            </li>
                             <li>
                                <a href="chart_sonde.php?sonde_id=2">Humidité</a>
                            </li>
                        </ul>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Météo<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li class="disabled">
                    <a href="#">Température</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Humidité</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=3">Pression</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Pluviométrie</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Vitesse et direction du vent</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Luminosité</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">VMC<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="chart_sonde.php?sonde_id=7">Puit Canadien</a>
                  </li>
                  <li class="dropdown-submenu">
                    <a href="#" tabindex="-1">Températures à l'échangeur</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="chart_sonde.php?sonde_id=4">Température Pulsion air frais</a>
                            </li>
                             <li>
                                <a href="chart_sonde.php?sonde_id=5">Température Aspiration air frais</a>
                            </li>
							<li>
                                <a href="chart_sonde.php?sonde_id=6">Température Pulsion air vicié</a>
                            </li>
                             <li>
                                <a href="chart_sonde.php?sonde_id=8">Température Aspiration air vicié</a>
                            </li>
                        </ul>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=9">Humidité air vicié</a>
                  </li>
                  <li class="disabled">
                    <a href="#">Contrôle de vitesse</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Eau<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                   <li  class="dropdown-submenu">
                    <a href="#"  tabindex="-1">Eau potable froide</a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="chart_sonde.php?sonde_id=21">Température</a>
                        </li>
                        <li>
                           <a href="chart_sonde.php?sonde_id=18">Consommation</a>
                        </li>
                    </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <a href="#"  tabindex="-1">Eau potable Chaude</a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="chart_sonde.php?sonde_id=10">Température</a>
                        </li>
                        <li>
                           <a href="chart_sonde.php?sonde_id=17">Consommation</a>
                        </li>
                    </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <a href="#"  tabindex="-1">Eau de pluie</a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="chart_sonde.php?sonde_id=20">Température</a>
                        </li>
                        <li>
                           <a href="chart_sonde.php?sonde_id=19">Consommation</a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Electricité<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="chart_sonde.php?sonde_id=24">Bilan [W]</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=16">Consommation [Wh]</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=23">Puissance [W]</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=15">Production photovoltaïque [Wh]</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=22">Puissance capteurs photovoltaïques [W]</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Solaire thermique<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="chart_sonde.php?sonde_id=14">Température entrée des capteurs</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=13">Température sortie des capteurs</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=12">Température bas du ballon solaire</a>
                  </li>
                  <li>
                    <a href="chart_sonde.php?sonde_id=11">Température haut du ballon solaire</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gaz<b class="caret dropdown-toggle"></b></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#">Consommation</a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav pull-right">
              <li>
                <a href="#about">A propos</a>
              </li>
            </ul>
          </div>
          </div>
        </div>
      </div>
    </div>
