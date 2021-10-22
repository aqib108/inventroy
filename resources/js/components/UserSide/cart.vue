<template>
  <div>
<div class="btn btn-success">Cart( {{sumofqty}} )</div>
<hr>
<table v-if="cartproducts.length>0" class="table">
  <thead>
    <tr>
      
      <th scope="col">title</th>
      <th scope="col">Price</th>
      <th scope="col">qty</th>
        <th scope="col">Subtotal</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="cartproduct in cartproducts" :key="cartproduct.id">
      
      <td>{{cartproduct.title}}</td>
      <td>{{cartproduct.price}}</td>
      <td><span class="btn btn-xs btn-outline-success" @click="addqty(cartproduct)">+</span><span class="px-1"><b> {{cartproduct.qty}} </b> </span> <span @click="removeqty(cartproduct)" class=" btn btn-xs btn-outline-danger">-</span></td>
        <td>{{cartproduct.subtotal}}</td>
      <td><button class="btn btn-xs btn-outline-danger" @click="deleteItem(cartproduct.id)">Removed</button></td>
    </tr>
      <tr>
   <td colspan="1"><b>Total Quantity : {{sumofqty}}</b></td>
   </tr>
   <tr>
   <td colspan="1"><b>SubTotal  : {{totalAmount}}</b></td>
   </tr>
   <tr>
   <td colspan="1"><b>Total Amount : {{totalAmount}}</b></td>
   </tr>
   <tr>
   <td colspan="1"><button class="btn btn-primary">Checkout</button></td>
   </tr>
  
  </tbody>
</table>
<hr>
  </div>
</template>

<script>
export default {
  computed:{
      cartproducts()
      {
     
         return  this.$store.getters.getcartproducts
      },
      sumofqty()
      {
        return  this.$store.getters.sumofqty
 
      },
      totalAmount()
      {
           return  this.$store.getters.sumofsubtotal
      }
  },
  methods:{
      deleteItem(productId)
      {
     
 this.$store.dispatch('removedItem',productId)
      },
      addqty(product)
      {
this.$store.dispatch('increment_cart',product)
      },
      removeqty(product)
      {
          if(product.qty>1)
          {
    this.$store.dispatch('decrement_cart',product)          
          }
          else
          {
              alert('Product QTY shuold be Greater then 1');
          }

      }

  }
}
</script>

<style>

</style>