# 🗄️ Documentació de MongoDB BASE DE DADES

S'ha utilitzat MongoDB per emmagatzemar i consultar els logs d’activitat de l’aplicació.
A més s'han implementat filtres per consultar segons diferents criteris.

## 🔎 Consultes principals
- Data de l’accés
- Rol de l’usuari
- Pàgina visitada (URL)

---

## 📋 1- Registre de logs
Funció per inserir els logs a la database
```
function inserirLog(){
        $collection = getCollection();

        if(!$collection){
            error_log("MONGODB no té URI configurada.");
            return;
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconegut';
        date_default_timezone_set('Europe/Madrid');
        $data = date('Y-m-d H:i:s');
        $rol = $_GET['rol'] ?? '';

        $collection->insertOne([
            'url' => $_SERVER['REQUEST_URI'],
            'metode' => $_SERVER['REQUEST_METHOD'],
            'rol' => $rol,
            'data' => $data,
            'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'ip' => $ip
        ]);
    }
```
---

## 📌 2- Filtre
Funció per filtrar els documents segons els paràmetres rebuts

``` 
    function filtrarDocuments($collection, $date, $usuari, $pagina) {
    //Construimos el filtro
    $filter = [];

    
    if (!empty($date)) {
       
        $filter['data'] = [
            // Filtrar por el rango de fechas del día
            '$gte' => $date . " 00:00:00",
            '$lte' => $date . " 23:59:59"
        ];
    }

    
    if (!empty($usuari)) {
        // Filtrar por rol exacto
        $filter['rol'] = $usuari;
    }

    
    if (!empty($pagina)) {
    
    //Utilizamos regex para buscar la palabra dentro de la URL
    $filter['url'] = ['$regex' => $pagina];
}

    return $collection->find($filter);
}
```
---

## 📊 3- Pipelines d’agregació

### 👤 Rols més actius
Aquest pipeline obté els rols emmagatzemats a la base de dades, sempre que el camp no estigui buit ni sigui nul. Posteriorment, els agrupa i calcula quants cops s’ha fet ús de cada rol. Finalment, els ordena per ordre descendent segons el nombre d’accessos.
```
$rolGr = $collection->aggregate([
    ['$match' => [
        'rol' => [
            '$nin' => [null, '', ' ']
        ]
    ]],
    ['$group' => [
        '_id' => '$rol',
        'total' => ['$sum' => 1]
    ]],
    ['$sort' => ['total' => -1]]
]);
```
--

### 🌐 Pàgines més visitades
Aquest pipeline agafa el nom de la pàgina del url, les agrupa per analitzar quines han sigut més visitades
```
paginesMesVisitadesGr = $collection->aggregate([
    ['$group' => [
        '_id' => '$url',
        'total' => ['$sum' => 1]
    ]],

    ['$sort' => ['total' => -1]],
]);
```
### 📅 Accessos
Aquest pipeline agafa de la posició 0 de la data fins la 10, per obtenir la data i els agrupa per generar estadístiques d'accesos

```
$estadAccessAvui = $collection->aggregate([
    ['$group' => [
        '_id' => ['$substr' => ['$data', 0, 10]],
        'total' => ['$sum' => 1]
    ]], // Agrupa per data els accesos agafant desde la pos 0 del string fins la 10 i després suma 1 per a aquella data al total.
    ['$sort' => ['_id' => 1]]
]);

```
---
 
## 🛠️ 4- Diagrama E-R
Diagrama entitat relació de la base de dades SQL

