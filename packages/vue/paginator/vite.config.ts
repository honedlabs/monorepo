import { resolve } from "path"
import { defineConfig } from "vite"
import dts from 'vite-plugin-dts'

export default defineConfig({
  plugins: [dts({
      exclude: ["src/test/**"],
      rollupTypes: true,
      insertTypesEntry: true,
      include: ["src/**/*.ts", "src/**/*.d.ts"],
      outDir: "dist",
    }),
  ],
  build: {
    lib: {
      entry: resolve(__dirname, "src/index.ts"),
      name: ':package_name',
      fileName: (format) => `index.${format === 'es' ? 'js' : 'umd.cjs'}`
    },
  },
})