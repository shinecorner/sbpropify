<?php
return [
	'user' =>
		[
			'administrator' => 'Administratoren',
			'super_admin' => 'Super-Administratoren',
			'add_admin' => 'Administrator hinzufügen',
			'edit_admin' => 'Administrator bearbeiten',
			'add_super_admin' => 'Super-Admin hinzufügen',
			'edit_super_admin' => 'Super-Admin bearbeiten',						
			'date' => 'Datum',
			'add' => 'Benutzer hinzufügen',			
			'saved' => 'Benutzer erfolgreich gespeichert.',
			'deleted' => 'Benutzer erfolgreich gelöscht.',			
			'not_found' => 'Benutzer nicht gefunden.',
			'profile_image' => 'Profil-Bild',
			'profile_text' => 'Profil-Text',
			'avatar_uploaded' => 'Profilbild aktualisiert',
			'logo_uploaded' => 'Logo aktualisiert.',
			'logo' => 'Firmenlogo',			
			'blank_pdf' => 'PDF ohne Briefkopf verwenden',
			'notificationSaved' => 'Benachrichtigungseinstellung gespeichert',
			'realEstateSaved' => 'Einstellungen gespeichert.',
			'serviceRequestCategorySaved' => 'Anfrage-Kategorie gespeichert',
			'serviceRequestCategoryDeleted' => 'Anfrage-Kategorie gelöscht',
			'setting_saved' => "Einstellung(en) gespeichert",
			'setting_deleted' => "Einstellung(en) gelöscht",
			'password_reset_request_sent' => "Wir haben Ihnen eine E-Mail mit weiteren Anweisungen gesendet. Bitte prüfen Sie Ihren Posteingang und schauen Sie ggf. auch in Ihrem Spam-Ordner nach.",
			'errors' => [
				'not_found' => "Benutzer nicht gefunden",
				'setting_not_found' => "Benutzereinstellung nicht gefunden",
				'image_upload' => "Fehler beim Hochladen des Profilbildes: ",
				'incorrect_password' => "Passwort falsch",
				'email_missing' => "E-Mail fehlt",
				'email_already_exists' => "Die E-Mail [:email] existiert bereits. Bitte bestehenden Eintrag verwenden oder eine andere E-Mail eingeben",
				'email_not_exists' => "Die E-Mail [:email] existiert nicht in unserer Datenbank.",
				'password_reset_token_invalid' => "Das Token zum Zurücksetzen des Passworts ist ungültig.",
				'deleted' => "Fehler beim Löschen durch den Benutzer: ",
			],
			'validation' =>
				[
					'name' =>
						[
							'required' => 'Name ist obligatorisch',
						],
					'role' =>
						[
							'required' => 'Rolle ist obligatorisch',
						],
				],
		],
	'tenant' =>
		[
			'view' => 'Mieter-Profil',
			'view_title' => 'Mieter-Profil',
			'edit_title' => 'Mieter bearbeiten',
			'download_credentials' => 'Zugangsdaten (pdf)',
			'send_credentials' => 'Zugangsdaten (email)',
			'credentials_sent' => 'Zugangsdaten wurden erfolgreich gesendet.',
			'credentials_send_fail' => 'Credentials file not found. Try updating the tenant password to regenerate it',
			'credentials_download_failed' => 'Credentials file not found. Try updating the tenant password to regenerate it',
			'add' => 'Mieter hinzufügen',			
			'saved' => 'Mieter gespeichert',
			'deleted' => 'Mieter gelöscht',
			'status_changed' => 'Status geändert',
			'password_reset' => 'Passwort erfolgreich zurückgesetzt',
			'update' => 'Update',			
			'first_name' => 'Vorname',
			'last_name' => 'Name',
			'birth_date' => 'Geburtsdatum',			
			'nation' => 'Nation',
			'mobile_phone' => 'Mobile',
			'work_phone' => 'Arbeit',			
			'personal_phone' => 'Telefon privat',
			'private_phone' => 'Telefon privat',
			'created_date' => 'Erstelldatum',									
			'contract' => 'Mietvertrag',
			'posts' => 'Beiträge',
			'products' => 'Marktplatz',
			'company' => 'Firmenname',
			'no_building' => 'Keine Liegenschaft(en) zugewiesen.',
			'building' =>
				[
					'name' => 'Liegenschaft',
				],
			'unit' =>
				[
					'name' => 'Einheit',
				],
			'search_building' => 'Liegenschaft suchen',
			'search_unit' => 'Einheit suchen',
			'validation' =>
				[
					'first_name' =>
						[
							'required' => 'Vorname ist obligatorisch',
						],
					'last_name' =>
						[
							'required' => 'Name ist obligatorisch',
						],
					'birth_date' =>
						[
							'required' => 'Geburtsdatum ist obligatorisch',
						],
					'building' =>
						[
							'required' => 'Liegenschaft ist obligatorisch',
						],
					'unit' =>
						[
							'required' => 'Einheit ist obligatorisch',
						],
					'title' =>
						[
							'required' => 'Anrede ist obligatorisch',
						],
					'language' =>
						[
							'required' => 'Sprache ist obligatorisch',
						]
				],
			'errors' => [
				'not_found' => "Mieter nicht gefunden",
				'incorrect_email' => "Falsche E-Mail Adresse",
				'create' => "Fehler beim Erstellen des Mieters: ",
				'update' => "Fehler bei der Aktualisierung des Mieters: ",
				'deleted' => "Fehler beim Löschen des Mieters: ",
				'not_allowed_change_status' => 'Sie können den Status nicht ändern.',
			],
			'building_card' => 'Liegenschaft zuweisen',
			'personal_details_card' => 'Persönliche Angaben',
			'account_info_card' => 'Benutzer-Login',
			'contact_info_card' => 'Kontaktdaten',
			'personal_data' => 'Meine Angaben',
			'my_documents' => 'Dokumente',
			'my_contract' => 'Mietvertrag',
			'contact_persons' => 'Kontakte',
			'no_contacts' => 'Keine Kontaktpersonen verfügbar.',
			'rent_end' => 'Mietende',
			'rent_start' => 'Mietbeginn',
			'rent_contract' => 'Mietvertrag',
			'contact' =>
				[
					'category' => 'Kategorie',															
				],
			'status' =>
				[
					'label' => 'Status',
					'active' => 'Aktiv',
					'not_active' => 'Inaktiv',
				],
		],
	'building' =>
		[
			'title' => 'Liegenschaften',
			'edit_title' => 'Liegenschaft bearbeiten',
			'add' => 'Liegenschaft hinzufügen',			
			'cancel' => 'Schliessen',							
			'deleted' => 'Liegenschaft erfolgreich gelöscht',
			'units' => 'Einheiten',			
			'saved' => 'Liegenschaft gespeichert',
			'floors' => 'Stockwerke',
			'basement' => 'Erdgeschoss',
			'attic' => 'Attikageschoss',
			'floor_nr' => 'Anzahl Stockwerke',
			'label' => 'Label',			
			'address_search' => 'Bitte Adresse eingeben.',
			'not_found' => 'Liegenschaft nicht gefunden.',
			'house_rules' => 'Hausordnung',
			'operating_instructions' => 'Benutzungsanleitungen',
			'care_instructions' => 'Pflegehinweise',
			'other' =>  'Sonstiges',
			'files' => 'Dokumente',
			'add_files' => 'Dokumente hinzufügen',
			'add_companies' => 'Dienstleister hinzufügen',
			'companies' => 'Dienstleister',
			'no_services' => 'Keine Partnerfirmen gewählt.',
			'select_media_category' => 'Kategorie der Mediendatei wählen',
			'district' => 'Überbauung',
			'managers' => 'Bewirtschafter',
			'house_nr' => 'Hausnummer',			
			'assign_managers' => 'Bewirtschafter zuweisen',
			'unassign_manager' => 'Entfernen',
			'managers_assigned' => 'Bewirtschafter zugewiesen',
			'occupied_units' => 'Vermietete Einheiten',
			'free_units' => 'Freie Einheiten',
			'manager' =>
				[
					'unassigned' => 'Bewirtschafter entfernt',
				],
			'document' =>
				[
					'uploaded' => 'Mediendatei hinaufgeladen',
					'deleted' => 'Mediendatei gelöscht',
				],
			'service' =>
				[
					'deleted' => 'Dienstleister entfernt',
				],
			'validation' =>
				[
					'name' =>
						[
							'required' => 'Name ist obligatorisch',
						],
					'floor_nr' =>
						[
							'required' => 'Stockwerk ist obligatorisch',
						],
					'description' =>
						[
							'required' => 'Beschreibung ist obligatorisch',
						],
					'label' =>
						[
							'required' => 'Label ist obligatorisch',
						],
					'address_id' =>
						[
							'required' => 'Adresse ist obligatorisch',
						],
				],
			'errors' => [
				'not_found' => "Liegenschaft nicht gefunden.",
				'manager_not_found' => "Bewirtschafter nicht gefunden",
				'deleted' => "Fehler beim Löschen von Mediendateien: ",
				'manager_assigned' => "Fehler beim Zuweisung des Bewirtschafters: ",
				'provider_deleted' => "Fehler beim Entfernen des Diestleisters: ",
			],
			'delete_building_modal' =>
				[
					'title' => 'Liegenschaft(en) löschen – Warnung!',
					'description_unit' => 'Der ausgewählten Liegenschaft sind Einheiten zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Option.',
					'description_request' => 'Der ausgewählten Liegenschaft sind Anfragen zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Option.',
					'description_both' => 'Der ausgewählten Liegenschaft sind Einheiten und Anfragen zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Optionen.',
					'delete_units' => ' Löschen',
					'dont_delete_units' => 'Nicht löschen',
					'delete_requests' => 'Löschen',
					'dont_delete_requests' => 'Nicht löschen',
				],
			'assigned_buildings' => 'Zugewiesene Liegenschaft(en)'
		],
	'unit' =>
		[
			'title' => 'Einheiten',
			'not_found' => 'Einheit nicht gefunden.',
			'add' => 'Einheit hinzufügen',
			'name' => 'Einheit-ID',								
			'deleted' => 'Einheit gelöscht',
			'saved' => 'Einheit gespeichert',
			'floor' => 'Stockwerk',
			'sq_meter' => 'Fläche',
			'room_no' => 'Anzahl Zimmer',
			'monthly_rent' => 'Monatsmiete',
			'building_search' => 'Bitte nach einer Liegenschaft suchen',
			'building' => 'Liegenschaft',			
			'basement' => 'Untergeschoss',
			'attic' => 'Attikageschoss',
			'empty_requests' => 'Keine Anfragen',
			'assigned_tenant' => 'Derzeitiger Mieter',			
			'tenant_assigned' => 'Mieter wurde erfolgreich zugewiesen',
			'tenant_unassigned' => 'Mieter wurde erfolgreich entfernt',
			'assignment' => 'Zugewiesene Mieter',
			'type' =>
				[
					'label' => 'Typ',
					'apartment' => 'Wohnung',
					'business' => 'Gewerbe',
				],
			'validation' =>
				[
					'name' =>
						[
							'required' => 'Name ist obligatorisch',
						],
					'building' =>
						[
							'required' => 'Liegenschaft ist obligatorisch',
						],
					'monthly_rent' =>
						[
							'required' => 'Monatsmiete ist obligatorisch',
						],
					'floor' =>
						[
							'required' => 'Stockwerk ist obligatorisch',
						],
					'room_no' =>
						[
							'required' => 'Nummer der Einheit ist obligatorisch',
						],
					'description' =>
						[
							'required' => 'Beschreibung ist obligatorisch',
						],
					'tenant' =>
						[
							'required' => 'Mieter ist erforderlich',
						]
				],
			'errors' => [
				'not_found' => "Einheit nicht gefunden",
				'create' => "Fehler beim Erstellen der Einheit: ",
				'update' => "Fehler beim Aktualisieren der Einheit: ",
				'tenant_assign' => "Fehler beim Zuweisen des Mieters: ",
				'tenant_not_assign' => "Fehler beim Zuweisen des Mieters",
				'tenant_not_found' => "Mieter nicht gefunden",
				'deleted' => "Fehler beim Löschen der Einheit: ",
			],
		],
	'address' =>
		[
			'add' => 'Adresse hinzufügen',			
			'name' => 'Address',								
			'country' => 'Kanton',
			'street' => 'Strasse',
			'street_nr' => 'Hausnummer',			
			'not_found' => 'Adresse nicht gefunden',
			'saved' => 'Adresse gespeichert',
			'state' =>
				[
					'label' => 'Kanton',
				],
			'validation' =>
				[
					'state' =>
						[
							'required' => 'Kanton ist obligatorisch',
						],
					'city' =>
						[
							'required' => 'Ort ist obligatorisch',
						],
					'street' =>
						[
							'required' => 'Strasse ist obligatorisch',
						],
					'street_nr' =>
						[
							'required' => 'Hausnummer ist obligatorisch',
						],
					'zip' =>
						[
							'required' => 'Postleitzahl  ist obligatorisch',
						],
				],
		],
	'post' =>
		[
			'title' => 'Pinnwand',
			'title_label' => 'Betreff',
			'content' => 'Inhalt',
			'preview' => 'Vorschau',
			'add' => 'Beitrag hinzufügen',
			'add_pinned' => 'Ankündigung erstellen',			
			'saved' => 'Beitrag wurde gespeichert',
			'view_incresead' => "Aufrufe erfolgreich gesteigert",
			'updated' => 'Beitrag wurde aktualisiert',
			'deleted' => 'Beitrag wurde gelöscht',			
			'edit_title' => 'Beitrag bearbeiten',						
			'likes' => 'Likes',
			'views' => 'Aufrufe',			
			'published_at' => 'Veröffentlichung',
			'publish' => 'Veröffentlicht',
			'unpublish' => 'Unpublish',
			'buildings' => 'Liegenschaften',
			'pinned' => 'Ankündigung',
			'notify_email' => 'Mieter benachrichtigen',
			'pinned_to' => 'Hervorheben bis',
			'comments' => 'Kommentare',
			'images' => 'Fotos und Dokumente',
			'category_default_image_label' => 'Möchten Sie dieses Bild verwenden?',			
			'placeholders' =>
				[
					'buildings' => 'Liegenschaft wählen',
					'search_provider' => 'Dienstleister suchen',
				],
			'type' =>
				[
					'label' => 'Typ',
					'post' => 'Post',
					'article' => 'Artikel',
					'new_neighbour' => 'Neuer Nachbar',
					'pinned' => 'Ankündigung',
				],
			'errors' => [
				'not_found' => "Beitrag nicht gefunden",
				'district_not_found' => "Überbbauung nicht gefunden",
				'building_not_found' => "Liegenschaft nicht gefunden",
				'provider_not_found' => "Dienstanbieter nicht gefunden",
				'deleted' => "Gelöschten Fehler buchen: ",
			],
			'status' =>
				[
					'label' => 'Status',
					'new' => 'Neu',
					'published' => 'Veröffentlicht',
					'unpublished' => 'Unveröffentlicht',
					'not_approved' => 'Nicht genehmigt',
				],
			'visibility' =>
				[
					'label' => 'Sichtbarkeit',
					'address' => 'Liegenschaft',
					'district' => 'Überbauung',
					'all' => 'Alle App-Nutzer',
				],
			'assignType' => 'Typ',					
			'buildingAlreadyAssigned' => 'Liegenschaft ist bereits einer Überauung zugewiesen.',
			'execution_interval' =>
				[
					'label' => 'Datum der Durchführung',
					'end' => 'Ende',
					'start' => 'Start',
					'separator' => 'Bis',
				],
			'category' =>
				[
					'label' => 'Kategorie',
					'general' => 'Generell',
					'maintenance' => 'Unterhalt',
					'electricity' => 'Elektro',
					'heating' => 'Heizung',
					'sanitary' => 'Sanitär',
				],
		],
	'service' =>
		[
			'title' => 'Dienstleister und Hauswartung',
			'add_title' => 'Neue Firma hinzufügen',
			'edit_title' => 'Firma bearbeiten',			
			'saved' => 'Dienstleister gespeichert',
			'deleted' => 'Dienstleister gelöscht',
			'category' => 'Gewerke',
			'electrician' => 'Elektro',
			'heating_company' => 'Heizung',
			'lift' => 'Lift',
			'sanitary' => 'Sanitär',
			'key_service' => 'Schlüsseldienst',
			'caretaker' => 'Hauswart',
			'real_estate_service' => 'Liegenschaftsdienst',			
			'contact_details' => 'Kontaktdaten',
			'user_credentials' => 'Logindaten',
			'company_details' => 'Firmendaten',
			'assignType' => 'Typ',						
			'buildingAlreadyAssigned' => 'Diese Liegenschaft ist bereits mit dieser Überbauung verbunden.',
			'placeholders' =>
				[
					'category' => 'Gewerk wählen',
				],
			'errors' => [
				'not_found' => "Dienstleister nicht gefunden",
				'create' => "Fehler beim Erstellen des Dienstleisters: ",
				'update' => "Fehler beim Aktualisieren des Dienstleisters: ",
				'deleted' => "Fehler beim Löschen des Dienstleisters: ",
				'district_not_found' => "Überbauung nicht gefunden",
				'building_not_found' => "Liegenschaft nicht gefunden",
				'building_already_assign' => "Liegenschaft wurde bereits einer Überbauung zugewiesen."
			],
		],
	'district' =>
		[
			'title' => 'Überbauungen',						
			'add' => 'Überbauung hinzufügen',
			"edit" => "Überbauung bearbeiten",			
			'saved' => 'Überbauung gespeichert',
			'deleted' => 'Überbauung gelöscht',
			'cancel' => 'Schliessen',
			'required' => 'Dies ist ein Pflichfeld!',
			'buildings' => 'Liegenschaften',
			'count_of_buildings' => 'Anzahl Liegenschaften',
			'errors' => [
				'not_found' => "Überbauung nicht gefunden",
				'deleted' => "Fehler durch den Bezirk gelöscht: ",
			],
		],
	'realEstate' =>
		[
			'title' => 'Einstellungen Liegenschaftsverwaltung',
			'settings' => 'Einstellungen',
			'iframe' => 'Iframe',
			'theme' => 'Thema',
			'login_variation' => 'Login-Variante',
			'login_variation_slider' => 'Möchten Sie den Schieberegler anzeigen?',
			'district_enable' => 'Überbauung',
			'marketplace_approval_enable' => 'Marktplatz aktivieren',
			'news_approval_enable' => 'Pinnwand-Beiträge zuerst prüfen',
			'comment_update_timeout' => 'Comment update timeout',
			'closed' => 'Geschlossen',
			'saved' => 'Gespeichert',
			'schedule' => 'Terminplanung',
			'endTime' => 'Ende',
			'startTime' => 'Start',
			'to' => 'An',
			'categories' => 'Kategorien',
			'contact_enable' => 'Dienstleister-Kontakte für Mieter aktivieren',
			'templates' => 'Vorlagen',
			'cleanify_email' => 'Cleanify email',
			'mail_encryption' => 'Verschlüsselung',
			'primary_color' => 'Primärfarbe',
			'accent_color' => 'Akzentfarbe',
			'iframe_enable' => 'Iframe aktivieren',
			'iframe_url' =>
				[
					'label' => 'Iframe URL',
					'validation' => 'Bitte geben Sie eine korrekte URL ein.',
				],
			"mail_from_name" =>
				[
					"label" => "Absender Name",
					"validation" => "Bitte den gewünschen Absender eingeben."
				],
			"mail_from_address" => [
				"label" => "Absender E-Mail",
				"required" => "Bitte eine E-Mail-Adresse eingeben.",
				"email" => "Bitte geben Sie eine gültige E-Mail-Adresse ein."
			],
			"mail_host" => [
				"label" => "Host",
				"validation" => "Der Host sollte eine gültige URL sein."
			],
			"mail_port" => [
				"label" => "Port",
				"validation" => "E-Mail-Port eingeben"
			],
			"mail_username" => [
				"label" => "Benutzername",
				"validation" => "E-Mail-Benutzernamen eingeben"
			],
			"mail_password" => [
				"label" => "Passwort",
				"validation" => "E-Mail-Passwort eingeben"
			],
			'errors' => [
				'not_found' => "Liegenschaften nicht gefunden",
				'update' => "Fehler beim aktualisieren der Liegenschaft(en):",
			],
		],
	'request' =>
		[
			'audits' => 'History',	
			'deleted' => 'Anfrage gelöscht',
			'title' => 'Übersicht Mieter-Anfragen',
			'created' => 'Erstellt',
			'saved' => 'Anfrage gespeichert',
			'prop_title' => 'Titel',
			'category' => 'Kategorie',			
			'edit_title' => 'Anfrage bearbeiten',
			'add_title' => 'Anfrage hinzufügen',
			'due_date' => 'Zu erledigen bis',
			'closed_date' => 'Erledigt am',
			'service' => 'Dienstleister',
			'created_by' => 'Erstellt durch',
			'is_public' => 'Öffentlich machen',
			'comments' => 'Mieter-Chat',
			'assigned_to' => 'Zuständig',
			'assign_providers' => 'Zuweisen',
			'assign_managers' => 'Zuweisen',			
			'notify' => 'Kommunikation',
			'public_legend' => 'Aktivieren Sie die Option, um die Anfrage allen Bewohnern einer Liegenschaft/Überbauung zu zeigen.',
			'conversation' => 'Chat-Mitteilungen',
			'conversation_created' => "Chat-Mitteilung wurde erstellt",
			'internal_notice_saved' => "Interne Notiz wurde gespeichert",
			'internal_notice_updated' => "Interne Notiz wurde aktualisiert",
			'internal_notice_deleted' => "Interne Notiz wurde gelöscht",
			'open_conversation' => 'Offen',
			'other_recipients' => 'Weitere Empfänger',
			'recipients' => 'Empfänger',			
			'images' => 'Fotos und Dokumente',
			'no_images_message' => 'Bisland keine Dateien hochgeladen',
			'request_details' => 'Beschreibung',
			'internal_notices' => 'Interne Notizen',
			'status_changed' => 'Status wurde geändert',
			'priority_changed' => 'Priorität wurde geändert',
			'assignment'=> 'Zugewiesene Personen/Firmen',
			'last_updated' => 'Last updated',
			'due_in' => 'Due in',
			'was_due_on' => 'Was due on',
			'due_on' => 'Due on',
			'media' =>
				[
					'added' => 'Mediendatei hinzugefügt',
					'removed' => 'Mediendatei entfernt.',
					'deleted' => 'Mediendatei gelöscht',
					'delete' => 'Löschen',
				],
			'priority' =>
				[
					'label' => 'Priorität',
					'urgent' => 'Dringend',
					'low' => 'Niedrig',
					'normal' => 'Normal',
				],
				'internal_priority' =>
				[
					'label' => 'Interne Priorität',
					'urgent' => 'Dringend',
					'low' => 'Niedrig',
					'normal' => 'Normal',
				],	
			'defect_location' =>
				[
					'label' => 'Örtlichkeit',
					'apartment' => 'Wohnung',
					'building' => 'Haus',
					'environment' => 'Ungebung',
				],
			'qualification' =>
				[
					'label' => 'Qualifikation',
					'none' => 'Keine',
					'optical' => 'Optisch',
					'sia' => 'SIA',
					'2_year_warranty' => '2-Jahresgarantie',
					'cost_consequences' => 'Kostenfolge',
				],
			'status' =>
				[
					'label' => 'Status',
					'received' => 'Erhalten',
					'assigned' => 'Avisiert',
					'in_processing' => 'In Bearbeitung',					
					'reactivated' => 'Reaktiviert',
					'done' => 'Erledigt',					
					'archived' => 'Archiviert',
					'solved' => "Erledigte",
					'pending' => "Ausstehende"
				],
			'category_options' =>
				[
					'disturbance' => 'Störung',
					'defect' => 'Defekt/Mangel',
					'other' => 'Sonstiges',
					'room' => 'Raum',
					'range' => 'Bereich',
					'component' => 'Bauteil',
					'acquisition' => 'Erfassungsphase',
					'cost' => 'Kostenfolge',
					'keywords' => 'Stichworte',
					'building_locations' => [
						'house_entrance' => 'Hauseingang',
						'staircase' => 'Treppenhaus',
						'elevator' => 'Lift',
						'car_park' => 'Tiefgarage',
						'washing' => 'Waschen/Trocknen',
						'heating' => 'Technik/Heizung',
						'electro' => 'Technik/Elektro',
						'facade' => 'Fassade',
						'roof' => 'Dach',
						'other' => 'Anderes'
					],
					'apartment_rooms' => [
						'bath' => 'Bad/WC',
						'shower' => 'Du/WC',
						'entrance' => 'Entrée',
						'passage' => 'Gang',
						'basement' => 'Keller',
						'kitchen' => 'Küche',
						'reduite' => 'Reduit',
						'habitation' => 'Wohnen',
						'room1' => 'Zimmer 1',
						'room2' => 'Zimmer 2',
						'room3' => 'Zimmer 3',
						'room4' => 'Zimmer 4',
						'all' => 'Alle',
						'other' => 'Anderes'
					],
					'acquisitions' => [
						'other' => 'Andere',
						'construction' => 'Bauphase (BP)',
						'shell' => 'Rohbauabnahme (RA)',
						'preliminary' => 'Vorabnahme (VA)',
						'work' => 'Bauabnahme (BA)',
						'surrender' => 'Übergabe (UEB)',
						'inspection' => 'Abnahme (AB)'
					],
					'costs' => [
						'landlord' => 'Vermieter',
						'tenant' => 'Mieter'
					]					
				],
			'placeholders' =>
				[
					'category' => 'Kategorie wählen',
					'priority' => 'Priorität wählen',
					'defect_location' => 'Bitte die Örtlichkeit angeben',
					'qualification' => 'Qualifikation wählen',
					'status' => 'Status wählen',
					'due_date' => 'Zu erledigen bis',
					'tenant' => 'Mieter suchen',
					'service' => 'Dienstleister suchen',
					'propertyManagers' => 'Bewirtschafter suchen',					
					'visibility' => 'Sichtbarkeit',
				],
			'mail' =>
				[
					'body' => 'Inhalt',
					'subject' => 'Betreff',
					'to' => 'An',
					'title' => 'Benachrichtigungen',
					'notify' => 'E-Mail senden',
					'bodyPlaceholder' => 'Bitte geben Sie hier eine Nachricht ein.',
					'provider' => 'Dienstleister',
					'manager' => 'Bewirtschafter',
					'cancel' => 'Schliessen',
					'send' => 'Senden',
					'cc' => 'CC',
					'bcc' => 'BCC',
					'success' => 'E-Mail wurde erfolgreich gesendet',
					'validation' =>
						[
							'required' => 'Dies ist ein Pflichfeld',
							'email' => 'Bitte eine gültige E-Mail Adresse eingeben',
						],
					'fail_cc' => 'CC/BCC/TO müssen korrekte Email Adressen enthalten.',
				],
			'userType' =>
				[
					'label' => 'Typ',
					'provider' => 'Dienstleister',
					'manager' => 'Bewirtschafter',
					'admin' => 'Administrator',
				],
			'visibility' =>
				[
					'label' => 'Sichtbarkeit',
					'tenant' => 'Nur ich',
					'district' => 'Überbauung',
					'building' => 'Liegenschaft',
				],
			'errors' => [
				'not_found' => 'Anfrage nicht gefunden',
				'not_allowed_change_status' => 'Sie dürfen den Status nicht ändern.',
				'provider_not_found' => 'Dienstleister nicht gefunden',
                'tag_not_found' => 'Tag nicht gefunden',
				'user_not_found' => 'Benutzer nicht gefunden',
				'conversation_not_found' => "Konversation nicht gefunden",
				'statistics_error' => "Statistik-Fehler: ",
				'internal_notice_not_found' => "Interne Notiz nicht gefunden",
				'deleted' => "Service Request gelöschter Fehler: ",
			],
			'requestID' => 'Anfrage-ID',
			'requestCategory' => 'Anfrage-Kategorie ',
			'actions' => 'Aktionen',
		],
	'requestCategory' =>
		[
			'title' => 'Anfrage Kategorien',
			'add' => 'Kategorie hinzufügen',								
			'cancel' => 'Schliessen',
			'required' => 'Dies ist ein Pflichtfeld',
			'parent' => 'Hauptkategorie',
			'errors' => [
				'not_found' => "Anfrage-Kategorie nicht gefunden",
				'parent_not_found' => "Die übergeordnete Anfrage-Kategorie wurde nicht gefunden",
				'multiple_level_not_found' => "Mehrstufig verschachtelte Kategorien sind nicht erlaubt.",
				'used_by_request' => "Diese Kategorie wird in Anfragen verwendet",
			]
		],
	'propertyManager' =>
		[
			'title' => 'Bewirtschafter',
			'add' => 'Bewischafter hinzufügen',			
			'saved' => 'Bewirtschafter wurde gespeichert',
			'deleted' => 'Bewirtschafter wurde gelöscht',
			'edit_title' => 'Bewirtschafter bearbeiten',			
			'firstName' => 'Vorname',
			'lastName' => 'Name',			
			'profession' => 'Position',
			'slogan' => 'Slogan',
			'linkedin_url' => 'Linkedin',
			'xing_url' => 'Xing',			
			'password' => 'Passwort',
			'confirm_password' => 'Passwort bestätigen',			
			'building_card' => 'Liegenschaft(en) zuweisen',
			'details_card' => 'Details & Konto',
			'no_buildings' => 'Keine Liegenschaft zugewiesen',
			'add_buildings' => 'Liegenschaft hinzufügen',
			'buildings_search' => 'Liegenschaft suchen',
			'districts' => 'Überbauungen',						
			'delete_with_reassign_modal' =>
				[
					'title' => 'Andere Person zuweisen und dann Benutzer löschen',
					'description' => 'Der gewählte Bewirtschafter ist mit Liegenschaften verbunden. Sie können die Liegenschaft(en) an eine anderen Person zuweisen. Wählen Sie hierzu einen Bewirtschafter aus der Liste aus.',
					'search_title' => 'Bewirtschafter suchen',
				],
			'delete_without_reassign' => 'Löschen',
			'profile_card' => 'User Profile',
			'social_card' => 'Social Media',
			'assignType' => 'Typ',
			'buildingAlreadyAssigned' => 'Liegenschaft ist bereits einer Überbauung zugewiesen.',
			'errors' => [
				'not_found' => "Bewirtschafter nicht gefunden",
				'create' => "Fehler beim Erstellen des Bewirtschafters: ",
				'update' => "Fehler beim Aktualisieren des Bewirtschafters:",
				'district_not_found' => "Überbauung nicht gefunden",
				'building_not_found' => "Liegenschaft nicht gefunden",
				'building_already_assign' => "Die Liegenschaft ist dieser Überbauung bereits zugewiesen.",
				'building_assign_deleted_property_manager' => "Sie können einem gelöschten Bewirtschafter keine Liegenschaft(en) zuordnen.",
				'deleted' => "Bewirtschafter löschte Fehler: ",
			],
		],
	'product' =>
		[
			'title' => 'Marktplatz',
			'add' => 'Inserat hinzufügen',
			'edit_title' => 'Inserat bearbeiten',
			'delete_action' => 'Löschen',
			'content' => 'Inhalt',
			'product_title' => 'Titel',
			'published_at' => 'Hinzugefügt am',
			'publish' => 'Veröffentlicht',
			'unpublish' => 'Unveröffentlicht',
			'likes' => 'Likes',			
			'saved' => 'Inserat gespeichert',
			'deleted' => 'Inserat gelöscht',
			'comments' => 'Kommentare',			
			'contact' => 'Kontaktdaten',
			'price' => 'Preis',
			'comment_created' => "Kommentar erfolgreich erstellt",
			'errors' => [
				'not_found' => "Produkt nicht gefunden",
				'deleted' => "Fehler beim Löschen des Produkts: ",
			],
			'type' =>
				[
					'label' => 'Typ',
					'sell' => 'Verkaufen',
					'lend' => 'Verleihen',
					'service' => 'Dienstleistung',
					'giveaway' => 'Verschenken',
				],
			'status' =>
				[
					'label' => 'Status',
					'published' => 'Veröffentlicht',
					'unpublished' => 'Unveröffentlicht',
				],
			'visibility' =>
				[
					'label' => 'Sichtbarkeit',
					'address' => 'Meine Nachbarn',
					'district' => 'Überbauung',
					'all' => 'Alle App-Nutzer',
				],
		],
	'template' =>
		[				
			'saved' => 'Vorlage gespeichert',
			'deleted' => 'Vorlage gelöscht',
			'add' => 'Hinzufügen',
			'title' => 'Vorlagen',
			'subject' => 'Betreff',
			'body' => 'Inhalt',
			'category' => 'Kategorie',
			'tags' => 'Tags',
			'placeholders' =>
				[
					'category' => 'Kategorie wählen',
				],
			'errors' => [
				'not_found' => "Vorlage nicht gefunden",
			]
		],
	'cleanify' =>
		[
			'pageTitle' => 'Cleanify request',
			'title' => 'Anrede',
			'lastName' => 'Name',
			'firstName' => 'Vorname',
			'address' => 'Strasse + Nr',					
			'save' => 'Anfragen einsenden',
			'success' => 'Ihr Anfrage wurde erfolgreich an Cleanify übertragen.',
			'terms_and_conditions' => 'Accept Terms & Conditions',
			'terms_text' => 'Terms text here, long text',
		],
];