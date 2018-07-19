<template>
    <div>
        <input v-model="quantity"/>
        <div v-for="availibility in availibilities">
            <span>Склад:{{availibility.store.name.name}}</span>
            <span>Наличие:{{availibility.quantity_free}}</span>
            <span>Кратно:{{availibility.multiply}}</span>
            <div v-for="(price,index) in availibility.prices">
                <span v-if="index==0">От {{availibility.minimum}}</span>
                <span v-else>От {{availibility.prices[index-1].maximum+1}}</span>
                <span>{{price.price}} руб.</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductCardComponent",
        props:['product'],
        data(){
            return {
                quantity:0,
                availibilities:[],
            }
        },
        watch:{
            product:function(newVal,oldVal){
                axios.get('prices',{params:{t1:1,product_id:newVal.id}})
                    .then(response => {
                        this.availibilities = response.data;
                    })
                    .catch(error => {
                        this.availibilities = [];
                    })
            }
        }
    }
</script>

<style scoped>

</style>