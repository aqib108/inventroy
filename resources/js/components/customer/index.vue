<template>
    <div class="p-3">
    <h3>All Customers</h3>
    <router-link to="/Add-Customer" style="float:right" class="mb-3 btn btn-outline-success">Add Customer</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Name" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
       <th scope="col">Address</th>
        <th scope="col">Image</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(customer,idx) in filtersearch" :key="idx">
      <th scope="row">{{idx+1}}</th>
      <td>{{customer.name}}</td>
    
      <td>{{customer.phone}}</td>
      <td>{{customer.address}}</td>
      <td><img :src="customer.photo" style="height: 90px; width: 80px" /></td>
        <td>
        <button class="btn btn-xs btn-outline-danger" @click="deletedata(customer.id)"><i class="fa fa-trash"></i></button>
        <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Customer', params:{customer_id:customer.id } }"><i class="fa fa-edit"></i></router-link></button>
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
       customers:[],
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.customers.filter(customer =>{
  return customer.name.match(this.searchTerm)
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this Customer",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/customer/'+id)
         .then(response=>{
             Notification.success();
             this.customers = this.customers.filter(customer => {
                  return customer.id != id
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
          axios.get("/api/customer").then(response=>
    {
      this.customers = response.data;
    
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