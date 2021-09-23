<template>
   <div>
   <div class="p-3">
    
    <router-link to="/All-Product"  class="mb-3 btn btn-outline-primary">View Product</router-link>
        </div>
   <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                  </div>
                  <form @submit.prevent="create" enctype="multipart/form-data">
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label>Product Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Your Product Name" v-model="form.product_name">
                       <small class="text-danger" v-if="errors.product_name" >{{ errors.product_name[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label>Product Code</label>
                      <input type="text" class="form-control" id="code" placeholder="Enter Your Product Code" v-model="form.product_code">
                       <small class="text-danger" v-if="errors.product_code" >{{ errors.product_code[0] }}</small>
                    </div>
                    </div>
                      
                    </div>
<div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
   
                      <label for="product_category">Product Category</label>
                      <select class="form-control" id="product_category" v-model="form.category_id">
                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
                      
                      </select>
                    
                       <small class="text-danger" v-if="errors.category_id" >{{ errors.category_id[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     
                    <label for="product_supplier">Product Supplier</label>
                      <select class="form-control" id="product_supplier" v-model="form.supplier_id">
                       <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">{{supplier.name}}</option>
   
                      </select>
                       <small class="text-danger" v-if="errors.supplier_id" >{{ errors.supplier_id[0] }}</small>
                    </div>
                    </div>
                      
                    </div>

                <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-4">
                    
                      <input type="text" class="form-control" id="shop_name" placeholder="Enter Product Root" v-model="form.root">
                       <small class="text-danger" v-if="errors.root" >{{ errors.root[0] }}</small>
                    </div>
                    <div class="col-md-4">
                   
                      <input type="number" class="form-control" id="bprice" placeholder="Enter Buying Price" v-model="form.buying_price">
                       <small class="text-danger" v-if="errors.buying_price" >{{ errors.buying_price[0] }}</small>
                    </div>
                  
                      <div class="col-md-4">
                    
                      <input type="number" class="form-control" id="sprice" placeholder="Enter Selling Price" v-model="form.selling_price">
                       <small class="text-danger" v-if="errors.selling_price" >{{ errors.buying_price[0] }}</small>
                    </div>
                    </div>
                    </div>
                
                  <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label>Buying Date</label>
                      <input type="date" class="form-control" id="buying_date" placeholder="Enter Your Buying Date" v-model="form.buying_date">
                       <small class="text-danger" v-if="errors.buying_date" >{{ errors.buying_date[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label>Product Quantity</label>
                      <input type="number" class="form-control" id="product_qty" placeholder="Product Quantity" v-model="form.qty">
                       <small class="text-danger" v-if="errors.qty" >{{ errors.qty[0] }}</small>
                    </div>
                    </div>
                  </div>
                                   <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                  
                      <input type="file" class="custom-file-input" @change="onChange" accept="image/*">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                       <small class="text-danger" v-if="errors.image" >{{ errors.image[0] }}</small>
                    </div>
                    <div class="col-md-6">
                    <img :src="form.image" style="height: 50px; width: 50px" />
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
  
  export default {
   created()
    {
      if(!User.loggedIn())
      {
        this.$router.push({name: '/'}) 
      }
      this.getcategories();
      this.getsuppliers();
    },
data(){
    return {
        form:{
            
            product_name:null,
            product_code:null,
            category_id:null,
            supplier_id:null,
            root:null,
            buying_price:null,
            selling_price:null,
            buying_date:null,
            qty:null,
            image:'https://image.shutterstock.com/image-vector/default-avatar-profile-icon-grey-600w-518740741.jpg',
        
            
        },
        errors:{},
        info:null,
        suppliers:{},
        categories:{}
    }
  },
methods:{
    onChange(e) {
      const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.form.image = e.target.result;
                    
                };
    },
      create()
      {
        axios.post('/api/product',this.form)
        .then(resp=>{
        
        Notification.success();
        this.$router.push({name: 'All-Product'})
         
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
      getsuppliers()
      {
  
          axios.get("/api/supplier").then(response=>
    {
      this.suppliers = response.data;
    }).
    catch(error=>{
        console.log(error);
    });
      
      }

  }
}
</script>
<style>

</style>