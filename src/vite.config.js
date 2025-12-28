import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: '0.0.0.0',     // bind inside container
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'localhost', // what the browser should use
      port: 5173,
    },
  },
});
