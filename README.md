# Saytup Starter

**Saytup Starter** *(Saytup Starter)* est une base de départ pour des projets Saytup créés par l'agence Agear Digital.

**Saytup Starter** est configuré pour fonctionner dans un environnement axé sur les outils Gulp, Sass et [KNACSS](http://knacss.com) (v7). Des connaissances minimales de ces outils sont un pré-requis.

## Fonctionnalités

- CSS / Sass :
  - compilation Scss vers CSS
  - ajout automatiques de préfixes CSS3 ([Autoprefixer](https://github.com/postcss/autoprefixer) configuré via [Browserslist](https://github.com/ai/browserslist))
  - réordonnement des propriétés (csscomb)
  - réindentation du code (beautify)
- HTML :
  - Templates de base pour saytup
- images :
  - optimisation des images .png, .jpg, .gif, .svg (imagemin)
- scripts :
  - rassemblements des JS projet et des JS "vendor" dans le même dossier
  - transpilation avec [Babel](https://babeljs.io/) pour profiter des syntaxes EcmaScript récentes
  - concaténation des fichiers (concat)
  - minification (uglify)
- workflow intelligent : les tâches ne sont exécutées que pour les fichiers modifiés ou ajoutés (HTML, PHP, images, fontes)
- intégration de KNACSS, la feuille de style de départ de tout bon projet
- fichier `.editorconfig` permettant d'assurer une cohérence dans les conventions d'indentations
- fichier `.sass-lint.yml` de configuration pour outils de Linter `.scss`

## Par où commencer

### Choisissez un distributeur pour Saytup Starter

Récupérez ce repo, :

- avec le plugin npm [saytup-starter-launch](https://github.com/agear-digital/saytup-starter-launch) ❤

### Configurez le projet

À la racine de votre dossier de projet :

- lancez `npm install` ou `yarn` pour installer automatiquement les plugins et dépendances nécessaires qui sont listées dans `package.json`,
- installez gulp et gulp-cli en global avec `npm i -g gulp gulp-cli`,
- modifiez le nom du dossier src/modeles/fr/Modele1 avec le nom du modèle indiqué dans la configuration webo-facto du projet
- modifiez le fichier gulpfile.js pour remplacer Modele1 par le nom du modèle indiqué dans la configuration webo-facto du projet
- modifier le fichier gulpfile.js pour renseigner la configuration FTP du projet
- supprimez sur l'espace FTP du projet, le dossier portant le nom du modèle indiqué dans la configuration webo-facto du projet 
- lancez une première fois la tâche `gulp build` pour générer le dossier de destination `/html`.

### Démarrez votre projet

Compilez vos fichiers avec `gulp build` pour les tâches de base, ou surveillez les fichiers dans votre projet avec `gulp monitor` pour relancer les tâches de base lorsqu'ils sont modifiés. Voir ci-après pour les tâches détaillées.

## Tâches Gulp

### Tâches principales

- **`gulp`** ou `gulp monitor` : surveille styles, html, php et scripts et upload via FTP uniquement les fichiers modifiés.
- `gulp build` : tous les fichiers de `/src` sont compilés dans `/html` et sont en plus concaténés, minifiés, optimisés et uploadés via FTP.

## .editorconfig

Les  règles d'indentation (espace / tabulation) sont configurées via le fichier `.editorconfig` à la racine du projet.

Pour qu'elles s'appliquent, il suffit généralement de télécharger le plugin "editorconfig" dans votre éditeur.

## CSS / SCSS Lint

Les fichiers Sass (`.scss`) de Saytup Starter sont rendus corrigés à l'aide d'un "linter" (outil de correction  et bonnes pratiques) dont les règles sont configurées via le fichier `.sass-lint.yml` à la racine du projet.

L'action de correction se fera à l'aide de plugins au sein de votre éditeur HTML, ou bien d'une tâche Gulp. Par exemple, sur l'éditeur Atom, les plugins nécessaires sont [Atom Linter](https://atom.io/packages/linter) et  [Atom Sass Lint](https://atom.io/packages/linter-sass-lint).

Note : les  _warning_ subsistants dans le *linter*, sont connus et éventuellement à corriger selon les projets au cas par cas.

## Usage avec KNACSS

- Modifiez le fichier `_variables.scss` dans votre dossier `src/modeles/fr/Modele1/css/_config` (c'est une copie modifiée de `./node_modules/knacss/sass/_config/_variables.scss`. Ce dernier n'est pas utlisé car il est écrasé à chaque mise à jour de KNACSS)
- Choisissez les fichiers KNACSS à importer au sein du fichier `src/modeles/fr/Modele1/css/knacss.scss`
- Votre fichier de travail est `src/modeles/fr/Modele1/css/styles.scss` et commencera par l'import des 2 fichiers de configuration de KNACSS `_config/_variables` et `_config/_mixins` puis par `@import "knacss";` (ce dernier ne réimporte pas les 2 premiers _partials ; ils y sont commentés), puis suivront vos styles personnalisés.

## Changelog

Voir le [Changelog](CHANGELOG.md)

## Crédits

Projet lancé par [Matthieu Bousendorfer](https://github.com/edenpulse), cloné et adapté par Agear Digital.

GitIgnore Mac OSX Crap : `https://github.com/github/gitignore/blob/master/Global/OSX.gitignore`
