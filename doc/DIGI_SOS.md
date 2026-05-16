## 📁 Estructura del Projecte

* **php/**: Codi font de l'aplicació web.
  * **assets/**: Imatges i recursos estàtics.
  * **css/**: Fulls d'estil.
  * **js/**: Validacions i funcions JavaScript.
  * **header-footer/**: Capçalera i peu de pàgina comuns.
  * **index.php**: Pàgina d'inici i login.
  * **usuari.php / tecnic.php / admin.php**: Menús segons el rol.
  * **buscar_incidencia.php / crear_incidencies.php / llistaIncidencies.php / detall_incidencia.php**: Gestió de les incidències.
  * **afegir_actuacio.php / modificar_incidencia.php**: Edició i seguiment.
  * **confirmacio.php**: Pàgina d'èxit de les accions.
  * **consum_dept.php / informe_tecnics.php / estadistiques_acces.php**: Informes i estadístiques (MySQL/MongoDB).
  * **connexio.php / funcions.php / logger.php**: Lògica interna, connexions i registre de logs.
* **db_init/**: Scripts SQL per inicialitzar la base de dades.
* **db_data/**: Dades persistents de la base de dades.
* **diagrames/**: Diagrames del projecte.
* **doc/**: Documentació del sistema.
* **images/**: Imatges del projecte.
* **docker-compose.yaml**: Configuració de l'entorn Docker.

## ⚙️ Funcionalitats Implementades

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
