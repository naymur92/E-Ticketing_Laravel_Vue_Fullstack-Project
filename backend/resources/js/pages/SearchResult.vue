<template>
  <div>{{ searchResult }}</div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: ["searchResult"],
  created() {
    console.log(this.searchResult);
  },
};
</script>
<style>
</style>