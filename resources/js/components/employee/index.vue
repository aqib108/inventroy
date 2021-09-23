<template>
    <div class="p-3">
    <h3>All Employee</h3>
    <router-link to="/Add-Employee" style="float:right" class="mb-3 btn btn-outline-primary">Add Employee</router-link>
        <input type="text" class="mytextbox" v-model="searchTerm" placeholder="Search By Name" /> 
        <div>
        
          <table  class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Salary</th>
            <th>Joing Date</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="employee in filtersearch" :key="employee.id">
            <td>{{employee.id}}</td>
            <td>{{employee.name}}</td>
            <td>{{employee.email}}</td>
            <td>{{employee.salary}}</td>
            <td>{{employee.date}}</td>
            <td><img :src="employee.photo" style="height: 90px; width: 80px" /></td>
            <td>
            <button class="btn btn-xs btn-outline-danger" @click="deletedata(employee.id)"><i class="fa fa-trash"></i></button>
               <button class="btn btn-xs btn-outline-success"><router-link :to="{ name:'Edit-Employee', params:{employee_id:employee.id } }"><i class="fa fa-edit"></i></router-link></button>
           <router-link :to="{ name:'Pay-Salary', params:{employee_id:employee.id } }"  class=" btn btn-xs btn-outline-primary">Pay Salary</router-link>
            </td>




          
          </tr>
          
        </tbody>
      </table>
        </div>    
    </div>
</template>
<script>
  
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
    computed:{
    
filtersearch()
     {
   
return this.employees.filter(employee =>{
  return employee.name.match(this.searchTerm)
})
     }
  },
data(){
    return {
       employees:[],
       searchTerm:''
    }
  },
  
methods:{
    onChange(e) {
      const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.form.photo = e.target.result;
                    console.log(this.form.photo);
                };
    },
      create()
      {
        axios.post('/api/create-employee',this.form)
        .then(resp=>{
        
        Notification.success();
         
        })
        .catch(error=>{
          this.errors = error.response.data.errors;
         Notification.warning();
        })
      },
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
     axios.delete('/api/delete-employee/'+id)
         .then(response=>{
             Notification.success();
          this.employees = this.employees.filter(employee => {
                  return employee.id != id
                });
          //   this.getdata();
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
          axios.get("/api/employees").then(response=>
    {
      this.employees = response.data;
     
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