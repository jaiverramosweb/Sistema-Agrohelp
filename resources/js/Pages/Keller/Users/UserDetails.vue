<template>
  <AuthenticatedLayout title="Usuarios">

    <div class='col-md-12'>

      <div class="row">

        <div class="col-md-3">
          
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                      src="/assets/admin-lte/dist/img/user4-128x128.jpg"
                      alt="User profile picture">
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
            <!-- /.card-body -->
          </div>
          
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
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
            <!-- /.card-body -->
          </div>
          
        </div>
        
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <!-- Post -->
                  <div class="post">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="/assets/admin-lte/dist/img/user1-128x128.jpg" alt="user image">
                      <span class="username">
                        <a href="#">Jonathan Burke Jr.</a>
                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                      </span>
                      <span class="description">Shared publicly - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      Lorem ipsum represents a long-held tradition for designers,
                      typographers and the like. Some people hate it and argue for
                      its demise, but others ignore the hate as they create awesome
                      tools to help create filler text for everyone from bacon lovers
                      to Charlie Sheen fans.
                    </p>

                    <p>
                      <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                      <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                      <span class="float-right">
                        <a href="#" class="link-black text-sm">
                          <i class="far fa-comments mr-1"></i> Comments (5)
                        </a>
                      </span>
                    </p>

                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                  </div>
                  <!-- /.post -->

                  <!-- Post -->
                  <div class="post clearfix">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="/assets/admin-lte/dist/img/user7-128x128.jpg" alt="User Image">
                      <span class="username">
                        <a href="#">Sarah Ross</a>
                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                      </span>
                      <span class="description">Sent you a message - 3 days ago</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      Lorem ipsum represents a long-held tradition for designers,
                      typographers and the like. Some people hate it and argue for
                      its demise, but others ignore the hate as they create awesome
                      tools to help create filler text for everyone from bacon lovers
                      to Charlie Sheen fans.
                    </p>

                    <form class="form-horizontal">
                      <div class="input-group input-group-sm mb-0">
                        <input class="form-control form-control-sm" placeholder="Response">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-danger">Send</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.post -->

                  <!-- Post -->
                  <div class="post">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="/assets/admin-lte/dist/img/user6-128x128.jpg" alt="User Image">
                      <span class="username">
                        <a href="#">Adam Jones</a>
                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                      </span>
                      <span class="description">Posted 5 photos - 5 days ago</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <img class="img-fluid" src="/assets/admin-lte/dist/img/photo1.png" alt="Photo">
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-6">
                            <img class="img-fluid mb-3" src="/assets/admin-lte/dist/img/photo2.png" alt="Photo">
                            <img class="img-fluid" src="/assets/admin-lte/dist/img/photo3.jpg" alt="Photo">
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-6">
                            <img class="img-fluid mb-3" src="/assets/admin-lte/dist/img/photo4.jpg" alt="Photo">
                            <img class="img-fluid" src="/assets/admin-lte/dist/img/photo1.png" alt="Photo">
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <p>
                      <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                      <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                      <span class="float-right">
                        <a href="#" class="link-black text-sm">
                          <i class="far fa-comments mr-1"></i> Comments (5)
                        </a>
                      </span>
                    </p>

                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                  </div>
                  <!-- /.post -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <div class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-danger">
                        10 Feb. 2014
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-envelope bg-primary"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                        <div class="timeline-body">
                          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                          weebly ning heekya handango imeem plugg dopplr jibjab, movity
                          jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                          quora plaxo ideeli hulu weebly balihoo...
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-primary btn-sm">Read more</a>
                          <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-user bg-info"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                        </h3>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-comments bg-warning"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                        <div class="timeline-body">
                          Take me to your leader!
                          Switzerland is small and neutral!
                          We are more like Germany, ambitious and misunderstood!
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-success">
                        3 Jan. 2014
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-camera bg-purple"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                        <div class="timeline-body">
                          <img src="https://placehold.it/150x100" alt="...">
                          <img src="https://placehold.it/150x100" alt="...">
                          <img src="https://placehold.it/150x100" alt="...">
                          <img src="https://placehold.it/150x100" alt="...">
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <div>
                      <i class="far fa-clock bg-gray"></i>
                    </div>
                  </div>
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="settings">
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>

    </div>

  </AuthenticatedLayout>
</template>

