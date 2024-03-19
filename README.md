# Project Name

Php Starter Kit 

## Description

Un piccolo template per iniziare a scrivere codice in PHP. 
Sono incluse le funzioni di:

- login e registrazione con un database MySQL
- routing di base
- un sistema di template per creare nuove pagine
- un sistema di classi per creare nuovi oggetti

Per fare il login come amministratore usare le seguenti credenziali:
- username: test
- password: test

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Installation

Per installare il software è necessario avere un server web con PHP e MySQL. 
Per configurare il database è necessario eseguire il file `db.sql` che si trova nella cartella principale.
Per configurare il sistema è necessario rinominare il file che si trova in includes/config.example.php in config.php e inserire le proprie credenziali.


## Usage

Se si vogliono creare nuove pagine inserire nel file routes.php il percorso della pagina e il nome del file che si trova nella cartella `pages`. Il plugin utilizzato è spiegato in questa guida

Per ogni classe creata inserire il file nella cartella `includes/models` e includerlo nel file `includes/header-script.php`.

Per creare nuove funzioni che non hanno una diretta associazione con delle classi utilizzare il  `includes/functions/functions.php` 

## License

Licenza MIT

