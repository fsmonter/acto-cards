const path = require('path')
const mix = require('laravel-mix')

mix
  .postCss('resources/css/app.css', 'public/css', [require('tailwindcss')])
  .js('resources/js/app.js', 'public/js')
  .vue()
  .alias({
    '@': path.join(__dirname, 'resources/js'),
  })
