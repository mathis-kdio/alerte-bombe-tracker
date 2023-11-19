import os
import csv
from collections import Counter

__location__ = os.path.realpath(os.path.join(os.getcwd(), os.path.dirname(__file__)))

# Lecture du fichier CSV d'origine
with open(os.path.join(__location__, 'alertes.csv'), 'r') as fichier_csv:
    csv_reader = csv.reader(fichier_csv)

    # Ignorer l'en-tête
    en_tete = next(csv_reader, None)

    # Initialiser un compteur de dates
    compteur_dates = Counter()

    # Parcourir les lignes du fichier et compter les alertes de chaque date
    for ligne in csv_reader:
        date = ligne[2]  # La troisième colonne contient la date
        compteur_dates[date] += 1

# Écriture des résultats dans un nouveau fichier CSV
with open(os.path.join(__location__, 'alertes_par_jours.csv'), 'w', newline='') as fichier_resultat:
    csv_writer = csv.writer(fichier_resultat)

    # Écrire l'en-tête du nouveau fichier CSV
    csv_writer.writerow(['Date', 'Nombre d\'alertes'])

    # Écrire les données dans le nouveau fichier CSV
    for date, nombre_alertes in compteur_dates.items():
        csv_writer.writerow([date, nombre_alertes])