<template>
    <div class="p-3">
    <h3>All Suppliers</h3>
    <router-link to="/Add-supplier" style="float:right" class="mb-3 btn btn-outline-success">Add Supplier</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Name" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Shop Name</th>
      <th scope="col">Phone</th>
       <th scope="col">Address</th>
        <th scope="col">Image</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="supplier in filtersearch" :key="supplier.id">
      <th scope="row">{{supplier.id}}</th>
      <td>{{supplier.name}}</td>
      <td>{{supplier.shop_name}}</td>
      <td>{{supplier.phone}}</td>
      <td>{{supplier.address}}</td>
      <td><img :src="supplier.photo" style="height: 90px; width: 80px" /></td>
        <td>
        <button class="btn btn-xs btn-outline-danger" @click="deletedata(supplier.id)"><i class="fa fa-trash"></i></button>
        <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Supplier', params:{supplier_id:supplier.id } }"><i class="fa fa-edit"></i></router-link></button>
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
       suppliers:[],
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.suppliers.filter(supplier =>{
  return supplier.name.match(this.searchTerm)
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this Employee",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/supplier/'+id)
         .then(response=>{
             Notification.success();
             this.suppliers = this.suppliers.filter(supplier => {
                  return supplier.id != id
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
          axios.get("/api/supplier").then(response=>
    {
      this.suppliers = response.data;
    
      // $('#datatable').DataTable();
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