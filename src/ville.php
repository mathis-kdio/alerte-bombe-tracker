<?php
include_once("includes/header.php");
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Récapitatif pour les villes</h1>

    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="p-5 bg-body-tertiary border rounded-3 mb-3">
          <h2>Classements des villes avec le plus d'alertes</h2>
          <div class="row">
            <div>
              <table id="myTable" class="display">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Département</th>
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
  d3.csv('https://raw.githubusercontent.com/mathis-kdio/alerte-bombe-tracker/main/src/alertes_par_ville.csv').then(fillComponent);

function fillComponent(data) {
  table(data);
}

function table(data) {
  let table = new DataTable('#myTable', {
    data: data,
    order: [[1, 'desc']],
    columns: [
      { data: 'nom',
        render: function (data, type, row) {
          return '<a href="?ville='+row.nom+'">'+row.nom+'</a>';
        }
      },
      { data: 'departement',
        render: function (data, type, row) {
          return '<a href="departement.php?departement='+row.departement+'">'+row.departement+'</a>';
        }
      },
      { data: 'nombre' }
    ]
  });
}

</script>

<?php
include_once("includes/footer.php");
?>