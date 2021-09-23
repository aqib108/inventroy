<template>
   <div>
   <div class="p-3">
    
    <router-link to="/All-Expense"  class="mb-3 btn btn-outline-primary">View Expense</router-link>
        </div>
   <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Expense</h1>
                  </div>
                  <form @submit.prevent="update" enctype="multipart/form-data">
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-12">
                     <label>Expense Details</label>
                     <textarea v-model="form.details" class="form-control"></textarea>
                     
                       <small class="text-danger" v-if="errors.category_name" >{{ errors.category_name[0] }}</small>
                    </div>
                    
                    </div>
                      
                    </div>
                <div class="form-group">
                <div class="form-row">
                <div class="col-md-6">
                 <label>Expense Amount</label>
                <input type="text" id="amount" class="form-control" v-model="form.amount" />
              <small class="text-danger" v-if="errors.amount" >{{ errors.amount[0] }}</small>
                </div>
                 <div class="col-md-6">
                  <label>Expense Date</label>
                <input type="date" id="expense_date" class="form-control" v-model="form.expense_date" />
              <small class="text-danger" v-if="errors.expense_date" >{{ errors.expense_date[0] }}</small>
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
      this.id =  this.$route.params.expense_id
       axios.get('/api/expense/'+this.id)
       .then(response=>{
            this.form = response.data;
        
       })
       .catch(error=>{

       })
    },
data(){
    return {
        form:{
            details:null,
            amount:null,
            expense_date:null,
        },
        id:null,
        errors:{},
        info:null
    }
  },
methods:{
    
    
      update()
      {
        axios.patch('/api/expense/'+this.id,this.form)
        .then(resp=>{
        
        Notification.success();
          this.$router.push({name: 'All-Expense'})
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