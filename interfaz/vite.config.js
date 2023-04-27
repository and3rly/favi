import { defineConfig } from "vite";
import path from "path";
import Vue from "@vitejs/plugin-vue";
import ViteImages from "vite-plugin-vue-images";

export default defineConfig({
  server: {
    port: 8080,
    open: true,
    proxy: {
      "/api": {
        target: "http://localhost/favi/",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/api/, ""),
      },
    },
  },
  plugins: [
    Vue()
  ],
  resolve: {
    extensions: [".mjs", ".js", ".ts", ".jsx", ".tsx", ".json", ".vue", ".css"],
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
});
