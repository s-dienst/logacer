# LOGACer

## 1. Presentation

**LOGACer** is free and open source research software for the management of archaeological artifacts databases.

LOGACer was initially developed by **Simon DIENST** as part of his PhD research. It was subsequently expanded to facilitate deployment and introduce additional analytical features.

The software is designed to provide a flexible environment for presenting and analysing archaeological artifacts, especially pottery and glassware, and can be adapted to different research projects, datasets and institutional infrastructures.

## 2. Features

LOGACer provides tools for:

- describe archaeological operations, with the different site-horizons and contexts;
- display pottery and glassware inventories;
- add illustrations to the artifacts;
- setting different levels of confidentiality and collaboration;
- browse and describe types, fabrics and regional horizons;
- add bibliography and files for the archaeological operations, types and fabrics;
- comment data, either privately or publicly;
- perform seriation analysis.

The precise functionality depends on the version of LOGACer and its configuration.

## Official website

[https://www.logacer.org](https://www.logacer.org)

When redistributing LOGACer or a modified version, the copyright notices and other notices required by the GPL must be retained.

Modified versions should clearly indicate that modifications have been made and should not be presented as the original LOGACer release.

## 3. Documented uses of LOGACer

An example of LOGACer applied to a project is presented in [CeVICA - Céramique et Verre de l'Italie Centrale Antique](https://cevica.uliege.be). Details about the uses of LOGACer will be published soon.

## 4. Requirements

To deploy LOGACer, the following components are required:

- A web server capable of running PHP applications. Apache has been tested. Compatibility with other web servers may depend on their configuration.
- A relational database compatible with the SQL structure provided with LOGACer. MySQL and MariaDB have both been tested, although compatibility with specific versions has not yet been exhaustively documented.
- **PHP 8.2 or later** (tested with PHP 8.2 and 8.3).
- The following PHP extensions:
  - PDO;
  - PDO MySQL.

LOGACer has been designed to minimise external dependencies. The standard distribution does not require a package manager or an additional build system.

The application itself requires less than 100 MB of disk space. Additional storage capacity must be provided for illustrations, documents and other files uploaded by users. The required space will depend on the size and nature of the research project.

A working SMTP service is required for sending emails related to user accounts and application features. Institutions can provide their own SMTP configuration. Alternatively, users may contact the LOGACer developer to obtain access to the default SMTP service provided for LOGACer installations.

PHP memory limits, execution time and upload limits should be configured according to the size of the datasets and files handled by the application. The default PHP configuration may need to be adjusted for large imports or uploads.

## 5. Installation

### 5.1. Download LOGACer

Download the desired version of LOGACer from the institutional repository:

[https://orbi.uliege.be/handle/2268/340248](https://hdl.handle.net/2268/340248)

Extract the archive and copy the content of the `logacer_v2_0_0` repository into your web server.

### 5.2. Configure the web server

Configure your web server and domain name so that the LOGACer application can be accessed through the desired URL.

The exact configuration depends on the infrastructure used by the institution or research project.

The URL must point to the `public` repository ; repositories and files outside `public` should not be available from any URL.

### 5.3. Initial setup of LOGACer

The initial configuration of LOGACer is performed directly through a web browser, using an installation interface accessible via the URL configured for the application.

**5.3.1. Language Selection**

When accessing the application URL for the first time, a page allows users to select their preferred language from the available options. This choice is stored in a cookie and will be used to display the installation interface and subsequent pages.

**5.3.2. Accessing the Installation Interface**

After selecting a language, the user is redirected to the LOGACer installation page.

This page brings together the various settings required for the application to operate. Before proceeding, it is recommended to have the database connection details and, if necessary, the mail server settings available.

**5.3.3. Database Configuration**

LOGACer uses a MySQL or MariaDB database.

The following information must be provided:
- Database server address;
- Connection port (usually 3306);
- Database name;
- SQL account username and password.

An encrypted TLS/SSL connection can also be enabled, with the paths to the required certificates provided when required by the infrastructure.

Three database setup modes are available:

- **Database fully prepared by the IT department**: the database and all its tables have already been created according to the schema expected by LOGACer (using, in particular, the supplied `db_structure.sql` file). The application then checks that the database structure complies with the expected schema.
- **Empty database created by the IT department, ready to be populated**: the database already exists, but its tables still need to be created. LOGACer then imports the SQL schema supplied with the application.
- **Application-managed initialization**: LOGACer creates the database itself and then imports the SQL schema required for its operation. This mode requires sufficient SQL privileges to create a database.

**Warning:** The installation SQL file contains statements that drop and recreate tables. When reinstalling the application on a database that already contains data, this data may therefore be permanently lost. It is essential to create a backup beforehand and to contact the IT department or the LOGACer developer before performing any reinstallation.

**5.3.4. General Settings**

This section allows users to define:
- The application's final URL, including cases where LOGACer is hosted in a subdirectory;
- The application's operating mode (standalone installation for a single project or multi-project application);
- The local application name, particularly for multi-project installations;
- The languages that will be made available to users;
- The administrator's email address, which will be used, among other things, to receive requests related to account management.

The current version of LOGACer includes verified translations in French and English.

**5.3.5. Email Configuration**

LOGACer uses an SMTP server to send emails related to user accounts and the application's various features.

The following settings are required:
- SMTP server address;
- Connection port;
- Connection security mode (STARTTLS, implicit TLS, or no encryption);
- Username and password;
- Sender email address and display name (optional).

If necessary, this information can be obtained from the institution's IT department.

**5.3.6. Limits and Performance**

Several settings allow LOGACer to be adapted to the resources available on the server:
- Maximum image size;
- Maximum file size;
- Maximum number of objects loaded simultaneously in inventory tables;
- Number of rows processed simultaneously during data imports.

It is recommended to keep the default values unless the server specifications or the installation's requirements justify changing them.

**5.3.7. Validation and Saving**

After the form is submitted, LOGACer performs the necessary checks:
- Validation of the entered settings;
- Connection to the database server;
- Creation of the database, if required;
- Creation or verification of the SQL structure;
- Additional checks required for the application to operate correctly.

If any errors are detected, they are displayed on the installation page so that they can be corrected. Some errors may require intervention from the IT department.

Once all checks have been successfully completed, the settings are saved to the application's configuration file.

The initial installation is then complete, and the user is redirected to the next step in the LOGACer configuration process.

Once the initial installation is complete, access to the installation interface should be restricted or disabled if it is no longer required.

## 6. First steps: admin and first project registration

After the initial software configuration, the user is redirected to the registration page to create an account.

The first account created is automatically activated and granted administrator privileges. **Make sure to keep these credentials safe, as this account has full administrative rights.**

For standalone (single-project) installations, the user is also prompted to enter a project code and name. The corresponding project is then automatically created.

Projects and user accounts can subsequently be managed through dedicated pages within LOGACer.

For further information, please refer to the user manual.

## 7. Updating

LOGACer is distributed in versioned releases. Each release is available through the [official LOGACer website](https://www.logacer.org) and the institutional repository.

**Version 2.0.0 introduces the possibility of deploying LOGACer independently on institutional or project-specific servers.** It is therefore the first release intended for autonomous deployment outside the original LOGACer infrastructure.

As this is the first release supporting independent installations, no automated update procedure is currently provided.

Future releases will include the necessary instructions and tools to update existing LOGACer installations while preserving their configuration and research data.

Before applying any future update, administrators should always create a complete backup of their installation, including the database, configuration file and uploaded files.

## 8. Configuration file

The application configuration is stored in:

`logacer/config/configuration.json`

Be careful when modifying this file, as incorrect settings may prevent LOGACer from functioning correctly.

The configuration file is normally created and managed through the installation and application interfaces. At present, configuration changes can only be performed manually by editing this file, except when it is deleted.

**Warning:** If the configuration file is deleted, LOGACer will redirect the user to the installation interface, allowing the application to be configured again. Unless the fully prepared database option is selected, the installation process may recreate the database structure and permanently delete existing data.

We strongly recommend creating a complete backup of the database before deleting the configuration file or attempting any reinstallation.

Manual modifications should only be performed by users familiar with the application's configuration structure. Further technical documentation and dedicated configuration interfaces are planned for future releases.

**Never publish or share a `configuration.json` file containing actual credentials or other sensitive information.**

## 9. Security and maintenance.

LOGACer may contain research data, unpublished archaeological information, user accounts and documents with restricted access. Each installation must therefore be properly secured and maintained.

The administrator of each installation is responsible for its security and maintenance.

The following recommendations should be followed.

### 9.1. Server security

- Use HTTPS to encrypt communications between users and the server.
- Ensure that only the `public` directory is accessible through the web server. Application files, configuration files and other resources located outside this directory must not be directly accessible through a URL.
- Keep PHP, the database server and the web server up to date.
- Restrict write permissions on application files and directories to what is strictly necessary.
- Protect the application's configuration file, which contains sensitive connection information.

### 9.2. Database security

- Use a dedicated database account for LOGACer.
- Grant this account only the privileges required by the application.
- Do not reuse administrative database credentials for the application's normal operation.
- Restrict access to the database server according to the institution's security policies.

### 9.3. User accounts and access control

- Choose a strong password for the first administrator account.
- Do not share administrator credentials between users.
- Assign user privileges according to their actual responsibilities and the confidentiality requirements of each project.
- Regularly review user accounts and access rights.

The first account created during the initial registration automatically receives administrator privileges. The initial registration should therefore be performed by the intended administrator, and access to the application should be restricted until this account has been created.

### 9.4. Backups and data preservation

Regular backups are essential to prevent data loss.

Backups should include:
- The LOGACer database;
- Uploaded illustrations, documents and other files stored on the server;
- The application configuration file.

Backups should be stored securely, preferably on a separate storage system, and protected against unauthorised access.

The restoration of backups should be tested periodically to ensure that data can be recovered when necessary.

### 9.5. Maintenance

The administrator is responsible for monitoring the installation, ensuring that sufficient storage space is available and maintaining the server environment.

Before making changes to the application, its configuration or the database, it is recommended to create a complete backup.

Information about upgrading existing LOGACer installations will be provided with future software releases.

## 10. Database structure

The distribution includes the SQL structure required to create a new LOGACer database. It is compatible with a MySQL/MariaDB database.

The database structure is intended to provide a starting point for research projects. Users may extend the database and its configuration to their own research requirements, for instance if working with other software.

## 11. Research data

LOGACer is a software tool and does not, by itself, constitute the archaeological data managed through it.

The LOGACer distribution does not contain the data from the original project.

Users are responsible for ensuring that the data entered into their own LOGACer installation comply with applicable legal, ethical, institutional and research-data requirements.

## 12. Versions and roadmap

LOGACer is distributed in versioned releases.

The version number identifies the specific version of the software corresponding to a particular release.

When publishing research based on LOGACer, please indicate the version used whenever possible.

### Version 1.0

Version 1.0 is the first completely functional version of LOGACer. In a nutshell, it allowed to:

- Navigate in the database in French;
- Create, modify, consult or delete manually :
    - archaeological operations, phases, contexts, objects and pictures;
    - horizon groups and regional horizons;
    - categories, functions, typologies, types and fabrics;
    - countries and regions;
    - bibliography references and files;
- Import XLSX data about archaeological operations, phases, contexts and objects;
- Download files and csv-inventories;
- Link regional horizons with phases, typologies with categories, and collaborators, references and files with various items;
- Login, logout, register and activate accounts;
- Create projects for a global management of archaeological operations, regional horizons, typologies and fabrics;
- Read some tutorials (incomplete at this time) and other information about the database and global framework.

### Current version: 2.0

Version 2.0 brings substantial improvements in the LOGACer website, centered on collaboration and chronological analysis.

#### A. LOGACer deployment and projects

With this version 2.0, projects are functioning as independent subsites within the LOGACer installation, with their own settings (using or not the chronological horizons, historical artifact data, comments, languages...). The projects can be deployed:

- In the [LOGACer server](https://www.logacer.org/);
- As independent project in another (for instance, institutional) server;
- As a group of project on another deployment of the LOGACer infrastructure.

Some work was done to facilitate the deployment of LOGACer, including the documentation, installation and project pages, as well as pictures.

The projects can be public or private. The LOGACer administrator can easily change privileges of the different users into LOGACer.

#### B. Multilingual support

LOGACer was translated in English, and a first draft for translation in Italian, German and Spanish was also done. The multilinguism is still not complete, but it is a work in progress and a future update should increase the translations. Users noticing translation errors are invited to contact Simon Dienst to help the translation process.

The multilinguism applies only for the frame. It does not apply for the data.

#### C. Chronological analysis and seriations

Work was done to provide an advanced horizon module, allowing :

- To compare assemblages (phases, contexts or horizons) with each others;
- To seriate the assemblages;
- To indicate the level of proximity between a type and a regional horizon (major, minor, residual... type).

To help the analysis and seriations, configurations allows the users to join or separate types for the analysis, and save their preferences.

#### D. Collaboration

The main collaboration tool, besides the project improvements, is the possibility to add or respond to comments for the main items in the database, if allowed by the project. The comments can be personal (a reminder for the user itself), private (destined to the creator and collaborators of the item) or, if allowed by the project, public.

### Planned

A lot of improvements are already planned for LOGACer. In a near future (before end 2026):

- Correcting bugs appearing on the current version;
- Improving the translations (including the data downloads and uploads);
- Improving tutorials and documentation about LOGACer;
- A better management of files and pictures;
- Make the search actually usable;
- Better management of the SMTP;
- Allowing deleting the projects and download all personal data;
- A first functional graphical module.

For the next major versions (1st semester 2027), it is planned to work on:

- API's to share data;
- The archaeometry module: add chemical and petrographical analysis, with statistical tools for the first one;
- Tools to better modify and upgrade the software.

## 13. License

LOGACer is distributed under the GNU General Public License, version 3 or any later version (GPL-3.0-or-later).

This means that you are free to:

- use LOGACer for any purpose;
- study its source code;
- modify it;
- adapt it to your own research project or infrastructure;
- redistribute LOGACer;
- redistribute modified versions of LOGACer.

When redistributing LOGACer or a modified version, the conditions of the GNU GPL must be respected.

The full license is provided in the LICENSE file.

For the authoritative text of the license, see:

[https://www.gnu.org/licenses/gpl-3.0.html](https://www.gnu.org/licenses/gpl-3.0.html)

## 14. Citation

If you use LOGACer in scientific research, please cite the software and its author.

This version of LOGACer can be cited as:

**Simon DIENST, LOGACer Version 2.0.0 (2026). [https://www.logacer.org](https://www.logacer.org)**

The preferred citation is provided in ``CITATION.cff``.

## 15. Author

**Simon DIENST**
Scientific Collaborator
Sercice d'Histoire de l'Art et d'Archéologie de l'Antiquité Gréco-Romaine
Université de Liège (Belgique)
[simon.dienst@uliege.be](simon.dienst@uliege.be)
Official website: [LOGACer](https://www.logacer.org)
Scientific publications and works accessible via [ORBi](https://orbi.uliege.be/profile?uid=p026985)

## 16. Disclaimer

LOGACer is provided free of charge and without warranty.
Users are responsible for the installation, configuration, security, backup, maintenance and operation of their own LOGACer installations.
