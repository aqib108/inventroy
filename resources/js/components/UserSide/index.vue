<template>
  <div>
<div class="container">
<h3 class="text-center">Our Products</h3>
<cart/>
 <div class="row pt-5">
    <div v-for="product in products" :key="product.id" class="col-sm">
      <div class="card" style="width: 18rem;">
  <img class="card-img-top" :src="product.image" width="80px" height="200px" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">{{product.product_name}}</h5>
    <p class="card-text">Price : {{product.selling_price}} Rs <br>
    Product Code : {{product.product_code}}
    </p>
    
  <button class="btn btn-primary" @click="addtocart(product)">Add to Cart</button>
  </div>
</div>
    </div>
   
  </div>
</div>
  </div>
</template>

<script>
import cart from './cart.vue'
export default {
    components:{
    cart
    },
    data()
    {
        return {
            loading:false,
          
        }
    },
  computed:{
      products()
      {
          //return this.$store.getters.getproduct
         return  this.$store.getters.getproduct
      }
      
  },
  created()
  {
      this.loading = true;
      this.$store.dispatch('fetchproducts')
      .then(()=>this.loading=false)
  },
  methods:{
      addtocart(product)
      {
          this.$store.dispatch('addtocart',product)
      }
  }
}
</script>

<style>

</style>