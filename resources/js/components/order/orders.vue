<template>
    <div class="p-3">
    <h3>Orders</h3>
    <router-link to="/Add-Product" style="float:right" class="mb-3 btn btn-outline-primary">Add Product</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By order Date" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Order Number</th>
       <th scope="col">Order Date</th>
      <th scope="col">Qty</th>
      <th scope="col">tex</th>
      <th scope="col">Total</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(order,idx) in filtersearch" :key="idx">
      <th scope="row">{{idx+1}}</th>
      <td>{{order.customer_name}}</td>
      <td>{{order.order_id}}</td>
      <td>{{order.order_date}}</td>
      <td>{{order.qty}}</td>
      <td>{{order.tex}}</td>
       <td>{{order.total}}</td>
    
        <td>
    
         <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Stock', params:{product_id:order.id } }"><i class="fa fa-eye"></i>View</router-link></button>
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
       orders:[],
       ind:1,
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.orders.filter(order =>{
  return order.order_date.match(this.searchTerm)
})
     }
  },
methods:{
     
    
      getdata()
      {
          axios.get("/api/getorders").then(response=>
    {
      this.orders = response.data;
    
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