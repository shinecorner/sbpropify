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
			'edit_action' => 'Öffnen',
			'delete' => 'Löschen',
			'name' => 'Name',
			'phone' => 'Telefon',
			'date' => 'Datum',
			'email' => 'E-Mail',
			'id' => 'ID',
			'add' => 'Benutzer hinzufügen',
			'save' => 'Speichern',
			'saved' => 'Benutzer erfolgreich gespeichert.',
			'deleted' => 'Benutzer erfolgreich gelöscht.',
			'edit' => 'Bearbeiten',
			'not_found' => 'Benutzer nicht gefunden.',
			'profile_image' => 'Profil-Bild',
			'profile_text' => 'Profil-Text',
			'avatar_uploaded' => 'Profilbild aktualisiert',
			'logo_uploaded' => 'Logo aktualisiert.',
			'logo' => 'Firmenlogo',
			'address' => 'Adresse',
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
			'save' => 'Speichern',
			'saved' => 'Mieter gespeichert',
			'deleted' => 'Mieter gelöscht',
			'status_changed' => 'Status geändert',
			'password_reset' => 'Passwort erfolgreich zurückgesetzt',
			'update' => 'Update',
			'name' => 'Name',
			'first_name' => 'Vorname',
			'last_name' => 'Name',
			'birth_date' => 'Geburtsdatum',
			'language' => 'Sprache',
      'nation' => 'Nation',
			'mobile_phone' => 'Mobile',
			'work_phone' => 'Arbeit',
			'email' => 'E-Mail',
			'personal_phone' => 'Telefon privat',
			'private_phone' => 'Telefon privat',
			'created_date' => 'Erstelldatum',
			'created_at' => 'Datum',
			'edit' => 'Bearbeiten',
			'delete' => 'Löschen',
			'id' => 'ID',
			'details' => 'Details',
			'contract' => 'Mietvertrag',
			'posts' => 'Beiträge',
			'products' => 'Marktplatz',
			'requests' => 'Anfragen',
			'company' => 'Firmenname',
			'no_building' => 'Keine Liegenschaft(en) zugewiesen.',
			'media' =>
				[
					'deleted' => 'Mediendatei gelöscht',
					'uploaded' => 'Mediendatei hochgeladen',
				],
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
			'search' => 'Suchen',
			'confirmDelete' =>
				[
					'title' => 'Warnung: Der Mieter wird endgültig gelöscht.',
					'text' => 'Sind Sie sicher, dass Sie fortfahren wollen?',
				],
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
					'name' => 'Name',
					'email' => 'E-Mail',
					'phone' => 'Telefon',
				],
			'titles' =>
				[
					'mr' => 'Herr',
					'mrs' => 'Frau',
					'company' => 'Firma',
				],
			'status' =>
				[
					'label' => 'Status',
					'active' => 'Aktiv',
					'not_active' => 'Inaktiv',
				],
			'confirmChange' =>
				[
					'title' => 'Wollen Sie den Status wirklich ändern?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
		],
	'building' =>
		[
			'title' => 'Liegenschaften',
			'edit_title' => 'Liegenschaft bearbeiten',
			'add' => 'Liegenschaft hinzufügen',
			'name' => 'Name',
			'cancel' => 'Schliessen',
			'created_at' => 'Datum',
			'edit' => 'Öffnen',
			'delete' => 'Löschen',
			'deleted' => 'Liegenschaft erfolgreich gelöscht',
			'units' => 'Einheiten',
			'save' => 'Speichern',
			'saved' => 'Liegenschaft gespeichert',
			'floors' => 'Stockwerke',
			'basement' => 'Erdgeschoss',
			'attic' => 'Attikageschoss',
			'description' => 'Beschreibung',
			'floor_nr' => 'Anzahl Stockwerke',
			'label' => 'Label',
			'address' => 'Adresse',
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
			'details' => 'Details',
			'select_media_category' => 'Kategorie der Mediendatei wählen',
			'district' => 'Überbauung',
			'tenants' => 'Mieter',
			'managers' => 'Bewirtschafter',
			'requests' => 'Anfragen',
			'house_nr' => 'Hausnummer',
			'assign' => 'Zuweisen',
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
			'confirmDelete' =>
				[
					'title' => 'Wenn Sie weiterfahren wird die Liegenschaft unwiderruflich gelöscht.',
					'text' => 'Wollen Sie wirklich weiterfahren?',
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
			'requestStatuses' =>
				[
					'total' => 'Total Anfragen',
					'received' => 'Neu',
					'assigned' => 'Avisiert',
					'in_processing' => 'In Bearbeitung',
					'reactivated' => 'Reaktiviert',
					'done' => 'Erledigt',
					'archived' => 'Archiviert',
					'solved' => "Erledigte Anfragen",
					'pending' => "Ausstehende Anfragen"
				],
			'placeholders' =>
				[
					'search' => 'Suchen',
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
			'tenantType' => [
				'attached' => 'Mieter wurde zugewiesen.',
				'detached' => 'Mieter wurde entfernt.'
			],
			'name' => 'Einheit-ID',
			'created_at' => 'Datum',
			'edit' => 'Einheit bearbeiten',
			'delete' => 'Löschen',
			'deleted' => 'Einheit gelöscht',
			'save' => 'Speichern',
			'saved' => 'Einheit gespeichert',
			'floor' => 'Stockwerk',
			'sq_meter' => 'Fläche',
			'room_no' => 'Anzahl Zimmer',
			'monthly_rent' => 'Monatsmiete',
			'building_search' => 'Bitte nach einer Liegenschaft suchen',
			'building' => 'Liegenschaft',
			'description' => 'Beschreibung',
			'basement' => 'Untergeschoss',
			'attic' => 'Attikageschoss',
			'requests' => 'Anfragen',
			'tenant' => 'Mieter',
			'empty_requests' => 'Keine Anfragen',
			'assigned_tenant' => 'Derzeitiger Mieter',
			'assign' => 'Zuweisen',
			'tenant_assigned' => 'Mieter wurde erfolgreich zugewiesen',
			'tenant_unassigned' => 'Mieter wurde erfolgreich entfernt',
			'assignment' => 'Zugewiesene Mieter',
			'type' =>
				[
					'label' => 'Typ',
					'apartment' => 'Wohnung',
					'business' => 'Gewerbe',
				],
			'confirmDelete' =>
				[
					'title' => 'Diese Einheit wird endgültig gelöscht',
					'text' => 'Sind Sie sicher, dass Sie fortfahren wollen?',
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
			'placeholders' =>
				[
					'search' => 'Suchen',
					'select' => 'Wählen',
				],
		],
	'address' =>
		[
			'add' => 'Adresse hinzufügen',
			'created_at' => 'Datum',
			'name' => 'Address',
			'edit' => 'Öffnen',
			'delete' => 'Entfernen',
			'save' => 'Speichern',
			'city' => 'Ort',
			'country' => 'Kanton',
			'street' => 'Strasse',
			'street_nr' => 'Hausnummer',
			'zip' => 'Postleitzahl',
			'not_found' => 'Adresse nicht gefunden',
			'saved' => 'Adresse gespeichert',
			'confirmDelete' =>
				[
					'title' => 'Die Liegenschaft wird endgültig gelöscht.',
					'text' => 'Sind Sie sicher, dass Sie fortfahren wollen?',
				],
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
			'save' => 'Speichern',
			'saved' => 'Beitrag wurde gespeichert',
			'view_incresead' => "Aufrufe erfolgreich gesteigert",
			'updated' => 'Beitrag wurde aktualisiert',
			'deleted' => 'Beitrag wurde gelöscht',
			'edit' => 'Öffnen',
			'edit_title' => 'Beitrag bearbeiten',
			'show' => 'Vorschau',
			'user' => 'Benutzer',
			'delete' => 'Löschen',
			'likes' => 'Likes',
			'tenants' => 'Mieter',
			'views' => 'Aufrufe',
			'details' => 'Beitragsdetails',
			'published_at' => 'Veröffentlichung',
			'publish' => 'Veröffentlicht',
			'unpublish' => 'Unpublish',
			'buildings' => 'Liegenschaften',
			'pinned' => 'Ankündigung',
			'notify_email' => 'Mieter benachrichtigen',
			'pinned_to' => 'Hervorheben bis',
			'comments' => 'Kommentare',
			'images' => 'Fotos und Dokumente',
			'details_title' => 'Vorschau',
			'placeholders' =>
				[
					'buildings' => 'Liegenschaft wählen',
					'search' => 'Liegenschaft suchen',
					'search_provider' => 'Dienstleister suchen',
				],
			'media' =>
				[
					'deleted' => 'Mediendatei wurde gelöscht',
					'uploaded' => 'Mediendatei wurde hochgeladen',
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
			'confirmChange' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
			'assignType' => 'Typ',
			'unassign' => 'Entfernen',
			'assign' => 'Zuweisen',
			'attached' =>
				[
					'building' => 'Liegenschaft wurde zugewiesen.',
					'district' => 'Überbauung wurde zugewiesen.',
					'provider' => 'Dienstleister wurde zugewiesen.',
				],
			'detached' =>
				[
					'building' => 'Liegenschaft wurde entfernt',
					'district' => 'Überbbauung wurde entfernt',
					'provider' => 'Dienstleister wurde wurde entfernt',
				],
			'buildingAlreadyAssigned' => 'Liegenschaft ist bereits einer Überauung zugewiesen.',
			'confirmUnassign' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
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
			'edit' => 'Öffnen',
			'delete' => 'Löschen',
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
			'name' => 'Name',
			'requests' => 'Anfragen',
			'contact_details' => 'Kontaktdaten',
			'user_credentials' => 'Logindaten',
			'company_details' => 'Firmendaten',
			'assignType' => 'Typ',
			'unassign' => 'Entfernen',
			'assign' => 'Zuweisen',
			'attached' =>
				[
					'building' => 'Liegenschaft wurde zugewiesen',
					'district' => 'Überbauung wurde entfernt',
				],
			'detached' =>
				[
					'building' => 'Liegenschaft wurde entfernt',
					'district' => 'Überbauung wurde entfernt',
				],
			'buildingAlreadyAssigned' => 'Diese Liegenschaft ist bereits mit dieser Überbauung verbunden.',
			'confirmUnassign' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
			'placeholders' =>
				[
					'search' => 'Suchen',
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
			'name' => 'Name',
			'description' => 'Beschreibung',
			'add' => 'Überbauung hinzufügen',
			"edit" => "Überbauung bearbeiten",
			'save' => 'Speichern',
			'saved' => 'Überbauung gespeichert',
			'edit_action' => 'Öffnen',
			'delete' => 'Löschen',
			'deleted' => 'Überbauung gelöscht',
			'cancel' => 'Schliessen',
			'required' => 'Dies ist ein Pflichfeld!',
			'details' => 'Überbauung Details',
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
			'details' => 'Details',
			'settings' => 'Einstellungen',
			'iframe' => 'Iframe',
			'theme' => 'Thema',
			'requests' => 'Anfragen',
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
			'edit' => 'Öffnen',
			'delete' => 'Löschen',
			'deleted' => 'Anfrage gelöscht',
			'title' => 'Übersicht Mieter-Anfragen',
			'created' => 'Erstellt',
			'saved' => 'Anfrage gespeichert',
			'prop_title' => 'Titel',
			'description' => 'Anfrage Informationen',
			'category' => 'Kategorie',
			'address' => 'Adresse',
			'edit_title' => 'Anfrage bearbeiten',
			'add_title' => 'Anfrage hinzufügen',
			'tenant' => 'Mieter',
			'due_date' => 'Zu erledigen bis',
			'closed_date' => 'Erledigt am',
			'service' => 'Dienstleister',
			'created_by' => 'Erstellt durch',
			'is_public' => 'Öffentlich machen',
			'comments' => 'Mieter-Chat',
			'assigned_to' => 'Zuständig',
			'assign_providers' => 'Zuweisen',
			'assign_managers' => 'Zuweisen',
			'unassign' => 'Entfernen',
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
			'assign' => 'Zuweisen',
			'images' => 'Fotos und Dokumente',
			'no_images_message' => 'Bisland keine Dateien hochgeladen',
			'request_details' => 'Beschreibung',
			'internal_notices' => 'Interne Notizen',
			'status_changed' => 'Status wurde geändert',
			'priority_changed' => 'Priorität wurde geändert',
			'assignment'=> 'Zugewiesene Personen/Firmen',
			'last_updated' => 'Last updated',
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
					'in_processing' => 'In Bearbeitung',
					'assigned' => 'Avisiert',
					'done' => 'Erledigt',
					'reactivated' => 'Reaktiviert',
					'archived' => 'Archiviert',
				],
			'category_options' =>
				[
					'disturbance' => 'Störung',
					'defect' => 'Defekt/Mangel',
					'order_documents' => 'Unterlagen bestellen',
					'order_a_payment_slip' => 'Einzahlungsschein(e) bestellen',
					'questions_about_the_tenancy' => 'Fragen zum Mietverhältnis',
					'other' => 'Sonstiges',
					'environment' => 'Umgebung',
					'house' => 'Haus',
					'apartment' => 'Wohnung',					
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
					'search' => 'Suchen',
					'visibility' => 'Sichtbarkeit',
				],
			'confirmChange' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
			'confirmUnassign' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
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
			'attached' =>
				[
					'services' => 'Dienstleister wurde zugewiesen.',
					'managers' => 'Bewirtschafter wurde zugewiesen.',
					'users' => 'Tag erfolgreich zugewiesen',
                    'tags' => 'Tag assigned successfully',
				],
			'detached' =>
				[
					'service' => 'Dienstleister wurde entfernt.',
					'manager' => 'Bewirtschafter wurde entfernt.',
					'admin' => 'Administrator wurde entfernt.',
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
			'edit' => 'Öffnen',
			'delete' => 'Löschen',
			'name' => 'Name',
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
			'save' => 'Speichern',
			'saved' => 'Bewirtschafter wurde gespeichert',
			'deleted' => 'Bewirtschafter wurde gelöscht',
			'edit' => 'Öffnen',
			'edit_title' => 'Bewirtschafter bearbeiten',
			'delete' => 'Löschen',
			'firstName' => 'Vorname',
			'lastName' => 'Name',
			'name' => 'Name',
			'profession' => 'Position',
			'slogan' => 'Slogan',
			'linkedin_url' => 'Linkedin',
			'xing_url' => 'Xing',
			'email' => 'E-Mail',
			'password' => 'Passwort',
			'confirm_password' => 'Passwort bestätigen',
			'phone' => 'Telefon',
			'building_card' => 'Liegenschaft(en) zuweisen',
			'details_card' => 'Details & Konto',
			'no_buildings' => 'Keine Liegenschaft zugewiesen',
			'add_buildings' => 'Liegenschaft hinzufügen',
			'buildings_search' => 'Liegenschaft suchen',
			'districts' => 'Überbauungen',
			'requests' => 'Anfragen',
			'assign' => 'Zuweisen',
			'unassign' => 'Entfernen',
			'delete_with_reassign_modal' =>
				[
					'title' => 'Andere Person zuweisen und dann Benutzer löschen',
					'description' => 'Der gewählte Bewirtschafter ist mit Liegenschaften verbunden. Sie können die Liegenschaft(en) an eine anderen Person zuweisen. Wählen Sie hierzu einen Bewirtschafter aus der Liste aus.',
					'search_title' => 'Bewirtschafter suchen',
				],
			'delete_without_reassign' => 'Löschen',
			'profile_card' => 'User Profile',
			'social_card' => 'Social Media',
			'titles' =>
				[
					'mr' => 'Herr',
					'mrs' => 'Frau',
				],
			'assignType' => 'Typ',
			'placeholders' =>
				[
					'search' => 'Suchen',
				],
			'attached' =>
				[
					'building' => 'Liegenschaft wurde zugewiesen.',
					'district' => 'Überbauung wurde zugewiesen',
				],
			'detached' =>
				[
					'building' => 'Liegenschaft wurde entfernt.',
					'district' => 'Überbauung wurde entfernt.',
				],
			'buildingAlreadyAssigned' => 'Liegenschaft ist bereits einer Überbauung zugewiesen.',
			'confirmUnassign' =>
				[
					'title' => 'Wollen Sie wirklich weiterfahren?',
					'warning' => 'Bitte bestätigen',
					'confirmBtnText' => 'Ja',
					'cancelBtnText' => 'Schliessen',
				],
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
			'edit' => 'Öffnen',
			'delete_action' => 'Löschen',
			'show' => 'Vorschau',
			'details' => 'Details zum Angebot',
			'delete' => 'Inserat löschen',
			'content' => 'Inhalt',
			'product_title' => 'Titel',
			'published_at' => 'Hinzugefügt am',
			'publish' => 'Veröffentlicht',
			'unpublish' => 'Unveröffentlicht',
			'likes' => 'Likes',
			'save' => 'Speichern',
			'saved' => 'Inserat gespeichert',
			'deleted' => 'Inserat gelöscht',
			'comments' => 'Kommentare',
			'user' => 'Benutzer',
			'contact' => 'Kontaktdaten',
			'price' => 'Preis',
			'comment_created' => "Kommentar erfolgreich erstellt",
			'media' =>
				[
					'deleted' => 'Dokument/Foto gelöscht',
					'uploaded' => 'Dokument/Foto hochgeladen',
				],
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
			'name' => 'Name',
			'edit' => 'Öffnen',
			'delete' => 'Löschen',
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
			'city' => 'Ort',
			'zip' => 'Postleitzahl',
			'email' => 'E-Mail',
			'phone' => 'Telefon',
			'save' => 'Anfragen einsenden',
			'success' => 'Ihr Anfrage wurde erfolgreich an Cleanify übertragen.',
			'terms_and_conditions' => 'Accept Terms & Conditions',
			'terms_text' => 'Terms text here, long text',
		],
];
