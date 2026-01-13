<template>
  <title>Crear</title>
  <select v-model="tipo">
    <option value="" disabled selected>¿Que quieres Agregar?</option>
    <option value="empresa">Empresa</option>
    <option value="usuario">Usuario</option>
    <option value="RA">Resultado de Aprendizaje</option>
  </select>

  <EmpresaForm v-if="tipo==='empresa'" :empresa="empresa" @guardar="guardarEmpresa" />
  <UsuarioForm v-else-if="tipo==='usuario'" :usuario="usuario" :grados="grados" @guardar="guardarUsuario" />
  <RAForm v-else-if="tipo==='RA'" :ra="ra" :grados="grados" @guardar="guardarRA" @añadirCompetencia="añadirCompetencia" @eliminarCompetencia="eliminarCompetencia" />
</template>

<script>
import axios from 'axios';
import EmpresaForm from './FormEmpresa.vue';
import UsuarioForm from './FormUsuario.vue';
import RAForm from './FormRA.vue';

export default {
  components: { EmpresaForm, UsuarioForm, RAForm },
  data() {
    return {
      tipo: '',
      token: localStorage.getItem('token'),
      empresa: { nombre_empresa: '', cif: '', poblacion: '', email: '', telefono: '', tipo_usuario: 'empresa' },
      usuario: { nombre: '', apellidos: '', email: '', password: '', tipo_usuario: '', grado_id: '' },
      ra: { descripcion: '', grado: '', competencias: [''] },
      grados: [
        { id: 1, nombre: 'Grado 1' },
        { id: 2, nombre: 'Grado 2' },
        { id: 3, nombre: 'Grado 3' }
      ]
    };
  },
  methods: {
    añadirCompetencia() { this.ra.competencias.push(''); },
    eliminarCompetencia(index) { this.ra.competencias.splice(index, 1); },

    async guardarRA() {
      try {
        await axios.post('http://localhost:8000/api/guardarRA', this.ra, { headers: { Authorization: `Bearer ${this.token}` } });
        alert('RA guardado con éxito');
      } catch (error) { console.error(error); }
    },

    async guardarEmpresa() {
      try {
        await axios.post('http://localhost:8000/api/guardarEmpresa', this.empresa, { headers: { Authorization: `Bearer ${this.token}` } });
        alert('Empresa guardada con éxito');
      } catch (error) { console.error(error); }
    },

    async guardarUsuario() {
      try {
        const payload = { ...this.usuario };
        if (payload.tipo_usuario !== 'alumno') { delete payload.grado_id; delete payload.curso; }
        await axios.post('http://localhost:8000/api/guardarUsuario', payload, { headers: { Authorization: `Bearer ${this.token}` } });
        alert('Usuario guardado con éxito');
      } catch (error) { console.error(error); }
    }
  }
}
</script>
