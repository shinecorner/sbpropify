<?php
return [
    'user' => 
    [
      'administrator' => 'Amministratori',
      'super_admin' => 'Super amministratori',
      'add_admin' => 'Aggiungi Amministratore',
      'edit_admin' => 'Modifica Amministratore',
      'add_super_admin' => 'Aggiungi Super admin',
      'edit_super_admin' => 'Modifica Super admin',
      "edit_action" => "Modifica",
      "delete" => "Cancellare",
      "name" => "Nome",
      "phone" => "Telefono",
      "date" => "Appuntamento",
      "email" => "Email",
      "id" => "ID",
      "add" => "Aggiungi utente",
      "save" => "Risparmiate",
      "saved" => "Utente salvato con successo",
      "deleted" => "Utente cancellato",
      "edit" => "Modifica utente",
      "not_found" => "Utente non trovato",
      "profile_image" => "Immagine del profilo",
      "profile_text" => "Testo del profilo",
      "avatar_uploaded" => "Avatar caricato",
      "logo_uploaded" => "Logo caricato",
      "logo" => "Logo",
      "address" => "Indirizzo",
      "blank_pdf" => "PDF in bianco",
      "notificationSaved" => "Impostazione della notifica salvata",
      "realEstateSaved" => "Impostazioni immobiliari salvate",
      "serviceRequestCategorySaved" => "Categoria della richiesta di servizio salvata",
      "serviceRequestCategoryDeleted" => "Categoria della richiesta di servizio cancellata",
      'setting_saved' => "impostazioni utente salvate",
      'setting_deleted' => "l'impostazione dell'utente è stata cancellata",
      'password_reset_request_sent' => "Le abbiamo inviato un'e-mail con ulteriori istruzioni. Controlla la tua casella di posta in arrivo.", 
      'errors' => [
        'not_found' => "Utente non trovato",
        'setting_not_found' => "impostazione utente non trovata",        
        'image_upload' => "Errore caricamento immagine utente : ",
        'incorrect_password' => "Password utente non corretta",
        'email_missing' => "manca l'email",
        'email_already_exists' => "Questa email [:email] esiste già, Seleziona un'altra email",
        'email_not_exists' => "Questa [:email] email non esiste",
        'password_reset_token_invalid' => "Questo token per la reimpostazione della password non è valido.",
        'deleted' => "Errore cancellato dall'utente: ",
      ],
      'validation' => 
      [
        'name' => 
        [
          'required' => 'Il nome è obbligatorio',
        ],
        'role' => 
        [
          'required' => 'Il ruolo è richiesto',
        ],
      ],
    ],
    'tenant' => 
    [
      "view" => "Vista",
      "view_title" => "Vedi inquilino",
      "edit_title" => "Modifica inquilino",
      "download_credentials" => "Scarica le credenziali",
      "send_credentials" => "Mandare le credenziali",
      "credentials_sent" => "Invio delle credenziali",
      "credentials_send_fail" => "File delle credenziali non trovato. Prova ad aggiornare la password dell'inquilino per rigenerarla",
      "credentials_download_failed" => "File delle credenziali non trovato. Prova ad aggiornare la password dell'inquilino per rigenerarla",
      "add" => "Aggiungi inquilino",
      "save" => "Risparmiate",
      "saved" => "L'inquilino salvato",
      "deleted" => "L'inquilino è stato cancellato",
      "status_changed" => "Stato cambiato",
      "password_reset" => "Il reset della password dell'inquilino ha avuto successo",
      "update" => "Aggiornamento",
      "name" => "Nome",
      "first_name" => "Nome",
      "last_name" => "Cognome",
      "birth_date" => "Data di nascita",
      "language" => "La lingua",
      "mobile_phone" => "Telefono cellulare",
      "work_phone" => "Telefono di lavoro",
      "email" => "Email",
      "personal_phone" => "Telefono personale",
      "private_phone" => "Telefono personale",
      "created_date" => "Data di creazione",
      "created_at" => "Appuntamento",
      "edit" => "Modifica",
      "delete" => "Cancellare",
      "id" => "ID",
      "details" => "Dettagli",
      "contract" => "Contratto",
      "posts" => "Messaggi",
      "products" => "Prodotti",
      "requests" => "Richieste",
      "company" => "Nome dell'azienda",
      "no_building" => "Niente edificio",
      'media' => 
      [
        'deleted' => 'Documento/foto eliminato',
        'uploaded' => 'Documento/foto caricato',
      ],
      'building' => 
      [
        'name' => 'Bâtiment',
      ],
      'unit' => 
      [
        'name' => 'Unità',
      ],
      'search_building' => 'Ricerca edificio',
      'search_unit' => 'Unità di ricerca',
      'search' => 'Ricerca',
      'confirmDelete' => 
      [
        'title' => "Questo cancellerà definitivamente l'inquilino.",
        'text' => "Sei sicuro?",
      ],
      'validation' => 
      [
        'first_name' => 
        [
          'required' => "Il nome è obbligatorio",
        ],
        'last_name' => 
        [
          'required' => "Il cognome è obbligatorio",
        ],
        'birth_date' => 
        [
          'required' => "La data di nascita è obbligatoria",
        ],
        'building' => 
        [
          'required' => "L'edificio è richiesto",
        ],
        'unit' => 
        [
          'required' => "L'unità è richiesta",
        ],
        'title' => 
        [
          'required' => "Il titolo è richiesto",
        ],
        'language' => 
        [
          'required' => "La lingua è richiesta",
        ]
      ],
      'errors' => [
        'not_found' => "L'inquilino non trovato",
        'incorrect_email' => "Indirizzo e-mail errato",
        'create' => "L'inquilino crea un errore: ",
        'update' => "Errore di aggiornamento dell'inquilino: ",	
        'deleted' => "Errore di cancellazione dell'inquilino: ",
        'not_allowed_change_status' => "Non è consentito modificare lo stato.",
      ],      
      "building_card" => "Assegnare l'unità",
      "personal_details_card" => "Dati personali",
      "account_info_card" => "Accesso utente",
      "contact_info_card" => "Dati di contatto",
      "personal_data" => "Dati personali",
      "my_documents" => "I miei documenti",
      "my_contract" => "Il mio contratto",
      "contact_persons" => "I miei contatti",
      "no_contacts" => "Nessun contatto disponibile",
      "rent_end" => "Fine affitto",
      "rent_start" => "Inizio affitto",
      "rent_contract" => "Contratto d'affitto",
      'contact' => 
      [
        "category" => "Categoria",
        "name" => "Nome",
        "email" => "Email",
        "phone" => "Telefono",
      ],
      'titles' => 
      [
        "mr" => "Signor",
        "mrs" => "Signora",
        "company" => "Azienda",
      ],
      'status' => 
      [
        "label" => "Situazione",
        "active" => "Attivo",
        "not_active" => "Non attivo",
      ],
      'confirmChange' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
    ],
    'building' => 
    [
      "title" => "Edifici",
      "edit_title" => "Modifica Edificio",
      "add" => "Aggiungi edificio",
      "name" => "Nome",
      "cancel" => "Annulla",
      "created_at" => "Appuntamento",
      "edit" => "Modifica",
      "delete" => "Cancellare",
      "deleted" => "Edificio cancellato con successo",
      "units" => "Unità",
      "save" => "Risparmiate",
      "saved" => "Edificio salvato",
      "floors" => "Pavimenti",
      "basement" => "Nel seminterrato",
      "attic" => "In soffitta",
      "description" => "Descrizione",
      "floor_nr" => "Numero di piani",
      "label" => "Etichetta",
      "address" => "Indirizzo",
      "address_search" => "Inserire l'indirizzo",
      "not_found" => "Edificio non trovato",
      "house_rules" => "Le regole della casa",
      "operating_instructions" => "Istruzioni per l'uso",
      'care_instructions' => 'Istruzioni per la cura',
      "other" => "Altro",
      "files" => "I file",
      "add_files" => "Aggiungere file",
      "add_companies" => "Aggiungere aziende",
      "companies" => "Società di servizi",
      "no_services" => "Nessun servizio aggiunto",
      "details" => "Dettagli",
      "select_media_category" => "Categoria di supporti selezionati",
      "district" => "Distretto",
      "tenants" => "Gli inquilini",
      "managers" => "Manager",
      "requests" => "Richieste",
      "house_nr" => "Casa Nr...",
      "assign" => "Assegnare",
      "assign_managers" => "Assegnare i manager",
      "unassign_manager" => "Disassegnare",
      "managers_assigned" => "Dirigenti assegnati",
      "occupied_units" => "Unità ossessionate",
      "free_units" => "Unità libere",
      'manager' => 
      [
        "unassigned" => "Manager non assegnato",
      ],
      'document' => 
      [
        "uploaded" => "Documento caricato",
        "deleted" => "Documento cancellato",
      ],
      'service' => 
      [
        "deleted" => "Servizio rimosso da questo edificio",
      ],
      'confirmDelete' => 
      [
        "title" => "Questo cancellerà definitivamente l'edificio...",
        "text" => "Sei sicuro?"
      ],
      'validation' => 
      [
        'name' => 
        [
          "required" => "Il nome è obbligatorio",
        ],
        'floor_nr' => 
        [
          "required" => "Il numero di piano è obbligatorio",
        ],
        'description' => 
        [
          "required" => "È necessaria una descrizione",
        ],
        'label' => 
        [
          "required" => "L'etichetta è obbligatoria",
        ],
        'address_id' => 
        [
          "required" => "L'indirizzo è obbligatorio",
        ],
      ],
      'errors' => [
        'not_found' => "Edificio non trovato",
        'manager_not_found' => "Property manager non trovato",
        'deleted' => "Edificio cancellato errore: ",
        'manager_assigned' => "I gestori di proprietà assegnano all'errore dell'edificio: ",
        'provider_deleted' => "Il fornitore del servizio ha cancellato l'errore: ",
      ],
      'requestStatuses' => 
      [
        "total" => "Totale richieste",
        "received" => "Richieste ricevute",
        "assigned" => "Richieste assegnate",
        "in_processing" => "Nell'elaborazione delle richieste",
        "reactivated" => "Richieste riattivate",
        "done" => "Richieste fatte",
        "archived" => "Richieste archiviate",
        'solved' => "Richieste risolte",
        'pending' => "Richieste in sospeso"
      ],
      'placeholders' => 
      [
        "search" => "Cerca",
      ],
      'delete_building_modal' => 
      [
        "title" => "Cancellare l'edificio o gli edifici",
        "description_unit" => "Le unità vengono assegnate alla proprietà selezionata. Se si desidera cancellare anche le unità, attivare l'opzione sottostante",
        "description_request" => "Le richieste vengono assegnate alla proprietà selezionata. Se si desidera cancellare anche la richiesta, attivare l'opzione sottostante",
        "description_both" => "Le unità e le richieste vengono assegnate alla proprietà selezionata. Se anche voi volete cancellarle, attivate le opzioni sottostanti",
        "delete_units" => "Elimina unità",
        "dont_delete_units" => "Non cancellare l'unità (o le unità)",
        "delete_requests" => "Cancellare la richiesta (o le richieste)",
        "dont_delete_requests" => "Non cancellare una o più richieste di cancellazione",
      ],
      'assigned_buildings' => "Edifici assegnati",
    ],
    'unit' => 
    [
      "title" => "Unità",
      "not_found" => "Unità non trovata",
      "add" => "Aggiungi unità",
      'tenantType' => [
        "attached" => "L'inquilino attaccato con successo",
        "detached" => "L'inquilino si è staccato con successo"
      ],
      "name" => "Numero di unità",
      "created_at" => "Appuntamento",
      "edit" => "Modifica unità",
      "delete" => "Rimuovi",
      "deleted" => "Unità cancellata",
      "save" => "Risparmiate",
      "saved" => "Unità salvata",
      "floor" => "Piano",
      "sq_meter" => "Misuratore di mq",
      "room_no" => "Numero di camere",
      "monthly_rent" => "Affitto mensile",
      "building_search" => "Inserire il nome di un edificio e selezionarlo",
      "building" => "Edificio",
      "description" => "Descrizione",
      "basement" => "Nel seminterrato",
      "attic" => "In soffitta",
      "requests" => "Richieste",
      "tenant" => "Un inquilino",
      "empty_requests" => "Nessuna richiesta",
      "assigned_tenant" => "Assegnato inquilino",
      "assign" => "Assegnare",
      "tenant_assigned" => "L'inquilino assegnato",
      "tenant_unassigned" => "Un inquilino non assegnato",
      'assignment' => 'Affittuari assegnati',
      'type' => 
      [
        "label" => "Tipo",
        "apartment" => "Appartamento",
        "business" => "Affari",
      ],
      'confirmDelete' => 
      [
        "title" => "Questo cancellerà definitivamente l'unità",
        "text" => "Sei sicuro?"
      ],
      'validation' => 
      [
        'name' => 
        [
          "required" => "Il nome è obbligatorio",
        ],
        'building' => 
        [
          "required" => "L'edificio è obbligatorio",
        ],
        'monthly_rent' => 
        [
          "required" => "L'affitto mensile è richiesto",
        ],
        'floor' => 
        [
          "required" => "Il pavimento è obbligatorio",
        ],
        'room_no' => 
        [
          "required" => "Il numero della camera è obbligatorio",
        ],
        'description' => 
        [
          "required" => "È necessaria una descrizione",
        ],
        'tenant' =>
        [
          "required" => "È necessaria una descrizione",
        ]
      ],
      'errors' => [
        'not_found' => "Unità non trovata",
        'create' => "Unità crea errore: ",
        'update' => "Errore di aggiornamento dell'unità: ",
        'tenant_assign' => "L'inquilino assegna un errore: ",
        'tenant_not_assign' => "Affittuario non assegnato a questa unità",
        'tenant_not_found' => "L'inquilino non trovato",
        'deleted' => "Unità cancellata errore: ",
      ],
      'placeholders' => 
      [
        "search" => "Cerca",
        "select" => "Selezionare",
      ],
    ],
    'address' => 
    [
      "add" => "Aggiungi indirizzo",
      "created_at" => "Appuntamento",
      "name" => "Indirizzo",
      "edit" => "Modifica",
      "delete" => "Rimuovi",
      "save" => "Risparmiate",
      "city" => "La citta'",
      "country" => "Paese",
      "street" => "Strada",
      "street_nr" => "Via Nr...",
      "zip" => "Zip",
      "not_found" => "Indirizzo non trovato",
      "saved" => "Indirizzo salvato",
      'confirmDelete' => 
      [
        "title" => "Questo cancellerà definitivamente l'indirizzo..",
        "text" => "Sei sicuro?"
      ],
      'state' => 
      [
        "label" => "Stato",
      ],
      'validation' => 
      [
        'state' => 
        [
          "required" => "Lo stato è obbligatorio",
        ],
        'city' => 
        [
          "required" => "La città è obbligatoria",
        ],
        'street' => 
        [
          "required" => "La strada è obbligatoria",
        ],
        'street_nr' => 
        [
          "required" => "Il numero civico è obbligatorio",
        ],
        'zip' => 
        [
          "required" => "E' richiesta la chiusura lampo",
        ],
      ],
    ],
    'post' => 
    [
      "title" => "Notizie",
      "title_label" => "Titolo",
      "content" => "Contenuto",
      "preview" => "Anteprima",
      "add" => "Aggiungi messaggio",
      "add_pinned" => "Aggiungere posta bloccata",
      "save" => "Risparmiate",
      "saved" => "Notizie salvare",
      'view_incresead' => "Le viste sono aumentate con successo",
      "updated" => "Notizie aggiornate",
      "deleted" => "Notizie Cancellate",
      "edit" => "Modifica",
      "edit_title" => "Modifica messaggio",
      "show" => "Dettagli",
      "user" => "Utente",
      "delete" => "Cancellare",
      "likes" => "Gli piace",
      "tenants" => "Gli inquilini",
      "views" => "Viste",
      "details" => "Pubblicare i dettagli",
      "published_at" => "Pubblicato",
      "publish" => "Pubblicare",
      "unpublish" => "Non pubblicare",
      "buildings" => "Edifici",
      "pinned" => "Inchiodato",
      "notify_email" => "Notifica e-mail",
      "pinned_to" => "Inchiodato a",
      "comments" => "Commenti",
      "images" => "Immagini",
      "details_title" => "Dettagli",
      'placeholders' => 
      [
        "buildings" => "Scegliere gli edifici",
        "search" => "Cerca",
        "search_provider" => "Fornitore di ricerca",
      ],
      'media' => 
      [
        'deleted' => 'Documento/foto eliminato',
        'uploaded' => 'Documento/foto caricato',
      ],
      'type' => 
      [
        "label" => "Tipo",
        "article" => "Articolo",
        'post' => "Messaggio",
        "new_neighbour" => "Nuovo vicino",
        "pinned" => "Inchiodato",
      ],
      'errors' => [
        'not_found' => "Posta non trovata",
        'district_not_found' => "Distretto non trovato",
        'building_not_found' => "Edificio non trovato",
        'provider_not_found' => "Fornitore di servizi non trovato",
        'deleted' => "Messaggio errore cancellato: ",
      ],
      'status' => 
      [
        "label" => "Situazione",
        "new" => "Nuovo",
        "published" => "Pubblicato",
        "unpublished" => "Inedito",
        "not_approved" => "Non approvato",
      ],
      'visibility' => 
      [
        "label" => "Visibilità",
        "address" => "Indirizzo",
        "district" => "Distretto",
        "all" => "Tutti",
      ],
      'confirmChange' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      "assignType" => "Tipo",
      "unassign" => "Disassegnare",
      "assign" => "Assegnare",
      'attached' => 
      [
        "building" => "Edificio assegnato",
        "district" => "Distretto assegnato",
        "provider" => "Fornitore assegnato",
      ],
      'detached' => 
      [
        "building" => "Costruire senza assegnazione",
        "district" => "Distretto non assegnato",
        "provider" => "Fornitore non assegnato",
      ],
      "buildingAlreadyAssigned" => "L'edificio e' gia' all'interno di un quartiere",
      'confirmUnassign' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      'execution_interval' => 
      [
        "label" => "Intervallo di esecuzione",
        "end" => "Fine dell'esecuzione",
        "start" => "Inizio esecuzione",
        "separator" => "A",
      ],
      'category' => 
      [
        "label" => "Categoria",
        "general" => "Generale",
        "maintenance" => "Manutenzione",
        "electricity" => "Elettricità",
        "heating" => "Riscaldamento",
        "sanitary" => "Sanitario",
      ],
    ],
    'service' => 
    [
      "title" => "Servizi",
      "add_title" => "Aggiungi servizio",
      "edit_title" => "Modifica servizio",
      "edit" => "Modifica",
      "delete" => "Cancellare",
      "saved" => "Servizio salvato",
      "deleted" => "Servizio cancellato",
      "category" => "Categoria",
      "electrician" => "Elettricista",
      "heating_company" => "Azienda di riscaldamento",
      "lift" => "Sollevare",
      "sanitary" => "Sanitario",
      "key_service" => "Servizio chiave",
      "caretaker" => "Custode",
      "real_estate_service" => "Servizio immobiliare",
      "name" => "Nome",
      "requests" => "Richieste",
      "contact_details" => "Dati di contatto",
      "user_credentials" => "Credenziali utente",
      "company_details" => "Dettagli dell'azienda",
      "assignType" => "Tipo",
      "unassign" => "Disassegnare",
      "assign" => "Assegnare",
      'attached' => 
      [
        "building" => "Edificio assegnato",
        "district" => "Distretto assegnato",
      ],
      'detached' => 
      [
        "building" => "Edificio assegnato",
        "district" => "Distretto assegnato",
      ],
      "buildingAlreadyAssigned" => "L'edificio e' gia' all'interno di un quartiere",
      'confirmUnassign' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      'placeholders' => 
      [
        "search" => "Cerca",
        "category" => "Selezionare la categoria",
      ],
      'errors' => [
        'not_found' => "Fornitore di servizi non trovato",
        'create' => "Il fornitore di servizi crea un errore: ",
        'update' => "Errore aggiornato del fornitore di servizi: ",	
        'deleted' => "Errore cancellato dal fornitore di servizi: ",
        'district_not_found' => "Distretto non trovato",
        'building_not_found' => "Edificio non trovato",
        'building_already_assign' => "Edificio già assegnato attraverso il distretto",        
      ],
    ],
    'district' => 
    [
      "title" => "Distretti",
      "name" => "Nome",
      "description" => "Descrizione",
      "add" => "Aggiungi distretto",
      "edit" => "Modifica Distretto",
      "save" => "Risparmiate",
      "saved" => "Distretto salvato",
      "edit_action" => "Modifica",
      "delete" => "Cancellare",
      "deleted" => "Distretto soppresso",
      "cancel" => "Annulla",
      "required" => "Questo campo è obbligatorio",
      "details" => "Dettagli",
      "buildings" => "Edifici",
      'count_of_buildings' => 'Conteggio degli edifici',
      'errors' => [
        'not_found' => "Distretto non trovato",   
        'deleted' => "Distretto cancellato errore: ",     
      ],
    ],
    'realEstate' => 
    [
      "title" => "Impostazioni immobiliari",
      "details" => "Dettagli",
      "settings" => "Impostazioni",
      'iframe' => 'Iframe',
      'theme' => 'Tema',
      'requests' => 'Richieste',
      'login_variation' => 'Variazione del login',
      'login_variation_slider' => 'Vuoi mostrare il cursore?',
      "district_enable" => "Distretto",
      "marketplace_approval_enable" => "Attivare il mercato",
      "news_approval_enable" => "Approvazione delle notizie",
      "comment_update_timeout" => "Timeout aggiornamento commento",
      "closed" => "Chiuso",
      "saved" => "Beni immobili salvati",
      "schedule" => "Programmazione",
      "endTime" => "E' l'ora della fine",
      "startTime" => "Ora di inizio",
      "to" => "A",
      "categories" => "Categorie",
      "templates" => "Modelli",
      "contact_enable" => "Attivare 'I miei contatti'",
      "cleanify_email" => "Pulire le e-mail",
      "mail_encryption" => "Crittografia",
      'primary_color' => 'Colore primario',
      'accent_color' => 'Colore d\'accento',
      'iframe_enable' => 'Attivare Iframe',
      'iframe_url' => 
      [
        "label" => "URL Iframe",
        "validation" => "Iframe URL dovrebbe essere un URL valido",
      ],
      "mail_from_name" =>
      [
        "label" => "Da Nome",
        "validation" => "Inserisci da Nome",
      ],
      "mail_from_address" => [
        "label" => "Dall'indirizzo",
        "required" => "Inserisci dall'indirizzo e-mail",
        "email" => "Inserisci un'e-mail valida",
      ],
      "mail_host" => [
        "label" => "Ospite",
        "validation" => "Host dovrebbe essere un URL valido",
      ],
      "mail_port" => [
        "label" => "Porto",
        "validation" => "Inserire la porta e-mail",
      ],
      "mail_username" => [
        "label" => "Nome utente",
        "validation" => "Inserisci il nome utente e-mail",
      ],
      "mail_password" => [
        "label" => "La password",
        "validation" => "Inserisci la password e-mail"
      ],
      'errors' => [
        'not_found' => "Immobili non trovati",
        'update' => "Errore nell'aggiornamento immobiliare: ",
      ],
    ],
    'request' => 
    [
      "audits" => "Audit",
      "edit" => "Modifica",
      "delete" => "Cancellare",
      "deleted" => "Richiesta supprimée",
      "title" => "Richieste",
      "created" => "Creato",
      "saved" => "Requête sauvegardée",
      "prop_title" => "Titolo",
      "description" => "Descrizione",
      "category" => "Categoria",
      "address" => "Indirizzo",
      "edit_title" => "Modifica Richiesta",
      "add_title" => "Aggiungi Richiesta",
      "tenant" => "Un inquilino",
      "due_date" => "Scadenza",
      "closed_date" => "Data di chiusura",
      "service" => "Servizio",
      "created_by" => "Creato da",
      "is_public" => "Pubblico",
      "comments" => "Commenti",
      "assigned_to" => "Assegnato a",
      "assign_providers" => "Assegnare i fornitori",
      "assign_managers" => "Assegnare i manager",
      "unassign" => "Disassegnare",
      "notify" => "Avvisare",
      "public_legend" => "Impostare questa opzione per rendere la richiesta visibile a tutti i vicini inquilini",
      "conversation" => "Conversazione",
      'conversation_created' => "Commento alla conversazione creato",
      'internal_notice_saved' => "Avviso interno salvato",
      'internal_notice_updated' => "Avviso interno aggiornato",
      'internal_notice_deleted' => "Soppressione dell'avviso interno",
      "open_conversation" => "Aprite",
      "other_recipients" => "Altri destinatari",
      "recipients" => "Destinatari",
      "assign" => "Assegnare",
      "images" => "Immagini",
      "no_images_message" => "Nessun file caricato",
      "request_details" => "Richiedi dettagli",
      "internal_notices" => "Avvisi interni",
      "status_changed" => "Stato cambiato",
      "priority_changed" => "La priorità è cambiata",
      'assignment'=> 'Assegnazione di manager/fornitori di servizi',
      'last_updated' => 'Last updated',
      'media' => 
      [
        "added" => "Documento ajouté",
        "removed" => "Supporti rimossi",
        "deleted" => "Media cancellati",
        "delete" => "Cancellare",
      ],
      'priority' => 
      [
        "label" => "Priorità",
        "urgent" => "E' urgente",
        "low" => "Basso",
        "normal" => "Normale",
      ],
      'defect_location' => 
      [
        "label" => "Posizione del difetto",
        "apartment" => "Appartamento",
        "building" => "Edificio",
        "environment" => "Ambiente"
      ],
      'qualification' => 
      [
        "label" => "Qualificazione",
        "none" => "Nessuna",
        "optical" => "Ottico",
        "sia" => "Sia",
        "2_year_warranty" => "2 anni di garanzia",
        "cost_consequences" => "Conseguenze dei costi",
      ],
      'status' => 
      [
        "label" => "Situazione",
        "received" => "Ricevuto",
        "in_processing" => "In lavorazione",
        "assigned" => "Assegnato",
        "done" => "Fatto",
        "reactivated" => "Riattivato",
        "archived" => "Archiviato",
      ],
      'category_options' => 
      [
        "disturbance" => "Perturbazione",
        "defect" => "Difetto",
        "order_documents" => "Ordinare i documenti",
        "order_a_payment_slip" => "Ordina una polizza di pagamento",
        "questions_about_the_tenancy" => "Domande sull'affitto",
        "other" => "Altro",
        "environment" => "Ambiente",
        "house" => "Casa",
        "apartment" => "Appartamento",
      ],
      'placeholders' => 
      [
        "category" => "Selezionare la categoria",
        "priority" => "Selezionare la priorità",
        "defect_location" => "Selezionare la posizione del difetto",
        "qualification" => "Selezionare la qualifica",
        "status" => "Selezionare lo stato",
        "due_date" => "Scegli la data di scadenza",
        "tenant" => "Cercate un inquilino",
        "service" => "Cerca un servizio",
        "propertyManagers" => "Ricerca di manager",
        "search" => "Cerca",
        "visibility" => "Selezionare la visibilità",
      ],
      'confirmChange' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      'confirmUnassign' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      'mail' => 
      [
        "body" => "Corpo",
        "subject" => "Oggetto",
        "to" => "A",
        "title" => "Avvisare il servizio di assistenza",
        "notify" => "Invia e-mail",
        "bodyPlaceholder" => "Scrivi qui il tuo messaggio",
        "provider" => "Fornitore",
        "manager" => "Manager",
        "cancel" => "Annulla",
        "send" => "Invia",
        "cc" => "CC",
        "bcc" => "BCC",
        "success" => "Messaggio di notifica inviato con successo",
        'validation' => 
        [
          "required" => "Questo campo è obbligatorio",
          "email" => "Questo campo deve essere un'e-mail valida",
        ],
        "fail_cc" => "I campi CC/BCC/TO devono essere e-mail valide",
      ],
      'attached' => 
      [
        "services" => "Fornitore collegato con successo",
        "managers" => "Manager attaccato con successo",
        "user" => "Utente assegnato con successo",
      ],
      'detached' => 
      [
        "service" => "Fornitore staccato con successo",
        "manager" => "Manager staccato con successo",
        "user" => "Utente non assegnato con successo",
      ],
      'userType' => 
      [
        "label" => "Tipo",
        "provider" => "Servizio",
        "manager" => "Manager",
        'admin' => 'Administrator',
      ],
      'visibility' => 
      [
        "label" => "Visibilità",
        "tenant" => "Soldato",
        "district" => "Distretto",
        "building" => "Edificio",
      ],
      'errors' => [
        'not_found' => 'Richiesta di servizio non trovata',
        'not_allowed_change_status' => "Non sei autorizzato a cambiare stato",
        'provider_not_found' => 'Fornitore di servizi non trovato',
        'user_not_found' => 'Utente non trovato',
        'conversation_not_found' => "Conversazione non trovata",
        'statistics_error' => "richiesta errore di statistica: ",
        'internal_notice_not_found' => "Avviso interno non trovato",
        'deleted' => "Errore cancellato nella richiesta di assistenza: ",
      ],
      "requestID" => "Richiedi un documento d'identità",
      "requestCategory" => "Richiedi categoria",
      'actions' => 'Azioni',
    ],
    'requestCategory' => 
    [
      "title" => "Richiedi categorie",
      "add" => "Aggiungi categoria",
      "edit" => "Modifica",
      "delete" => "Cancellare",
      "name" => "Nome",
      "cancel" => "Annulla",
      "required" => "Questo campo è obbligatorio",
      "parent" => "Categoria genitore",
      'errors' => [
        'not_found' => "Richiesta di servizio Categoria non trovata",
        'parent_not_found' => "Richiesta di servizio genitori Categoria non trovata",
        'multiple_level_not_found' => "Non sono ammesse categorie nidificate a più livelli",
        'used_by_request' => "Categoria di richiesta di servizio che viene utilizzata da una richiesta di servizio",
      ]
    ],
    'propertyManager' => 
    [
      "title" => "Gestori immobiliari",
      "add" => "Aggiungi Property Manager",
      "save" => "Risparmiate",
      "saved" => "Gestionnaire immobilier sauvé",
      "deleted" => "Gestionnaire immobilier supprimé",
      "edit" => "Modifica",
      "edit_title" => "Modifica Property Manager",
      "delete" => "Cancellare",
      "firstName" => "Nome",
      "lastName" => "Cognome",
      "name" => "Nome",
      "profession" => "Professione",
      "slogan" => "Slogan",
      "linkedin_url" => "URL di linkedin",
      "xing_url" => "URL Xing",
      "email" => "Email",
      "password" => "La password",
      "confirm_password" => "Confermare la password",
      "phone" => "Telefono",
      "building_card" => "Assegnare gli edifici",
      "details_card" => "Dettagli",
      "no_buildings" => "Non ci sono edifici assegnati",
      "add_buildings" => "Aggiungere edifici",
      "buildings_search" => "Ricerca di edifici",
      "districts" => "Distretti",
      "requests" => "Richieste",
      "assign" => "Assegnare",
      "unassign" => "Disassegnare",
      'delete_with_reassign_modal' =>
      [
        "title" => "Cancellare e riassegnare gli edifici",
        "description" => "Il gestore di proprietà selezionato è collegato alle proprietà. È possibile assegnare le proprietà ad un'altra persona. Per fare questo, selezionare un gestore di proprietà dall'elenco",
        "search_title" => "Cerca Property Manager",
      ],
      "delete_without_reassign" => "Cancellare",
      "profile_card" => "Profilo utente",
      "social_card" => "Social Media",
      'titles' => 
      [
        "mr" => "Signor",
        "mrs" => "Signora"
      ],
      "assignType" => "Tipo",
      'placeholders' => 
      [
        "search" => "Cerca",
      ],
      'attached' => 
      [
        "building" => "Edificio assegnato",
        "district" => "Distretto assegnato",
      ],
      'detached' => 
      [
        "building" => "Costruire senza assegnazione",
        "district" => "Distretto non assegnato"
      ],
      "buildingAlreadyAssigned" => "L'edificio e' gia' all'interno di un quartiere",
      'confirmUnassign' => 
      [
        "title" => "Sei sicuro di voler continuare?",
        "warning" => "Attenzione",
        "confirmBtnText" => "Ok",
        "cancelBtnText" => "Annulla",
      ],
      'errors' => [
        'not_found' => "Property Manager non trovato",
        'create' => "Property Manager crea un errore: ",
        'update' => "Errore aggiornato Property Manager: ",
        'district_not_found' => "Distretto non trovato",
        'building_not_found' => "Edificio non trovato",
        'building_already_assign' => "Edificio già assegnato attraverso il distretto",
        'building_assign_deleted_property_manager' => "Non è possibile assegnare edifici a un gestore di proprietà cancellato",
        'deleted' => "Errore cancellato dal Property Manager: ",
      ],
    ],
    'product' => 
    [
      "title" => "Prodotti",
      "add" => "Aggiungi prodotto",
      "edit_title" => "Modifica prodotto",
      "edit" => "Modifica",
      "delete_action" => "Cancellare",
      "show" => "Dettagli",
      "details" => "Dettagli del prodotto",
      "delete" => "Cancellare il prodotto",
      "content" => "Contenuto",
      "product_title" => "Titolo",
      "published_at" => "Pubblicato",
      "publish" => "Pubblicare",
      "unpublish" => "Non pubblicare",
      "likes" => "Gli piace",
      "save" => "Risparmiate",
      "saved" => "Prodotto salvato",
      "deleted" => "Prodotto cancellato",
      "comments" => "Commenti",
      "user" => "Utente",
      "contact" => "Contatto",
      "price" => "Prezzo",
      'comment_created' => "Commento creato con successo",
      'media' => 
      [
        'deleted' => 'Documento/foto eliminato',
        'uploaded' => 'Documento/foto caricato',
      ],
      'errors' => [
        'not_found' => "Prodotto non trovato",
        'deleted' => "Errore prodotto cancellato: ",
      ],
      'type' => 
      [
        'label' => 'Tipo',
        'sell' => 'Vendere',
        'lend' => 'Prestito',
        'service' => 'Servizio',
        'giveaway' => 'Dare via',
      ],
      'status' => 
      [
        'label' => 'Stato',
        'published' => 'Pubblicato',
        'unpublished' => 'Inedito',
      ],
      'visibility' => 
      [
        'label' => 'Visibilità',
        'address' => 'Indirizzo',
        'district' => 'Distretto',
        'all' => 'Tutti',
      ],
    ],
    'template' => 
    [
      'name' => 'Nome',
      'edit' => 'Modifica',
      'delete' => 'Cancellare',
      'saved' => 'Modello salvato',
      'deleted' => 'Modello cancellato',
      'add' => 'Aggiungi',
      'title' => 'Modelli',
      'subject' => 'Oggetto',
      'body' => 'Corpo',
      'category' => 'Categoria',
      'tags' => 'Tags',
      'placeholders' => 
      [
        'category' => 'Scegli la categoria',
      ],
      'errors' => [
        'not_found' => "Modello non trovato",
      ],
    ],
    'cleanify' => 
    [
      "pageTitle" => "Pulire la richiesta",
      "title" => "Titolo",
      "lastName" => "Cognome",
      "firstName" => "Nome",
      "address" => "Indirizzo",
      "city" => "La citta'",
      "zip" => "La cerniera",
      "email" => "Email",
      "phone" => "Telefono",
      "save" => "Invia richiesta",
      "success" => "Pulire la richiesta inviata con successo",
      "terms_and_conditions" => "Accettare i termini e le condizioni",
      "terms_text" => "Termini testo qui, testo lungo"
    ],
];