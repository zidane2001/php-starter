<template>
  <div>
    <h2>Parcelles disponibles</h2>
    <div v-if="parcelles.length === 0">
      Aucune parcelle disponible pour le moment.
    </div>
    <ul v-else>
      <li v-for="parcelle in parcelles" :key="parcelle.id">
        {{ parcelle.section }} - {{ parcelle.lot }} - {{ parcelle.parcelle }} - {{ parcelle.prix }} FCFA
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      parcelles: []
    }
  },
  mounted() {
    this.fetchParcelles();
  },
  methods: {
    async fetchParcelles() {
      try {
        const response = await fetch('https://ton-domaine.com/api/parcelles.php?action=get_parcelles_by_type');
        const data = await response.json();
        console.log('Réponse des parcelles:', data);

        // Vérifie que data.parcelles existe et est un tableau
        if (data.success && Array.isArray(data.parcelles)) {
          this.parcelles = data.parcelles.map(p => ({
            ...p,
            statut: 'disponible'
          }));
        } else {
          this.parcelles = [];
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des parcelles:', error);
        this.parcelles = [];
      }
    }
  }
}
</script>

<style scoped>
ul {
  list-style: none;
  padding: 0;
}
li {
  margin-bottom: 0.5rem;
}
</style>
