<template>
    <div class="container-fluid justify-content-center">
        <nav class="navbar navbar-dark sticky-top" style="background-color: rgb(247, 247, 247)">
          <h2>Gestion Personnelle:{{' '}}<span class="badge badge-secondary">{{persos.length}}</span></h2>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Entrez la matricule" aria-label="Search" @keyup="search" v-model="q">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal" @click="init">
                    Nouveau Personnel
                </button>
            </form>     
        </nav>
        <div class="container-fuild">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="error != ''">
                <p>{{error}}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table">
                <caption>List of users</caption>
                <thead>
                    <tr>
                    <th scope="col">Matricule</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom(s)</th>
                    <th scope="col">Date de Naissance</th>
                    <th scope="col">Lieu de Naissance</th>
                    <th scope="col">Cin</th>
                    <th scope="col">Poste</th>
                    <th scope="col">Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="perso in persos" :key="perso.id">
                        <td>{{ perso.matricule }}</td>
                        <td>{{ perso.nom }}</td>
                        <td>{{ perso.prenom }}</td>
                        <td>{{ perso.dateNaiss }}</td>
                        <td>{{ perso.lieuNaiss }}</td>
                        <td>{{ perso.cin }}</td>
                        <td>{{ perso.poste }}</td>
                        <td><Trash2Icon stroke="#FF0000" data-toggle="modal" data-target="#deleteModal" @click="fixId(perso)"/>{{' '+' '}}<EditIcon stroke="#00FF00" data-toggle="modal" data-target="#editModal" @click="fixId(perso)"/></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Store-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajout d'un Personnelle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="matricule">Matricule</label>
                                <input v-model="matricule" type="text" class="form-control" id="matricule" aria-describedby="matriculeHelp" placeholder="Entrez le numero matricule De la forme 0001/H ou 0001/F" required pattern="[0-9]*/[H|F|f|h]">
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input v-model="nom" type="text" class="form-control" id="nom" placeholder="Entrez votre nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom(s)</label>
                                <input v-model="prenom" type="text" class="form-control" id="prenom" placeholder="Entrez votre prenom">
                            </div>
                            <div class="form-group">
                                <label for="dateNaiss">Date de naissance</label>
                                <input v-model="dateNaiss" type="date" class="form-control" id="dateNaiss" required>
                            </div>
                            <div class="form-group">
                                <label for="lieuNaiss">Lieu de Naissance</label>
                                <input v-model="lieuNaiss" type="text" class="form-control" id="lieuNaiss" placeholder="Entrez le lieu de naissance" required>
                            </div>
                            <div class="form-group">
                                <label for="cin">CIN</label>
                                <input v-model="cin" type="text" class="form-control" id="cin" aria-describedby="cinHelp" placeholder="501031526856" maxlength="12" required pattern="[0-9]{12}">
                            </div>
                            <div class="form-group">
                                <label for="poste">Poste</label>
                                <input v-model="poste" type="text" class="form-control" id="poste" placeholder="Entrez votre la poste" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" @click="storePerso">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit-->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajout d'un Personnelle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="matricule">Matricule</label>
                                <input v-model="matricule" disabled type="text" class="form-control" id="matricule" aria-describedby="matriculeHelp" placeholder="Entrez le numero matricule De la forme 0001/H ou 0001/F" required pattern="[0-9]*/[H|F|f|h]">
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input v-model="nom" type="text" class="form-control" id="nom" placeholder="Entrez votre nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom(s)</label>
                                <input v-model="prenom" type="text" class="form-control" id="prenom" placeholder="Entrez votre prenom">
                            </div>
                            <div class="form-group">
                                <label for="dateNaiss">Date de naissance</label>
                                <input v-model="dateNaiss" type="date" class="form-control" id="dateNaiss">
                            </div>
                            <div class="form-group">
                                <label for="lieuNaiss">Lieu de Naissance</label>
                                <input v-model="lieuNaiss" type="text" class="form-control" id="lieuNaiss" placeholder="Entrez le lieu de naissance">
                            </div>
                            <div class="form-group">
                                <label for="cin">CIN</label>
                                <input v-model="cin" type="text" class="form-control" id="cin" aria-describedby="cinHelp" placeholder="501031526856" maxlength="12" required pattern="[0-9]{12}">
                            </div>
                            <div class="form-group">
                                <label for="poste">Poste</label>
                                <input v-model="poste" type="text" class="form-control" id="poste" placeholder="Entrez votre la poste" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" @click="updatePerso">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Supp-->
         <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Suppression d'un Personnelle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Confirmez la suppression
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger" data-dismiss="modal" @click="deletePerson">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UrlStore from '../stores/UrlStore';
    import { EditIcon, Trash2Icon } from "vue-feather-icons";

    export default {

        components:{
            EditIcon,
            Trash2Icon,
        },

        data(){
            return {
                url: UrlStore.data,

                id: '',
                matricule:'',
                nom: '',
                prenom: '',
                dateNaiss: '',
                lieuNaiss: '',
                cin: '',
                poste: '',

                persos: {},
                error: '',
                q:'',
            }
        },

        methods:{
            validation(mat, carteIdentite){
                let reMatricule = new RegExp(/^[0-9]+\/[f|h|F|H]$/, 'i');
                let reCin = new RegExp(/[0-9]{12}/,'i');
                return (reMatricule.test(mat) && reCin.test(carteIdentite))
            },

            recuperation(){
                axios.get(this.url.url + '/listePerso/')
                .then(response => this.persos = response.data.perso)
                .catch();
            },

            storePerso(){
                if (this.matricule != '' && this.nom != '' && this.cin != '' && this.poste != '' && this.dateNaiss != '' && this.lieuNaiss != '' && this.validation(this.matricule, this.cin)) {
                   let bool = false;
                   this.persos.forEach(element => {
                       if (element.matricule == this.matricule) {
                           this.error = 'la matricule que vous avez entrer existe déjà';
                           bool = true;
                       }
                   });
                   if (!bool) {
                       axios.post(this.url.url + '/listePerso/',
                            {
                                matricule: this.matricule,
                                nom: this.nom,
                                prenom: this.prenom,
                                dateNaiss: this.dateNaiss,
                                lieuNaiss: this.lieuNaiss,
                                cin: this.cin,
                                poste: this.poste,
                            })
                            .then(response => {
                                console.log(response.data),
                                this.recuperation(),
                                this.init()})
                            .catch(error =>console.log(error));
                            this.error = '';
                   }

                }else{
                    this.error = "Veuillez respecter le format de chaque champs"
                }
            },

            updatePerso(){
                if (this.matricule != '' && this.nom != '' && this.cin != '' && this.poste != '' && this.dateNaiss != '' && this.lieuNaiss != '' && this.validation(this.matricule, this.cin)) {
                        axios.patch(this.url.url + '/listePerso/' + this.id, {
                        matricule: this.matricule,
                        nom: this.nom,
                        prenom: this.prenom,
                        dateNaiss: this.dateNaiss,
                        lieuNaiss: this.lieuNaiss,
                        cin: this.cin,
                        poste: this.poste,
                    })
                    .then(response => {
                        console.log(response.data),
                        this.recuperation()
                        this.init()})
                    .catch(error =>console.log(error));
                    this.error = '';                 
                }else{
                    this.error = "Veuillez respecter le format de chaque champs"
                }
            },

            deletePerson(){
                if (this.id) {
                    axios.delete(this.url.url + '/listePerso/' + this.id)
                    .then(response => {
                        console.log(response.data),
                        this.recuperation()})
                    .catch(error =>console.log(error));
                }
            },

            fixId(perso){
                this.persos.forEach(element => {
                    if (element.id === perso.id) {
                        this.id = element.id;
                        this.matricule = element.matricule;
                        this.nom = element.nom;
                        this.prenom = element.prenom;
                        this.dateNaiss = element.dateNaiss;
                        this.lieuNaiss = element.lieuNaiss;
                        this.cin = element.cin;
                        this.poste = element.poste;
                    }
                });
            },

            init(){
                this.id = '';
                this.matricule = '';
                this.nom = '';
                this.prenom = '';
                this.dateNaiss = '';
                this.lieuNaiss = '';
                this.cin = '';
                this.poste = '';
            },

            search(){
                if (this.q.length >= 2) {
                    axios.get(this.url.url + '/listePerso/'+ this.q)
                    .then(response => this.persos = response.data.perso)
                    .catch();
                }else{
                    this.recuperation();
                }
            },
        },

        mounted() {
            console.log('Component mounted.')
        },

        created(){
            this.recuperation();
        },

    }
</script>
