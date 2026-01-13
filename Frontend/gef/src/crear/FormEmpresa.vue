<template>
  <div>
    <h2>Crear Empresa</h2>
    <form @submit.prevent="$emit('guardar')">
      <label for="nombre_empresa">Nombre de la Empresa:</label>
      <input type="text" v-model="empresa.nombre_empresa" required />
      <label for="cif">CIF:</label>
      <input type="text" v-model="empresa.cif" required />
      <label for="poblacion">Poblacion:</label>
      <input type="text" v-model="empresa.poblacion" required />
      <label for="email">Email:</label>
      <input type="emaiºl" v-model="empresa.email" required />
      <label for="telefono">Teléfono:</label>
      <input type="tel" v-model="empresa.telefono" />
      <input type="hidden" v-model="empresa.tipo_usuario" value="empresa"/>
      <button type="submit">Crear Empresa</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['empresa']
}
</script>
