<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['solicitud_id'])

onMounted(() => {
    setTimeout(() => {
        active.value = true;
        setTimeout(() => {
            fileLoad();
            getFiles();

        }, 111);
    }, 222);

    solicitud_id.value = props.solicitud_id
})

const active = ref(false)
const solicitud_id = ref(0)
const selected_files = ref([])
const documents_list = ref([])


const fileLoad = () => {

    var dropArea = document.getElementById('dropArea');

    dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('bg-light');
    });

    dropArea.addEventListener('dragleave', function () {
        dropArea.classList.remove('bg-light');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('bg-light');
        handleFiles('DROP', e.dataTransfer.files);
    });

    dropArea.addEventListener('click', function () {
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput').addEventListener('change', (e) => {
        handleFiles('CHANGE', e.target.files);

        addFiles(e.target.files);
    });

}

const handleFiles = (name, files) => {
    console.log(name + '-TEST:::', files);
    addFiles(files);
}

const addFiles = (files) => {
    selected_files.value = files;
}

const validateFileExists = (f) => {
    let exist = false;
    for (let index = 0; index < selected_files.value.length; index++) {
        const el = selected_files.value[index];
        console.log("VIEJO[ " + index + " ]::" + el.name + '----' + "NUEVO::" + f.name)
        if (el.name == f.name && el.size == f.size && el.type == f.type) {
            exist = true;
        }
    }
    return exist;
}

const removeFile = (i) => {

    let temp = [];
    if (i >= 0 && i < selected_files.value.length) {
        for (let index = 0; index < selected_files.value.length; index++) {
            const element = selected_files.value[index];
            if (i != index) {
                temp.push(element)
            }
        }
    } else {
        alert('Índice fuera de los límites del array.');
        return false;
    }

    selected_files.value = temp;
    return true;
}

const upload = () => {
    let form_data = new FormData();

    for (let i = 0; i < selected_files.value.length; i++) {
        form_data.append('documents[]', selected_files.value[i]);
    }

    form_data.append('solicitud_id', solicitud_id.value)

    axios.post('/updload-files', form_data)
        .then(res => {
            Swal.fire(
                'Cargado!',
                'Recursos cargados correctamente.',
                'success'
            );
            selected_files.value = [];

            getFiles();

        }).catch((error) => {
            Swal.fire({
                title: 'Error',
                text: 'Se ha generado un error al intentar cargar los documentos',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then((result) => {
                //this.$router.push({name: "index"});
            });

        });
}

const getFiles = () => {
    axios.get(`/get-files/${solicitud_id.value}`).then(({ data }) => {
        console.log(data.data)
        documents_list.value = data.data
    })
}

const transforDate = (date) => {
    var fecha = new Date(date);

    var año = fecha.getFullYear();
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    var dia = fecha.getDate().toString().padStart(2, '0');

    var fechaFormateada = `${año}-${mes}-${dia}`;

    return fechaFormateada

}

const downloadFile = (id) => {
    let url = '/download-files/' + id;
    window.open(url, '_blank');
}

const destroyFile = (id) => {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
    })
        .then((result) => {
            if (result.isConfirmed) {
                axios.delete('/delete-file/' + id)
                    .then((resp) => {
                        Swal.fire(
                            'Deleted!',
                            'El recurso ha sido borrado.',
                            'success'
                        );
                        this.getFiles()
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });
}

</script>

<template>
    <div class="card">
        <div class="row mt-2">

            <div class="col-md-10 offset-md-1">
                <div id="dropArea" class="text-muted">
                    <p>Arrastra y suelta archivos aquí o haz clic para seleccionarlos.</p>
                    <input type="file" id="fileInput" class="d-none" multiple>
                </div>
            </div>

        </div>

        <div class="row my-2">
            <div class="col-md-10 offset-md-1 row">

                <template v-for=" ( item, i ) in selected_files " :key="i">

                    <a class="btn btn-app col-2">
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle" @click="removeFile(i)"></i>
                        </span>
                        <i class="fas fa-image"></i>
                        {{ item.name }}
                    </a>

                    <!-- <a style="height: 80px;" class="btn btn-app col-2 m-3" v-else>
                        <i class="fas fa-file-alt"></i>
                        {{ item.name }}
                    </a> -->
                </template>


            </div>
            <div class="col-lg-10 offset-md-1" v-if="selected_files.length > 0">
                <button type="button" class="btn btn-warning mr-3" @click="upload()">
                    <i class="fas fa-upload pr-2"></i>
                    Subir documentos
                    <i class="fas fa-file-alt pl-2"></i>
                </button>
            </div>
        </div>

        <div class="row">

            <div class='table-responsive'>

                <div class="col-12">

                    <table class="table ">

                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"># </th>
                                <th scope="col">Nombre </th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for=" ( item, i ) in documents_list " :key="i">
                                <td>{{ i + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ transforDate(item.created_at) }}</td>
                                <td>
                                    <button class="btn mr-1 btn-xs bg-warning  btn-round"
                                        @click='downloadFile(item.id)'>
                                        <i class='fas fa-download'></i>
                                    </button>
                                    <button :class="'btn mr-1 btn-xs bg-danger btn-round'"
                                        @click='destroyFile(item.id)'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>
</template>

<style>
#dropArea {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}

.btn-app {
    border-radius: 3px;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    color: #6c757d;
    font-size: 12px;
    height: 60px;
    margin: 0 0 10px 15px;
    padding: 15px 5px;
    position: relative;
    text-align: center;
}

.btn-app>.badge {
    font-size: 12px;
    font-weight: 400;
    position: absolute;
    right: -10px;
    top: -3px;
}
</style>