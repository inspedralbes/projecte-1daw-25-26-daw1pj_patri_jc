# Funcionalitats JavaScript

## Filtres d'incidències

**mostrarIncidenciesActives()**
Mostra només les incidències actives quan es carrega la pàgina.

**filtreAssignades()**
Filtra les incidències entre totes o només les no assignades a cap tècnic.

**filtreEstat()**
Filtra les incidències entre totes o només les actives.

## Validacions de formularis

**errorUpdateIncidencia()**
Valida el formulari d'edició d'incidències. Evita enviar-lo si els camps prioritat, tècnic i tipus estan buits. Mostra un error i l'oculta en tancar el modal.

**comprobarCrearIncidencia()**
Valida la creació d'incidències. Comprova que departament i tipus estiguin seleccionats i que la descripció tingui mínim 20 caràcters.

**introduirDesc()**
Valida el formulari d'actuacions de tècnics. Comprova que temps, data i descripció (mínim 20 caràcters) estiguin correctes.

**comprobarFinalitzarIncidencia()**
Mostra un missatge de confirmació abans de finalitzar una incidència.

## Navegació entre pestanyes

**showSection()**
Canvia entre les seccions principals: Gràfiques i Logs.

**showTopic()**
Canvia entre les pestanyes dins de Gràfiques: Accessos, Pàgines i Rols. En tornar a Gràfiques, reinicia a la pestanya Accessos.

## Inicialització

Totes les funcions s'executen automàticament en carregar la pàgina.
