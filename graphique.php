<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphique Facturation</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<label for="client">Sélectionnez un client :</label>
<input type="text" id="client" placeholder="Nom du client">
<button onclick="loadChart()">Charger</button>

<canvas id="factureChart"></canvas>

<script>
    function loadChart() {
        const client = document.getElementById('client').value;
        if (!client) {
            alert("Veuillez entrer un nom de client");
            return;
        }

        fetch(`data.php?client=${encodeURIComponent(client)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                const labels = data.map(item => item.nomAppli);
                const values = data.map(item => parseFloat(item.TotalFacture));

                const ctx = document.getElementById('factureChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Facturé (€)',
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            })
            .catch(error => console.error('Erreur:', error));
    }
</script>

</body>
</html>
