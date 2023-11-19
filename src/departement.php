<?php
include_once("includes/header.php");
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Récapitatif pour les départements</h1>
    
    <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
      <h2>Nombre d'alertes à la bombe chaque jour</h2>
      <div class="row justify-content-center">
        <div class="col-auto">
          <svg height="600px" width="600px"></svg>
        </div>
      </div>
    </div>

    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Au total en <span id="recapTitre"></span></h2>
          <div class="row">
            <div class="col-md-3">
              <h3 id="recapAlertes">XX</h3>
              <h4>Alertes à la bombe</h4>
            </div>
            <div class="col-md-3">
              <h3 id="recapVilles">XX</h3>
              <h4>Nombre de villes impactées</h4>
            </div>
            <div class="col-md-3">
              <h3>XX</h3>
              <h4>Etablissements scolaires impactés</h4>
            </div>
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Arrestations</h4>
            </div>
          </div>
        </div>

        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Les alertes</h2>
          <div class="row">
            <div>
              <table id="myTable" class="display">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Ville</th>
                    <th>Lieu</th>
                    <th>Nom du lieu</th>
                    <th>Type</th>
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
  </div>
</main>

<script>
  //https://www.datavis.fr/index.php/d3js/map-improve
  //https://pixees.fr/informatiquelycee/d3_a15.html
  let colors = ['#d4eac7', '#c6e3b5', '#b7dda2', '#a9d68f', '#9bcf7d', '#8cc86a', '#7ec157', '#77be4e', '#70ba45', '#65a83e', '#599537', '#4e8230', '#437029', '#385d22', '#2d4a1c', '#223815'];
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
        window.location = "?departement=" + i.properties.NOM_DEPT;
      });
  });

  let params = new URL(document.location).searchParams;
  const departement = params.get("departement");
  if (departement) {
    document.getElementById("recapTitre").textContent=departement;
    fillComponent(departement)
  }

  async function fillComponent(departement) {
    let data = await d3.csv('https://raw.githubusercontent.com/mathis-kdio/alerte-bombe-tracker/main/src/alertes.csv');

    const dataDepartement = data.filter(element => element.departement.toUpperCase() == departement.toUpperCase());
    recap(dataDepartement);
    table(dataDepartement);
  }

  function recap(data) {
    let totalAlertes = d3.count(data, (d) => d.nombre)
    document.getElementById("recapAlertes").textContent=totalAlertes;
    const villes = d3.groups(data, (d) => d.ville);
    document.getElementById("recapVilles").textContent=villes.length;
  }

  function table(data) {
    let table = new DataTable('#myTable', {
      data: data,
      order: [[0, 'desc']],
      columns: [
        { data: 'date' },
        { data: 'ville' },
        { data: 'type' },
        { data: 'nom' },
        { data: 'alerte' }
      ]
    });
  }

</script>

<?php
include_once("includes/footer.php");
?>