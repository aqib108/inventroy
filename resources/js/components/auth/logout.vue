<template>

</template>
<script>
export default{
    created()
    {
      if(User.logout())
      {
        Toast.fire({
                 icon: 'success',
                 title: 'Logout Successfully'
                   });
        this.$router.push({name: '/login'}) 
      }

    }
}
</script>
<style scoped>

</style>