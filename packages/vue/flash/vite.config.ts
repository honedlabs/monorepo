import { resolve } from "path"
import { defineConfig } from "vite"
import dts from 'vite-plugin-dts'

export default defineConfig({
  plugins: [dts({
      exclude: ["src/test/**"],
      rollupTypes: true,
      insertTypesEntry: true,
      include: ["src/**/*.ts", "src/**/*.d.ts", "src/**/*.tsx", "src/**/*.vue"],
      outDir: "dist",
    }),
  ],
  build: {
    lib: {
      entry: resolve(__dirname, "src/index.ts"),
      name: ':package_name',
      fileName: (format) => `index.${format === 'es' ? 'js' : 'umd.cjs'}`
    },
    rollupOptions: {
      external: ['vue', '@inertiajs/vue3', 'axios'],
      output: {
        globals: {
          vue: 'Vue',
          '@inertiajs/vue3': 'Inertia',
          axios: 'axios',
        },
      },
    },
  },
})