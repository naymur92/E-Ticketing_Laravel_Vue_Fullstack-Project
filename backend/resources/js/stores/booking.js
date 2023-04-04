import { defineStore } from "pinia";

export const useBookingTrain = defineStore('book_train', {
  state: () => ({
    schedule_id: null
  })
});
