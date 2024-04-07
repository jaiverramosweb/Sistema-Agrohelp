<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { onMounted, reactive, ref, computed, watch } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import Swal from 'sweetalert2/dist/sweetalert2.js';
    import 'sweetalert2/dist/sweetalert2.css'
    import ThPagination from '@/Komponents/ThPagination.vue';


    const props = defineProps(['permissions'])

    onMounted(() => {
        activeMenu('manejador_de_datos', 'manejador_piezometro')
        // dataPiezometro.value    = props.piezometro.data.data
        // pagination.value        = props.piezometro.pagination

    })

    const isActived = computed(() => {
      return pagination.value.current_page;
    });

    const pagesNumber = computed(() => {
      if (!pagination.value.to) {
        return [];
      }
      
      let from = pagination.value.current_page - offset.value;
      if (from < 1) {
        from = 1;
      }
      let to = from + offset.value * 2;
      if (to >= pagination.value.last_page) {
        to = pagination.value.last_page;
      }
      const pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    });


    const loader = ref( false );

    const order_cell = ref('id')
    const order_type = ref('ASC')
    const show = ref(5)
    const offset = ref(3)
    const search = ref('')
    const pagination = ref('')
    const setTimeoutSearch = ref('')

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    const dataPiezometro = ref('')

    
    // Metodos Requeridos para iniciar modulo
    const activeMenu = (menu, submenu) => {
        $( ".menu_"+ menu ).addClass( 'menu-is-opening menu-open')
        $( "#menu_"+ menu).addClass( 'active')
        $(  "#sub_menu_"+ submenu).addClass( 'active')
    }

    const orderTest = ( val ) => {
        let result;
        if( val == order_cell.value )
        {
          result = order_type.value == 'DESC' ? 3 : 2 ;
        }else{
          result = 1;
        }
        return result;
    }

    const filterColumn = ( field_ ) => {
        if( field_ == order_cell.value )
        {
            order_type.value = order_type.value == 'DESC' ? 'ASC' : 'DESC';
        }else{
            order_cell.value = field_;
        }

        paginationList();
    }

    const fieldValue = ( col , record ) => {

        let result;

        Object.entries( record ).map(( el ) => {

        if ( el[0] == col.name )
        {
            result = "type_object" in col  ? el[1][col.type_object.name] : el[1] ;
        }

        });

        return result;
    }

    const asyncFind = () => {
        clearTimeout(setTimeoutSearch.value);
        setTimeoutSearch.value = setTimeout(() => {
            if (search.value != "") {
                paginationList();
            }
        }, 700);
    }

    const paginationList = ( page ) => {

        axios.post( '/manejo-piezometro-pagination' , { 
            "page": page,
            "show": show.value,
            "search": search.value,
            "order_field": order_cell.value,
            "order_type": order_type.value
        })
        .then((response) => {
            let res = response.data;
            dataPiezometro.value = res.data.data;
            pagination.value = res.pagination;
        })
        .catch((error) => {
            console.log("error peticion", error);
        });
    }

    const changePage = (page) => {
        pagination.value.current_page = page;
        paginationList(page);
    }


    // Modulos a crear

    const save = () => {
        axios.post('/manejo-piezometro', {

            zonas_id:           zonas_id.value,
       
            coordinate_z:       coordinate_z.value,

        }).then( res => {
            paginationList()
            clear()
            $('#modalPiezometro').modal('hide')
            Toast.fire({
                icon: 'success',
                title: 'Registro creado con exito'
            })
        })
    }

    const clear = () => {
        id.value = ''
        zonas_id.value = 0

    }

    const edit = (item) => {

        id.value                    = item.id
        zonas_id.value              = item.zonas_id


        $('#modalPiezometro').modal('show')
    }

    const update = () => {
        axios.put(`/manejo-piezometro/${id.value}`, {

            zonas_id:           zonas_id.value,
 

        }).then( res => {
            console.log(res.data)

            paginationList()
            clear()
            $('#modalPiezometro').modal('hide')
            Toast.fire({
                icon: 'success',
                title: 'Registro actualizado con exito'
            })
        })
    }

    const deleteItem = (id) => {
        Swal.fire({
            title: 'Estas seguro de eliminarlo?',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
        }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/manejo-piezometro/${id}`).then(res => {
                paginationList()
                Swal.fire('Eliminado!', '', 'success')
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
        })
    }

    const isLouding = () => {
        loader.value = true
    }

</script>

<template>
    
    <AuthenticatedLayout title="Piezómetro">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>

        
        <template #header>
            <div class="row mb-2">
            
                <div class="col-sm-6">
                    <h1 class="m-0">Creación de piezómetros</h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Manjador de datos</li>
                        <li class="breadcrumb-item active">Piezómetro</li>
                    </ol>
                </div>
                
            </div>
        </template>

        <div class="row">

            <div class="col-lg-12">

                <div class="card">
                    
                    <div class="card-header">
                    
                        <h3 class="card-title">Lista de piezómetros</h3>

                        <div class="card-tools">
                            <button v-if="permissions.create" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPiezometro">
                                Crear Piezómetro
                            </button>
                            <!-- <button href="#" class="btn btn-sm btn-success" v-if="permissions.create">
                                <i class='fas fa-plus'></i> 
                                Crear Zona
                            </button> -->
                        </div>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class='row'>

                            <!-- FILTRO -->
                            <div class='col-md-4 col-sm-6 col-xs-12'>
                                <b>Mostrar </b>
                                <select id="entries" @change='paginationList()' v-model="show">
                                    <option :value="5">5</option>
                                    <option :value="10">10</option>
                                    <option :value="15">15</option>
                                    <option :value="20">20</option>
                                    <option :value="25">25</option>
                                    <option :value="30">30</option>
                                    <option :value="50">50</option>
                                </select>
                                <b> registros</b>
                            </div>

                            <!-- BUSCADOR -->
                            <div class='col-md-8 col-sm-6 col-xs-12'>
                            
                                <div class="pull-right">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <!-- <input type="text" maxlength="250" id='search' @change='asyncFind()' class='form-control' placeholder="Buscar" v-model="search"> -->
                                    <input type="text" maxlength="250" id='search' @keyup='asyncFind()' class='form-control' placeholder="Buscar" v-model="search">
                                    </div>
                                </div>

                            </div>

                            <!-- TABLA -->
                            <div class='col-12'>
                                <div class='table-responsive'>
                                    <table class='table table-bordered table-striped table-hover table-title'>
                                        
                                        <thead style='background-color: black; color: white'>
                                            
                                            <tr>                                            
                                                      
                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <!-- <tbody>

                                            <tr v-for=" ( item_data , i ) in dataPiezometro " :key='i'>

                                                <td v-for=" ( col , i ) in columns " :key="i">                                            
                                                    {{ fieldValue( col , item_data ) }}
                                                </td>

                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>

                                                        <button :class="'btn mr-1 btn-xs bg-info btn-round'" @click="showItem( item_data )" v-if="permissions.read">
                                                            <i class='fas fa-eye'></i>
                                                        </button>
                                                        
                                                        <Link class="btn mr-1 btn-xs bg-gray btn-round" data-toggle="tooltip" title="Info" :href="'/users/'+item_data.id+'/details' " v-if="permissions.read">
                                                            <i class='fas fa-list'></i>
                                                        </Link>

                                                        <Link :href="route('info.sensor',{id: item_data.serial} )" @click="isLouding" class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip" title="Ir a piezometro">
                                                            <i class='fas fa-eye'></i>
                                                        </Link>
                                                        
                                                        <button @click="edit(item_data)" class="btn mr-1 btn-xs bg-warning  btn-round" data-toggle="tooltip" title="Editar"  v-if="permissions.update">
                                                            <i class='fas fa-edit'></i>
                                                        </button>

                                                        <button class="btn mr-1 btn-xs bg-danger btn-round" data-toggle="tooltip" title="Eliminar" @click='deleteItem( item_data.id )' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i> 
                                                        </button>                                                        
                                                        
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='dataPiezometro.length == 0'>
                                                <td colspan="6">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>
                                            
                                        </tbody> -->
                                    
                                    </table>
                                </div>
                            </div>


                            <div class='col-md-8 col-sm-6 col-xs-12'>
                            
                                <ul class="pagination pagination-sm m-0 float-right">
                                    
                                    <li style='cursor:pointer' class="page-item">
                                        <a class="page-link" @click.prevent="changePage(1)" >
                                        Primero
                                        </a>
                                    </li>
                                    <li style='cursor:pointer' class="page-item" v-if="pagination.current_page > 1">
                                        <a  @click.prevent="changePage(pagination.current_page - 1)" class="page-link" >
                                        Anterior.
                                        </a>
                                    </li>
                                    <li class="paginate_button page-item" :key="page" v-for="( page ) in pagesNumber "  :class="[ page == isActived ? 'active' : '' ]"  >
                                        <a href="#" @click.prevent="changePage(page)" class="page-link" >
                                        {{ page }}
                                        </a  >
                                    </li>
                                    <li   style='cursor:pointer' class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a  @click.prevent="changePage(pagination.current_page + 1)" class="page-link" >
                                        Sig.
                                        </a>
                                    </li>
                                    <li style='cursor:pointer' class="page-item">
                                        <a class="page-link" @click.prevent="changePage(pagination.last_page)" >
                                        Último
                                        </a>
                                    </li>
                                </ul>
                            
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalPiezometro" data-backdrop="static" tabindex="-1" aria-labelledby="modalPiezometroLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPiezometroLabel">Crear Piezómetro</h5>

                        </div>
                        <div class="modal-body">
                            <form>

                                <div class="row">

                                    <!-- <div class="form-group col-md-3  has-validation">
                                        <label for="zonas_id">Zona</label>
                                        <select v-model="zonas_id" class="form-control" id="zonas_id">
                                            <option value="0" >Seleccione..</option>
                                            <option v-for="zona in zonas" :key="zona.id" :value="zona.id">{{ zona.name }}</option>
                                        </select>
                                        <div v-if="zonas_id.length == 0" class="invalid-feedback d-block">El campo es requerido</div>
                                    </div>

                                    <div class="form-group col-md-3"  has-validation>
                                        <label for="channel">Canal</label>
                                        <input v-model="zonas_id" type="number" class="form-control" id="channel" aria-describedby="channel" autocomplete="off">
                                        <div v-if="serial.length < 1" class="invalid-feedback d-block">El campo es requerido</div>
                                    </div> -->

                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Canelar</button>
                            <!-- <button v-if="id == 0" @click="save" type="button" class="btn btn-primary">Guardar</button>
                            <button v-if="id != 0" @click="update" type="button" class="btn btn-primary">Editar</button> -->
                        </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </AuthenticatedLayout>
    

</template>
