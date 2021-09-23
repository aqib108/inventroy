<template>
   <div>
   <div class="p-3">
    
    <router-link to="/All-Salary"  class="mb-3 btn btn-outline-primary">View Salaries</router-link>
        </div>
   <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Salary</h1>
                  </div>
                  <form @submit.prevent="update" enctype="multipart/form-data">
               <div class="form-group">
                <div class="form-row">
                <div class="col-md-6">
                 <label>Employee Name</label>
                <input type="text" id="name" class="form-control" v-model="build.name" disabled />
  
                </div>
                 <div class="col-md-6">
                  <label>Employee Email</label>
                 <input type="text" id="email" class="form-control" v-model="build.email" disabled />
                </div>
                </div>
                </div>

                <div class="form-group">
                <div class="form-row">
                <div class="col-md-4">
                 <label>Pay Amount</label>
                <input type="number" id="amount" class="form-control" v-model="form.amount" />
              <small class="text-danger" v-if="errors.amount" >{{ errors.amount[0] }}</small>
                </div>
                <div class="col-md-4">
                <label>Salary Month</label>
                <select id="month" name="month"  class="form-control" v-model="form.salary_month">
    <option>month</option>
    <option value="january">January</option>
    <option value="february">February</option>
    <option value="march">March</option>
    <option value="april">April</option>
    <option value="may">May</option>
    <option value="june">June</option>
    <option value="july">July</option>
    <option value="august">August</option>
    <option value="september">September</option>
    <option value="october">October</option>
    <option value="november">November</option>
    <option value="december">December</option>
</select>
                </div>
                 <div class="col-md-4">
                  <label>Pay Date</label>
                <input type="date" id="salary_date" class="form-control" v-model="form.salary_date" />
              <small class="text-danger" v-if="errors.salary_date" >{{ errors.salary_date[0] }}</small>
                </div>
                </div>
                </div>
                
                      
                   
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                   
                  </form>
                 
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
</template>
<script>
import index from './index.vue'
  var d = new Date();
  export default {
  components: { index },
   created()
    {
      if(!User.loggedIn())
      {
        this.$router.push({name: '/'}) 
      }
      else
      {

      }
      this.employee_id =  this.$route.params.employee_id,
      this.id =  this.$route.params.salary_id
       axios.put('/api/edit-employee/'+this.employee_id)
       .then(response=>{
            this.build = response.data;
            this.getedit();
       })
       .catch(error=>{

       })
    },
data(){
  

    return {
      
        form:{
            
            amount:null,
            salary_month:null,
            salary_date:null,
            salary_year:null,
            employee_id:null
        },
        build:{
            name:null,
            email:null,
        },
        employee_id:null,
        id:null,
        errors:{},
        info:null
    }
  },
methods:{
    getedit()
    {
       axios.get('/api/salary/'+this.id)
       .then(response=>{
            this.form = response.data;
            
            
       })
       .catch(error=>{

       })  
    },
    
      update()
      {
        axios.patch('/api/salary/'+this.id,this.form)
        .then(resp=>{
        
        Notification.success();
        
          this.$router.push({name: 'AllPay-Salary',params:{salary_month:this.form.salary_month}})
        })
        .catch(error=>{
          this.errors = error.response.data.errors;
         Notification.warning();
        })
      }

  }
}
</script>
<style>

</style>