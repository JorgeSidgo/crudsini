<div id="app">
<modal-registrar id_form="frmRegistrar" id="modalRegistrar" url="?1=UsuarioController&2=registrar" titulo="Registrar Usuario"
        :campos="campos_registro" tamanio='tiny'></modal-registrar>

<modal-editar id_form="frmEditar" id="modalEditar" url="" titulo="Editar Institucion"
        :campos="campos_editar" tamanio='tiny'></modal-editar>

    <modal-eliminar id_form="frmEliminar" id="modalEliminar" url="?1=UsuarioController&2=eliminar" titulo="Eliminar Institucion"
        sub_titulo="¿Está seguro de querer eliminar este usuario?" :campos="campos_eliminar" tamanio='tiny'></modal-eliminar>

    <div class="ui grid">
        <div class="row">
            <div class="titulo">
                Usuarios
            </div>
        </div>
        <div class="row title-bar">
            <div class="sixteen wide column">
                <button class="ui right floated positive labeled icon button" @click="modalRegistrar" id="btnModalRegistro">
                    <i class="plus icon"></i>
                    Agregar
                </button>
            </div>
        </div>
        <div class="row title-bar">
            <div class="sixteen wide column">
                <div class="ui divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="sixteen wide column">
                <table id="dtUsuarios" class="ui selectable very compact celled table" style="width:100%; margin:auto;">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombres</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Autorización</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="./res/tablas/tablaUsuarios.js"></script>
<script src="./res/js/modalRegistrar.js"></script>
<script src="./res/js/modalEditar.js"></script>
<script src="./res/js/modalEliminar.js"></script>

<script>
var app = new Vue({
        el: "#app",
        data: {
            campos_registro: [{
                    label: 'Nombre:',
                    name: 'nombre',
                    type: 'text'
                },
                {
                    label: 'Apellido:',
                    name: 'apellido',
                    type: 'text'
                },
                {
                    label: 'Nombre de Usuario Deloitte:',
                    name: 'user',
                    type: 'text'
                },
                {
                    label: 'Correo Electrónico:',
                    name: 'correo',
                    type: 'text'
                },
                {
                    label: 'Contraseña:',
                    name: 'pass',
                    type: 'password'
                },
                {
                    label: 'Rol:',
                    name: 'rol',
                    type: 'select',
                    options: [{
                            val: 1,
                            text: 'Administrador'
                        },
                        {
                            val: 2,
                            text: 'Solicitante'
                        }
                    ]
                }
            ],
            campos_editar: [
            {
                    label: 'Nombre:',
                    name: 'nomI',
                    type: 'text'
                },
                {
                    label: 'Direccion:',
                    name: 'direI',
                    type: 'text'
                },
                {
                    label: 'Correo:',
                    name: 'emailI',
                    type: 'text'
                },
                {
                    label: 'Telefono:',
                    name: 'telI',
                    type: 'text'
                },
                {
                    label: 'Tipo:',
                    name: 'tipoI',
                    type: 'select',
                    options: [{
                            val: 1,
                            text: 'Pública'
                        },
                        {
                            val: 2,
                            text: 'Privada'
                        },
                        {
                            val: 3,
                            text: 'ONG'
                        }
                    ]
                },
                {
                    name: 'idDetalle',
                    type: 'hidden'
                }

            ],
            campos_eliminar: [{
                name: 'idEliminar',
                type: 'hidden'
            }]
        },
        methods: {
            refrescarTabla() {
                tablaUsuarios.ajax.reload();
            },
            modalRegistrar() {
                $('#modalRegistrar').modal('setting', 'autofocus', false).modal('setting', 'closable', false).modal(
                    'show');
            },
            cargarDatos() {
                var id = $("#idDetalle").val();

                fetch("../controladorInstitucion?op=getInstitucion&id=" + id)
                    .then(response => {
                        return response.json();
                    })
                    .then(dat => {
                        $('#frmEditar input[name="idDetalle"]').val(dat.id);
                        $('#frmEditar input[name="nomI"]').val(dat.NombreInstitucion);
                        $('#frmEditar input[name="direI"]').val(dat.Direccion);
                        $('#frmEditar input[name="emailI"]').val(dat.Correo);
                        $('#frmEditar input[name="telI"]').val(dat.Telefono);
                        $('#frmEditar select[name="tipoI"]').dropdown('set selected', dat.idTipo);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        }
    });
</script>

<script>
        $(document).on("click", ".btnEliminar", function () {
            $('#modalEliminar').modal('setting', 'closable', false).modal('show');
            $('#idEliminar').val($(this).attr("id"));
        });
        $(document).on("click", ".btnEditar", function () {
            $('#modalEditar').modal('setting', 'autofocus', false).modal('setting', 'closable', false).modal('show');
            $('#idDetalle').val($(this).attr("id"));
            app.cargarDatos();
        });
</script>
     