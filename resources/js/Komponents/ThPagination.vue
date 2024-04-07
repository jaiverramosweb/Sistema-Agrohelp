<template>
  
  <th class="border">
    <div class="d-flex flex-r">

      <span class="pr-2">
        {{title_}}
      </span>
      <span  style='float:right;'>
        <i style='cursor:pointer;' :class="classTh()" @click='orderby()'></i>
      </span>

    </div>
  </th>

</template>

<script>

  export default {

    props:[ 'order_' , 'title_'  , 'field_' ],
    methods:{
      orderby()
      {
        this.$emit( 'filter-column' , this.field_ )
      },
      classTh()
      {
        let result;
        switch (this.order_) {
          case 1:
            result = 'fas fa-sort'
          break;
          case 2:
            result = 'fas fa-arrow-up text-danger'
          break;
          case 3:
            result = 'fas fa-arrow-down text-success'
          break;
        
          default:
            result = 'fas fa-cogs'
          break;
        }
        return result;
      }
    }
      
  }

</script>