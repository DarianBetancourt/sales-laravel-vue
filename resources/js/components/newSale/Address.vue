<template>
    <fieldset disabled class="mb-3">
        <form class="form-floating">
            <input v-model="completeAddress" type="text" class="form-control">
            <label for="floatingInputValue">Endereco</label>
        </form>              
    </fieldset>
</template>
<script>
export default {
    name:"Address",
    props:{
        completeAddress: String,
    }
}
</script>