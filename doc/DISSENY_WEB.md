# 🎨DISSENY WEB 
# 1-Avaluació heurística

## 1. Visibilitat de l’estat del sistema
Es compleix, ja que el sistema informa l’usuari en tot moment. Per exemple, si es produeix un error en l’enviament del formulari, aquest es mostra abans de finalitzar l’acció. Així mateix, quan es crea una incidència, es mostra una confirmació amb l’identificador corresponent.

---

## 2. Relació entre el sistema i el món real
Es compleix. S’utilitza un llenguatge proper a l’usuari i comprensible. A més, s’empren icones representatives, com ara una casa per tornar a l’inici, una gràfica per accedir a les estadístiques o un llapis per modificar incidències.

---

## 3. Control i llibertat de l’usuari
Es compleix. Totes les pàgines disposen d’opcions per tornar a la pàgina anterior i per tornar a l’inici. En les pàgines de modificació d’incidències, també s’inclou l’opció de cancel·lar l’acció. En el cas de la llista d’administració, s’ha implementat la possibilitat de restablir tots els filtres.

---

## 4. Consistència i estàndards
Es compleix. Els botons principals, com ara guardar, enviar, cancel·lar o tancar, mantenen una coherència visual i funcional en tot el sistema. Igualment, el logotip de la web redirigeix a la pàgina d’inici. També s’utilitza una paleta de colors consistent en tota l’aplicació.

---

## 5. Prevenció d’errors
Es compleix. Si el formulari s’envia amb camps obligatoris buits, el sistema no permet l’enviament i mostra un missatge d’error. Els camps obligatoris estan clarament indicats i els requisits mínims es mostren quan és necessari. A més, determinades accions crítiques, com el tancament d’una incidència, requereixen una confirmació prèvia.

---

## 6. Reconeixement abans que recordatori
Es compleix. Tots els botons inclouen text descriptiu, facilitant la comprensió de la seva funció. En la cerca d’incidències, s’ha incorporat la possibilitat de filtrar per departament, a més de per identificador, per facilitar la localització en cas que l’usuari no el recordi.

---

## 7. Flexibilitat i eficiència d’ús
Es compleix parcialment. El sistema inclou filtres que faciliten la cerca d’informació i un botó d’inici per evitar recorreguts innecessaris. En els formularis, es pot navegar entre camps mitjançant el tabulador, i els camps de selecció (select) permeten agilitzar l’entrada de dades sense necessitat d’escriure text manualment.

---

## 8. Disseny estètic i minimalista
Es compleix. El disseny es basa en els elements essencials per garantir una interfície clara i funcional. S’eviten elements innecessaris que puguin distreure l’usuari. Els textos i botons són clars i directes, i es fa ús d’una paleta de colors neta i coherent.

---

## 9. Ajuda als usuaris a reconèixer, diagnosticar i recuperar-se dels errors
Es compleix. Quan es produeix un error, es mostra un missatge clar i comprensible que indica què ha passat i com es pot solucionar.

---

## 10. Ajuda i documentació
Es compleix. El sistema incorpora elements d’ajuda contextual, com ara placeholders explicatius, indicació dels requisits dels camps i missatges d’error que guien l’usuari durant l’ús de l’aplicació.

---

# 2-WCAG

## Pàgina: Crear Incidència

La pàgina `crear_incidencies.php` ha estat desenvolupada seguint criteris d’accessibilitat WCAG 2.1 nivell AA.

### Mesures implementades

- Formulari estructurat amb etiquetes HTML semàntiques
- Ús de `label` associats correctament als camps del formulari
- Navegació accessible mitjançant teclat
- Camps obligatoris amb validació (`required`)
- Compatibilitat responsive amb Bootstrap 5
- Contrast visual adequat
- Estructura clara i llegible

### Aspectes pendents de millora

Actualment encara hi ha alguns aspectes d’accessibilitat millorables per complir completament WCAG AA:

- Els missatges d’error encara no utilitzen atributs ARIA (`aria-live`)
- Falta afegir descripcions contextuals addicionals als camps del formulari
- No s’ha implementat encara una gestió avançada del focus en errors
- Alguns elements visuals encara es poden millorar per augmentar la compatibilitat amb lectors de pantalla


## Pàgina: Llista d’Incidències (Tècnic)

La pàgina `llistaIncidencies.php` en la vista de tècnic ha estat desenvolupada seguint criteris d’accessibilitat WCAG 2.1 nivell AA.

### Mesures implementades

- Estructura semàntica amb etiquetes HTML adequades (`table`, `thead`, `tbody`, `th`, `td`)
- Ús correcte de `scope="col"` a les capçaleres de la taula
- Navegació accessible mitjançant teclat
- Enllaços accessibles per consultar el detall de cada incidència
- Compatibilitat responsive amb Bootstrap 5
- Separació clara entre contingut i navegació
- Taula amb estructura clara i llegible

### Aspectes pendents de millora

Actualment encara hi ha alguns aspectes d’accessibilitat millorables per complir completament WCAG AA:

- Alguns estats d’incidència depenen del color per transmetre informació visual
- El contrast del color taronja utilitzat en alguns textos pot ser insuficient
- No es mostra un missatge informatiu quan no existeixen incidències
- Alguns elements visuals encara es poden millorar per augmentar la compatibilitat amb lectors de pantalla
