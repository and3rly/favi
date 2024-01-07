import { defineStore } from "pinia";
import axios from 'axios';

let transformedObject: any;

export const useAppSidebarMenuStore = defineStore({
  id: "appSidebarMenu",
  state: () => {
    return {
      menuItems: {
        "0": {
          'text': 'Menu',
          'is_header': true,
          'childs': []
        }
      }
    }
  },
  actions: {
    async fetchMenu() {
      try {
        const res = await axios.get(`http://localhost:8080/api/index.php/menubar/buscar`);
        if (res.data.lista) {
          const jsonArray = JSON.parse(res.data.lista);

          transformedObject = jsonArray.map((item: { id: any; url: any; icon: any; text: any; level: any; father: any;}) => (
            {
              'id': item.id,
              'url': item.url,
              'icon': item.icon,
              'text': item.text,
              'level': item.level,
              'father': item.father,
              'countChilds': 0,
              'childs': []
            }
          ));
          
          transformedObject.sort((a, b) => a.father - b.father);
          
          transformedObject.forEach((item, index) => {
            if (item.father > 0) {
              if(this.menuItems.hasOwnProperty(item.father)){
                this.menuItems[item.father].childs.push(item);
                this.menuItems[item.father].countChilds += 1;
              }
            } else {
              this.menuItems[item.id] = item;
            }
            
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
});

useAppSidebarMenuStore().fetchMenu();