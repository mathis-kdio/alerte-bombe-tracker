import os
import csv
from collections import Counter

__location__ = os.path.realpath(os.path.join(os.getcwd(), os.path.dirname(__file__)))

# Lecture du fichier CSV d'origine
with open(os.path.join(__location__, 'alertes.csv'), 'r') as fichier_csv:
    csv_reader = csv.reader(fichier_csv)

    # Ignorer l'en-tête
    en_tete = next(csv_reader, None)

    # Initialiser un compteur de villes
    compteur_villes = Counter()

    # Parcourir les lignes du fichier et compter les alertes de chaque ville
    for ligne in csv_reader:
        ville = ligne[0]  # La première colonne contient la ville
        compteur_villes[ville] += 1

# Écriture des résultats dans un nouveau fichier CSV
with open(os.path.join(__location__, 'alertes_par_jours.csv'), 'w', newline='') as fichier_resultat:
    csv_writer = csv.writer(fichier_resultat)

    # Écrire l'en-tête du nouveau fichier CSV
    csv_writer.writerow(['ville', 'nombre'])

    # Écrire les données dans le nouveau fichier CSV
    for ville, nombre_alertes in compteur_villes.items():
        csv_writer.writerow([ville, nombre_alertes])