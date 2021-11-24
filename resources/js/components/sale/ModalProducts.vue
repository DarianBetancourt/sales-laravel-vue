<template>
    <div name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  <h3>Produtos <i class="fas fa-cart-arrow-down"></i></h3>
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                    <table class="table table-hover table-primary">
                        <thead>
                            <tr class="text-uppercase">
                            <th scope="col" >#</th>
                            <th scope="col">name</th>
                            <th scope="col">preco</th>
                            <th scope="col">qtde</th>
                            <th scope="col">subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-for="product in products" :key="product.id" >
                                <th scope="row">{{product.id}}</th>
                                <td>{{product.name}} </td>
                                <td>{{product.pivot.price}} R$</td>
                                <td>{{product.pivot.amount}} </td>
                                <td>{{product.pivot.total}} R$</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="w-100 d-flex justify-content-between total">
                        <div>Total</div>
                        <div class="text-end "><i class="fas fa-money-bill-wave" alt="total"></i> R$ {{total}}</div>
                        
                    </div>
                    
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  <a class="btn btn-danger text-end" @click="$emit('close')"><i class="far fa-eye-slash"></i></a>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

<script>

export default {
    name:"ModalProducts",
    data() {
        return {
            total:0
        }
    },
    props:{
        products:{
            type: Array,
            default: () => []
        }
    },
    methods:{
        totalPrice(){
            this.products.forEach(product => {
               this.total+=product.pivot.total
            });
        }
    },mounted() {
        this.totalPrice();
    },
}
</script>
<style scoped>
    .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
    }

    .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
    }

    .modal-container {
    width: 300px;
    margin: 10px auto;
    padding: 10px 10px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
    margin-top: 0;
    color: #0d6efd;
    text-shadow: 2px 1px 3px rgba(150, 150, 150, 1);
    font-weight: bold;
    }

    .modal-body {
    margin: 10px 0;
    }

    .modal-enter {
    opacity: 0;
    }

    .modal-leave-active {
    opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    }
    
    thead tr > td,th{
        font-size: large;
    }

    .tbody tr > td,th{
        font-size: x-small;
    }
    .total{
        color:#0d6efd;
    }

    

</style>
