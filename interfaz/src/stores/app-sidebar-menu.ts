import { defineStore } from "pinia";
import axiosClient from "@/plugins/axios.js" 

export const useAppSidebarMenuStore = defineStore({
  id: "appSidebarMenu",
  state:() => ({
    modulos: null,
    urlBase: ''
  }),
  actions: {
    async get_menu() {
      await axiosClient.get(`${this.urlBase}/mnt/menu/get_modulos`)
      .then (res => {
        this.modulos = res.data.lista
      });
    }
  }
});

useAppSidebarMenuStore().get_menu();
