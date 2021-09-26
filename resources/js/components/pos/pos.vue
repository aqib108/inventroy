<template>
    <div>
      <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Point of Sale</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
          </div>

          <div class="row mb-3">
          
         
          
           

            <!-- Invoice Example -->
            <div class="col-xl-6 col-lg-6 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Cart</h6>
                  <a class="m-0 float-right btn btn-primary btn-sm"   data-toggle="modal" data-target="#exampleModalLong"><i
                      class="fas fa-user"></i>Add Customer</a>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                   
                     
                      
                      <tr v-for="cartproduct in cartproducts" :key="cartproduct.id">
                        <td><router-link :to="{ name:'Edit-Product', params:{product_id:cartproduct.product_id } }">{{cartproduct.product_name}}</router-link></td>
                        <td><span @click="increment(cartproduct.id)" class="btn btn-sm btn-outline-success mb-1"><i class="fa fa-plus"></i></span><input class="qtytext" type="number" :value="cartproduct.product_qty" ><span v-if="cartproduct.product_qty>=2" @click="decrement(cartproduct.id)" class="btn btn-sm btn-outline-danger mb-1"><i class="fa fa-minus"></i></span><span v-else @click="decrement(0)" class="btn btn-sm btn-outline-danger mb-1"><i class="fa fa-minus"></i></span></td>
                        <td>{{cartproduct.product_price}}</td>
                        <td>{{cartproduct.subtotal}}</td>
                        <td><a  @click="removetocart(cartproduct.id)" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-item-center">
                Qty : <strong>{{ Qty }}</strong>
                </li>
                 <li class="list-group-item d-flex justify-content-between align-item-center">
                Sub Total : <strong>{{ Total }} RS</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-item-center">
                Tex : <strong>5%</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-item-center">
                Total : <strong>{{ Total*(1+5/100) }} RS</strong>
                </li>
                </ul>
                <hr>
                <form @submit.prevent="placeorder">
                <label>Customer Name</label>
                <select class="form-control" id="product_supplier" v-model="form.customer_id">
                <option v-for="customer in customers" :value="customer.id" :key="customer.id">{{customer.name}}</option>
                </select>
                <label>Pay</label>
                <input type="text" class="form-control" v-model="form.pay" />
                <label>Due</label>
                <input type="text" class="form-control" v-model="form.due" />
                <label>Pay Method</label>
                <select class="form-control"  v-model="form.pay_method">
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
                <option value="cheaque">Cheaque</option>
                </select>
                <br>
                <button type="submit" class="btn btn-primary mr-auto">Checkout</button>
                </form>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6">
            
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
             
   <input type="text" v-model="searchTerm" placeholder="Search by Name" class="form-control" />

                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" @click="getproducts(0)" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Products</a>
  </li>
  <li v-for="category in categories" :key="category.id" class="nav-item">
    <a class="nav-link" id="profile-tab" @click="getproducts(category.id)" data-toggle="tab" href="#home" role="tab" aria-controls="profile" aria-selected="false">{{ category.category_name }}</a>
  </li>
  

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
   
   <div class="row">
     <div v-for="product in filtersearch" :key="product.id" class="col-md-4 p-3">
      <div class="card" style="width: 7rem;">
  <img class="card-img-top" :src="product.image" alt="Card image cap">
  <div class="card-body">
  <p>{{product.product_name}}</p>
  <p>{{product.selling_price}}</p>
   <button @click="Addtocart(product.id)" type="button" class="btn btn-xs btn-primary">
  <i class="fas fa-cart-plus"></i>
  
</button>
    
  </div>
</div>

     </div>
   </div>

  </div>
