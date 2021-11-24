<template>
    <div class="justify-content-center">
        <!-- Products -->
        <section class="justify-content-center">
            <p class="fs-1 text-center fw-bold title mb-0"> <i class="fab fa-shopify"></i>  Nova Venda</p>
            <hr class="mt-0" style="color:#0d6efd">
            <!-- Search Product -->
            <div class="row g-3 align-items-center d-flex justify-content-center mt-3 mb-4">
                    <div id="btn-search-product" class="input-group ">
                        <select v-model="searchProduct.name" class="form-select shadow-lg" id="inputGroupSelect04" aria-label="Example select with button addon">
                            <option disabled value="">Encontrar um Produto pelo</option>
                            <option value="name">nome</option>
                            <option value="code">codigo</option>
                            <option value="reference">referência</option>
                        </select>
                        <input v-model="searchProduct.value"  type="text" class="form-control shadow-lg" id="product" aria-describedby="productHelp" placeholder='de Produto' required>
                        <button @click="findProduct(searchProduct)" class="btn btn-outline-secondary shadow-lg btn-search-right" type="button"><i class="fas fa-search"></i></button>
                    </div>
                    <!-- spinner -->
                    <Spinner v-if="waitingProduct"/>
                    <!-- End spinner -->
                    <!-- Alert Product -->
                    <div id="alertProduct" v-if="productAlert.state" v-bind:class="{'alert-danger': productAlert.danger,'alert-primary':productAlert.primary}" class="alert  alert-dismissible fade show" role="alert">
                        <div v-if="productAlert.primary">
                            <!-- Product found -->
                            <table class="table table-hover table-striped">
                                <tbody class="tbody">
                                    <tr class="text-left">
                                        <th scope="row">Codigo</th>
                                        <td>{{newProduct.code}}</td>
                                    </tr>
                                    <tr class="text-left">
                                        <th scope="row">Referência</th>
                                        <td>{{newProduct.reference}}</td>
                                    </tr>
                                    <tr class="text-left">
                                        <th scope="row">Nome</th>
                                        <td>{{newProduct.name}}</td>
                                    </tr>
                                    <tr class="text-left">
                                        <th scope="row">Preço</th>
                                        <td>{{newProduct.price}} R$</td>
                                    </tr>
                                    <tr >
                                        <th> </th>
                                        <td class="text-right"> 
                                            <div class="d-grid gap-2">
                                                <button @click="addProduct(newProduct)" type="button" class="btn btn-primary">Add Produto</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Product found -->
                        </div>
                        {{productAlert.msg}}
                        <button @click="alertClosed" type="button" class="btn-close text-right" aria-label="Close"></button>
                    </div>
                    <!-- End Alert Product -->
                    <!-- table Products -->
                    <div id="container-table-products" class=" mt-5 py-5">
                        <table id="table-products" class="table table-hover table-striped shadow-lg">
                            <thead class="table-primary">
                                <tr class="text-center">
                                <th scope="col">PRODUTO</th> 
                                <th scope="col"> QTDE</th>
                                <th scope="col"> VALOR  </th>
                                <th scope="col"> SUBTOTAL </th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                
                                <tr v-for="(product,index) in products" :key="product.id" class="text-center align-middle">
                                    <th scope="row">{{product.name}}</th>
                                    <td class="text-center">
                                        <input v-model.number="product.amount" type="number" class="form-control text-center" @change="subtotal(index);" @keyup.enter="subtotal(index)" @blur="subtotal(index)">
                                    </td>
                                    <td>{{product.price}} R$</td>

                                    <td> 
                                        <div class="input-group align-middle">
                                            <input v-model.number="product.total" type="number" class="text-center form-control align-middle"  aria-describedby="basic-addon2" disabled>
                                            <span class="input-group-text" id="basic-addon2">R$</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a type="button" @click="delProduct(index)" class="btn btn-light"><i style="color:red" class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row"></th>
                                    <td scope="col"></td>
                                    <th scope="row">Total</th>
                                    <td>
                                        <div class="input-group align-middle">
                                            <input :value="total" type="number" class="text-center form-control align-middle" aria-describedby="basic-addon2" disabled>
                                            <span class="input-group-text" id="basic-addon2">R$</span>
                                        </div>
                                    </td>
                                    <td scope="col"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End table Products -->
            </div>
            <!--End Search Product-->
        </section>
        <!-- End Products -->

        <!-- Address -->
        <div class="justify-content-center">
            <p class="fs-3 text-center"> <i class="fas fa-paper-plane"></i> {{msg}}</p>
            <hr style="color:#0d6efd">
            <form v-on:submit.prevent="confirmSale"  id="container-address">
                <div class="input-group flex-nowrap mb-3">
                    <span class="input-group-text shadow-lg" id="addon-wrapping">CEP</span>
                    <input id="input-cep" v-model="address.cep" @blur="keyDown" type="number" class="form-control shadow-lg" placeholder="Preencha o CEP" aria-label="Preencha o CEP" aria-describedby="addon-wrapping">
                </div>
                <!-- Start Spinner -->
                <Spinner v-if="waitingCep"/>
                <!-- End spinner -->
                <!-- Alert cep -->
                <div v-if="invalidCep" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Cep invalido!</strong>
                    <button type="button" @click="invalidCep=false;address.cep=''" class="btn-close" aria-label="Close"></button>
                </div>
                <!-- End Alert cep -->
                <Address v-if="foundCep" v-bind:completeAddress="completeAddress"/>
                <div class="w-100 text-center">
                    <button v-if="foundCep && products.length > 0" class="btn btn-primary mb-5">OK</button>
                </div>
            </form>
        </div>
        <!-- End Address -->
    </div>
