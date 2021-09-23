<template>
    <div class="p-3">
    <h3>{{month}} Salaries List</h3>
    <router-link to="/All-Employee" style="float:right" class="mb-3 btn btn-outline-primary">Pay Salary</router-link>
       <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Employee Name" /> 
        <div>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Amount</th>
      <th scope="col">Status</th>
      <th scope="col">Salary Date</th>
         <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(salary,idx) in filtersearch" :key="idx">
      <th scope="row">{{idx+1}}</th>
      <td>{{salary.employee_name}}</td>
     <td>{{salary.employee_email}}</td>
     <td>{{salary.amount}}</td>
       <td>Paid</td>
     <td>{{salary.salary_date}}</td>
        <td>
           <button class="btn btn-xs btn-outline-danger" @click="deletedata(salary.id)"><i class="fa fa-trash"></i></button>
               <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Salary', params:{salary_id:salary.id,employee_id:salary.employee_id} }"><i class="fa fa-edit"></i></router-link></button>
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
       month:this.$route.params.salary_month,
       salaries:[],
       searchTerm:''
    }
  },
  computed:{
    
filtersearch()
     {
   
return this.salaries.filter(salary =>{
  return salary.employee_name.toLowerCase().match(this.searchTerm.toLowerCase())
})
     }
  },
methods:{
     
      deletedata(id)
      {
         
          swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Delete this Month Salary Record",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     axios.delete('/api/salary/'+id)
         .then(response=>{
             Notification.success();
             this.salaries = this.salaries.filter(salary => {
                  return salary.id != id
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
          axios.get("/api/Allsalarybymonth/"+this.month).then(response=>
    {
      this.salaries = response.data;
   
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