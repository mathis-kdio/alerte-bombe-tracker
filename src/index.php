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
          <h2>Les chiffres d'aujoud'hui (14-11-2023)</h2>
          <div class="row">
            <div class="col-md-3">
              <h3>21</h3>
              <h4>Alertes à la bombe</h4>
            </div>
            <div class="col-md-3">
              <h3>7</h3>
              <h4>Nombre de villes impactées</h4>
            </div>
            <div class="col-md-3">
              <h3>21</h3>
              <h4>Etablissements scolaires impactés</h4>
            </div>
            <div class="col-md-3">
              <h3>XXX</h3>
              <h4>Arrestations</h4>
            </div>
          </div>
        </div>

        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Les alertes les plus récentes</h2>
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
      </div>
    </div>
  </div>
</main>

<script>
  d3.csv('alertes.csv').then(fillComponent);

  function fillComponent(data) {
    table(data);
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
</script>

<?php
include_once("includes/footer.php");
?>