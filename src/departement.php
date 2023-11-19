<?php
include_once("includes/header.php");
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Récapitatif pour les départements</h1>
    
    <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
      <h2>Nombre d'alertes à la bombe chaque jour</h2>
      <div class="row">
        <svg width="600px" height="600px">
        </svg>
      </div>
    </div>

    <!--
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Au total</h2>
          <div class="row">
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Alertes à la bombe</h4>
            </div>
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Nombre de villes impactées</h4>
            </div>
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Etablissements scolaires impactés</h4>
            </div>
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Arrestations</h4>
            </div>
          </div>
        </div>

        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Nombre d'alertes à la bombe chaque jour</h2>
          <div class="row">
            <div>
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>

        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Classements jours avec le plus d'alertes</h2>
          <div class="row">
            <div>
              <table id="myTable" class="display">
                <thead>
                  <tr>
                    <th>Jour</th>
                    <th>Nombre</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    -->
  </div>
</main>

<script>
  //https://www.datavis.fr/index.php/d3js/map-population
  //https://pixees.fr/informatiquelycee/d3_a15.html
  let svg = d3.select("svg");
  let path = d3.geoPath();
  let projection = d3.geoConicConformal()
    .center([2.454071, 46.279229])
    .scale(3000)
    .translate([300,300]);
  path.projection(projection);
  d3.json("departements.json").then(function(geoJSON) {
    let map = svg.selectAll("path").data(geoJSON.features)
    map.enter()
      .append("path")
      .attr("fill","white")
      .attr("stroke","black")
      .attr("d", path)
      .on("mouseover",function(d) {
        d3.select(this)
          .attr("fill","red")
          .style("cursor", "pointer")
      })
      .on("mouseout",function() {
        d3.select(this)
          .attr("fill","white")
          .style("cursor", "default")
      })
      .on("click", function(d, i) {
        window.location = "?departement=" + i.properties.CODE_DEPT;
      });
  });

</script>

<?php
include_once("includes/footer.php");
?>