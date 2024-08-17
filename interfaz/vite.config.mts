import { fileURLToPath, URL } from "url";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import vueJsx from "@vitejs/plugin-vue-jsx";

// https://vitejs.dev/config/
export default defineConfig({
  server: {
    port: 8080,
    open: true,
    host: true,
    proxy: {
      "/app": {
        target: "http://localhost/favi/",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/app/, ""),
      }
    }  
  },
  plugins: [vue(), vueJsx()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  optimizeDeps: {
    exclude: ['vue-demi']
  },
  /*build: {
    outDir: "../",
    assetsDir: "assets",
    chunkSizeWarningLimit: 4096
  }*/
});