</div>
                 
                 
                 
                 
                </div>
                <div class="card-footer text-center">
                  <a class="m-0 small text-primary card-link" href="#">View More <i
                      class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
           
          
           
          </div>
          <!--Row-->

          <div class="row">
            <div class="col-lg-12 text-center">
              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </div>
          </div>

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div> 
          <!--add user modal -->
          <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Customer</h1>
                  </div>
                  <form @submit.prevent="create" enctype="multipart/form-data">
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label> Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Your Name" v-model="form1.name">
                       <small class="text-danger" v-if="errors.name" >{{ errors.name[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label> Email</label>
                      <input type="text" class="form-control" id="email" placeholder="Enter Your Email" v-model="form1.email">
                       <small class="text-danger" v-if="errors.email" >{{ errors.email[0] }}</small>
                    </div>
                    </div>
                      
                    </div>
     <div class="form-group">
                    <div class="form-row">
                    
                    <div class="col-md-6">
                     <label> Phone</label>
                      <input type="number" class="form-control" id="phone" placeholder="Enter Your Phone No" v-model="form1.phone">
                       <small class="text-danger" v-if="errors.phone" >{{ errors.phone[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label> Address</label>
                      <input type="text" class="form-control" id="address" placeholder="Enter Your Address" v-model="form1.address">
                       <small class="text-danger" v-if="errors.address" >{{ errors.address[0] }}</small>
                    </div>
                    </div>
                      
                    </div>
                
                  
                                   <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                   
                      <input type="file" class="custom-file-input" @change="onChange" accept="image/*">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                       <small class="text-danger" v-if="errors.photo" >{{ errors.photo[0] }}</small>
                    </div>
                    <div class="col-md-6">
                    <img :src="form1.photo" style="height: 50px; width: 50px" />
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
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
    this.getcategories();
    this.getproducts(0);
    this.getcustomers();
     this.cartproduct();
    Reload.$on('AfterAddtoCart',()=>{
      this.cartproduct();
        this.getcustomers();
    });
    },
    computed:{
    filtersearch()
     {
   
return this.products.filter(product =>{
  return product.product_name.match(this.searchTerm)
})
     },
     Qty()
     {
       let sum=0;
       for(let i=0; i<this.cartproducts.length; i++)
       {
         sum = sum + (parseFloat(this.cartproducts[i].product_qty));
       }
       return sum;
     }, 
     Total()
     {
       let sum=0;
       for(let i=0; i<this.cartproducts.length; i++)
       {
         sum = sum + (parseFloat(this.cartproducts[i].subtotal));
       }
       return sum;
     }
  },
    data(){
    return {
      form:{
        customer_id:null,
        pay_method:null,
        pay:null,
        due:null
      },
       form1:{
            email:null,
            name:null,
            photo:'https://image.shutterstock.com/image-vector/default-avatar-profile-icon-grey-600w-518740741.jpg',
            phone:null,
            address:null,

            
        },
       errors:[],
       products:[],
       categories:[],
       customers:[],
       cartproducts:[],
       searchTerm:'',
       carts:[]
    }
  },
  methods:{
    onChange(e) {
      const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.form1.photo = e.target.result;
                    
                };
    },
      create()
      {
       
        axios.post('/api/customer',this.form1)
        .then(resp=>{
        
        Notification.success();
           Reload.$emit('AfterAddtoCart');
           
         //this.$router.push({name: 'All-Customer'})
         
        })
        .catch(error=>{
          this.errors = error.response.data.errors;
         Notification.warning();
        })
      },
        placeorder()
      {
        axios.post('/api/placeorder',this.form)
        .then(resp=>{
        
        Notification.informer(resp.data.message);
       Reload.$emit('AfterAddtoCart');
       //  this.$router.push({name: 'All-Expense'})
         
        })
        .catch(error=>{
          this.errors = error.response.data.errors;
         Notification.warning();
        })
      },

      getcategories()
      {
        axios.get("/api/category").then(response=>
     {
        this.categories = response.data;
     }).
     catch(error=>{
        console.log(error);
     });
    },
    getproducts(id)
    {
         axios.get("/api/getproduct/"+id).then(response=>
     {
        this.products = response.data;
     }).
     catch(error=>{
        console.log(error);
     });

    },
    getcustomers()
    {
      axios.get("/api/customer").then(response=>
    {
      this.customers = response.data;
    
      // $('#datatable').DataTable();
    }).
    catch(error=>{
        console.log(error);
    });
    },
    Addtocart(id)
    {
      axios.get("/api/Addtocart/"+id).then(response=>
     {
       Reload.$emit('AfterAddtoCart');
       Notification.informer(response.data.message);
        //this.carts = response.data;
     }).
     catch(error=>{
        Notification.errorinformer(error);
     });
     
    },
    cartproduct()
    {
      axios.get("/api/cartproducts").then(response=>
    {
      this.cartproducts = response.data;
    
      // $('#datatable').DataTable();
    }).
    catch(error=>{
        console.log(error);
    });

    },
    removetocart(id)
    {
      axios.get("/api/removetocart/"+id).then(response=>
     {
       Reload.$emit('AfterAddtoCart');
       Notification.informer(response.data.message);
        //this.carts = response.data;
     }).
     catch(error=>{
        Notification.errorinformer(error);
     });
    },
    increment(id)
    {
      axios.get("/api/incrementcart/"+id).then(response=>
     {
       Reload.$emit('AfterAddtoCart');
       Notification.informer(response.data.message);
        //this.carts = response.data;
     }).
     catch(error=>{
        Notification.errorinformer(error);
     });
    },
    decrement(id)
    {
      if(id==0)
      {
        Notification.errorinformer('The Quantity Not Less Then 1');
        return false;
      }
      axios.get("/api/decrementcart/"+id).then(response=>
     {
       Reload.$emit('AfterAddtoCart');
       Notification.informer(response.data.message);
        //this.carts = response.data;
     }).
     catch(error=>{
        Notification.errorinformer(error);
     });
    }
  }

}
</script>
<style scoped>
.qtytext{
    text-align-last: revert;
    text-align: center;
    width: 34px;
}

</style>
