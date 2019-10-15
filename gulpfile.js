/* eslint-disable no-console */
/* jshint node: true */
'use strict';

/**
 * Chargement et initialisation de Gulp
 */
const { watch, series, src, dest } = require('gulp');

/**
 * Chargement et initialisation des composants utilisés
 */
var $ = require('gulp-load-plugins')(),
  gutil = require('gulp-util'),
  ftp = require('vinyl-ftp'),
  changed = require('gulp-changed'),
  csscomb = require('gulp-csscomb'),
  cssbeautify = require('gulp-cssbeautify'),
  argv = require('yargs').argv,
  notify = require("gulp-notify"),
  del = require('del');

/**
 * Configuration générale du projet et des composants utilisés
 */
var project = {
  name: 'saytup-starter', // nom du projet, utilisé notamment pour le fichier ZIP
  url: 'http://saytup-starter.agear-digital.fr/', // url du projet, utilisée par browserSync en mode proxy
  zip: {
    namespace: 'ageardigital', // préfixe du fichier ZIP
  },
  plugins: { // activation ou désactivation de certains plugins à la carte
    browserSync: {
      status: false, // utilisation du plugin browserSync lors du Watch ?
      proxyMode: true, // utilisation du plugin browserSync en mode proxy (si false en mode standalone)
    },
    babel: false // utilisation de Babel pour transpiler JavaScript
  },
  configuration: { // configuration des différents composants de ce projet
    // Browserslist : chaîne des navigateurs supportés, paramètrage pour Autoprefixer (annoncé : IE11+, last Chr/Fx/Edge/Opera et iOS 9+, Android 5+ ; ici c'est plus large)
    //  ⇒ Couverture (mondiale, pas française) de 94,73% (mai 2017) d'après
    //  ⇒ http://browserl.ist/?q=%3E+1%25%2C+last+2+versions%2C+IE+%3E%3D+10%2C+Edge+%3E%3D+12%2C++Chrome+%3E%3D+42%2C++Firefox+%3E%3D+42%2C+Firefox+ESR%2C++Safari+%3E%3D+8%2C++ios_saf+%3E%3D+8%2C++Android+%3E%3D+4.4
    //  ⇒ http://browserl.ist et > 1%, last 2 versions, IE >= 10, Edge >= 12,  Chrome >= 42,  Firefox >= 42, Firefox ESR,  Safari >= 8,  ios_saf >= 8,  Android >= 4.4
    browsersList: [
      "> 1%",
      "last 2 versions",
      "IE >= 11", "Edge >= 16",
      "Chrome >= 60",
      "Firefox >= 50", "Firefox ESR",
      "Safari >= 10",
      "ios_saf >= 10",
      "Android >= 5"
    ],
    cssbeautify: {
      indent: '  ',
    },
    htmlExtend: {
      annotations: false,
      verbose: false,
    },
    sass: {
      outputStyle: 'expanded' // CSS non minifiée plus lisible ('}' à la ligne)
    },
    imagemin: {
      svgoPlugins: [
        {
          removeViewBox: false,
        }, {
          cleanupIDs: false,
        },
      ],
    },
  },
};

/**
 * Configuration FTP du projet
 */
var user = '',
    password = '',
    host = '',
    port = 21,
    localFilesGlob = ['./html/**/*'],
    remoteFolder = '/';

// helper function to build an FTP connection based on our configuration
function getFtpConnection() {
  return ftp.create({
    host: host,
    port: port,
    user: user,
    password: password,
    parallel: 5,
    log: gutil.log,
  })
}

/**
 * Chemins vers les ressources ciblées
 */
