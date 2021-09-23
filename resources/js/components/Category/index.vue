<template>
    <div class="p-3">
    <h3>All Categories</h3>
    <router-link to="/Add-Category" style="float:right" class="mb-3 btn btn-outline-primary">Add Category</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Name" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Category Name</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="category in filtersearch" :key="category.id">
      <th scope="row">{{category.id}}</th>
      <td>{{category.category_name}}</td>
     
        <td>
        <button class="btn btn-xs btn-outline-danger" @click="deletedata(category.id)"><i class="fa fa-trash"></i></button>
        <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Category', params:{category_id:category.id }}"><i class="fa fa-edit"></i></router-link></button>
        </td>
    </tr>
   
  </tbody>
</table>
        </div>    
    </div>
</template>
<script>
  import 'jquery/dist/jquery.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from 'jquery';
  export default {
      
   created()
    {
     
      if(!User.loggedIn())
      {
        this.$router.push({name: '/'}) 
      }
      else
      {
  this.getdata();
      }
  

    },
data(){
    return {
       categories:[],
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.categories.filter(category =>{
  return category.category_name.toLowerCase().match(this.searchTerm.toLowerCase())
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this Category",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/category/'+id)
         .then(response=>{
             Notification.success();
             this.categories = this.categories.filter(category => {
                  return category.id != id
                });
         })
         .catch(error=>{

         })
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
   
  }
})
        
      },
      getdata()
      {
          axios.get("/api/category").then(response=>
    {
      this.categories = response.data;
   
    }).
    catch(error=>{
        console.log(error);
    });
      }

  }
}
</script>

<style scoped>
.mytextbox{
    border: none;
    border-bottom: 1px solid;
}
</style>