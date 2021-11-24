<template>
    <div class="table-responsive">
        <h1 class="mb-5 title"> <i class="fab fa-shopify"></i>Vendas</h1>
        <!-- <TableSales/> -->
        <table class="table table-hover table-striped">
            <thead class="table-primary">
                <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col"> Produtos </th>
                <th scope="col"> Total </th>
                <th scope="col"> Data </th>
                <th scope="col"> Endereco </th>
                <th scope="col"> Acoes </th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-for="sale in sales" :key="sale.id" class="text-center">
                <th scope="row">{{sale.id}}</th>
                <td class="text-center">
                    <a type="button" class="btn btn-success" @click="showProducts(sale.products)"><i class="text-white fas fa-eye"></i></a>
                </td>
                <td>{{sale.total}} R$</td>
                <td>{{sale.date}}</td>
                <td>{{sale.address.cep}},
                    {{sale.address.street}},
                    {{sale.address.neighborhood}},
                    {{sale.address.city}},
                    {{sale.address.state}},
                </td>
                <td>
                    <a type="button" @click="deleteSale(sale.id)" class="btn btn-danger"><i class="fas fa-trash text-white"></i></a>
                </td>
                </tr>
            </tbody>
        </table>
        <modal-products v-if="showModal" @close="showModal = false" :products=products />
    </div>
</template>
<script>
import ModalProducts from './sale/ModalProducts.vue'

export default {
    name:"sales",
    data(){
        return {
            sales:[],
            showModal: false,
            products:[]
        }
    },
    mounted(){
        this.showSales()
    },
    methods:{
        async showSales(){
            await this.axios.get('/api/sale').then(response=>{
                this.sales = response.data
            }).catch(error=>{
                console.log(error)
                this.sales = []
            })
        },
        deleteSale(id){
            if(confirm("¿Confirma eliminar el registro?")){
                this.axios.delete(`/api/sale/${id}`).then(response=>{
                    this.showSales()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        showProducts(products){
            this.products=products;
            console.log(this.products)
            this.showModal = true
        }
    },
    components:{
        ModalProducts
    }
}
</script>
<style scoped>
.tbody tr > td{
        font-size: small;
    }

.title , thead , .tbody tr > th{
    color:#0d6efd;
}

.title{
    text-shadow: 2px 1px 3px rgba(150, 150, 150, 1);
    font-weight: bold;
}
</style>
