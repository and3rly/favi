import { defineStore } from "pinia";
import axiosClient from "@/plugins/axios.js" 

export const useAppSidebarMenuStore = defineStore({
  id: "appSidebarMenu",
  state:() => ({
    modulos: null
  }),
  actions: {
    async get_menu() {
      await axiosClient.get("/api/index.php/mnt/menu/buscar")
      .then (res => {
        this.modulos = res.data.lista
      });
    }
  }
});

useAppSidebarMenuStore().get_menu();
