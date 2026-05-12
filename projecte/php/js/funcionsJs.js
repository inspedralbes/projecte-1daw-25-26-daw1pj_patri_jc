//Per defecte mostra les que estan obertes encara
function mostrarIncidenciesActives(){
    document.querySelectorAll('tbody tr').forEach(fila => {
        const estat = fila.dataset.estat;
        if(estat === 'Tancada') {
            fila.style.display = 'none';
        }
    });
}



//filtrar entre incidencies assignades i no assignades
function filtreAssignades(){
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
}


//filtra per estat de la incidencia
function filtreEstat(){
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
}

//Si envia el form del modal de update incidencia sense cap camp omplert dona error
function errorUpdateIncidencia(){

    document.querySelectorAll('.modal form').forEach(form => {
        form.addEventListener('submit', event => {
            var prioritat = form.querySelector('[name="prioritat"]').value;
            var tecnic = form.querySelector('[name="tecnic"]').value;
            var tipus = form.querySelector('[name="tipus"]').value;

            if(prioritat === '' && tecnic ==='' && tipus === ''){
                event.preventDefault(); //prevé que s'envii el formulari si elstres camps son vuits.

                var idIncidencia = form.action.split('id=')[1].split('&')[0];
                //agafa de l'url la part que va despres de id= i (3&rol=admin) i desprésla part que va abans del & (3) aixi obtneim l'id del modal i la incidencia per posar l'error al modal correcte ja que cada incidencia té un modal propi amb el mateix id.

                var error=document.getElementById('error-updateInc-' + idIncidencia);
                //Busca el div que conté el id error-updateInc...

                error.classList.remove('d-none');
                //Treu la calsse d-none que es amb la que bootstrap oculta el div amb l'error
            }

        });
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () =>{ //Quan el modal esta tancat
            var errors = modal.querySelectorAll('.alert'); //agafa totes les classes alert
            errors.forEach(error =>{
                error.classList.add('d-none'); // i a cada una li afegeix a la clase d-none per ocultarles
            });
        });
    });
}


function comprobarCrearIncidencia(){
        document.querySelector('form').addEventListener('submit', function(e){
            var valid = true;
            var errores = [];

            const dept = document.querySelector('select[name="dept"]').value;
            const tipus = document.querySelector('select[name="tipus"]').value;
            const desc = document.querySelector('textarea[name="desc"]').value;

            if(dept === '' || dept === 0){
                valid = false;
                errores.push('Has de seleccionar un departament.');
            }

            if(tipus === '' || tipus === 0){
                valid = false;
                errores.push('Has de seleccionar un tipus.');
            }

            if(desc.trim().length < 20){
                valid = false;
                errores.push('La descripció ha de tenir com a mínim 20 caràcters.')
            }

            if (!valid){
                e.preventDefault();
                
                var errorDiv = document.getElementById('errors');
                errorDiv.innerHTML = '';

                errores.forEach(function(error){
                    errorDiv.innerHTML += '<p class ="text-danger">⚠️ ' + error + '</p>'
                });
            }
        });
    }

    function introduirDesc(){
        
        document.querySelector('form').addEventListener('submit',function(e){

            var valid = true;
            var errores = [];

            const temps = document.querySelector('input[name="temps"]').value;
            const desc = document.querySelector('textarea[name="desc"]').value;
            const dataActuacio = document.querySelector('input[name="dataActuacio"]').value;
            
            if(temps === ''){
            valid = false;
            errores.push('Has de posar el temps dedicat.');
        }

        if(dataActuacio && dataActuacio.type === 'date' && dataActuacio.value === ''){
            valid = false;
            errores.push('Has de posar la data.');
        }
        if(desc.trim() === ''){
            valid = false;
            errores.push('La descripció no pot estar buida.');
        }
        if(desc.trim().length < 20){
            valid = false;
            errores.push('La descripció ha de tenir com a mínim 20 caràcters.');
        }

        if(!valid){
            e.preventDefault();
            var errorDiv = document.getElementById('errors');
            errorDiv.innerHTML = '';
            errores.forEach(function(error){
                errorDiv.innerHTML += '<p class="text-danger">⚠️ ' + error + '</p>';
            });
        }
        });
    }
    

    comprobarCrearIncidencia();
    mostrarIncidenciesActives();
    filtreAssignades();
    filtreEstat();
    errorUpdateIncidencia();
    introduirDesc();