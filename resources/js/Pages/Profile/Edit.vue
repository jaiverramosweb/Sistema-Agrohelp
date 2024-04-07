
<template>
    
  <AuthenticatedLayout title="Profile">

    <template #breadcrumb>
          
      <div class="container-fluid">
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Perfil</li>
            </ol>
          </div>
        </div>

      </div>

    </template>
      
    <div class="row">
      
      <!-- <div class="col-md-4">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"  :src="$page.props.auth.user.avatar"  :alt="$page.props.auth.user.name">
            </div>

            <h3 class="profile-username text-center">Nina Mcintire</h3>

            <p class="text-muted text-center">Software Engineer</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Followers</b> <a class="float-right">1,322</a>
              </li>
              <li class="list-group-item">
                <b>Following</b> <a class="float-right">543</a>
              </li>
              <li class="list-group-item">
                <b>Friends</b> <a class="float-right">13,287</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
          </div>
        </div>

        <div class="card card-primary">
          
          <div class="card-header">
            <h3 class="card-title">About Me</h3>
          </div>

          <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i> Education</strong>

            <p class="text-muted">
              B.S. in Computer Science from the University of Tennessee at Knoxville
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

            <p class="text-muted">Malibu, California</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

            <p class="text-muted">
              <span class="tag tag-danger">UI Design</span>
              <span class="tag tag-success">Coding</span>
              <span class="tag tag-info">Javascript</span>
              <span class="tag tag-warning">PHP</span>
              <span class="tag tag-primary">Node.js</span>
            </p>

            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
          </div>
          
        </div>

      </div> -->
      
      <div class="col-md-12">
        
        <div class="card">
          
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              

              <li class="nav-item"><a class="nav-link active" href="#update_profile" data-toggle="tab">Actualizar perfil</a></li>
              <li class="nav-item"><a class="nav-link" href="#security" data-toggle="tab">Seguridad</a></li>

            </ul>
          </div>
          
          <div class="card-body">
            <div class="tab-content">
                
              <div class="tab-pane active" id="update_profile">
                <div >
                  <UpdateProfileInformationForm :user="$page.props.auth.user" />
                </div>
              </div>

              <div class="tab-pane" id="security">

                <div >
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />
                </div>

              </div>

            </div>
            <!-- /.tab-content -->
          </div>
          
        </div>
        
      </div>
      
    </div>

  </AuthenticatedLayout>

</template>

<style lang="css">

  body{
    text-decoration: none !important;
  }

</style>

<script setup>
  
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
  //   import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
  
  import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
  import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

  defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
  });

</script>
