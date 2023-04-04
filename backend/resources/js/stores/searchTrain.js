import { defineStore } from "pinia";

export const useSearchStore = defineStore('search_train', {
  state: () => ({
    search_result: []
  }),
  getters: {
    searchResult: (state) => state.search_result
  },
  actions: {
    setSearchResult(result) {
      this.search_result = result;
    }
  }
});
