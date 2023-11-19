<?php
include_once("includes/header.php");
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Récapitatif pour la France</h1>
    
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Au total</h2>
          <div class="row">
            <div class="col-md-3">
              <h3 id="recapAlertes">XXX</h3>
              <h4>Alertes à la bombe</h4>
            </div>
            <div class="col-md-3">
              <h3 id="recapVilles">XXX</h3>
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
  </div>
</main>

<script>
  d3.csv('https://raw.githubusercontent.com/mathis-kdio/alerte-bombe-tracker/main/src/alertes.csv').then(recap);
  d3.csv('https://raw.githubusercontent.com/mathis-kdio/alerte-bombe-tracker/main/src/alertes_par_jours.csv').then(fillComponent);

  function fillComponent(data) {
    graph(data);
    table(data);
  }

  function recap(data) {
    let totalAlertes = d3.count(data, (d) => d.nombre)
    document.getElementById("recapAlertes").textContent=totalAlertes;
    const villes = d3.groups(data, (d) => d.ville);
    document.getElementById("recapVilles").textContent=villes.length;
  }

  function graph(data) {
    const ctx = document.getElementById('myChart');
    let dateLabels = data.map(function(d) {return d.date});
    let alertesData = data.map(function(d) {return d.nombre});
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: dateLabels,
        datasets: [{
          label: '# nombre d\'alerte en France par jour',
          data: alertesData,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }

  function table(data) {
    let table = new DataTable('#myTable', {
      data: data,
      order: [[1, 'desc']],
      columns: [
        { data: 'date' },
        { data: 'nombre' }
      ]
    });
  }
</script>

<?php
include_once("includes/footer.php");
?>