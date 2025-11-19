import * as esbuild from 'esbuild';

await esbuild.build({
  entryPoints: ['resources/js/app.js'],
  bundle: true,
  minify: true,
  sourcemap: true,
  outfile: 'public/js/app.js',
  format: 'iife',
  globalName: 'App',
});

console.log('JavaScript built successfully!');
