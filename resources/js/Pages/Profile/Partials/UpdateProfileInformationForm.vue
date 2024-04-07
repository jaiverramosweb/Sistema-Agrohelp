<template>
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Información del usuario</h3>
    </div>

    <div class="card-body">
      <p>
        Actualice la información de perfil y la dirección de correo electrónico de su
        cuenta..
      </p>

      <div class="row">

        <div class="col-12">
          
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="form-group iscf" id="div_description">

                <div  class="col-12 " style="text-align: center;">
                  <i class="fas fa-times times_" v-show="photoPreview" @click="destroyImg()"></i>
            
                  <input type="file" class="custom-file-input d-none" id="exampleInputFile" ref="photoInput" @change="updatePhotoPreview">
                  
                  <div v-show=" !photoPreview " class="mt-2" @click.prevent="selectNewPhoto" style="cursor: pointer;">
                      <img :src="form.avatar"  :alt="user.name" class="profile-user-img  rounded-circle" style="width: 200px;">
                  </div>
                  
                  <div v-show="photoPreview" class="mt-2">
                      <img :src="photoPreview" class="profile-user-img rounded-circle" alt="..." style="width:200px;">
                  </div>
                  
                  <button type="button" class="btn btn-danger mt-3 mx-auto" v-if="user.avatar" @click.prevent="deletePhoto"> 
                    Eliminar foto 
                  </button>

                  <InputError :message="form.errors.photo" class="mt-2" />
                </div>

                
              </div>
            </div>
          </div>

        </div>

        <div class="col-12">
          <form @submit.prevent="updateProfileInformation" class="row">

            <div class="form-group col-6">
              <label for="name">Primer nombre</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Nombre"
                v-model="form.nombre"
              />
              <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="form-group col-6">
              <label for="name">Segundo nombre</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Segundo nombre"
                v-model="form.segundo_nombre"
              />
              <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="form-group col-6">
              <label for="name">Primer apellido</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Primer apellido"
                v-model="form.apellido"
              />
              <InputError :message="form.errors.last_name" class="mt-2" />
            </div>

            <div class="form-group col-6">
              <label for="name">Segundo apellido</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Segundo apellido"
                v-model="form.segundo_apellido"
              />
              <InputError :message="form.errors.last_name" class="mt-2" />
            </div>

            <div class="form-group col-6">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                placeholder="you@example.com"
                v-model="form.email"
              />
              <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="form-group col-6">
              <label for="email">Número de identificación</label>
              <input
                type="text"
                class="form-control"
                id="document"
                placeholder=""
                v-model="form.documento"
              />
              <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="card-footer col-12">
              <button
                type="submit"
                class="btn btn-primary"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Actulizar
              </button>
            </div>
            
          </form>
        </div>
          
      </div>
    </div>
  </div>
</template>


<style lang="css">

  .times_ {
    position: absolute;
    right: 12px;
    font-size: 23px;
    top: 12px;
    color: red;
    cursor: pointer;
  }
  
</style>

<script setup>
import { ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";


import SecondaryButton from "@/Components/SecondaryButton.vue";

import Swal from 'sweetalert2'

const props = defineProps({
  user: Object,
});

const form = useForm({
  nombre: props.user.nombre,
  apellido: props.user.apellido,

  segundo_nombre: props.user.segundo_nombre,
  segundo_apellido: props.user.segundo_apellido,
  documento: props.user.documento,

  email: props.user.email,
  avatar:  props.user.avatar == '' ? '/assets/admin-lte/dist/img/default-150x150.png' : props.user.avatar,
  
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {

  if (photoInput.value) {
    form.photo = photoInput.value.files[0];
  }

  let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  let formData = new FormData();
  formData.append( 'file_' , form.photo );
  formData.append( 'data' , JSON.stringify(form) );

  axios.post( route('profile.update') , formData )
  .then(function ( response ) {

    $("#modal_rol").modal("hide");

    Swal.fire(
      '¡Buen trabajo!',
      'Recurso creado correctamente!',
      'success'
    );
    get();

  })
  .catch(function (response) {
    let errors = response.response.data.errors
    errors_( errors , errors_temp );
    errors_temp = errors;
  });

  // form.po`st( route('profile.update'),{
  //   preserveScroll: true,
  //   onSuccess: () => {
  //     Toast.fire({
  //       icon: 'success',
  //       title: 'Información actualizado.'
  //     });
  //   }
  // });`
 


//   form.post(route("profile.update"), {
//     errorBag: "updateProfileInformation",
//     preserveScroll: true,
//     onSuccess: () => clearPhotoFileInput(),
//   });

};

const sendEmailVerification = () => {
  verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
  photoInput.value.click();
};

const destroyImg = ()=>{ 
  alert('alert')
  photoPreview.value = null; 
} 

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0];

  if (!photo) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};

const deletePhoto = () => {
  router.delete(route("current-user-photo.destroy"), {
    preserveScroll: true,
    onSuccess: () => {
      photoPreview.value = null;
      clearPhotoFileInput();
    },
  });
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};
</script>
