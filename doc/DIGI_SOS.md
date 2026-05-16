## Funcionalitats Implementades

### Gestió d'Incidències
- Creació de noves incidències amb departament, tipus i descripció
- Visualització del detall de cada incidència
- Modificació de prioritat, tècnic i tipus per part de l'administrador
- Tancament d'incidències per part del tècnic

### Gestió d'Actuacions
- Afegir actuacions a una incidència
- Modificar actuacions existents
- Control de visibilitat per a l'usuari
- Càlcul del temps total dedicat per incidència

### Rols d'Usuari
- **Usuari** → Cerca incidències per departament, crea noves incidències i consulta l'estat
- **Tècnic** → Gestiona les seves incidències assignades i afegeix actuacions
- **Administrador** → Accés complet, filtres avançats i modificació d'incidències

### Informes i Estadístiques
- Informe de consum per departament (nombre d'incidències i temps dedicat)
- Informe d'incidències actives per tècnic
- Estadístiques d'accés amb gràfiques i logs

### Logs amb MongoDB
- Registre automàtic de cada accés a l'aplicació
- Filtratge de logs per data, rol i pàgina
- Gràfiques d'accessos per dia

### Validacions
- Validació de formularis amb JavaScript (camps obligatoris, mínim de caràcters)
- Confirmació abans de tancar una incidència
- Validació de dades al servidor amb PHP
