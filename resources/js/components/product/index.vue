<template>
    <div class="p-3">
    <h3>All Product</h3>
    <router-link to="/Add-Product" style="float:right" class="mb-3 btn btn-outline-primary">Add Product</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Name" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Category Name</th>
      <th scope="col">Qty</th>
       <th scope="col">Buying Price</th>
        <th scope="col">Sell Price</th>
        <th scope="col">Supplier Name</th>
        <th scope="col">image</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(product,idx) in filtersearch" :key="idx">
      <th scope="row">{{idx+1}}</th>
      <td>{{product.product_name}}</td>
      <td>{{product.category_name}}</td>
      <td>{{product.qty}}</td>
      <td>{{product.buying_price}}</td>
      <td>{{product.selling_price}}</td>
       <td>{{product.supplier_name}}</td>
      <td><img :src="product.image" style="height: 90px; width: 80px" /></td>
        <td>
        <button class="btn btn-xs btn-outline-danger" @click="deletedata(product.id)"><i class="fa fa-trash"></i></button>
         <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Product', params:{product_id:product.id } }"><i class="fa fa-edit"></i></router-link></button>
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
       products:[],
       ind:1,
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.products.filter(product =>{
  return product.product_name.match(this.searchTerm)
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this Product",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/product/'+id)
         .then(response=>{
             Notification.success();
             this.products = this.products.filter(product => {
                  return product.id != id
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
          axios.get("/api/product").then(response=>
    {
      this.products = response.data;
    
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