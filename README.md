# Installation

Suivre les commandes suivantes pour installer le site sur votre ordinateur

1. `cd /C/Documents/Sites`

2. `git clone https://github.com/victorweiss/wf3-386.git corrections`

3. `cd corrections`

4. `composer install`

5. Créer le fichier `.env.local` en changeant les variables

6. `symfony serve -d`

Une fois le projet installé, pour récupérer les mises à jours il suffira d'être dans le dossier /corrections et faire 
- `git pull`
- `composer install`
