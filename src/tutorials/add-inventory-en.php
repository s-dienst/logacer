
  <!-- Barre latérale -->
  <nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Back: Tutorials List</a></h6><br>
    <h4 class="px-3">Inventory Import</h4>
    <a href="#introduction">Introduction</a>
    <h5 class="px-3">I. From the Personal Space</h5>
    <a href="#bugs-connus">Known Bugs</a>
    <a href="#telecharger-completer-templates">Download and Complete the Templates</a>
    <ul>
      <li><a href="#telecharger-template">Download the Templates</a></li>
      <li><a href="#contenu-templates">Template Contents</a></li>
      <li><a href="#ouvrir-templates">Open the Templates</a></li>
      <li><a href="#completer-enregistrer">Complete and Save</a></li>
    </ul>
    <a href="#integrer">Import the Templates</a>
    <ul>
      <li><a href="#ajouter-template">Add the Templates</a></li>
      <li><a href="#ecran-ajout">Import Screen</a></li>
      <li><a href="#corrections">Corrections</a></li>
      <li><a href="#validation">Validation or Cancellation</a></li>
    </ul>
    <a href="#longues-integrations">Managing Long Imports</a>
    <ul>
      <li><a href="#pause-integration">Temporarily Stop the Import</a></li>
      <li><a href="#reprendre-upload">Resume the Upload</a></li>
    </ul>
    <h5 class="px-3">II. Within the Pages</h5>
    <h5 class="px-3">III. Manual Import</h5>
  </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: adding archaeological operations, site-horizons, contexts and inventory data</h1>
    <section id="introduction" class="mb-5">
      <p>The addition (and modification) of sites, phases, contexts and inventory data can be done in <?php echo WEBSITE_NAME; ?> in several ways:</p>
      
      <ul>
        <li>By globally adding data via the personal space;</li>
        <li>By adding data specific to a project, an archaeological operation or a context through the dedicated pages;</li>
        <li>By manually adding, modifying and deleting data through the pages displaying the relevant data.</li>
      </ul>

      <p>These different ways of proceeding are explained below.</p>
    </section>

    <h2>I. Importing data from the personal space</h2>

      <section id="bugs-connus" class="mb-5">
        <h4>Known Bugs</h4>
        
        <p>A number of bugs have already been identified and are currently being resolved. Implementing these features nevertheless takes a great deal of time, as does resolving certain bugs. Please let the administrator know if you encounter any other bugs.</p>
        <p>In general, a colour indication of an error may remain even after it has been corrected. It is recommended to click a second time in the cell and then press "Enter" to check whether the value is correct or not.</p>
        <p>Regarding the addition of sites:</p>
        <ul>
          <li>When a region is specified in the imported file but does not exist, it is simply removed from the table.</li>
        </ul>
        <p>Regarding the addition of phases and contexts:</p>
        <ul>
          <li>Even if an error is indicated, when the first indication of a new phase is incorrect but a subsequent indication is correct, the phase is added from that point onwards and the contexts are added to that phase. An erroneous phase does not prevent the context from being imported.</li>
          <li>When the regional horizon code is incorrect, it is simply removed without indicating an error.</li>
        </ul>
        <p>Regarding the addition of inventory:</p>
        <ul>
          <li>The short version still needs to be tested in greater detail, especially given the numerous changes that have been made. It is likely that it does not work correctly.</li>
          <li>The long version has not yet been implemented, as it requires changes to the current way <?php echo WEBSITE_NAME; ?> operates.</li>
        </ul>
      </section>


    <section id="telecharger-completer-templates" class="mb-5">
      <h3>1. Downloading and completing the templates</h3>
      <section id="telecharger-template" class="mb-5">
        <h4>1.1. Downloading the templates</h4>
        
        <p>The different templates can be downloaded from the personal space, under the "templates" tab. At present, templates are available for adding:</p>
        <ul>
          <li>archaeological operations;</li>
          <li>contexts (as well as their potential site-horizons);</li>
          <li>inventory data.</li>
        </ul>

        <p>You must select the template you are interested in from the list provided, then click "download".</p>
      </section>

      <section id="contenu-templates" class="mb-5">
        <h4>1.2. Template contents</h4>

        <p>Each of these templates is available in a short version and a long version.</p>

        <h5>Sites – short version</h5>
        <ul>
          <li><b>Project ID (optional):</b> Identifier of the project to which your operation should be linked, if you want to link it to a project. The identifier is the numerical indicator visible in the URL when opening your project: ".../project/1", with "1" as the identifier.</li>
          <li><b>Operation manager (optional):</b> The identifier in <?php echo WEBSITE_NAME; ?> (not to be confused with the first and last name) of the person responsible for the operation. If this is you, you can leave it blank. If it is someone else, they must be registered in <?php echo WEBSITE_NAME; ?>; in this case, you will automatically be added as a contributor.</li>
          <li><b>Archaeological operation code (required):</b> Code used to identify the operation easily. The code must be unique for the operation manager and is mandatory. It is limited to 32 characters.</li>
          <li><b>Archaeological operation name (required):</b> Full name of the archaeological operation. The name is limited to 255 characters. No other archaeological operation with the same name may exist in <?php echo WEBSITE_NAME; ?>.</li>
        </ul>

        <h5>Sites – long version</h5>
        <p>Additional fields (all optional):</p>
        <ul>
          <li><b>Lat. coord.:</b> Site coordinates in latitude (in decimal form using a dot, between -90 and 90, with positive numbers representing north latitude and negative numbers representing south latitude).</li>
          <li><b>Long. coord.:</b> Site coordinates in longitude (in decimal form using a dot, between -180 and 180, with positive numbers representing east longitude and negative numbers representing west longitude).</li>
          <li><b>Region code:</b> Regional code. The codes already integrated <a href="<?php echo create_url(['geography']); ?>" target='_blank'>are available here</a>. If you want to add another region, you need to contact the administrator of <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Public (yes/no):</b> Indicates whether or not you want the archaeological operation to be viewable by everyone, or only by the managers and contributors of the project and/or operation. By default, the archaeological operation is not public. You can also make it public while manually hiding certain site-horizons and contexts (except when adding them via the table).</li>
          <li><b>Unpublished (yes/no):</b> Indicates whether or not the data imported into <?php echo WEBSITE_NAME; ?> are unpublished. If not, you must add the bibliography manually after importing via the CSV file. By default, the archaeological operation is not considered unpublished. You can also indicate that it has already been published while manually marking certain site-horizons and contexts as unpublished (except when adding them via the table).</li>
          <li><b>Literature review (yes/no):</b> If this archaeological operation was not published by you but you retrieved it (with or without modifications), you should indicate that it consists of data extracted from (and presumably revised from) a publication. You can configure this parameter more precisely for site-horizons and contexts (except when adding them via the table).</li>
          <li><b>Description:</b> You can add a description of the site (free text).</li>
        </ul>

        <h5>Contexts – short version</h5>
        <p>You must provide either the operation manager and archaeological operation code (unique combination), or the (unique) name of the archaeological operation.</p>
        <ul>
          <li><b>Operation manager:</b> The identifier in <?php echo WEBSITE_NAME; ?> (not to be confused with the first and last name) of the person responsible for the archaeological operation to which you want to add the context.</li>
          <li><b>Archaeological operation (code):</b> The code of the archaeological operation to which you want to add the context.</li>
          <li><b>Archaeological operation (name) (required):</b> The name of the archaeological operation to which you want to add the context.</li>
          <li><b>Site-horizon code (optional):</b> If you want to add the context to a site-horizon, enter its code here, allowing it to be easily identified. This may be a new site-horizon (a code indicated as not yet existing for this archaeological operation), an existing site-horizon, or a site-horizon added for a context imported earlier in the CSV file. The code is limited to 32 characters.</li>
          <li><b>Site-horizon name (optional unless new):</b> If this is a site-horizon introduced for this context, you must enter its name. Otherwise, this field will be ignored. The name is limited to 255 characters.</li>
          <li><b>Context code (required):</b> Code used to easily identify the context. The code must be unique for the archaeological operation (e.g. SU). It is limited to 32 characters.</li>
          <li><b>Context name (required):</b> Full name of the context (may be equivalent to the code). The name is limited to 255 characters.</li>
        </ul>

        <h5>Contexts – long version</h5>
        <p>Additional fields (all optional):</p>
        <ul>
          <li><b>Regional horizon group code (required if the following field is completed):</b> If a new site-horizon is introduced, it can be linked to a regional horizon. Before entering the code of the latter, it is necessary to enter the code of the horizon group to which it belongs (e.g. ROME for the horizons of the Roman region). The regional horizon must already exist. This field and the following two are not taken into account if the site-horizon already exists or was introduced earlier.</li>
          <li><b>Regional horizon code:</b> If the new site-horizon is linked to a regional horizon, its code must be entered in this column. The regional horizon must already exist.</li>
          <li><b>Link type (major = 1, minor = 2, uncertain = 3):</b> Indicates the importance of the site-horizon in defining its regional horizon. It must be an integer between 1 and 3. It can be left blank if the importance is unknown.</li>
          <li><b>Site-horizon description:</b> You can add a description of the new site-horizon (free text).</li>
          <li><b>Context description:</b> You can add a description of the context (free text).</li>
        </ul>

        <h5>Inventory – short version</h5>
        <p>This is currently the only fully functional way of adding data. It is mandatory to provide either the archaeological operation manager and the archaeological operation code (unique combination), or the (unique) name of the archaeological operation.</p>
        <ul>
          <li><b> Operation manager:</b> The identifier in <?php echo WEBSITE_NAME; ?> (not to be confused with the first and last name) of the manager of the archaeological operation to which the context belongs, to which you want to add an inventory entry.</li>
          <li><b>Archaeological operation (code):</b> The code of the archaeological operation to which the context belongs, to which you want to add an inventory entry.</li>
          <li><b>Archaeological operation (name):</b> The name of the archaeological operation to which the context belongs, to which you want to add an inventory entry.</li>
          <li><b>Context (code) (required):</b> The code of the context to which you want to add the inventory entry.</li>
          <li><b>Inventory number (required):</b> Inventory number of the object you want to add, unique within the context. The inventory number is limited to 128 characters.</li>

          <li><b>Category (required):</b> Abbreviation of the category to which the object belongs (maximum 16 characters). The category does not need to have been added to <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Function (required):</b> Name of the function to which the object belongs (maximum 128 characters). The function does not need to have been added to <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Type (required):</b> Name of the type to which the object belongs (maximum 128 characters). The type does not need to have been added to <?php echo WEBSITE_NAME; ?>. </li>
          <li><b>var. (optional):</b> If this is a variant of the type, indicate it here (preferably using the indication "var.", maximum 8 characters).</li>
          <li><b>uncertain (optional):</b> If there is uncertainty about the identification of the type, indicate it here (preferably using the punctuation mark "?", maximum 16 characters).</li>
          <li><b>Fabric (optional):</b> Code of the fabric group to which the object belongs (maximum 64 characters). The fabric group does not need to have been added to <?php echo WEBSITE_NAME; ?>.</li>

          <li><b>Diam. (optional):</b> Information about the diameter of the object (maximum 16 characters).</li>
          <li><b>Stamps (optional):</b> If there are stamps on the object, indicate them separately from the type in order to facilitate searches for them (maximum 255 characters).</li>
          <li><b>Comment (optional):</b> Free comment or description (maximum 255 characters).</li>
          <li><b>Rims (optional):</b> Number of rims (integer >= 0).</li>
          <li><b>Bases (optional):</b> Number of bases (integer >= 0).</li>
          <li><b>Handles (optional):</b> Number of handles (integer >= 0).</li>
          <li><b>Walls (optional):</b> Number of walls (integer >= 0).</li>
          <li><b>MNI (optional):</b> Minimum number of individuals (strict, based on rims alone) (integer >= 0).</li>
          <li><b>NR (optional):</b> Number of remains (or fragments) (integer >= 0).</li>
        </ul>


        <h5>Inventory – long version</h5>
        <p>The long version is useful for literature reviews (or for making contexts studied some time ago available online), as it allows categories, functions, types and fabric groups to be modified in the database while retaining the information originally published. <div style="color:#ff0000">Importing inventories in this form is not currently possible.</div> The fields concerned are replaced by:</p>
        <ul>
          <li><b>Category (adapted) (required):</b> Equivalent to Category in the short template.</li>
          <li><b>Category (bibliographic) (optional):</b> Category mentioned in the bibliography (feature to be added).</li>
          <li><b>Function (adapted) (required):</b> Equivalent to Function in the short template.</li>
          <li><b>Function (bibliographic) (optional):</b> Function mentioned in the bibliography (feature to be added).</li>
          <li><b>Type (adapted) (required):</b> Equivalent to Type in the short template.</li>
          <li><b>Type (bibliographic) (optional):</b> Type mentioned in the bibliography (feature to be added).</li>
          <li><b>Fabric (adapted) (optional):</b> Equivalent to Fabric Group in the short template.</li>
          <li><b>Fabric (bibliographic) (optional):</b> Fabric group mentioned in the bibliography (feature to be added).</li>
        </ul>
      </section>

      <section id="ouvrir-templates" class="mb-5">
        <h4>1.3. Opening the templates</h4>
        
        <p>The templates have been configured to use semicolons as separators, which is the default configuration for MS Excel in its French-language version. However, the template may not display correctly on your system; in that case, do not hesitate to contact the site administrator to find a solution.</p>
      </section>

      <section id="completer-enregistrer" class="mb-5">
        <h4>1.4. Completing and saving the templates</h4>
        <h5>Completing the template</h5>
        <p>Once opened, you can complete the template. Make sure not to remove any fields from the template and not to change the order of the columns. <?php echo WEBSITE_NAME; ?> normally handles the addition of new fields (which are ignored), the removal of required fields and changes to the order, but bugs may nevertheless occur.</p>
        <p>Leave unused and non-required fields completely blank. Note that style modifications (bold, italics, underlining, fonts, etc.) are not preserved in a CSV file. Small capitals are converted to capitals.</p>
        <p><b>The maximum size of the templates is currently approximately 200 MB, but it will be restricted to 2 MB (in order to keep them manageable), i.e. approximately 50,000 inventory entries. Please do not exceed this figure.</b></p>

        <h5>Saving the template</h5>
        <p>The template must always be saved in CSV format, using the semicolon as the separator. In MS Excel configured for French-speaking users, this should be the case.</p>
        <p>You can nevertheless check this by opening your CSV file in a text editor (TextEdit) on Mac and checking whether semicolons or another separator (usually a comma) is used to separate the fields. If it is a comma, and you are sure that you have not used commas when completing the template, you can use find and replace to replace the commas with semicolons.</p>
      </section>
    </section>

    <section id="integrer" class="mb-5">
      <h3>2. Integrating the templates</h3>
      <section id="ajouter-template" class="mb-5">
        <h4>2.1. Adding the templates and going to the data import screen</h4>
        <p>To add the template, return to the Personal Area. Under "Import data", you will need to:</p>
        <ul>
          <li>Select an option from the list to select the type of template you will add (regardless of whether it is the long or short template);</li>
          <li>Add the completed file;</li>
          <li>Indicate whether or not you want to display the imported data without errors. "Without errors" means that the data can be integrated exactly as entered, without any modification by the user. Please note that the absence of a match for categories, functions, types and fabric groups is not considered an error. If you want to perform these checks, we recommend that you do not tick this box. This choice cannot be changed afterwards. If you are unsure about your choice, you can always perform a test, then abandon the data integration and choose to change your selection (see below).</li>
        </ul>
      </section>
      <section id="ecran-ajout" class="mb-5">
        <h4>2.2. Data import screen</h4>
        <p>You will then arrive at a screen allowing you to validate the data import. This screen consists of two parts: an integration summary and the table containing the imported data.</p>

        <h5>Integration data</h5>
        <p>This is a summary of the data being added:</p>
        <ul>
          <li><b>Rows:</b> The rows currently being processed within the CSV (to match Excel's numbering, the header row is considered row 1).</li>
          <li><b>Total rows:</b> Number of rows contained in the uploaded file (including the header row).</li>
          <li><b>Remaining rows:</b> Number of rows that have not yet been processed.</li>
          <li><b>Displayed rows:</b> Number of rows displayed in this table.</li>
        </ul>

        <h5>Data table</h5>
        <p>Below this information, the table is displayed, either with all integrated data or only with erroneous data, depending on the choice made during integration. <?php echo WEBSITE_NAME; ?> is configured to display a maximum of 200 rows. If the option "Also display imported data without errors" has not been checked, <?php echo WEBSITE_NAME; ?> will process a maximum of 1,000 rows at a time, regardless of whether there are errors or not (and will display a maximum of 200 erroneous rows).</p>
        <p>Correctly completed data is displayed in black. Other data is displayed in different colours depending on its severity.</p>

        <h5>Errors preventing data import</h5>
        <p>These errors are indicated in dark red. Importing may be possible in some cases, but we have chosen to consider them blocking errors, as the user will likely want to correct them. In general:</p>
        <ul>
          <li><b>Invalid format:</b> When mandatory data is missing, does not have the correct format (for example, letters instead of numbers), or the maximum number of characters has been exceeded.</li>
        </ul>
        <p>For the import of sites:</p>
        <ul>
          <li><b>Project:</b> No project corresponds to this identifier, or the user is not included in the corresponding project.</li>
          <li><b>Operation supervisor:</b> The username does not exist. The site code cannot be checked and is therefore also considered incorrect.</li>
          <li><b>Code:</b> The code is missing, too long, or already exists for this supervisor.</li>
          <li><b>Name:</b> The name is missing, too long, or already exists in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Region:</b> The code of the specified region does not yet exist in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Coordinates:</b> The latitude and/or longitude are not provided as numbers or contain impossible values (between -90 and 90 for latitude, between -180 and 180 for longitude).</li>
        </ul>
        <p>For the import of site-horizons and contexts:</p>
        <ul>
          <li><b>Site:</b> No site corresponds to this code, or the user is neither the supervisor nor a contributor of this site (the context code is also considered incorrect, as it cannot be checked).</li>
          <li><b>Site-horizon code:</b> This code is already assigned to this site (in the case where a name other than that of the existing site-horizon or the site-horizon mentioned above under the same code differs for this row - <b>Rule to be confirmed</b>).</li>
          <li><b>Link type:</b> The type of link with the regional horizon must be empty or a number between 0 and 3 (major = 1, minor = 2, uncertain = 3, unknown = 0) - <b>It still needs to be specified whether this is a blocking issue or not</b>.</li>
          <li><b>Context code:</b> The code already exists for this site.</li>
        </ul>
        <p>For the import of inventory:</p>
        <ul>
          <li><b>Site:</b> No site corresponds to this code, or the user is neither the supervisor nor a contributor of this site (the context code and inventory number are also considered incorrect, as they cannot be checked).</li>
          <li><b>Context:</b> The code specified for the context does not exist for this site (the inventory number is also considered incorrect, as it cannot be checked).</li>
          <li><b>Inventory number:</b> The number must be unique within the context (including among the data being added)</li>
          <li><b>Rims, bases, handles, walls, MNI, NR:</b> If these columns are completed, they must contain positive integers (or 0)</li>
        </ul>

        <h5>Errors not preventing data import</h5>
        <p>These errors are (normally) displayed in grey. In the case of inventory import, they are not really errors but rather the addition of data that is not linked at the reference-system level.</p>
        <p>For the import of sites:</p>
        <ul>
          <li><b> Public, Unpublished, Literature review:</b> When the format is incorrect (an answer other than "yes" or "no", or an empty field). The default values will be applied.</li>
        </ul>
        <p>For the import of site-horizons and contexts:</p>
        <ul>
          <li><b>Horizon group (code):</b> No horizon group corresponds to this code, or the user is neither the supervisor nor a contributor of this group (the horizon code is also considered incorrect, as it cannot be checked).</li>
          <li><b>Horizon (code):</b> The code specified for the regional horizon does not exist for this horizon group.</li>
          <li><b>Link type:</b> If the type is specified, it must be an integer between 1 and 3</li>
        </ul>
        <p>For the import of inventory:</p>
        <ul>
          <li><b>Category, Function, Type and Fabric Group:</b> When there is no element in the <?php echo WEBSITE_NAME; ?> reference system (currently not connected to ONICer) that can be linked.</li>
        </ul>
      </section>

      <section id="corrections" class="mb-5">
        <h4>2.3. Corrections during integration</h4>
        <p>Whether in the event of an error or for any other type of correction, you can change the displayed value by simply clicking on the cell you want to modify and correcting the value. When you click elsewhere, the value is displayed in black if it is valid, or in the colour corresponding to the type of error.</p>
      </section>

      <section id="validation" class="mb-5">
        <h4>2.4. Validating or abandoning the integration</h4>
        <p>Once you have checked and applied all the modifications you wanted, you can validate the integration. Two cases are possible:</p>
        <ul>
          <li><b>Import valid rows and load the next batch:</b> When there is still data that has not yet been processed, you integrate the valid data and the next data is displayed.</li>
          <li><b>Import valid rows and finish the upload:</b> When there is little data left to import or you have reached the end of the data to be imported, you integrate the valid data and are then redirected to your personal area.</li>
        </ul>
        <p>Invalid data will not be added (<b style="color:#ff0000">CLARIFY</b>).</p>
        <p>You can also abandon the upload. Data that has already been imported (during previous displays) will not be deleted, but the data currently displayed and all data still to be processed will not be integrated into <?php echo WEBSITE_NAME; ?>. You cannot go back. This is a useful option if you notice many problems in your file and want to rework it, or if you want to change the option for displaying erroneous data or not. If you simply want to stop the integration for now, pausing it is more appropriate (see below).</p>
      </section>
    </section>

    <section id="longues-integrations" class="mb-5">
      <h3>3. Managing long integrations</h3>
      <section id="pause-integration" class="mb-5">
        <h4>3.1. Temporarily stopping the upload</h4>
        <p>If you need to stop while adding data, a "Temporarily stop the upload" button allows you to pause the data integration. Unless other data is added in the meantime, you can then restart the data addition from where you left off. You can also simply leave the screen.</p>
        <p>This will not affect the rows that have already been added to the database.</p>
      </section>

      <section id="reprendre-upload" class="mb-5">
        <h4>3.2. Resuming the upload</h4>
        <p>To resume an upload that has been paused in this way, you must go to your personal area. Under "Import data", a green button allows you to resume a paused upload. This button is not displayed if no upload has been paused.</p> 
        <p>For now, it is not planned to allow multiple uploads to be paused and restarted for the same user. If you start a new upload (of sites, contexts or inventory), it will delete the paused upload.</p>
      </section>
    </section>

    <h2>II. Integrating data from project, site and context pages</h2>
    <p>This option has not yet been implemented in <?php echo WEBSITE_NAME; ?>.</p>

    <h2>III. Manually integrating data</h2>
    <div style="color:#ff0000"><p>Section under construction.</p></div>
  </div>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
