
# ECF - Part 1 - Projet bibliothèque - BDD

## Cahier des charges

### User

Attributs :

- id : clé primaire
- email : varchar 190
- roles : text
- password : varchar 190

Relations :

- aucune



### Livre

Attributs :

- id : clé primaire
- titre : varchar 190
- annee_edition : int, nullable
- nombre_pages : int
- code_isbn : varchar 190, nullable

Relations :

- auteur : many to one
- genres : many to many
- emprunts : one to many

### Auteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190

Relations :

- livres : one to many

### Genre

Attributs :

- id : clé primaire
- nom : varchar 190
- description : text, nullable

Relations :

- livres : many to many

### Emprunteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190
- tel : varchar 190
- actif : boolean
- date_creation : datetime
- date_modification : datetime, nullable

Relations :

- emprunts : one to many
- user : one to one, unidirectionnel

### Emprunt

Attributs :

- id : clé primaire
- date_emprunt : datetime
- date_retour : datetime, nullable

Relations :

- emprunteur : many to one
- livre : many to one