springconsult
=============
######To use webpack feature install nodejs and npm
####To build assets run one of command below
 
app-webpack/node_modules/.bin/webpack index.js dist/bundle.js

app-webpack/node_modules/.bin/webpack --devtool source-map index.js dist/bundle.js

NODE_ENV=prod app-webpack/node_modules/.bin/webpack --config webpack.config.js


######To setup environment use .htaccess file and line below

SetEnv CI_ENV testing