<script>

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import Swal from 'sweetalert2/dist/sweetalert2.js';
  import 'sweetalert2/dist/sweetalert2.css'

  import errors_ from '../../../scripts/keller_validate.js';

  export default {
    props:[ 'custom' , 'roles' ],
    components:{
      AuthenticatedLayout,
      Swal,
      errors_
    },
    data() {

      return {
        id: 0,
        sending: false,
        element:{
        },
        isLoading:false,
        errors_temp:{}
      }

    },
    mounted() {

    },
    methods:{
      
      return_index: function()
      {
        this.$router.push({name: "index"});
      },

      getUser()
      {
        axios.get('./patients/' + this.id)
        .then((resp)=>{
          
          console.log('./patients/',resp.data);
          
          var user = resp.data.data.patient;
          
          this.element = user;
          this.selectedService = {}
          this.selectedService.name = user.name_allied;
          this.selectedService.id   = user.fk_allied_company_id;
          
        })
        .catch(function (error) {
          console.log(error);
        });

      },
      store()
      {
        $(".error").css("display","none");
        $("input").removeClass("is-invalid");
        $("select").removeClass("is-invalid");
        
        var errores = 0;
        var form = $("#form")[0];

        for(var i = 0; i<form.elements.length; i++)
        {
          var element = $(form.elements[i]);
          var attr = $(form.elements[i]).attr("required");
          var _id = $(form.elements[i]).attr("id");

          if (typeof attr !== typeof undefined && attr !== false)
          {
            if(element.val() == "" || element.val() == null)
            {
              $(".error-"+_id).css("display","block");
              element.addClass("is-invalid");
              errores++;
            }
          }
        }

        if( errores == 0 )
        {
          
          $("#btn_save").attr("disabled");
          this.sending = true;
          this.user__perfiles_id = 5;

          this.element.company = this.selectedService.id;

          axios.post('/users', this.element )
          .then( (response)=> {
            this.sending = false;
            var data = response.data;
            Swal.fire({
              title: 'Recurso almacenado',
              text:  'El recurso se a creado correctamente.',
              icon:  'success',
              confirmButtonText: 'Ok',
            }).then((result) => {
              this.$router.push({name: "index"});
            });
          })
          .catch( (error) => {

            
            let errors = error.response.data.errors
            errors_( errors , this.errors_temp );
            this.errors_temp = errors;
            console.log( '------------------>>>>>' , error );

            Swal.fire({
                title: 'Error' ,
                text: 'Se ha generado un error al intentar almacenar el recurso',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then((result) => {
                //this.$router.push({name: "index"});
            })
            
            $("#btn_save").removeAttr("disabled");
            this.sending = false;
          });

        }

      },
      update()
      {
        $(".error").css("display","none");
        $("input").removeClass("is-invalid");
        $("select").removeClass("is-invalid");
        var errores = 0;
        var form = $("#form")[0];

        for(var i = 0; i<form.elements.length; i++){
          var element = $(form.elements[i]);
          var attr = $(form.elements[i]).attr("required");
          var _id = $(form.elements[i]).attr("id");
          if (typeof attr !== typeof undefined && attr !== false)
          {
            if(element.val() == "")
            {
              $(".error-"+_id).css("display","block");
              element.addClass("is-invalid");
              errores++;
            }
          }
        }

        if(errores == 0 && this.val_email)
        {
          $("#btn_save").attr("disabled");
          this.sending = true;
          let url = 'patients/'+this.id;
          this.element.company = this.selectedService.id;

          axios.put( url , this.element )
          .then( (response)=> {
            $("#btn_save").removeAttr("disabled");
            this.sending = false;
            var data = response.data;
            if(data.type == "success"){
              Swal.fire({
                  title: this.labels.text_alert_save_title,
                  text:  this.labels.text_alert_save_text,
                  icon:  'success',
                  confirmButtonText: this.labels.text_alert_save_confir
              }).then((result) => {
                  //location.reload()
                  this.$router.push({name: "index"});
              })
            }
            else{
              Swal.fire({
                  title: this.labels.text_alert_error_title ,
                  text: this.labels.text_alert_error_text,
                  icon: 'error',
                  confirmButtonText: this.labels.text_alert_error_confir
              }).then((result) => {
                  //location.reload()
                  //this.$router.push({name: "index"});
              })
            }
          })
          .catch(function (error) {
            console.log(error);
            $("#btn_save").removeAttr("disabled");
            this.sending = false;
          });

        }

      },


      calcularEdad() {
        
        this.element.edad = this.element.fecha_nacimiento == NaN ? '' : this.element.fecha_nacimiento ; 
        let fecha = this.element.fecha_nacimiento;
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate()))
        {
          edad--;
        }

        this.element.edad = edad

      },


      limitText (count) {
        return `and ${count} other services`
      },
      asyncFindService (query) {

        // this.isLoading = true
        axios.post('./allied/search-all' , {search : query })
        .then((resp)=>{
          // console.log('./services/search' ,resp.data.data);
          this.services = resp.data.data
          // this.isLoading = false
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      clearAll() {
        this.selectedService = []
      },
      toAssign( item ){
        this.plan_seleted = true;
        this.plan_ = item;
      },
    
    }
  }
    
</script>
