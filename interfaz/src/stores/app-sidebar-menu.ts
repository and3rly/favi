import { defineStore } from "pinia";

export const useAppSidebarMenuStore = defineStore({
  id: "appSidebarMenu",
  state: () => {
    return [{
			text: 'Menú',
			is_header: true
		},
    {
      'url': '/inicio',
      'icon': 'fa fa-home',
      'text': 'Inicio'
    },
    {
      'url': '/usuario',
      'icon': 'fa fa-user',
      'text': 'Usuario'
    },
    {
      'url': '/sucursal',
      'icon': 'fas fa-sitemap',
      'text': 'Sucursal'
    }
	]}
});
