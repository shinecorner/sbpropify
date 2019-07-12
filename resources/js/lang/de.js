import enLocale from 'element-ui/lib/locale/lang/en';

export default {
    ...enLocale,
    en: 'EN',
    fr: 'FR',
    it: 'IT',
    de: 'DE',
    yes: 'Yes',
    languages: {
        fr: 'Français',
        it: 'Italiano',
        de: 'Deutsch',
        en: 'English'
    },
    days: {
        monday: 'Montag',
        tuesday: 'Dienstag',
        wednesday: 'Mittwoch',
        thursday: 'Donnerstag',
        friday: 'Freitag',
        saturday: 'Samstag',
        sunday: 'Sonntag'
    },
    no: 'Nein',
    none: 'None',
    all: 'Alle',
    loadMore: 'Mehr laden',
    account: "Konto",
    unauthenticated: 'Unauthenticated',
    logged_out: 'Ausgeloggt',
    logged_in: 'Eingeloggt',
    invalid_credentials: 'Die eingegebenen Daten stimmen nicht.',
    server_error: 'Server Fehler',
    reset_password: 'Passwort zurücksetzen',
    reset_password_mail: 'Passwort per E-Mail zurücksetzen.',
    reset_password_mail_sent: 'Eine E-Mail wurde an Sie gesendet. Bitte fahren Sie dort weiter.',
    back_to_login: 'Zurück zum Login',
    forgot_password: 'Passwort vergessen',
    remember_me: 'Angemeldet bleiben',
    password: 'Passwort',
    change_password: 'Passwort ändern',
    new_password: 'Neues Passwort',
    old_password: 'Altes Passwort',
    new_password_confirmation: "Neues Passwort bestätigen",
    change: 'Ändern',
    cancel: 'Schliessen',
    confirm: 'Bestätigen',
    confirm_password: 'Passwort bestätigen',
    incorrect_password: "Altes Passwort stimmt nicht",
    password_changed: "Passwort erfolgreich geändert",
    details_saved: 'Angaben gespeichert',
    password_validation: {
        required: "Passwort ist obligatorisch",
        confirm: 'Passwort bestätigen',
        match: 'Die eingegebenen Passwörter sind nicht identisch.',
        min: "Das Passwort muss aus mind. 6 Zeichen bestehen.",
        old_password_min: "Das alte Passwort müsste aus mind. 6 Zeichen bestehen.",
        old_password_required: 'Das alte Passwort wird benötigt.'
    },
    email: 'E-Mail',
    email_validation: {
        required: 'E-Mail ist obligatorisch',
        email: 'Bitte geben Sie eine gültige E-Mail Adresse ein.',
    },
    token_invalid: "Invalid token",
    login: 'Login',
    menu: {
        dashboard: 'Dashboard',
        news: 'Pinnwand',
        requests: 'Service Center',
        all_requests: 'Anfragen',
        marketplace: 'Marktplatz',
        settings: 'Einstellungen',
        logout: 'Anmelden',
        profile: 'Profil',
        users: 'Benutzer',
        employees: 'Bewirtschafter',
        companies: 'Partnerfirmen',
        admins: 'Administratoren',
        super_admins: 'Super Administratoren',
        home_owners: 'Eigentümer',
        registered: 'Registriert',
        about: 'Über',
        feedback: 'Feedback',
        tenants: 'Mieter',
        buildings: 'Liegenschaften',
        all_buildings: 'Objekte',
        units: 'Einheiten',
        addresses: 'Liegenschaften',
        posts: 'Pinnwand',
        districts: 'Überbauungen',
        products: 'Marktplatz',
        requestCategories: 'Kategorien',
        services: "Partnerfirmen",
        activity: 'Aktivität',
        propertyManagers: 'Bewirtschafter',
        templates: 'Vorlagen'
    },
    dashboard:{
        statistics: 'Statistiken',        
        requests_by_creation_date: 'Anfragen nach Erstellungsdatum',
        requests_by_status: 'Anfragen nach Status',
        requests_by_category: 'Anfragen nach Kategorie',        
        each_hour_request: 'Jede Stunde fordert',
    },
    pages: {
        profile: {
            pageTitle: 'Profil-Einstellungen',
            profile: 'Profil',
            account: 'Konto',
            security: 'Sicherheit',
            notifications: 'Benachrichtigungen'
        },
        user: {
            title: 'Users'
        },
        request_activities: {
            title: 'Tracking von Anfrage-Aktivitäten'
        },
        tenant: {
            title: 'Mieter'
        }
    },
    support: "Support",
    actions: {
        label: "Operations",
        edit: 'Öffnen',
        add: 'Add',
        delete: 'Löschen',
        create: 'Erstellen',
        view: 'Details',
        save: 'Speichern',
        close: 'Schliessen',
        saveAndClose: 'Speichern & schliessen',
        upload: 'Upload'
    },
    models: {
        user: {
            edit_action: 'Öffnen',
            delete: 'Löschen',
            name: 'Name',
            phone: 'Telefon',
            date: 'Datum',
            email: 'E-Mail',
            id: 'ID',
            add: 'Nutzer hinzufügen',
            save: 'Speichern',
            saved: 'Benutzer erfolgreich gespeichert',
            edit: 'Benutzer bearbeiten',
            not_found: 'Benutzer nicht gefunden',
            profile_image: 'Profil-Bild',
            profile_text: 'Profil-Text',
            avatar_uploaded: 'Avatar aktualisiert',
            logo_uploaded: 'Logo aktualisiert',
            logo: 'Logo',
            address: 'Addresse',
            blank_pdf: 'Blank pdf',
            realEstateSaved: "Real Estate settings saved",
            validation: {
                name: {
                    required: 'Name ist obligatorisch'
                },
                role: {
                    required: 'Role ist obligatorisch'
                }
            }
        },
        tenant: {
            edit_title: 'Mieter bearbeiten',
            download_credentials: 'Download credentials',
            send_credentials: 'Send credentials',
            credentials_sent: 'Credentials sent',
            credentials_send_fail: 'Credentials file not found. Try updating the tenant password to regenerate it',
            credentials_download_failed: 'Credentials file not found. Try updating the tenant password to regenerate it',
            add: 'Mieter hinzufügen',
            save: 'Speichern',
            update: 'Update',
            name: 'Name',
            first_name: 'Vorname',
            last_name: 'Name',
            birth_date: 'Geburtsdatum',
            title: 'Anrede',
            mobile_phone: 'Mobile',
            work_phone: 'Arbeit',
            email: 'E-Mail',
            personal_phone: 'Telefon privat',
            private_phone: 'Telefon privat',
            created_at: 'Datum',
            edit: 'Öffnen',
            delete: 'Löschen',
            id: 'ID',
            details: 'Details',
            contract: 'Mietvertrag',
            posts: 'Beiträge',
            products: 'Marktplatz',
            requests: 'Anfragen',
            company: 'Company name',
            no_building: 'Keine Liegenschaften',
            building: {
                name: 'Liegenschaft'
            },
            unit: {
                name: 'Einheit'
            },
            search_building: 'Liegenschaft suchen',
            search_unit: 'Einheit suchen',
            confirmDelete: {
                title: "Der Mieter wird endgültig gelöscht",
                text: 'Sind Sie sicher?'
            },
            validation: {
                first_name: {
                    required: 'Vorname ist obligatorisch'
                },
                last_name: {
                    required: 'Name ist obligatorisch'
                },
                birth_date: {
                    required: 'Geburtsdatum ist obligatorisch'
                },
                building: {
                    required: 'Liegenschaft ist obligatorisch',
                },
                unit: {
                    required: 'Einheit ist obligatorisch',
                },
                title: {
                    required: 'Anrede ist obligatorisch',
                },
            },
            building_card: 'Liegenschaft zuweisen',
            personal_details_card: 'Persönliche Angaben',
            account_info_card: 'Benutzer-Login',
            contact_info_card: 'Kontaktdaten',
            personal_data: 'Meine Angaben',
            my_documents: 'Dokumente',
            my_contract: 'Mietvertrag',
            contact_persons: 'Kontakte',
            no_contacts: 'Keine Kontakte verfügbar.',
            rent_end: 'Mietende',
            rent_start: 'Mietbeginn',
            rent_contract: 'Mietvertrag',
            contact: {
                category: 'Kategorie',
                name: 'Name',
                email: 'E-Mail',
                phone: 'Telefon'
            },
            titles: {
                mr: 'Herr',
                mrs: 'Frau',
                company: 'Firma'
            },
            status: {
                label: 'Status',
                active: 'Aktiv',
                not_active: 'Deaktiv'
            },
            confirmChange: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            }
        },
        building: {
            title: 'Liegenschaften',
            edit_title: 'Liegenschaft bearbeiten',
            add: 'Liegenschaft hinzufügen',
            name: 'Name',
            cancel: 'Schliessen',
            created_at: 'Datum',
            edit: 'Öffnen',
            delete: 'Löschen',
            units: 'Einheiten',
            save: 'Speichern',
            saved: 'Liegenschaft gespeichert',
            floors: 'Stockwerke',
            basement: 'Erdgeschoss',
            attic: 'Attika',
            description: 'Beschreibung',
            floor_nr: 'Anzahl der Stockwerke',
            label: "Label",
            address: 'Adresse',
            address_search: 'Bitte Adresse eingeben',
            not_found: 'Liegenschaft nicht gefunden',
            house_rules: 'Hausordnung',
            operating_instructions: 'Nenutzungsanleitungen',
            files: 'Dokumente',
            add_files: 'Dokumente hinzufügen',
            add_companies: 'Partnerfirma hinzufügen',
            companies: 'Partnerfirmen',
            no_services: 'Keine Partnerfirmen gewählt.',
            details: 'Details',
            select_media_category: 'Selected media category',
            district: 'Überbauung',
            tenants: 'Mieter',
            managers: 'Bewirtschafter',
            requests: 'Anfragen',
            house_nr: 'Hausnummer',
            assign: 'Zuweisen',
            assign_managers: 'Bewirtschafter zuweisen',
            unassign_manager: 'Entfernen',
            managers_assigned: 'Bewirtschafter zugewiesen',
            occupied_units: "Vermietete Einheiten",
            free_units: "Freie Einheiten",
            manager: {
                unassigned: 'Bewirtschafter entfernt'
            },
            document: {
                uploaded: 'Dokument(e) hinaufgeladen',
                deleted: 'Dokument(e) gelöscht'
            },
            service: {
                deleted: 'Partnerfirma entfernt'
            },
            confirmDelete: {
                title: "Wenn Sie weiterfahren wird die Liegenschaft unwiderruflich gelöscht.",
                text: 'Wollen Sie wirklich weiterfahren?'
            },
            validation: {
                name: {
                    required: 'Name ist obligatorisch'
                },
                floor_nr: {
                    required: 'Stockwerk ist obligatorisch'
                },
                description: {
                    required: 'Beschreibung ist obligatorisch'
                },
                label: {
                    required: 'Label ist obligatorisch'
                },
                address_id: {
                    required: 'Adresse ist obligatorisch'
                },
            },
            requestStatuses: {
                total: 'Total Anfragen',
                received: 'Neu',
                assigned: 'Anvisiert',
                in_processing: 'In Bearbeitung',
                reactivated: 'Reaktiviert',
                done: 'Erledigt',
                archived: 'Archiviert'
            },
            placeholders: {
                search: 'Suchen'
            }
        },
        unit: {
            title: 'Einheiten',
            not_found: 'Einheit nicht gefunden',
            add: 'Einheit hinzufügen',
            name: 'Einheit Nummer',
            created_at: 'Datum',
            edit: 'Öffnen',
            delete: 'Löschen',
            save: 'Speichern',
            saved: "Einheit gespeichert",
            floor: 'Stockwerk',
            room_no: 'Anzahl Zimmer',
            monthly_rent: 'Monatsmiete',
            building_search: 'Bitte nach einer Liegenschaft suchen',
            building: 'Liegenschaft',
            description: 'Beschreibung',
            basement: 'Untergeschoss',
            attic: 'Attika',
            requests: 'Anfragen',
            tenant: 'Mieter',
            empty_requests: 'Keine Anfragen',
            assigned_tenant: 'Derzeitiger Mieter',
            type: {
                label: 'Typ',
                apartment: 'Wohnung',
                business: 'Gewerbe'
            },
            confirmDelete: {
                title: "Diese Einheit wird endgültig gelöscht",
                text: 'Sind Sie sicher?'
            },
            validation: {
                name: {
                    required: 'Name ist obligatorisch'
                },
                building: {
                    required: 'Liegenschaft ist obligatorisch'
                },
                monthly_rent: {
                    required: 'Monatsmiete ist obligatorisch'
                },
                floor: {
                    required: 'Stockwerk ist obligatorisch'
                },
                room_no: {
                    required: 'Nummer der Einheit ist obligatorisch'
                },
                description: {
                    required: 'Beschreibung ist obligatorisch'
                },
            },
            placeholders: {
                search: 'Suchen',
                select: 'Wählen'
            }
        },
        address: {
            add: 'Adresse hinzufügen',
            created_at: 'Datum',
            name: 'Address',
            edit: 'Öffnen',
            delete: 'Entfernen',
            save: 'Speichern',
            city: 'Ort',
            country: 'Kanton',
            street: 'Strasse',
            street_nr: 'Hausnummer',
            zip: 'Postleitzahl',
            not_found: 'Adresse nicht gefunden',
            saved: 'Adresse gespeichert',
            confirmDelete: {
                title: "Die Liegenschaft wird endgültig gelöscht.",
                text: 'Sind Sie sicher, dass Sie fortfahren wollen?'
            },
            state: {
                label: 'Kanton'
            },
            validation: {
                state: {
                    required: 'Kanton ist obligatorisch'
                },
                city: {
                    required: 'Ort ist obligatorisch'
                },
                street: {
                    required: 'Strasse ist obligatorisch'
                },
                street_nr: {
                    required: 'Hausnummer ist obligatorisch'
                },
                zip: {
                    required: 'Postleitzahl  ist obligatorisch'
                }
            }
        },
        post: {
            title: 'Pinnwand',
            title_label: 'Anrede',
            content: 'Inhalt',
            preview: 'Vorschau',
            add: 'Nachricht hinzufügen',
            add_pinned: 'Ankündigung erstellen',
            save: 'Speichern',
            edit: 'Öffnen',
            edit_title: 'Beitrag bearbeiten',
            show: 'Vorschau',
            user: "Benutzer",
            delete: 'Löschen',
            likes: 'Likes',
            details: 'Beitragsdetails',
            published_at: 'Veröffentlicht an',
            publish: 'Veröffentlicht',
            unpublish: 'Unpublish',
            buildings: 'Liegenschaften',
            pinned: 'Ankündigung',
            notify_email: 'Per E-Mail benachrichtigen',
            pinned_to: 'Hervorheben bis',
            comments: 'Kommentare',
            images: 'Fotos und Dokumente',
            placeholders: {
                buildings: "Liegenschaft wählen",
                search: 'Suche',
                search_provider: 'Partnerfirma suchen'
            },
            media: {
                deleted: 'Dokument/Foto gelöscht',
                removed: 'Dokument/Foto entfernt'
            },
            type: {
                label: 'Typ',
                article: 'Artikel',
                new_neighbour: 'Neuer Nachbar',
                pinned: 'Ankündigung',
            },
            status: {
                label: 'Status',
                new: 'Neu',
                published: 'Veröffentlicht',
                unpublished: 'Unveröffentlicht',
                not_approved: 'Nicht genehmigt'
            },
            visibility: {
                label: 'Sichtbarkeit',
                address: 'Liegenschaft',
                district: 'Überbauung',
                all: 'Alle'
            },
            confirmChange: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            },
            assignmentTypes: {
                building: 'Liegenschaft',
                district: 'Überbauung'
            },
            assignType: 'Typ',
            unassign: 'Entfernen',
            assign: 'Zuweisen',
            attached: {
                building: 'Liegenschaft wurde verlinkt',
                district: 'Überbauung wurde verlinkt',
                provider: 'Partnerfirma wurde verlinkt'
            },
            detached: {
                building: 'Liegenschaft wurde entfernt',
                district: 'Überbbauung wurde entfernt',
                provider: 'Partnerfirma wurde wurde entfernt'
            },
            buildingAlreadyAssigned: 'Building is already inside on a district',
            confirmUnassign: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            },
            execution_interval: {
                label: 'Datum der Durchführung',
                end: 'Ende',
                start: 'Start',
                separator: 'Bis'
            },
            category: {
                label: 'Kategorie',
                general: 'Generell',
                maintenance: 'Unterhalt',
                electricity: 'Elektro',
                heating: 'Heizung',
                sanitary: 'Sanitär'
            }
        },
        service: {
            title: 'Partnerfirmen und Dienstleister',
            add_title: 'Firma erfassen',
            edit_title: 'Bearbeiten',
            edit: 'Öffnen',
            delete: 'Löschen',
            category: 'Kategorie',
            electrician: "Elektro",
            heating_company: 'Heizung',
            lift: 'Lift',
            sanitary: 'Sanitär',
            key_service: 'Schlüsseldienst',
            caretaker: 'Hauswart',
            real_estate_service: 'Liegenschaftsdienst',
            deleted: 'Gelöscht',
            name: 'Name',
            requests: 'Anfragen',
            contact_details: 'Kontaktdaten',
            user_credentials: 'Logindaten',
            company_details: 'Firmendaten',
            assignmentTypes: {
                building: 'Liegenschaft',
                district: 'Überbauung'
            },
            assignType: 'Typ',
            unassign: 'Entfernen',
            assign: 'Zuweisen',
            attached: {
                building: 'Liegenschaft wurde verlinkt',
                district: 'Überbauung wurde entfernt'
            },
            detached: {
                building: 'Liegenschaft wurde entfernt',
                district: 'Überbauung wurde entfernt'
            },
            buildingAlreadyAssigned: 'Diese Liegenschaft ist bereits mit dieser Überbauung verbunden.',
            confirmUnassign: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            },
            placeholders: {
                search: 'Suchen',
                category: 'Kategorie wählen'
            }
        },
        district: {
            title: 'Überbauungen',
            name: 'Name',
            description: 'Beschreibung',
            add: 'Überbauung hinzufügen',
            edit: 'Überbauung bearbeiten',
            save: 'Speichern',
            edit_action: 'Öffnen',
            delete: 'Löschen',
            cancel: 'Schliessen',
            required: 'Dies ist ein Pflichfeld',
            details: 'Öffnen',
            buildings: 'Liegenschaften'
        },
        realEstate: {
            title: 'Einstellungen Liegenschaftsverwaltung',
            details: 'Details',
            settings: 'Einstellungen',
            district_enable: 'Überbauung',
            marketplace_approval_enable: 'Marktplatz aktivieren',
            news_approval_enable: 'Pinnwand-Beiträge zuerst prüfen',
            comment_update_timeout: 'Comment update timeout',
            closed: 'Geschlossen',
            schedule: 'Schedule',
            endTime: 'Ende',
            startTime: 'Start',
            to: 'An',
            categories: 'Kategorien',
            contact_enable: 'Meine Kontakte aktivieren',
            templates: 'Templates',
            cleanify_email: 'Cleanify email',
            iframe_url: {
                label: 'Iframe URL',
                validation: 'Bitte geben Sie eine korrekte URL ein.'
            }
        },
        request: {
            edit: 'Öffnen',
            delete: 'Löschen',
            deleted: 'Gelöscht',
            title: 'Anfragen',
            created: 'Erstellt',
            prop_title: 'Titel',
            description: 'Beschreibung',
            category: 'Kategorie',
            address: 'Adresse',
            edit_title: 'Anfrage bearbeiten',
            add_title: 'Anfrage erstellen',
            tenant: 'Mieter',
            due_date: 'Zu erledigen bis',
            closed_date: 'Erledigt am',
            service: 'Partnerfirma',
            created_by: 'Erstellt durch',
            is_public: 'Öffentlich machen',
            comments: 'Nachrichten',
            assigned_to: 'Zuständig',
            assign_providers: 'Zuweisen',
            assign_managers: 'Zuweisen',
            unassign: 'Entfernen',
            notify: 'Kommunikation',
            public_legend: 'Aktivieren Sie die Option, um die Anfrage allen Bewohnern einer Liegenschaft/Überbauung zu zeigen.',
            conversation: 'Chat-Mitteilungen',
            open_conversation: 'Offen',
            assign: 'Zuweisen',
            images: 'Fotos und Dokumente',
            assignmentTypes: {
                services: 'Partnerfirma',
                managers: 'Bewirtschafter'
            },
            media: {
                removed: 'Dokument entfernt.',
                deleted: 'Dokument gelöscht',
                delete: 'Löschen'
            },
            priority: {
                label: 'Priorität',
                urgent: 'Dringend',
                low: 'Niedrig',
                normal: 'Normal'
            },
            defect_location: {
                label: 'Örtlichkeit',
                apartment: 'Wohnung',
                building: 'Liegenschaft',
                environment: 'Ungebung'
            },
            qualification: {
                label: 'Qualifikation',
                none: 'Nicht gewählt',
                optical: 'Optisch',
                sia: 'SIA',
                '2_year_warranty': '2-Jahresgarantie',
                cost_consequences: 'Kostenfolge'
            },
            status: {
                label: 'Status',
                received: 'Erhalten',
                in_processing: 'In Bearbeitung',
                assigned: 'Anvisiert',
                done: 'Erledigt',
                reactivated: 'Reaktiviert',
                archived: 'Archiviert'
            },
            placeholders: {
                category: 'Kategorie wählen',
                priority: 'Priorität wählen',
                defect_location: 'Bitte Örtlichkeite wählen',
                qualification: 'Qualifikation wählen',
                status: 'Status wählen',
                due_date: 'Zu erledigen bis',
                tenant: 'Mieter suchen',
                service: 'Partnerfirma suchen',
                propertyManagers: 'Bewirtschafter suchen',
                search: 'Suchen',
                visibility: 'Sichtbar für'
            },
            confirmChange: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            },
            confirmUnassign: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            },
            mail: {
                body: 'Inhalt',
                subject: 'Betreff',
                to: 'An',
                title: 'Benachrichtigungen',
                notify: 'E-Mail senden',
                bodyPlaceholder: 'Bitte geben Sie hier eine Nachricht ein',
                provider: 'Partnerfirma',
                manager: 'Bewirtschafter',
                cancel: 'Schliessen',
                send: 'Senden',
                cc: 'CC',
                bcc: 'BCC',
                success: 'Benachrichtigung erfolgreich gesendet',
                validation: {
                    required: 'Dies ist ein Pflichfeld',
                    email: 'Bitte eine gültige E-Mail Adresse eingeben'
                },
                fail_cc: "CC/BCC/TO müssen korrekte Email Adressen enthalten."
            },
            attached: {
                services: 'Partnerfirma wurde hinzugefügt.',
                managers: 'Bewirtschafter wurde hinzugefügt.'
            },
            detached: {
                service: 'Partnerfirma wurde entfernt.',
                manager: 'Bewirtschafter wurde entfernt.'
            },
            userType: {
                label: 'Typ',
                provider: 'Partnerfirma',
                user: 'Bewirtschafter'
            },
            visibility: {
                label: 'Sichtbarkeit',
                tenant: 'Mieter',
                district: 'Überbauung',
                building: 'Liegenschaft',
            }
        },
        requestCategory: {
            title: 'Anfrage Kategorien',
            add: 'Kategorie hinzufügen',
            edit: 'Öffnen',
            delete: 'Löschen',
            name: 'Name',
            cancel: 'Schliessen',
            required: 'Dies ist ein Pflichtfeld',
            parent: 'Hauptkategorie'
        },
        propertyManager: {
            title: 'Bewirtschafter',
            title_label: 'Anrede',
            add: 'Bewirtschafter hinzufügen',
            save: 'Speichern',
            edit: 'Öffnen',
            edit_title: 'Bewirtschafter bearbeiten',
            delete: 'Löschen',
            firstName: 'Vorname',
            lastName: 'Name',
            name: 'Name',
            profession: 'Position',
            slogan: 'Slogan',
            linkedin_url: 'Linkedin',
            xing_url: 'Xing',
            email: "E-Mail",
            password: 'Passwort',
            confirm_password: 'Passwort bestätigen',
            phone: 'Telefon',
            building_card: 'Liegenschaft(en) zuweisen',
            details_card: 'Details & Konto',
            no_buildings: 'Keine Liegenschaft zugewiesen',
            add_buildings: 'Liegenschaft hinzufügen',
            buildings_search: 'Liegenschaft suchen',
            districts: 'Überbauungen',
            requests: 'Anfragen',
            assign: 'Zuweisen',
            unassign: 'Entfernen',
            delete_with_reassign: 'Neu zuweisen und Benutzer löschen',
            delete_without_reassign: 'Löschen',
            deleted: 'Gelöscht',
            titles: {
                mr: 'Herr',
                mrs: 'Frau'
            },
            assignmentTypes: {
                building: 'Liegenschaft',
                district: 'Überbauung'
            },
            assignType: 'Typ',
            placeholders: {
                search: 'Suchen'
            },
            attached: {
                building: 'Liegenschaft wurde verlinkt.',
                district: 'Überbauung wurde verlinkt',
            },
            detached: {
                building: 'Liegenschaft wurde entfernt.',
                district: 'Überbauung wurde entfernt.'
            },
            buildingAlreadyAssigned: 'Liegenschaft ist bereits einer Überbauung zugewiesen.',
            confirmUnassign: {
                title: 'Wollen Sie wirklich weiterfahren?',
                warning: 'Warnung',
                confirmBtnText: 'Ja',
                cancelBtnText: 'Schliessen'
            }
        },
        product: {
            title: 'Marktplatz',
            add: 'Inserat hinzufügen',
            edit_title: 'Inserat bearbeiten',
            edit: 'Öffnen',
            delete_action: 'Löschen',
            show: 'Vorschau',
            details: 'Details zum Angebot',
            delete: 'Inserat löschen',
            content: "Inhalt",
            product_title: 'Titel',
            published_at: 'Hinzugefügt am',
            publish: 'Veröffentlicht',
            unpublish: 'Unveröffentlicht',
            likes: 'Likes',
            save: 'Speichern',
            comments: 'Kommentare',
            user: 'Benutzer',
            contact: 'Kontaktdaten',
            price: 'Preis',
            media: {
                removed: 'Bild entfernt',
                deleted: 'Bild gelöscht',
            },
            type: {
                label: 'Typ',
                sell: 'Verkaufen',
                lend: 'Leihen',
                service: 'Service',
                giveaway: 'Gratis'
            },
            status: {
                label: 'Status',
                published: 'Veröffentlicht',
                unpublished: 'Unveröffentlicht'
            },
            visibility: {
                label: 'Sichtbarkeit',
                address: 'Liegenschaft',
                district: 'Überbauung',
                all: 'Alle'
            }
        },
        template: {
            name: 'Name',
            edit: 'Öffnen',
            delete: 'Löschen',
            add: 'Hinzufügen',
            title: 'Vorlagen',
            subject: 'Betreff',
            body: 'Inhalt',
            category: 'Kategorie',
            tags: 'Tags',
            placeholders: {
                category: 'Kategorie wählen'
            }
        },
        cleanify: {
            pageTitle: 'Cleanify request',
            title: 'Anrede',
            lastName: 'Name',
            firstName: 'Vorname',
            address: 'Strasse + Nr',
            city: 'Ort',
            zip: 'Postleitzahl',
            email: 'E-Mail',
            phone: 'Telefon',
            save: 'Anfragen einsenden',
            success: 'Ihr Anfrage wurde erfolgreich an Cleanify übertragen.',
            terms_and_conditions: 'Accept Terms & Conditions',
            terms_text: "Terms text here, long text"
        }
    },
    swal: {
        delete: {
            title: 'Sind Sie sicher?',
            text: 'Dies kann nicht mehr rückgänging gemacht werden',
            confirmText: 'Ja, ich will löschen!',
            deleted: 'Erfolgreich gelöscht'
        },
        add: {
            added: 'Erfolgreich hinzugefügt'
        }
    },
    roles: {
        label: 'Rolle',
        manager: 'Bewirtschafter',
        registered: 'Registriert',
        service: 'Partnerfirma',
        administrator: 'Administrator',
        super_admin: 'Super Administrator',
        homeowner: 'Eigentümer',
    },
    settings: {
        notifications: "Benachrichtigungen und Sprache",
        admin: 'Benachrichtigungen vom Vermieter',
        news: 'Pinnwand',
        service: 'Partnerfirmen',
        updated: 'Einstellungen wurden gespeichert.',
        language: 'Sprache',
        summary: {
            label: "Statistiken",
            daily: "Täglich",
            monthly: "Wöchentlich",
            yearly: "Jährlich"
        }
    },
    search: {
        placeholder: 'Suchen'
    },
    filters: {
        header: 'Filter',
        districts: 'Überbauungen',
        buildings: 'Liegenschaften',
        requests: 'Anfragen',
        open_requests: 'Offene Anfragen',
        units: 'Einheiten',
        states: 'Kantone',
        status: 'Status',
        search: 'Suchen',
        requestStatus: 'Anfrage Status',
        propertyManagers: 'Bewirtschafter',
        categories: 'Kategorien',
        created_from: 'Erstellt vom',
        created_to: 'Erstellt bis',
        services: 'Partnerfirmen',
        tenant: 'Tenants'
    },
    errors: {
        files_extension_images: 'Nur Dateien in der Formaten .jpg und .png erlaubt'
    },
    validation: {
        general: {
            required: 'Dies ist ein Pflichtfeld'
        },
        price: {
            valid: 'Bitte gib einen gültigen Preis ein.',
            required: 'Preis ist ein Pflichtfeld',
        },
        firstName: {
            required: 'Vorname ist obligatorisch'
        },
        lastName: {
            required: 'Name ist obligatorisch'
        },
        phone: {
            required: 'Telefon ist obligatorisch'
        },
        address: {
            required: 'Adresse ist obligatorisch'
        },
        zip: {
            required: 'Postleitzahl ist obligatorisch'
        },
        city: {
            required: 'Ort ist obligatorisch'
        },
        title: {
            required: 'Anrede'
        },
        terms: {
            required: 'Please approve with terms and conditions'
        }
    }
}
