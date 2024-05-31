<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';

const props = defineProps({
    valor: {
        type: Number,
        required: true
    }
});

const emits = defineEmits(['update:valor']);

const formatoNumero = (value) => {
    return '$ ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const numeroFormateado = computed({
    get: () => {
        return formatoNumero(props.valor);
    },
    set: (value) => {
        emits('update:valor', parseFloat(value.replace(/\./g, '').replace('$ ', '')));
    }
});

const onInput = (event) => {
    let value = event.target.value;
    // Eliminar cualquier cosa que no sea un número o un punto
    value = value.replace(/[^\d.]/g, '');
    // Si hay más de un punto, eliminar los extras
    // value = value.replace(/(\..*)\./g, '$1');
    // Actualizar el modelo con el valor limpio
    emits('update:valor', parseFloat(value));
};
</script>

<template>

    <input type="text" class="form-control" autocomplete="off" :value="numeroFormateado" @input="onInput" />
</template>