<template>
  
  <fieldset class="bordesito" style='margin-top:20px;'>

    <legend class="bordesito" >
      {{ title_ }}
    </legend>

    <div class='row'>

      <template v-for=" ( item, i ) in fields_ " :key="i" >
        <div :class=" item.class "  v-if=" item.type_field == 'dynamic' ">
          <b>{{ item.title }} :: {{i}} </b>
          <div class="input-group input-group-sm input mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i :class=" item.icon "></i>
              </span>
            </div>

              <input type="text" :id=" item.id_" class='form-control' placeholder="item.ph"  v-if=" item.type == 'text' " v-model="item.value" @change="dataRefresh">

          </div>
        </div>
      </template>
      

    </div>
  
  </fieldset>

</template>

<script>

  export default {

    props:[ 'title_' , 'fields' , 'data' ],
    data(){
      return {
        fields_:{}
      }
    },
    mounted() {
      this.fields_ = this.fields

      setTimeout(() => {
        this.loadData();
      }, 555);
    },
    methods:{

      dataRefresh()
      {
        this.$emit( 'data-scf' , this.fields_  )
      },

      loadData(){
        for ( const key in this.data )
        {
          if (Object.hasOwnProperty.call( this.fields_ , key)) {
            this.fields_[ key ].value = this.data[key].value;
          }
        }
      }

    }
      
  }

</script>