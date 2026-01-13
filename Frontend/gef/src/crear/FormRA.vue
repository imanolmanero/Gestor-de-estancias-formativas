<template>
  <div>
    <h2>Crear Resultado de Aprendizaje</h2>
    <form @submit.prevent="$emit('guardar')">
      <label>Descripción del Resultado de Aprendizaje:</label>
      <textarea v-model="ra.descripcion" required></textarea>
      <select v-model="ra.grado" required>
        <option disabled value="">Selecciona un grado</option>
        <option v-for="grado in grados" :key="grado.id" :value="grado.id">{{ grado.nombre }}</option>
      </select>

      <label>Competencias</label>
      <div v-for="(competencia, index) in ra.competencias" :key="index">
        <input type="text" v-model="ra.competencias[index]" placeholder="Descripcion de la competencia" required />
        <button type="button" @click="$emit('eliminarCompetencia', index)">Eliminar</button>
      </div>
      <button type="button" @click="$emit('añadirCompetencia')">Añadir Competencia</button>
      <button type="submit">Guardar Resultado de Aprendizaje</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['ra', 'grados']
}
</script>