</template>
<script>
import  Spinner from './newSale/Spinner.vue'
import Address from './newSale/Address.vue'

export default {
    name:"home",
    data(){
        return {
            msg:'Endereço de envio',
            waitingProduct:false,
            searchProduct:{
                value:"",
                name:""
            },
            productAlert:{
                state:false,
                msg:"",
                danger:false,
                primary:true
            },
            newProduct:{},
            products:[],
            total:0,
            address:{
                cep:"",
                street:"",
                neighborhood:"",
                city:"",
                state:""
            },
            completeAddress:"",
            invalidCep:false,
            foundCep:false,
            waitingCep:false,
            showModal: false,
        }
    },
    methods:{
        keyDown(){
            this.waitingCep=true;
            const value = event.target.value
            this.address.cep = value
            console.log(this.address.cep)
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(this.address.cep)) {
                this.invalidCep=false;
                this.findCep(this.address.cep)
            }
            else{
                this.cleanAddress();
                this.waitingCep=false;
            }
        },
        async findProduct(product){
            if(product.name!=='' && product.value!==''){
                
                this.waitingProduct=true;

                await this.axios.get("http://localhost:8000/api/product/"+product.name+"/"+product.value)
                .then(response=>{
                    if (response.data.length > 0){

                        this.newProduct=response.data[0];
                        console.log(this.newProduct)
                        this.alertSuccess("")
                        this.waitingProduct=false;
                    }
                    else{

                        this.alertError("Produto não encontrado")
                        console.log("product not found")
                        this.waitingProduct=false;
                        
                    }
                    
                }).catch(error=>{
                    console.log(error)
                });
            }else{
                this.alertError("selecione um tipo de pesquisa e preencha o campo do produto")
            }
        },
        async findCep(cep){
            console.log("buscando")
            await this.axios.get('https://viacep.com.br/ws/'+cep+'/json/').then(response=>{
                if(response.data.logradouro!==undefined){
                    this.fillAddress(response)
                    this.foundCep=true;
                    console.log(this.address)
                }
                else{
                    this.cleanAddress();
                    this.foundCep=false;
                }

            }).catch(error=>{
                console.log(error)
            })
        },
        fillAddress(response){
            this.address.street=response.data.logradouro;
            this.address.neighborhood=response.data.bairro;
            this.address.city=response.data.localidade;
            this.address.state=response.data.uf;
            this.getAddress()
            this.waitingCep=false;
        },
        getAddress(){
            this.completeAddress=
            this.address.street+" , "
            +this.address.neighborhood+" , "
            +this.address.city+" , "
            +this.address.state
        },
        cleanAddress(){
            this.invalidCep=true;
            this.address.street="";
            this.address.neighborhood="";
            this.address.city="";
            this.address.state="";
        },
        alertError(msg){
            this.productAlert.msg=msg;
            this.productAlert.danger=true;
            this.productAlert.primary=false;
            this.productAlert.state=true;
        },
        alertSuccess(msg){
            this.productAlert.msg=msg;
            this.productAlert.state=true;
            this.productAlert.danger=false;
            this.productAlert.primary=true;
        },
        alertClosed(){
            this.productAlert.state=false;
            this.productAlert.msg="";
        },
        addProduct(product){
            this.alertClosed()
            if(this.isadded(product.code)){
                this.alertError("o produto já foi adicionado")
            }else{
                product.amount=1
                product.total=product.amount*product.price
                this.products.push(product)
                console.log(this.products)
            }
        },
        delProduct(index){
            let removed
            removed = this.products.splice(index, 1);
            
        },
        isadded(code){
            for(var i=0; i<this.products.length; i++) {
                if(this.products[i].code === code) {
                    return true
                }
            }
            return false
        },
        subtotal(index){
            this.products[index].total=this.products[index].amount*this.products[index].price
            this.totalProducts()
        },
        totalProducts(){
            this.total=0
            this.products.forEach(product => {
              this.total=this.total+product.total 
              console.log(this.total) 
            });
        },
        async confirmSale(){
            let json={
                address:this.address, 
                products: this.products 
            }
            console.log(json)
            await this.axios.post('http://localhost:8000/api/sale',json).then(response=>{
                console.log(response.status);
                if(response.status===201){
                    alert("venda feita com sucesso")
                    this.$router.push({ name: 'sale' })
                }
            }).catch(error=>{
                console.log(error)
            })
        } 
    },
    watch:{
        products: function () {
            this.total=0
            this.products.forEach(product => {
              this.total=this.total+product.total 
              console.log(this.total) 
            }); 
        }
    },
    components:{
        Spinner,
        Address,
    },
    computed:{
    }
}
</script>
<style scoped>
@import '../../css/home.css'
</style>