var paths = {
  root: './', // dossier actuel
  src: './src/', // dossier de travail
  dest: './html/', // dossier destiné à la livraison
  test: './test/', // dossier de test pour la copy de fichier
  doc: './doc/', // dossier destiné à la documentation
  vendors: './node_modules/', // dossier des dépendances du projet
  assets: 'images/',
  styles: {
    root: 'modeles/fr/Modele1/css/', // fichier contenant les fichiers CSS & Sass
    css: {
      mainFile: 'modeles/fr/Modele1/css/styles.css', // fichier CSS principal
      files: 'modeles/fr/Modele1/css/*.css', // cible tous les fichiers CSS
    },
    sass: {
      mainFile: 'modeles/fr/Modele1/css/styles.scss', // fichier Sass principal
      styleguideFile: 'modeles/fr/Modele1/css/styleguide.scss', // fichier Sass spécifique au Styleguide
      files: 'modeles/fr/Modele1/css/{,*/}*.scss', // fichiers Sass à surveiller (css/ et tous ses sous-répertoires)
    },
  },
  scripts: {
    root: 'modeles/fr/Modele1/scripts/', // dossier contenant les fichiers JavaScript
    files: 'modeles/fr/Modele1/scripts/*.js', // fichiers JavaScript (hors vendor)
    mainFile: 'main.min.js', // nom du fichier JS après concaténation
    styleguideFiles: 'assets/js/styleguide-scroll.js', // fichier(s) JS spécifiques au styleguide
    destStyleguideFiles: 'styleguide.min.js', // nom du fichier JS que chargera spécifiquement le styleguide (contiendra son ou ses scritps concaténés et minifiés)
  },
  html: {
    racine: '*.html', // fichiers & dossiers HTML à compiler / copier à la racine uniquement
    root: 'modeles/', // dossier distant contenant les fichiers html
    allFiles: 'modeles/**/*.html', // fichiers & dossiers HTML à compiler / copier à la racine et dans le dossier html/
    siteClosed: {
      root: 'site_ferme/', // dossier distant contenant les fichiers html utilisés lorsque le site est fermé
      allFiles: 'site_ferme/**/*.html', // fichiers & dossiers HTML à compiler / copier à la racine et dans le dossier html/
    }
  },
  styleguide: {
    config: 'assets/styleguide/config.md', // fichier config du styleguide
    files: 'assets/styleguide/patterns/*.md', // fichiers .MD du styleguide
    title: 'Styleguide HTML CSS', // value for the title element in the head of the Styleguide
  },
  php: {
    root: 'specifs/', // dossier distant contenant les spécifs
    allFiles: 'specifs/**/*', // fichiers & dossiers PHP à copier
  },
  fonts: 'modeles/fr/Modele1/css/fonts/', // fichiers typographiques à copier,
  images: 'images/{,css/}img/{,*/}*.{png,jpg,jpeg,gif,svg}', // fichiers images à compresser
  misc: '*.{ico,htaccess,txt}', // fichiers divers à copier
  maps: '/maps', // fichiers provenant de sourcemaps
};

/**
 * Tâche de gestion des erreurs à la volée
 */
var onError = {
  errorHandler: function (err) {
    console.log(err);
    this.emit('end');
  }
};

/*
 * Tâche HTML : copie des fichiers modifiés
 */
function html() {
  return src(paths.src + paths.html.allFiles)
    .pipe(changed(paths.dest + paths.html.root))
    .pipe($.plumber(onError))
    .pipe(dest(paths.dest + paths.html.root));
}

/*
 * Tâche HTML pour le site fermé : copie des fichiers modifiés
 */
function htmlSiteClosed() {
  return src(paths.src + paths.html.siteClosed.allFiles)
    .pipe(changed(paths.dest + paths.html.siteClosed.root))
    .pipe($.plumber(onError))
    .pipe(dest(paths.dest + paths.html.siteClosed.root));
}

/*
 * Tâche PHP : copie des fichiers modifiés
 */
function php() {
  return src(paths.src + paths.php.allFiles)
    .pipe(changed(paths.dest + paths.php.root))
    .pipe($.plumber(onError))
    .pipe(dest(paths.dest + paths.php.root));
}

/*
 * Tâches JS : copie des fichiers JS et vendor + concat et uglify
 */
function js() {
  return src(paths.src + paths.scripts.files)
    .pipe($.plumber(onError))
    .pipe($.if(project.plugins.babel,$.babel({presets:['env']})))
    .pipe($.concat(paths.scripts.mainFile))
    .pipe($.uglify())
    .pipe(dest(paths.dest + paths.scripts.root));
}

/*
 * Tâche CSS : Sass + Autoprefixer + csscomb + cssbeautify
 */
function css() {
  return src(paths.src + paths.styles.sass.mainFile)
    .pipe($.plumber(onError))
    .pipe($.sass(project.configuration.sass))
    .pipe($.autoprefixer())
    .pipe(csscomb())
    .pipe(cssbeautify({indent: '  '}))
    .pipe(dest(paths.dest + paths.styles.root));
}

/*
 * Tâche d'upload FTP des fichiers modifiés
 */
function ftpUpload() {
  notify('Création de la connexion');
  var conn = ftp.create({
    host: host,
    port: port,
    user: user,
    password: password,
    parallel: 5,
    log: gutil.log,
  });

  return src(localFilesGlob, { base: '.', buffer: false })
    .pipe(conn.newer(remoteFolder)) // only upload newer files
    .pipe(conn.dest(remoteFolder));
}

/*
 * Tâche BUILD : génération HTML, PHP, JS, SASS + UPLOAD FTP
 */
function build() {
  series('html', 'htmlSiteClosed', 'php', 'js', 'css', 'ftpUpload');
}

/*
 * Tâche MONITOR : surveillance HTML, PHP, JS, SASS + UPLOAD FTP
 */
function monitor() {
  watch([paths.html.allFiles, paths.html.siteClosed.allFiles, paths.php.allFiles, paths.scripts.files, paths.styles.sass.files], {cwd: paths.src}, series('html', 'htmlSiteClosed', 'php', 'js', 'css'/*, 'ftpUpload'*/));
}

/*
 Définition des tâches
 */
exports.default = monitor;
exports.monitor = monitor;
exports.build = build;
exports.html = html;
exports.htmlSiteClosed = htmlSiteClosed;
exports.php = php;
exports.js = js;
exports.css = css;
exports.ftpUpload = ftpUpload;