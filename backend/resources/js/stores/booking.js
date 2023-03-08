import { defineStore } from "pinia";

export const useBookingTrain = defineStore({
  id: "book",
  state: () => ({
    schedule_id: null
  })
});
