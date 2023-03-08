import { defineStore } from "pinia";

export const useSearchStore = defineStore({
  id: "search",
  state: () => ({
    searchResult: []
  })
});
