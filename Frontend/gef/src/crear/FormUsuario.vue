<template>
  <div>
    <h2>Crear Usuario</h2>
    <form @submit.prevent="$emit('guardar')">
      <label>Nombre:</label>
      <input type="text" v-model="usuario.nombre" required />
      <label>Apellidos:</label>
      <input type="text" v-model="usuario.apellidos" required />
      <label>Email:</label>
      <input type="email" v-model="usuario.email" required />
      <label>Contraseña:</label>
      <input type="password" v-model="usuario.password" required />
      <input type="hidden" v-model="usuario.tipo_usuario" value="tutor_empresa"/>
      <label>Tipo de Usuario:</label>
      <select v-model="usuario.tipo_usuario" required>
        <option value="tutor_empresa">Tutor de Empresa</option>
        <option value="tutor_centro">Tutor de Centro</option>
        <option value="admin">Administrador</option>
        <option value="alumno">Alumno</option>
      </select>

      <div v-if="usuario.tipo_usuario === 'alumno'">
        <label>Grado:</label>
        <select v-model="usuario.grado" required>
          <option disabled value="">Selecciona un grado</option>
          <option v-for="grado in grados" :key="grado.id" :value="grado.id">
            {{ grado.nombre }}
          </option>
        </select>
      </div>

      <button type="submit">
        Crear {{ usuario.tipo_usuario === 'tutor_empresa' ? 'Tutor de Empresa' : usuario.tipo_usuario === 'tutor_centro' ? 'Tutor de Centro' : usuario.tipo_usuario === 'admin' ? 'Administrador' : 'Alumno' }}
      </button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['usuario', 'grados']
}
</script>
