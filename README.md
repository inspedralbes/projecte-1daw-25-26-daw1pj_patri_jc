# 📌 Projecte Gestió d’Incidències

## 👥 Grup 
 - Grup 6

## 👨‍💻 Integrants del projecte
 - Juan Carlos Diaz Dual
 - Patricia Fornieles Rosa

---

## 🎯 Objectiu del projecte

Desenvolupar una una aplicació web de gestió d’incidències que permeti:
- Als usuaris crear noves incidències i comprovar el seu estat
- Als tècnics gestionar-les i afegir-hi actuacions
- Als administradors supervisar el sistema

---

## 🚧 Estat del projecte

El projecte es troba funcionalment complet, amb possibles millores futures. S’han implementat les funcionalitats principals i els requisits del sistema seguint les User Stories, incloent la gestió d’incidències, validacions, filtres, estadístiques i registre de logs

---

## 📖 Funcions principals del projecte

- Crear incidències
- Gestionar incidències segons el rol
- Registrar actuacions tècniques
- Filtrar i consultar incidències
- Visualitzar estadístiques i logs d’accés

El sistema està dividit en diferents rols:
- 👤 Usuari
- 🛠️ Tècnic
- 👨‍💼 Administrador

---

# ⚙️ Instal·lació del projecte

## 📋 Requisits previs

És necessari tenir instal·lat:
- PHP 7.4 o superior (recomanat PHP 8+)
- Servidor web (Apache o similar)
- Navegador web modern

## 🚀 Administració de la base de dades

### Local
- MySQL → Adminer: http://localhost:8081  
- MongoDB → mongo-express: http://localhost:8082

### Producció
- MySQL → phpMyAdmin
- MongoDB → Atlas (cloud)

## ⚙️ Configuració (.env)

La connexió a les bases de dades es configura mitjançant variables d’entorn:

```bash id="env"
VAR1=usuari_mysql
VAR2=password_mysql
VAR3=root_password
MONGODB_URI=mongodb://mongo:27017
```

## 🧠 Tecnologies utilitzades
- PHP
- JavaScript
- HTML / CSS
- Bootstrap
- MySQL
- MongoDB
- Chart.js (visualització de dades i gràfiques)

---

# 🔗 Links del projecte

## 🎨 Prototipatge / Wireframing

🔗 [Wireframing del projecte](https://design.penpot.app/#/view?file-id=ceed1600-61c0-8087-8007-e869e1004e03&page-id=ceed1600-61c0-8087-8007-e869e1004e04&section=interactions&frame-id=cca6d22d-0d62-80c7-8007-e869e9551fcf&index=0&share-id=614162e1-9f0e-816a-8007-eea89bb7ce69)

---

## 🌐 Projecte desplegat

🔗 [Accedir al projecte](http://g6.daw.inspedralbes.cat/projecte-1daw-25-26-daw1pj_patri_jc/php/index.php)
