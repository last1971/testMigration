<template>
    <div classs="container">
        <div class="form-row">
            <label class="col">Введите количество</label>
            <input class="col" v-model="quantity"/>
        </div>
        <div class="row" v-for="availibility in availibilities">
            <span class="col">Склад: {{availibility.store.name.name}}</span>
            <span class="col">Наличие: {{availibility.quantity_free}}</span>
            <span class="col">Кратно: {{availibility.multiply}}</span>
            <div class="container" v-for="(price,index) in availibility.prices">
                <div class="row"
                     v-bind:class="{ 'bg-warning': notAvailible(quantity,availibility.quantity_free) }"
                     v-if="(index == 0 && quantity >= availibility.minimum && quantity <= price.maximum) || (index > 0 && quantity >= availibility.prices[index-1].maximum+1 && quantity <= price.maximum)"
                >
                    <span class="col" v-if="index == 0">От {{availibility.minimum}} шт.</span>
                    <span class="col" v-else>От {{availibility.prices[index-1].maximum+1}} шт.</span>
                    <span class="col">Цена: {{number_format(price.price,2,',',' ')}} руб.</span>
                    <span class="col">Итого: {{number_format(price.price * quantity,2,',',' ')}} руб.</span>
                </div>
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
                quantity:1,
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
        },
        methods: {
            notAvailible(quantity,maximum){
                return quantity>maximum;
            },
            number_format(number, decimals, dec_point, thousands_sep) {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + (Math.round(n * k) / k)
                            .toFixed(prec);
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                    .split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '')
                    .length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1)
                        .join('0');
                }
                return s.join(dec);
            }
        }
    }
</script>

<style scoped>

</style>