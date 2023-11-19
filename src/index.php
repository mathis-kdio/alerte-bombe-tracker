<?php
include_once("includes/header.php");
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Statistiques et visualisations des alertes à la bombe en France</h1>
    <p class="lead">AlerteBombeTracker est un outil permettant de suivre l'évolution des alertes à la bombe en France. Pour des analyses quotidiennes des chiffres, vous pouvez suivre @ sur X.</p>
    
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Les chiffres d'aujoud'hui (<span id="recapDate">XX-XX-XX</span>)</h2>
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
          <h2>Les alertes du jour</h2>
          <div class="row">
            <div>
              <table id="myTable" class="display">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Ville</th>
                    <th>Département</th>
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

        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Répartition des types de lieux touchés aujourd'hui</h2>
          <div class="row justify-content-center">
            <div class="col-6">
              <canvas id="graphTypesLieux"></canvas>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<script>
  d3.csv('https://raw.githubusercontent.com/mathis-kdio/alerte-bombe-tracker/main/src/alertes.csv').then(fillComponent);

  function fillComponent(data) {
    const date = new Date();
    let today = date.getDate() +'/'+ (date.getMonth() + 1) +'/'+ date.getFullYear().toString().slice(-2);
    document.getElementById("recapDate").textContent=today;

    const dataToday = data.filter(element => element.date == today);
    recap(dataToday);
    table(dataToday);
    graphTypesLieux(dataToday);
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
        { data: 'departement' },
        { data: 'type' },
        { data: 'nom' },
        { data: 'alerte' }
      ]
    });
  }

  function graphTypesLieux(data) {
    const ctx = document.getElementById('graphTypesLieux');
    let alertesData = data.map(function(d) {return d.type});
    let labels = [...new Set(alertesData)]
    const occurrences = alertesData.reduce(function (acc, curr) {
      return acc[curr] ? ++acc[curr] : acc[curr] = 1, acc
    }, {});
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          label: 'touchés aujourd\'hui',
          data: Object.values(occurrences),
        }]
      }
    });
  }

</script>

<?php
include_once("includes/footer.php");
?>