<template>
    <div class="p-3">
    <h3>All Expense</h3>
    <router-link to="/Add-Expense" style="float:right" class="mb-3 btn btn-outline-primary">Add Expense</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Date" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Amount</th>
      <th scope="col">Details</th>
      <th scope="col">Date</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(Expense,idx) in filtersearch" :key="idx">
      <th scope="row">{{idx+1}}</th>
      <td>{{Expense.amount}}</td>
      <td>{{Expense.details}}</td>
     <td>{{Expense.expense_date}}</td>
        <td>
        <button class="btn btn-xs btn-outline-danger" @click="deletedata(Expense.id)"><i class="fa fa-trash"></i></button>
        <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Expense', params:{expense_id:Expense.id }}"><i class="fa fa-edit"></i></router-link></button>
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
       expenses:[],
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.expenses.filter(Expense =>{
  return Expense.expense_date.match(this.searchTerm)
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this expense",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/expense/'+id)
         .then(response=>{
             Notification.success();
             this.expenses = this.expenses.filter(Expense => {
                  return Expense.id != id
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
          axios.get("/api/expense").then(response=>
    {
      this.expenses = response.data;
   
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