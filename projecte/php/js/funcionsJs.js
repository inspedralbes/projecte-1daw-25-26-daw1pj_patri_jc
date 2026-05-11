//Per defecte mostra les que estan obertes encara
document.querySelectorAll('tbody tr').forEach(fila => {
    const estat = fila.dataset.estat;
    if(estat === 'Tancada') {
        fila.style.display = 'none';
    }
});


//filtrar entre incidencies assignades i no assignades
document.querySelectorAll('[data-f-tecnic]').forEach(btn => { //troa todos els botons del filtre
    btn.addEventListener('click', function() { // Escolta quan fas click
        const filtre = this.dataset.fTecnic; //Llegeix l'atribut data de cada fila

        document.querySelectorAll('tbody tr').forEach(fila => { //recorre totes les tr que hi ha dins de tbody, totes les files de les incidencies
            const tecnic = fila.dataset.tecnic; //llegeix l'atribut data-tecnic del tr

            if (filtre === 'totes') {
                fila.style.display = ''; //mostra la fila
            }else if(filtre === 'no_assignades'){
                if(tecnic === ''){
                    fila.style.display = ''; //si el tecnic esta buit (no assignada) mostra la fila
                }else{
                    fila.style.display = 'none'; //si esta asginada l'amaga
                }
            }
        });
    });
});

//filtra per estat de la incidencia
document.querySelectorAll('[data-f-estat]').forEach(btn => {
    btn.addEventListener('click', function() {
        const filtre = this.dataset.fEstat;

        document.querySelectorAll('tbody tr').forEach(fila => {
            const estat = fila.dataset.estat;
                console.log(estat);
            
            if(filtre === 'totes'){
                fila.style.display = '';
            }else if(filtre === 'actives'){
                if(estat === 'Tancada'){
                    fila.style.display = 'none';
                } else {
                    fila.style.display = '';
                }
            }      
        });
    });
});

//TODO HAY QUE CAMBIARLO TODO