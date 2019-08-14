export default {
    "de": {
<<<<<<< HEAD
        "auth": {
            "failed": "Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.",
            "throttle": "Zu viele Loginversuche. Versuchen Sie es bitte in {seconds} Sekunden nochmal."
        },
        "common": {
            "mr": "Herr",
            "mrs": "Frau",
            "company": "Firma",
            "request_status_1": "Erhalten",
            "request_status_2": "In Bearbeitung",
            "request_status_3": "Anvisiert",
            "request_status_4": "Erledigt",
            "request_status_5": "Reaktiviert",
            "request_status_6": "Archiviert",
            "originalRequest_status_1": "Erhalten",
            "originalRequest_status_2": "In Bearbeitung",
            "originalRequest_status_3": "Anvisiert",
            "originalRequest_status_4": "Erledigt",
            "originalRequest_status_5": "Reaktiviert",
            "originalRequest_status_6": "Archiviert",
            "email_footer_message1": "Sie erhalten Sie Mitteilung, weil Sie Nutzer vom Mieterportal der {CompanyName} sind.",
            "email_footer_message2": "...",
            "email_link_contacts": "Kontakt",
            "email_link_terms_of_use": "Nutzungsbedingungen",
            "email_link_data_protection": "Datenschutz"
        },
        "components": {
            "common": {
                "audit": {
                    "type": {
                        "post": "Pinnwand",
                        "product": "Markplatz",
                        "request": "Anfragen"
                    },
                    "filter": {
                        "type": {
                            "post": "Pinnwand",
                            "product": "Markplatz",
                            "request": "Anfragen"
                        },
                        "post": {
                            "created": "Erstellt",
                            "updated": "Aktualisiert",
                            "provider_assigned": "Dienstleister zugewiesen",
                            "user_assigned": "Benutzer zugewiesen",
                            "media_uploaded": "Mediendateien hinaufgeladen",
                            "media_deleted": "Mediendateien gelöscht"
                        },
                        "product": [],
                        "request": {
                            "created": "Erstellt",
                            "updated": "Aktualisiert",
                            "provider_assigned": "Dienstleister zugewiesen",
                            "user_assigned": "Benutzer Dienstleister",
                            "media_uploaded": "Medien hinaufgeladen",
                            "media_deleted": "Medien gelöscht"
                        }
                    },
                    "content": {
                        "withId": {
                            "post": {
                                "created": "{userName} hat diesen Beitrag erstellt.",
                                "updated": {
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "published_at": "Beitrag wurde veröffentlicht am {new}."
                                }
                            },
                            "product": {
                                "created": "{userName} opened this {auditable_type}.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleistern zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            },
                            "request": {
                                "created": "{userName} hat diese Anfrage erstellt.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleister zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            }
                        },
                        "withNoId": {
                            "post": {
                                "created": "{userName} hat die Anfrage {auditable_type} on {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" im {auditable_type} #{auditable_id} geändert.",
                                    "published_at": "Post published on {new} on {auditable_type} #{auditable_id}."
                                }
                            },
                            "product": {
                                "created": "{userName} hat dieses Inserat erstellt #{auditable_id}.",
                                "updated": {
                                    "title": "The title changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "status": "The status changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "due_date": "The due date changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "priority": "The priority changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "category_id": "The category changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "qualification": "The qualification changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "visibility": "The visibility changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}."
                                },
                                "provider_assigned": "{providerName} has been assigned as provider on {auditable_type} #{auditable_id}.",
                                "user_assigned": "{userName} has been assigned as manager on {auditable_type} #{auditable_id}.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            },
                            "request": {
                                "created": "{userName} hat diese Anfrage erstellt.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleister zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            }
                        }
                    }
                },
                "commentsList": {
                    "loading": "Ladet...",
                    "loadMore": {
                        "simple": "Weitere {count} laden",
                        "detailed": "Lade {count} weitere Kommentare"
                    },
                    "emptyPlaceholder": {
                        "title": "Bislang wurde kein Beitrag geteilt...",
                        "description": "Verfasse den ersten Post in dem du auf den unten stehenden Button klickst."
                    }
                },
                "comment": {
                    "updateShortcut": "oder Verwendung {shortcut} Abkürzung",
                    "updateOrCancel": "{update} oder drücke {esc} um {cancel}",
                    "update": "bearbeiten",
                    "esc": "ESC",
                    "cancel": "abzubrechen",
                    "addChildComment": "Kommentar",
                    "loadMore": "Lade 1 weiteren Kommentar | Lade {count} weitere Kommentare",
                    "deletedCommentPlaceholder": "Der Kommentar wurde gelöscht."
                },
                "addComment": {
                    "placeholder": "Schreibe einen Kommentar...",
                    "tooltipTemplates": "Wählen Sie eine Vorlage",
                    "loadingTemplates": "Vorlagen werden geladen...",
                    "saveShortcut": "oder verwende {shortcut} Abkürzung",
                    "emptyTemplatesPlaceholder": "Keine Vorlagen vorhanden"
                },
                "media": {
                    "buttons": {
                        "selectFiles": {
                            "withDrop": "Schieben oder wählen Sie die Dateien...",
                            "withoutDrop": "Datei wählen..."
                        },
                        "upload": "Hinauflauden"
                    },
                    "dropActive": {
                        "title": "Schieben Sie die Dateien hier hinein..",
                        "description": "Nur die Dateien mit eines bestimmten Typs sind erlaubt..."
                    },
                    "messages": {
                        "preview": "Es kann keine Vorschau angezeigt werden.",
                        "uploading": "Hinaufladen...",
                        "uploaded": "Mediendateien wurden erfolgreich hochgeladen.",
                        "size": "Hoppla! Einige Dateien sind grösser als die maximal zulässige Anzahl von {bytes}.",
                        "extensions": "Hoppla! Einige Datei-Typen wurden ausgewählt, die nicht erlaubt sind. Überspringen..."
                    }
                }
            },
            "tenant": {
                "weatherWidget": {
                    "minTemp": "min",
                    "maxTemp": "max",
                    "wind": "Wind",
                    "cloudiness": "Bewölkung",
                    "humidity": "Luftfeuchte",
                    "pressure": "Druck"
                },
                "postAdd": {
                    "visibility": {
                        "address": "Nachbarn",
                        "district": "Überbauung",
                        "all": "Alle"
                    }
                }
            },
            "admin": []
        },
        "dashboard": {
            "statistics": "Statistiken",
            "requests_by_creation_date": "Anfragen nach Erstellungsdatum",
            "requests_by_status": "Anfragen nach Status",
            "requests_by_category": "Anfragen nach Kategorie",
            "requests_by_assigned_status": "Einbezug von Dienstleistern",
            "each_hour_request": "Stündlich",
            "average_request_duration": "Ø Bearbeitungszeit",
            "week_hour": "Woche und Stunden",
            "month_date": "Monat und Tag",
            "news_by_creation_date": "Nachrichten nach Erstellungsdatum",
            "news_by_status": "Nachrichten nach Status",
            "news_by_type": "Nachrichten nach Typ",
            "latest_products": "Neueste Produkte",
            "products_by_creation_date": "Marktplatz-Produkte nach Erstellungsdatum",
            "products_by_type": "Marktplatz-Produkte nach Typ",
            "tenants_by_creation_date": "Mieter nach Erstellungsdatum",
            "tenants_by_request_status": "Mieter nach Anfrage-Status",
            "tenants_by_status": "Mieter nach Status",
            "tenants_by_language": "Mieter Sprache",
            "tenants_by_title": "Anrede",
            "tenants_by_device": "Geräte",
            "tenants_by_gender": "Demografische Merkmale",
            "actions": "Aktionen",
            "requests": {
                "requests_with_service_providers": "Mit Dienstleister",
                "request_wihout_service_providers": "Ohne Dienstleister"
            },
            "buildings": {
                "total_building": "Anzahl Liegenschaften",
                "total_units": "Anzahl Enheiten",
                "occupied_units": "Vermiete Einheiten",
                "free_units": "Freie Einheiten",
                "buildings_by_creation_date": "Liegenschaften nach Erstellungsdatum"
            },
            "tenants": {
                "total_tenants": "Total Mieter",
                "average_age": "Durchschnittsalter:",
                "average_age_acr": "Ø Alter"
            },
            "marketplace": {
                "go_to_marketplace": "zum Marktplatz gehen"
            }
        },
        "filters": {
            "header": "Filter",
            "districts": "Überbauungen",
            "buildings": "Liegenschaften",
            "requests": "Anfragen",
            "open_requests": "Offene Anfragen",
            "units": "Einheiten",
            "states": "Kanton",
            "status": "Status",
            "search": "Suchen",
            "requestStatus": "Anfrage Status",
            "propertyManagers": "Bewirtschafter",
            "categories": "Kategorien",
            "created_from": "Erstellt vom",
            "created_to": "Erstellt bis",
            "services": "Partnerfirmen",
            "tenant": "Mieter-Typ"
        },
        "general": {
            "en": "EN",
            "fr": "FR",
            "it": "IT",
            "de": "DE",
            "yes": "Ja",
            "timestamps": {
                "hours": "Stunden",
                "days": "Tage",
                "weeks": "Wochen",
                "months": "Monate",
                "years": "Jahre"
            },
            "chooseLanguage": "Sprache auswählen",
            "languages": {
                "fr": "Français",
                "it": "Italiano",
                "de": "Deutsch",
                "en": "English"
            },
            "footerText": {
                "companyName": "Propify",
                "leftSideText": "Sie brauchen Unterstützung? Kontaktieren Sie Support-Team unter<br>0800 000 000 oder via eine E-Mail an support@propify.ch",
                "allRightsSaved": "Alle Rechte vorbehalten"
            },
            "days": {
                "monday": "Montag",
                "tuesday": "Dienstag",
                "wednesday": "Mittwoch",
                "thursday": "Donnerstag",
                "friday": "Freitag",
                "saturday": "Samstag",
                "sunday": "Sonntag"
            },
            "no": "Nein",
            "none": "Nichts gewählt",
            "all": "Alle",
            "loadMore": "Mehr laden",
            "account": "Konto",
            "unauthenticated": "Unauthenticated",
            "logged_out": "Ausgeloggt",
            "logged_in": "Eingeloggt",
            "invalid_credentials": "Die eingegebenen Daten stimmen nicht.",
            "server_error": "Server Fehler",
            "reset_password": "Passwort zurücksetzen",
            "reset_password_mail": "Passwort per E-Mail zurücksetzen.",
            "reset_password_mail_sent": "Eine E-Mail wurde an Sie gesendet. Bitte fahren Sie dort weiter.",
            "back_to_login": "Zurück zum Login",
            "forgot_password": "Passwort vergessen",
            "remember_me": "Angemeldet bleiben",
            "password": "Passwort",
            "change_password": "Passwort ändern",
            "new_password": "Neues Passwort",
            "old_password": "Altes Passwort",
            "new_password_confirmation": "Neues Passwort bestätigen",
            "change": "Ändern",
            "cancel": "Schliessen",
            "confirm": "Bestätigen",
            "confirm_password": "Passwort bestätigen",
            "incorrect_password": "Altes Passwort stimmt nicht",
            "password_changed": "Passwort erfolgreich geändert",
            "details_saved": "Angaben gespeichert",
            "please_wait": "Bitte warten...",
            "no_data_available": "Keine Daten verfügbar",
            "password_validation": {
                "required": "Passwort ist obligatorisch",
                "confirm": "Passwort bestätigen",
                "match": "Die eingegebenen Passwörter sind nicht identisch.",
                "min": "Das Passwort muss aus mind. 6 Zeichen bestehen.",
                "old_password_min": "Das alte Passwort müsste aus mind. 6 Zeichen bestehen.",
                "old_password_required": "Das alte Passwort wird benötigt."
            },
            "email": "E-Mail",
            "email_validation": {
                "required": "E-Mail ist obligatorisch",
                "email": "Bitte geben Sie eine gültige E-Mail Adresse ein."
            },
            "token_invalid": "Invalid token",
            "login": "Login",
            "support": "Support",
            "actions": {
                "label": "Operationen",
                "edit": "Öffnen",
                "add": "Hinzufügen",
                "delete": "Löschen",
                "create": "Erstellen",
                "view": "Details",
                "save": "Speichern",
                "close": "Schliessen",
                "saveAndClose": "Speichern & schliessen",
                "upload": "Herunterladen"
            },
            "swal": {
                "delete": {
                    "title": "Sind Sie sicher?",
                    "text": "Dies kann nicht mehr rückgänging gemacht werden!",
                    "confirmText": "Ja, ich will löschen!",
                    "deleted": "Erfolgreich gelöscht!"
                },
                "add": {
                    "added": "Erfolgreich hinzugefügt"
                },
                "media": {
                    "added": "Dokument/Foto hinzugefügt",
                    "deleted": "Dokument/Foto gelöscht"
                },
                "logout_confirm": "Sie werden eingelogt ausgeloggt."
            },
            "roles": {
                "label": "Rolle",
                "administrator": "Administrator",
                "homeowner": "Eigentümer",
                "manager": "Bewirtschafter",
                "registered": "Registriert",
                "service": "Partnerfirma",
                "super_admin": "Super Administrator"
            },
            "search": {
                "placeholder": "Suchen"
            },
            "errors": {
                "files_extension_images": "Nur Dateien in der Formaten .jpg und .png erlaubt."
            },
            "dateTimeFormat": "{date} um {time}",
            "date_range": {
                "range_separator": "Bis",
                "start_date": "Startdatum",
                "end_date": "Enddatum",
                "last_week": "Letzte Woche",
                "last_month": "Letzte Monat",
                "last_3_months": "Letzte 3 Monate",
                "last_6_months": "Letzte 3 Monate",
                "last_year": "Letzte Jahr",
                "last_2_years": "Letzte 2 Jahre",
                "all_time": "Alle Zeit",
                "week": "Woche",
                "peek_week": "Wählen Sie eine Woche"
            }
        },
        "layouts": {
            "tenant": {
                "menu": {
                    "logout": "Abmelden"
                },
                "sidebar": {
                    "dashboard": "Dashboard",
                    "myTenancy": "Mein Dossier",
                    "myPersonalData": "Persönliche Angaben",
                    "myRecentContract": "Mietvertrag",
                    "myDocuments": "Objekt-Dokumentation",
                    "myContactPersons": "Kontaktpersonen",
                    "posts": "Pinnwand",
                    "requests": "Anfragen",
                    "products": "Marktplatz",
                    "settings": "Einstellungen"
                }
            }
        },
        "menu": {
            "dashboard": "Dashboard",
            "news": "Pinnwand",
            "requests": "Service Center",
            "all_requests": "Anfragen",
            "marketplace": "Marktplatz",
            "settings": "Einstellungen",
            "logout": "Anmelden",
            "profile": "Profil",
            "users": "Benutzer",
            "employees": "Bewirtschafter",
            "companies": "Partnerfirmen",
            "admins": "Administratoren",
            "super_admins": "Super Administratoren",
            "home_owners": "Eigentümer",
            "registered": "Registriert",
            "about": "Über",
            "feedback": "Feedback",
            "tenants": "Mieter",
            "buildings": "Liegenschaften",
            "all_buildings": "Objekte",
            "units": "Einheiten",
            "addresses": "Liegenschaften",
            "posts": "Pinnwand",
            "districts": "Überbauungen",
            "products": "Marktplatz",
            "requestCategories": "Kategorien",
            "services": "Partnerfirmen",
            "activity": "Aktivität",
            "propertyManagers": "Bewirtschafter",
            "templates": "Vorlagen"
=======
        "passwords": {
            "password": "Passwörter müssen mindestens 6 Zeichen lang sein und korrekt bestätigt werden.",
            "reset": "Das Passwort wurde erfolgreich zurückgesetzt!",
            "sent": "Passworterinnerung wurde an die angegebene E-Mail-Adresse  gesendet!",
            "token": "Der Passwort-Wiederherstellungs-Schlüssel ist ungültig oder abgelaufen.",
            "user": "Es konnte leider kein Nutzer mit dieser E-Mail-Adresse gefunden werden."
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
        },
        "models": {
            "user": {
                "edit_action": "Öffnen",
                "delete": "Löschen",
                "name": "Name",
                "phone": "Telefon",
                "date": "Datum",
                "email": "E-Mail",
                "id": "ID",
                "add": "Nutzer hinzufügen",
                "save": "Speichern",
                "saved": "Benutzer erfolgreich gespeichert",
                "deleted": "Benutzer gelöscht",
                "edit": "Benutzer bearbeiten",
                "not_found": "Benutzer nicht gefunden",
                "profile_image": "Profil-Bild",
                "profile_text": "Profil-Text",
                "avatar_uploaded": "Profilbild aktualisiert",
                "logo_uploaded": "Logo aktualisiert",
                "logo": "Firmenlogo",
                "address": "Adresse",
                "blank_pdf": "PDF ohne Briefkopf verwenden",
                "notificationSaved": "Benachrichtigungseinstellung gespeichert",
                "realEstateSaved": "Einstellungen gespeichert.",
                "serviceRequestCategorySaved": "Anfrage-Kategorie gespeichert",
                "serviceRequestCategoryDeleted": "Anfrage-Kategorie gelöscht",
                "validation": {
                    "name": {
                        "required": "Name ist obligatorisch"
                    },
                    "role": {
                        "required": "Role ist obligatorisch"
                    }
                }
            },
            "tenant": {
                "view": "Mieter-Profil",
                "view_title": "Mieter-Profil",
                "edit_title": "Mieter bearbeiten",
                "download_credentials": "Zugangsdaten (pdf)",
                "send_credentials": "Zugangsdaten (email)",
                "credentials_sent": "Zugangsdaten wurden erfolgreich gesendet.",
                "credentials_send_fail": "Credentials file not found. Try updating the tenant password to regenerate it",
                "credentials_download_failed": "Credentials file not found. Try updating the tenant password to regenerate it",
                "add": "Mieter hinzufügen",
                "save": "Speichern",
                "saved": "Mieter gespeichert",
                "deleted": "Mieter gelöscht",
                "status_changed": "Status geändert",
                "password_reset": "Mandantenpasswort erfolgreich zurückgesetzt",
                "update": "Update",
                "name": "Name",
                "first_name": "Vorname",
                "last_name": "Name",
                "birth_date": "Geburtsdatum",
                "language": "Sprache",
                "title": "Anrede",
                "mobile_phone": "Mobile",
                "work_phone": "Arbeit",
                "email": "E-Mail",
                "personal_phone": "Telefon privat",
                "private_phone": "Telefon privat",
                "created_date": "Aangemaakte datum",
                "created_at": "Datum",
                "edit": "Bearbeiten",
                "delete": "Löschen",
                "id": "ID",
                "details": "Details",
                "contract": "Mietvertrag",
                "posts": "Beiträge",
                "products": "Marktplatz",
                "requests": "Anfragen",
                "company": "Firmenname",
                "no_building": "Zu keiner Liegenschaft zugewiesen.",
                "media": {
                    "deleted": "Dokument/Foto gelöscht",
                    "uploaded": "Dokument/Foto hochgeladen"
                },
                "building": {
                    "name": "Liegenschaft"
                },
                "unit": {
                    "name": "Einheit"
                },
                "search_building": "Liegenschaft suchen",
                "search_unit": "Einheit suchen",
                "search": "Suchen",
                "confirmDelete": {
                    "title": "Der Mieter wird endgültig gelöscht.",
                    "text": "Sind Sie sicher?"
                },
                "validation": {
                    "first_name": {
                        "required": "Vorname ist obligatorisch"
                    },
                    "last_name": {
                        "required": "Name ist obligatorisch"
                    },
                    "birth_date": {
                        "required": "Geburtsdatum ist obligatorisch"
                    },
                    "building": {
                        "required": "Liegenschaft ist obligatorisch"
                    },
                    "unit": {
                        "required": "Einheit ist obligatorisch"
                    },
                    "title": {
                        "required": "Anrede ist obligatorisch"
                    },
                    "language": {
                        "required": "Sprache ist obligatorisch"
                    }
                },
                "building_card": "Liegenschaft zuweisen",
                "personal_details_card": "Persönliche Angaben",
                "account_info_card": "Benutzer-Login",
                "contact_info_card": "Kontaktdaten",
                "personal_data": "Meine Angaben",
                "my_documents": "Dokumente",
                "my_contract": "Mietvertrag",
                "contact_persons": "Kontakte",
                "no_contacts": "Keine Kontaktpersonen verfügbar.",
                "rent_end": "Mietende",
                "rent_start": "Mietbeginn",
                "rent_contract": "Mietvertrag",
                "contact": {
                    "category": "Kategorie",
                    "name": "Name",
                    "email": "E-Mail",
                    "phone": "Telefon"
                },
                "titles": {
                    "mr": "Herr",
                    "mrs": "Frau",
                    "company": "Firma"
                },
                "status": {
                    "label": "Status",
                    "active": "Inaktiv",
                    "not_active": "Deaktiv"
                },
                "confirmChange": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                }
            },
            "building": {
                "title": "Liegenschaften",
                "edit_title": "Liegenschaft bearbeiten",
                "add": "Liegenschaft hinzufügen",
                "name": "Name",
                "cancel": "Schliessen",
                "created_at": "Datum",
                "edit": "Öffnen",
                "delete": "Löschen",
                "deleted": "Liegenschaft erfolgreich gelöscht",
                "units": "Einheiten",
                "save": "Speichern",
                "saved": "Liegenschaft gespeichert",
                "floors": "Stockwerke",
                "basement": "Erdgeschoss",
                "attic": "Attika",
                "description": "Beschreibung",
                "floor_nr": "Anzahl der Stockwerke",
                "label": "Label",
                "address": "Adresse",
                "address_search": "Bitte Adresse eingeben",
                "not_found": "Liegenschaft nicht gefunden",
                "house_rules": "Hausordnung",
                "operating_instructions": "Benutzungsanleitungen",
                "other": "Sonstiges",
                "files": "Dokumente",
                "add_files": "Dokumente hinzufügen",
                "add_companies": "Dienstleister hinzufügen",
                "companies": "Partnerfirmen",
                "no_services": "Keine Partnerfirmen gewählt.",
                "details": "Details",
                "select_media_category": "Katagorie der Mediendatei wählen",
                "district": "Überbauung",
                "tenants": "Mieter",
                "managers": "Bewirtschafter",
                "requests": "Anfragen",
                "house_nr": "Hausnummer",
                "assign": "Zuweisen",
                "assign_managers": "Bewirtschafter zuweisen",
                "unassign_manager": "Entfernen",
                "managers_assigned": "Bewirtschafter zugewiesen",
                "occupied_units": "Vermietete Einheiten",
                "free_units": "Freie Einheiten",
                "manager": {
                    "unassigned": "Bewirtschafter entfernt"
                },
                "document": {
                    "uploaded": "Dokument(e) hinaufgeladen",
                    "deleted": "Dokument(e) gelöscht"
                },
                "service": {
                    "deleted": "Dienstleister entfernt"
                },
                "confirmDelete": {
                    "title": "Wenn Sie weiterfahren wird die Liegenschaft unwiderruflich gelöscht.",
                    "text": "Wollen Sie wirklich weiterfahren?"
                },
                "validation": {
                    "name": {
                        "required": "Name ist obligatorisch"
                    },
                    "floor_nr": {
                        "required": "Stockwerk ist obligatorisch"
                    },
                    "description": {
                        "required": "Beschreibung ist obligatorisch"
                    },
                    "label": {
                        "required": "Label ist obligatorisch"
                    },
                    "address_id": {
                        "required": "Adresse ist obligatorisch"
                    }
                },
                "requestStatuses": {
                    "total": "Total Anfragen",
                    "received": "Neu",
                    "assigned": "Anvisiert",
                    "in_processing": "In Bearbeitung",
                    "reactivated": "Reaktiviert",
                    "done": "Erledigt",
                    "archived": "Archiviert"
                },
                "placeholders": {
                    "search": "Suchen"
                },
                "delete_building_modal": {
                    "title": "Liegenschaft(en) löschen – Warnung!",
                    "description_unit": "Der ausgewählten Liegenschaft(en) sind Einheiten zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Option.",
                    "description_request": "Der ausgewählten Liegenschaft(en) sind Anfragen zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Option.",
                    "description_both": "Der ausgewählten Liegenschaft(en) sind Einheiten und Anfragen zugewiesen. Wenn diese ebenfalls gelöscht werden sollen, dann aktivieren Sie die unten stehende Optionen.",
                    "delete_units": " Löschen",
                    "dont_delete_units": "Nicht löschen",
                    "delete_requests": "Löschen",
                    "dont_delete_requests": "Nicht löschen"
                }
            },
            "unit": {
                "title": "Einheiten",
                "not_found": "Einheit nicht gefunden.",
                "add": "Einheit hinzufügen",
                "tenantType": {
                    "attached": "Mieter erfolgreich zugewiesen.",
                    "detached": "Mieter erfolgreich entfernt."
                },
                "name": "Einheit-ID",
                "created_at": "Datum",
                "edit": "Bearbeiten",
                "delete": "Löschen",
                "deleted": "Einheit gelöscht",
                "save": "Speichern",
                "saved": "Einheit gespeichert",
                "floor": "Stockwerk",
                "sq_meter": "Fläche",
                "room_no": "Anzahl Zimmer",
                "monthly_rent": "Monatsmiete",
                "building_search": "Bitte nach einer Liegenschaft suchen",
                "building": "Liegenschaft",
                "description": "Beschreibung",
                "basement": "Untergeschoss",
                "attic": "Attika",
                "requests": "Anfragen",
                "tenant": "Mieter",
                "empty_requests": "Keine Anfragen",
                "assigned_tenant": "Derzeitiger Mieter",
                "tenant_assigned": "Zugeordneter Mieter",
                "tenant_unassigned": "Mieter nicht zugeordnet",
                "type": {
                    "label": "Typ",
                    "apartment": "Wohnung",
                    "business": "Gewerbe"
                },
                "confirmDelete": {
                    "title": "Diese Einheit wird endgültig gelöscht",
                    "text": "Sind Sie sicher?"
                },
                "validation": {
                    "name": {
                        "required": "Name ist obligatorisch"
                    },
                    "building": {
                        "required": "Liegenschaft ist obligatorisch"
                    },
                    "monthly_rent": {
                        "required": "Monatsmiete ist obligatorisch"
                    },
                    "floor": {
                        "required": "Stockwerk ist obligatorisch"
                    },
                    "room_no": {
                        "required": "Nummer der Einheit ist obligatorisch"
                    },
                    "description": {
                        "required": "Beschreibung ist obligatorisch"
                    }
                },
                "placeholders": {
                    "search": "Suchen",
                    "select": "Wählen"
                }
            },
            "address": {
                "add": "Adresse hinzufügen",
                "created_at": "Datum",
                "name": "Address",
                "edit": "Öffnen",
                "delete": "Entfernen",
                "save": "Speichern",
                "city": "Ort",
                "country": "Kanton",
                "street": "Strasse",
                "street_nr": "Hausnummer",
                "zip": "Postleitzahl",
                "not_found": "Adresse nicht gefunden",
                "saved": "Adresse gespeichert",
                "confirmDelete": {
                    "title": "Die Liegenschaft wird endgültig gelöscht.",
                    "text": "Sind Sie sicher, dass Sie fortfahren wollen?"
                },
                "state": {
                    "label": "Kanton"
                },
                "validation": {
                    "state": {
                        "required": "Kanton ist obligatorisch"
                    },
                    "city": {
                        "required": "Ort ist obligatorisch"
                    },
                    "street": {
                        "required": "Strasse ist obligatorisch"
                    },
                    "street_nr": {
                        "required": "Hausnummer ist obligatorisch"
                    },
                    "zip": {
                        "required": "Postleitzahl  ist obligatorisch"
                    }
                }
            },
            "post": {
                "title": "Pinnwand",
                "title_label": "Betreff",
                "content": "Inhalt",
                "preview": "Vorschau",
                "add": "Nachricht hinzufügen",
                "add_pinned": "Ankündigung erstellen",
                "save": "Speichern",
                "saved": "Nachricht gespeichert",
                "updated": "Nachricht aktualisiert",
                "deleted": "Nachricht gelöscht",
                "edit": "Öffnen",
                "edit_title": "Beitrag bearbeiten",
                "show": "Vorschau",
                "user": "Benutzer",
                "delete": "Löschen",
                "likes": "Likes",
                "details": "Beitragsdetails",
                "published_at": "Veröffentlichung",
                "publish": "Veröffentlicht",
                "unpublish": "Unpublish",
                "buildings": "Liegenschaften",
                "pinned": "Ankündigung",
                "notify_email": "Mieter benachrichtigen",
                "pinned_to": "Hervorheben bis",
                "comments": "Kommentare",
                "images": "Fotos und Dokumente",
                "details_title": "Vorschau",
                "placeholders": {
                    "buildings": "Liegenschaft wählen",
                    "search": "Suche",
                    "search_provider": "Dienstleister suchen"
                },
                "media": {
                    "deleted": "Dokument/Foto gelöscht",
                    "uploaded": "Dokument / Foto hochgeladen"
                },
                "type": {
                    "label": "Typ",
                    "article": "Artikel",
                    "new_neighbour": "Neuer Nachbar",
                    "pinned": "Ankündigung"
                },
                "status": {
                    "label": "Status",
                    "new": "Neu",
                    "published": "Veröffentlicht",
                    "unpublished": "Unveröffentlicht",
                    "not_approved": "Nicht genehmigt"
                },
                "visibility": {
                    "label": "Sichtbarkeit",
                    "address": "Nachbarn",
                    "district": "Überbauung",
                    "all": "Alle App-Nutzer"
                },
                "confirmChange": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                },
                "assignmentTypes": {
                    "building": "Liegenschaft",
                    "district": "Überbauung"
                },
                "assignType": "Typ",
                "unassign": "Entfernen",
                "assign": "Zuweisen",
                "attached": {
                    "building": "Liegenschaft wurde verlinkt",
                    "district": "Überbauung wurde verlinkt",
                    "provider": "Dienstleister wurde verlinkt"
                },
                "detached": {
                    "building": "Liegenschaft wurde entfernt",
                    "district": "Überbbauung wurde entfernt",
                    "provider": "Dienstleister wurde wurde entfernt"
                },
                "buildingAlreadyAssigned": "Building is already inside on a district",
                "confirmUnassign": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                },
                "execution_interval": {
                    "label": "Datum der Durchführung",
                    "end": "Ende",
                    "start": "Start",
                    "separator": "Bis"
                },
                "category": {
                    "label": "Kategorie",
                    "general": "Generell",
                    "maintenance": "Unterhalt",
                    "electricity": "Elektro",
                    "heating": "Heizung",
                    "sanitary": "Sanitär"
                }
            },
            "service": {
                "title": "Partnerfirmen und Dienstleister",
                "add_title": "Firma erfassen",
                "edit_title": "Bearbeiten",
                "edit": "Öffnen",
                "delete": "Löschen",
                "saved": "Firma gespeichert",
                "deleted": "Firma gelöscht",
                "category": "Kategorie",
                "electrician": "Elektro",
                "heating_company": "Heizung",
                "lift": "Lift",
                "sanitary": "Sanitär",
                "key_service": "Schlüsseldienst",
                "caretaker": "Hauswart",
                "real_estate_service": "Liegenschaftsdienst",
                "name": "Name",
                "requests": "Anfragen",
                "contact_details": "Kontaktdaten",
                "user_credentials": "Logindaten",
                "company_details": "Firmendaten",
                "assignmentTypes": {
                    "building": "Liegenschaft",
                    "district": "Überbauung"
                },
                "assignType": "Typ",
                "unassign": "Entfernen",
                "assign": "Zuweisen",
                "attached": {
                    "building": "Liegenschaft wurde zugewiesen",
                    "district": "Überbauung wurde entfernt"
                },
                "detached": {
                    "building": "Liegenschaft wurde entfernt",
                    "district": "Überbauung wurde entfernt"
                },
                "buildingAlreadyAssigned": "Diese Liegenschaft ist bereits mit dieser Überbauung verbunden.",
                "confirmUnassign": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                },
                "placeholders": {
                    "search": "Suchen",
                    "category": "Kategorie wählen"
                }
            },
            "district": {
                "title": "Überbauungen",
                "name": "Name",
                "description": "Beschreibung",
                "add": "Überbauung hinzufügen",
                "save": "Speichern",
                "saved": "Überbauung gespeichert",
                "edit_action": "Öffnen",
                "delete": "Löschen",
                "deleted": "Überbauung gelöscht",
                "cancel": "Schliessen",
                "required": "Dies ist ein Pflichfeld",
                "details": "Öffnen",
                "buildings": "Liegenschaften"
            },
            "realEstate": {
                "title": "Einstellungen Liegenschaftsverwaltung",
                "details": "Details",
                "settings": "Einstellungen",
                "district_enable": "Überbauung",
                "marketplace_approval_enable": "Marktplatz aktivieren",
                "news_approval_enable": "Pinnwand-Beiträge zuerst prüfen",
                "comment_update_timeout": "Comment update timeout",
                "closed": "Geschlossen",
                "saved": "Gespeichert",
                "schedule": "Terminplanung",
                "endTime": "Ende",
                "startTime": "Start",
                "to": "An",
                "categories": "Kategorien",
                "contact_enable": "Dienstleister-Kontakte für Mieter aktivieren",
                "templates": "Vorlagen",
                "cleanify_email": "Cleanify email",
                "mail_encryption": "Verschlüsselung",
                "mail_from_address": "Abesender E-Mail",
                "mail_from_name": "Absender Name",
                "mail_host": "Host",
                "mail_password": "Passwort",
                "mail_port": "Port",
                "mail_username": "Benutzername (E-Mail)",
                "iframe_url": {
                    "label": "Iframe URL",
                    "validation": "Bitte geben Sie eine korrekte URL ein."
                }
            },
            "request": {
                "audits": "History",
                "edit": "Öffnen",
                "delete": "Löschen",
                "deleted": "Anfrage gelöscht",
                "title": "Übersicht Mieter-Anfragen",
                "created": "Erstellt",
                "saved": "Anfrage gespeichert",
                "prop_title": "Titel",
                "description": "Beschreibung",
                "category": "Kategorie",
                "address": "Adresse",
                "edit_title": "Anfrage bearbeiten",
                "add_title": "Anfrage erstellen",
                "tenant": "Mieter",
                "due_date": "Zu erledigen bis",
                "closed_date": "Erledigt am",
                "service": "Dienstleister",
                "created_by": "Erstellt durch",
                "is_public": "Öffentlich machen",
                "comments": "Nachrichten",
                "assigned_to": "Zuständig",
                "assign_providers": "Zuweisen",
                "assign_managers": "Zuweisen",
                "unassign": "Entfernen",
                "notify": "Kommunikation",
                "public_legend": "Aktivieren Sie die Option, um die Anfrage allen Bewohnern einer Liegenschaft/Überbauung zu zeigen.",
                "conversation": "Chat-Mitteilungen",
                "open_conversation": "Offen",
                "other_recipients": "Weitere Empfänger",
                "recipients": "Empfänger",
                "assign": "Zuweisen",
                "images": "Fotos und Dokumente",
                "no_images_message": "Keine Dateien hochgeladen",
                "request_details": "Beschreibung",
                "internal_notices": "Interne Notizen",
                "status_changed": "Status geändert",
                "priority_changed": "Priorität geändert",
                "assignmentTypes": {
                    "services": "Dienstleister",
                    "managers": "Bewirtschafter"
                },
                "media": {
                    "added": "Dokument hinzugefügt",
                    "removed": "Dokument entfernt.",
                    "deleted": "Dokument gelöscht",
                    "delete": "Löschen"
                },
                "priority": {
                    "label": "Priorität",
                    "urgent": "Dringend",
                    "low": "Niedrig",
                    "normal": "Normal"
                },
                "defect_location": {
                    "label": "Örtlichkeit",
                    "apartment": "Wohnung",
                    "building": "Haus",
                    "environment": "Ungebung"
                },
                "qualification": {
                    "label": "Qualifikation",
                    "none": "Keine",
                    "optical": "Optisch",
                    "sia": "SIA",
                    "2_year_warranty": "2-Jahresgarantie",
                    "cost_consequences": "Kostenfolge"
                },
                "status": {
                    "label": "Status",
                    "received": "Erhalten",
                    "in_processing": "In Bearbeitung",
                    "assigned": "Anvisiert",
                    "done": "Erledigt",
                    "reactivated": "Reaktiviert",
                    "archived": "Archiviert"
                },
                "category_options": {
                    "disturbance": "Störung",
                    "defect": "Mängel",
                    "order_documents": "Unterlagen bestellen",
                    "order_a_payment_slip": "Einzahlungsschein(e) bestellen",
                    "questions_about_the_tenancy": "Fragen zum Mietverhältnis",
                    "other": "Sonstiges",
                    "environment": "Umgebung",
                    "house": "Haus",
                    "apartment": "Wohnung"
                },
                "placeholders": {
                    "category": "Kategorie wählen",
                    "priority": "Priorität wählen",
                    "defect_location": "Bitte die Örtlichkeit angeben",
                    "qualification": "Qualifikation wählen",
                    "status": "Status wählen",
                    "due_date": "Zu erledigen bis",
                    "tenant": "Mieter suchen",
                    "service": "Dienstleister suchen",
                    "propertyManagers": "Bewirtschafter suchen",
                    "search": "Suchen",
                    "visibility": "Sichtbar für"
                },
                "confirmChange": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                },
                "confirmUnassign": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                },
                "mail": {
                    "body": "Inhalt",
                    "subject": "Betreff",
                    "to": "An",
                    "title": "Benachrichtigungen",
                    "notify": "E-Mail senden",
                    "bodyPlaceholder": "Bitte geben Sie hier eine Nachricht ein",
                    "provider": "Dienstleister",
                    "manager": "Bewirtschafter",
                    "cancel": "Schliessen",
                    "send": "Senden",
                    "cc": "CC",
                    "bcc": "BCC",
                    "success": "Benachrichtigung erfolgreich gesendet",
                    "validation": {
                        "required": "Dies ist ein Pflichfeld",
                        "email": "Bitte eine gültige E-Mail Adresse eingeben"
                    },
                    "fail_cc": "CC/BCC/TO müssen korrekte Email Adressen enthalten."
                },
                "attached": {
                    "services": "Dienstleister wurde zugewiesen.",
                    "managers": "Bewirtschafter wurde zugewiesen.",
                    "user": "Benutzer erfolgreich zugewiesen"
                },
                "detached": {
                    "service": "Dienstleister wurde entfernt.",
                    "manager": "Bewirtschafter wurde entfernt.",
                    "user": "Benutzer wurde entfernt."
                },
                "userType": {
                    "label": "Typ",
                    "provider": "Dienstleister",
                    "user": "Bewirtschafter"
                },
                "visibility": {
                    "label": "Sichtbarkeit",
                    "tenant": "Nachbarn",
                    "district": "Überbauung",
                    "building": "Liegenschaft"
                },
                "requestID": "Anfrage-ID",
                "requestCategory": "Anfrage-Kategorie "
            },
            "requestCategory": {
                "title": "Anfrage Kategorien",
                "add": "Kategorie hinzufügen",
                "edit": "Öffnen",
                "delete": "Löschen",
                "name": "Name",
                "cancel": "Schliessen",
                "required": "Dies ist ein Pflichtfeld",
                "parent": "Hauptkategorie"
            },
            "propertyManager": {
                "title": "Bewirtschafter",
                "title_label": "Anrede",
                "add": "Bewirtschafter hinzufügen",
                "save": "Speichern",
                "saved": "Bewirtschafter gespeichert",
                "deleted": "Bewirtschafter gelöscht",
                "edit": "Öffnen",
                "edit_title": "Bewirtschafter bearbeiten",
                "delete": "Löschen",
                "firstName": "Vorname",
                "lastName": "Name",
                "name": "Name",
                "profession": "Position",
                "slogan": "Slogan",
                "linkedin_url": "Linkedin",
                "xing_url": "Xing",
                "email": "E-Mail",
                "password": "Passwort",
                "confirm_password": "Passwort bestätigen",
                "phone": "Telefon",
                "building_card": "Liegenschaft(en) zuweisen",
                "details_card": "Details & Konto",
                "no_buildings": "Keine Liegenschaft zugewiesen",
                "add_buildings": "Liegenschaft hinzufügen",
                "buildings_search": "Liegenschaft suchen",
                "districts": "Überbauungen",
                "requests": "Anfragen",
                "assign": "Zuweisen",
                "unassign": "Entfernen",
                "delete_with_reassign_modal": {
                    "title": "Neu zuweisen und Benutzer löschen",
                    "description": "Der gewählte Bewirtschafter ist mit Liegenschaften verbunden. Sie können die Liegenschaft(en) an eine anderen Person zuweisen. Wählen Sie hierzu einen Bewirtschafter aus der Liste aus.",
                    "search_title": "Bewirtaschafter suchen"
                },
                "delete_without_reassign": "Löschen",
                "profile_card": "User Profile",
                "social_card": "Social Media",
                "titles": {
                    "mr": "Herr",
                    "mrs": "Frau"
                },
                "assignmentTypes": {
                    "building": "Liegenschaft",
                    "district": "Überbauung"
                },
                "assignType": "Typ",
                "placeholders": {
                    "search": "Suchen"
                },
                "attached": {
                    "building": "Liegenschaft wurde zugewiesen.",
                    "district": "Überbauung wurde zugewiesen"
                },
                "detached": {
                    "building": "Liegenschaft wurde entfernt.",
                    "district": "Überbauung wurde entfernt."
                },
                "buildingAlreadyAssigned": "Liegenschaft ist bereits einer Überbauung zugewiesen.",
                "confirmUnassign": {
                    "title": "Wollen Sie wirklich weiterfahren?",
                    "warning": "Warnung",
                    "confirmBtnText": "Ja",
                    "cancelBtnText": "Schliessen"
                }
            },
            "product": {
                "title": "Marktplatz",
                "add": "Anzeige hinzufügen",
                "edit_title": "Anzeige bearbeiten",
                "edit": "Öffnen",
                "delete_action": "Löschen",
                "show": "Vorschau",
                "details": "Details zum Angebot",
                "delete": "Anzeige löschen",
                "content": "Inhalt",
                "product_title": "Titel",
                "published_at": "Hinzugefügt am",
                "publish": "Veröffentlicht",
                "unpublish": "Unveröffentlicht",
                "likes": "Likes",
                "save": "Speichern",
                "saved": "Anzeige gespeichert",
                "deleted": "Anzeige gelöscht",
                "comments": "Kommentare",
                "user": "Benutzer",
                "contact": "Kontaktdaten",
                "price": "Preis",
                "media": {
                    "deleted": "Dokument/Foto gelöscht",
                    "uploaded": "Dokument/Foto hochgeladen"
                },
                "type": {
                    "label": "Typ",
                    "sell": "Verkaufen",
                    "lend": "Leihen",
                    "service": "Dienstleistung",
                    "giveaway": "Gratis"
                },
                "status": {
                    "label": "Status",
                    "published": "Veröffentlicht",
                    "unpublished": "Unveröffentlicht"
                },
                "visibility": {
                    "label": "Sichtbarkeit",
                    "address": "Liegenschaft",
                    "district": "Überbauung",
                    "all": "Alle"
                }
            },
            "template": {
                "name": "Name",
                "edit": "Öffnen",
                "delete": "Löschen",
                "saved": "Vorlage gespeichert",
                "deleted": "Vorlage gelöscht",
                "add": "Hinzufügen",
                "title": "Vorlagen",
                "subject": "Betreff",
                "body": "Inhalt",
                "category": "Kategorie",
                "tags": "Tags",
                "placeholders": {
                    "category": "Kategorie wählen"
                }
            },
            "cleanify": {
                "pageTitle": "Cleanify request",
                "title": "Anrede",
                "lastName": "Name",
                "firstName": "Vorname",
                "address": "Strasse + Nr",
                "city": "Ort",
                "zip": "Postleitzahl",
                "email": "E-Mail",
                "phone": "Telefon",
                "save": "Anfragen einsenden",
                "success": "Ihr Anfrage wurde erfolgreich an Cleanify übertragen.",
                "terms_and_conditions": "Accept Terms & Conditions",
                "terms_text": "Terms text here, long text"
            }
        },
        "filters": {
            "header": "Filter",
            "districts": "Überbauungen",
            "buildings": "Liegenschaften",
            "requests": "Anfragen",
            "open_requests": "Offene Anfragen",
            "units": "Einheiten",
            "states": "Kanton",
            "status": "Status",
            "search": "Suchen",
            "requestStatus": "Anfrage Status",
            "propertyManagers": "Bewirtschafter",
            "categories": "Kategorien",
            "created_from": "Erstellt vom",
            "created_to": "Erstellt bis",
            "services": "Partnerfirmen",
            "tenant": "Mieter-Typ"
        },
        "dashboard": {
            "statistics": "Statistiken",
            "requests_by_creation_date": "Anfragen nach Erstellungsdatum",
            "requests_by_status": "Anfragen nach Status",
            "requests_by_category": "Anfragen nach Kategorie",
            "requests_by_assigned_status": "Einbezug von Dienstleistern",
            "each_hour_request": "Stündlich",
            "average_request_duration": "Ø Bearbeitungszeit",
            "week_hour": "Woche und Stunden",
            "month_date": "Monat und Tag",
            "news_by_creation_date": "Nachrichten nach Erstellungsdatum",
            "news_by_status": "Nachrichten nach Status",
            "news_by_type": "Nachrichten nach Typ",
            "latest_products": "Neueste Produkte",
            "products_by_creation_date": "Marktplatz-Produkte nach Erstellungsdatum",
            "products_by_type": "Marktplatz-Produkte nach Typ",
            "tenants_by_creation_date": "Mieter nach Erstellungsdatum",
            "tenants_by_request_status": "Mieter nach Anfrage-Status",
            "tenants_by_status": "Mieter nach Status",
            "tenants_by_language": "Mieter Sprache",
            "tenants_by_title": "Anrede",
            "tenants_by_device": "Geräte",
            "tenants_by_gender": "Demografische Merkmale",
            "actions": "Aktionen",
            "requests": {
                "requests_with_service_providers": "Mit Dienstleister",
                "request_wihout_service_providers": "Ohne Dienstleister"
            },
            "buildings": {
                "total_building": "Anzahl Liegenschaften",
                "total_units": "Anzahl Enheiten",
                "occupied_units": "Vermiete Einheiten",
                "free_units": "Freie Einheiten",
                "buildings_by_creation_date": "Liegenschaften nach Erstellungsdatum"
            },
            "tenants": {
                "total_tenants": "Total Mieter",
                "average_age": "Durchschnittsalter:",
                "average_age_acr": "Ø Alter"
            },
            "marketplace": {
                "go_to_marketplace": "zum Marktplatz gehen"
            }
        },
        "auth": {
            "failed": "Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.",
            "throttle": "Zu viele Loginversuche. Versuchen Sie es bitte in {seconds} Sekunden nochmal.",
            "login_welcome": "Willkommen zurück, bitte melden Sie sich bei Ihrem Konto an."
        },
        "settings": {
            "notifications": "Benachrichtigungen und Sprache",
            "admin": "Benachrichtigungen vom Vermieter",
            "news": "Pinnwand",
            "marketplace": "Marketplace notifications",
            "service": "Partnerfirmen",
            "updated": "Einstellungen wurden gespeichert.",
            "language": "Sprache",
            "summary": {
                "label": "Statistiken",
                "daily": "Täglich",
                "monthly": "Wöchentlich",
                "yearly": "Jährlich"
            },
            "contact_enable": {
                "use_global": "Verwenden Sie global",
                "show": "Show",
                "hide": "Мerbergen"
            }
        },
        "pagination": {
            "previous": "&laquo; Zurück",
            "next": "Weiter &raquo;"
        },
        "views": {
            "tenant": {
                "my": {
                    "personal": {
                        "title": "Persönliche Angaben",
                        "description": "Meine Daten",
                        "placeholder": {
                            "title": "Keine persönlichen Angaben angegeben.",
                            "description": "Bislang wurden keine Daten in diesem Bereich hinterlegt."
                        }
                    }
                }
            }
        },
        "menu": {
            "dashboard": "Dashboard",
            "news": "Pinnwand",
            "requests": "Service Center",
            "all_requests": "Anfragen",
            "marketplace": "Marktplatz",
            "settings": "Einstellungen",
            "logout": "Anmelden",
            "profile": "Profil",
            "users": "Benutzer",
            "employees": "Bewirtschafter",
            "companies": "Partnerfirmen",
            "admins": "Administratoren",
            "super_admins": "Super Administratoren",
            "home_owners": "Eigentümer",
            "registered": "Registriert",
            "about": "Über",
            "feedback": "Feedback",
            "tenants": "Mieter",
            "buildings": "Liegenschaften",
            "all_buildings": "Objekte",
            "units": "Einheiten",
            "addresses": "Liegenschaften",
            "posts": "Pinnwand",
            "districts": "Überbauungen",
            "products": "Marktplatz",
            "requestCategories": "Kategorien",
            "services": "Partnerfirmen",
            "activity": "Aktivität",
            "propertyManagers": "Bewirtschafter",
            "templates": "Vorlagen"
        },
        "components": {
            "common": {
                "audit": {
                    "type": {
                        "post": "Pinnwand",
                        "product": "Markplatz",
                        "request": "Anfragen"
                    },
                    "filter": {
                        "type": {
                            "post": "Pinnwand",
                            "product": "Markplatz",
                            "request": "Anfragen"
                        },
                        "post": {
                            "created": "Erstellt",
                            "updated": "Aktualisiert",
                            "provider_assigned": "Dienstleister zugewiesen",
                            "user_assigned": "Benutzer zugewiesen",
                            "media_uploaded": "Mediendateien hinaufgeladen",
                            "media_deleted": "Mediendateien gelöscht"
                        },
                        "product": [],
                        "request": {
                            "created": "Erstellt",
                            "updated": "Aktualisiert",
                            "provider_assigned": "Dienstleister zugewiesen",
                            "user_assigned": "Benutzer Dienstleister",
                            "media_uploaded": "Medien hinaufgeladen",
                            "media_deleted": "Medien gelöscht"
                        }
                    },
                    "content": {
                        "withId": {
                            "post": {
                                "created": "{userName} hat diesen Beitrag erstellt.",
                                "updated": {
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "published_at": "Beitrag wurde veröffentlicht am {new}."
                                }
                            },
                            "product": {
                                "created": "{userName} opened this {auditable_type}.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleistern zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            },
                            "request": {
                                "created": "{userName} hat diese Anfrage erstellt.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleister zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            }
                        },
                        "withNoId": {
                            "post": {
                                "created": "{userName} hat die Anfrage {auditable_type} on {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" im {auditable_type} #{auditable_id} geändert.",
                                    "published_at": "Post published on {new} on {auditable_type} #{auditable_id}."
                                }
                            },
                            "product": {
                                "created": "{userName} hat dieses Inserat erstellt #{auditable_id}.",
                                "updated": {
                                    "title": "The title changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "status": "The status changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "due_date": "The due date changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "priority": "The priority changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "category_id": "The category changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "qualification": "The qualification changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "visibility": "The visibility changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}."
                                },
                                "provider_assigned": "{providerName} has been assigned as provider on {auditable_type} #{auditable_id}.",
                                "user_assigned": "{userName} has been assigned as manager on {auditable_type} #{auditable_id}.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            },
                            "request": {
                                "created": "{userName} hat diese Anfrage erstellt.",
                                "updated": {
                                    "title": "Der Titel wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "status": "Der Status wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "due_date": "Das Erledigungsdatum wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "priority": "Die Priorität wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "category_id": "Die Kategorie wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "qualification": "Die Qualifikation wurde von \"{old}\" zu \"{new}\" geändert.",
                                    "visibility": "Die Sichtbarkeit wurde von \"{old}\" zu \"{new}\" geändert."
                                },
                                "provider_assigned": "{providerName} wurde als Dienstleister zugewiesen.",
                                "user_assigned": "{userName} wurde als zuständige Person zugewiesen.",
                                "media_uploaded": "Mediendateien aktualisiert",
                                "media_deleted": "Mediendateien gelöscht"
                            }
                        }
                    }
                },
                "commentsList": {
                    "loading": "Ladet...",
                    "loadMore": {
                        "simple": "Weitere {count} laden",
                        "detailed": "Lade {count} weitere Kommentare"
                    },
                    "emptyPlaceholder": {
                        "title": "Bislang wurde kein Beitrag geteilt...",
                        "description": "Verfasse den ersten Post in dem du auf den unten stehenden Button klickst."
                    }
                },
                "comment": {
                    "updateShortcut": "oder Verwendung {shortcut} Abkürzung",
                    "updateOrCancel": "{update} oder drücke {esc} um {cancel}",
                    "update": "bearbeiten",
                    "esc": "ESC",
                    "cancel": "abzubrechen",
                    "addChildComment": "Kommentar",
                    "loadMore": "Lade 1 weiteren Kommentar | Lade {count} weitere Kommentare",
                    "deletedCommentPlaceholder": "Der Kommentar wurde gelöscht."
                },
                "addComment": {
                    "placeholder": "Schreibe einen Kommentar...",
                    "tooltipTemplates": "Wählen Sie eine Vorlage",
                    "loadingTemplates": "Vorlagen werden geladen...",
                    "saveShortcut": "oder verwende {shortcut} Abkürzung",
                    "emptyTemplatesPlaceholder": "Keine Vorlagen vorhanden"
                },
                "media": {
                    "buttons": {
                        "selectFiles": {
                            "withDrop": "Schieben oder wählen Sie die Dateien...",
                            "withoutDrop": "Datei wählen..."
                        },
                        "upload": "Hinauflauden"
                    },
                    "dropActive": {
                        "title": "Schieben Sie die Dateien hier hinein..",
                        "description": "Nur die Dateien mit eines bestimmten Typs sind erlaubt..."
                    },
                    "messages": {
                        "preview": "Es kann keine Vorschau angezeigt werden.",
                        "uploading": "Hinaufladen...",
                        "uploaded": "Mediendateien wurden erfolgreich hochgeladen.",
                        "size": "Hoppla! Einige Dateien sind grösser als die maximal zulässige Anzahl von {bytes}.",
                        "extensions": "Hoppla! Einige Datei-Typen wurden ausgewählt, die nicht erlaubt sind. Überspringen..."
                    }
                }
            },
            "tenant": {
                "weatherWidget": {
                    "minTemp": "min",
                    "maxTemp": "max",
                    "wind": "Wind",
                    "cloudiness": "Bewölkung",
                    "humidity": "Luftfeuchte",
                    "pressure": "Druck"
                },
                "postAdd": {
                    "visibility": {
                        "address": "Nachbarn",
                        "district": "Überbauung",
                        "all": "Alle"
                    }
                }
            },
            "admin": []
        },
        "layouts": {
            "tenant": {
                "menu": {
                    "logout": "Abmelden"
                },
                "sidebar": {
                    "dashboard": "Dashboard",
                    "myTenancy": "Mein Dossier",
                    "myPersonalData": "Persönliche Angaben",
                    "myRecentContract": "Mietvertrag",
                    "myDocuments": "Objekt-Dokumentation",
                    "myContactPersons": "Kontaktpersonen",
                    "posts": "Pinnwand",
                    "requests": "Anfragen",
                    "products": "Marktplatz",
                    "settings": "Einstellungen"
                }
            }
        },
<<<<<<< HEAD
        "pages": {
            "profile": {
                "pageTitle": "Profil-Einstellungen",
                "profile": "Profil",
                "account": "Konto",
                "security": "Sicherheit",
                "notifications": "Benachrichtigungen"
            },
            "user": {
                "title": "Benutzer"
            },
            "request_activities": {
                "title": "Aktivitäten Tracking"
            },
            "tenant": {
                "title": "Mieter"
            }
        },
        "pagination": {
            "previous": "&laquo; Zurück",
            "next": "Weiter &raquo;"
        },
        "passwords": {
            "password": "Passwörter müssen mindestens 6 Zeichen lang sein und korrekt bestätigt werden.",
            "reset": "Das Passwort wurde erfolgreich zurückgesetzt!",
            "sent": "Passworterinnerung wurde an die angegebene E-Mail-Adresse  gesendet!",
            "token": "Der Passwort-Wiederherstellungs-Schlüssel ist ungültig oder abgelaufen.",
            "user": "Es konnte leider kein Nutzer mit dieser E-Mail-Adresse gefunden werden."
        },
        "settings": {
            "notifications": "Benachrichtigungen und Sprache",
            "admin": "Benachrichtigungen vom Vermieter",
            "news": "Pinnwand",
            "marketplace": "Marketplace notifications",
            "service": "Partnerfirmen",
            "updated": "Einstellungen wurden gespeichert.",
            "language": "Sprache",
            "summary": {
                "label": "Statistiken",
                "daily": "Täglich",
                "monthly": "Wöchentlich",
                "yearly": "Jährlich"
            }
=======
        "common": {
            "mr": "Herr",
            "mrs": "Frau",
            "company": "Firma",
            "request_status_1": "Erhalten",
            "request_status_2": "In Bearbeitung",
            "request_status_3": "Anvisiert",
            "request_status_4": "Erledigt",
            "request_status_5": "Reaktiviert",
            "request_status_6": "Archiviert",
            "originalRequest_status_1": "Erhalten",
            "originalRequest_status_2": "In Bearbeitung",
            "originalRequest_status_3": "Anvisiert",
            "originalRequest_status_4": "Erledigt",
            "originalRequest_status_5": "Reaktiviert",
            "originalRequest_status_6": "Archiviert",
            "email_footer_message1": "Sie erhalten Sie Mitteilung, weil Sie Nutzer vom Mieterportal der {CompanyName} sind.",
            "email_footer_message2": "...",
            "email_link_contacts": "Kontakt",
            "email_link_terms_of_use": "Nutzungsbedingungen",
            "email_link_data_protection": "Datenschutz"
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
        },
        "validation": {
            "accepted": "{attribute} muss akzeptiert werden.",
            "active_url": "{attribute} ist keine gültige Internet-Adresse.",
            "after": "{attribute} muss ein Datum nach dem {date} sein.",
            "after_or_equal": "{attribute} muss ein Datum nach dem {date} oder gleich dem {date} sein.",
            "alpha": "{attribute} darf nur aus Buchstaben bestehen.",
            "alpha_dash": "{attribute} darf nur aus Buchstaben, Zahlen, Binde- und Unterstrichen bestehen.",
            "alpha_num": "{attribute} darf nur aus Buchstaben und Zahlen bestehen.",
            "array": "{attribute} muss ein Array sein.",
            "before": "{attribute} muss ein Datum vor dem {date} sein.",
            "before_or_equal": "{attribute} muss ein Datum vor dem {date} oder gleich dem {date} sein.",
            "between": {
                "numeric": "{attribute} muss zwischen {min} & {max} liegen.",
                "file": "{attribute} muss zwischen {min} & {max} Kilobytes gross sein.",
                "string": "{attribute} muss zwischen {min} & {max} Zeichen lang sein.",
                "array": "{attribute} muss zwischen {min} & {max} Elemente haben."
            },
            "boolean": "{attribute} muss entweder 'true' oder 'false' sein.",
            "confirmed": "{attribute} stimmt nicht mit der Bestätigung überein.",
            "date": "{attribute} muss ein gültiges Datum sein.",
            "date_equals": "The {attribute} must be a date equal to {date}.",
            "date_format": "{attribute} entspricht nicht dem gültigen Format für {format}.",
            "different": "{attribute} und {other} müssen sich unterscheiden.",
            "digits": "{attribute} muss {digits} Stellen haben.",
            "digits_between": "{attribute} muss zwischen {min} und {max} Stellen haben.",
            "dimensions": "{attribute} hat ungültige Bildabmessungen.",
            "distinct": "{attribute} beinhaltet einen bereits vorhandenen Wert.",
            "email": "{attribute} muss eine gültige E-Mail-Adresse sein.",
            "exists": "Der gewählte Wert für {attribute} ist ungültig.",
            "file": "{attribute} muss eine Datei sein.",
            "filled": "{attribute} muss ausgefüllt sein.",
            "gt": {
                "numeric": "{attribute} muss mindestens {value} sein.",
                "file": "{attribute} muss mindestens {value} Kilobytes gross sein.",
                "string": "{attribute} muss mindestens {value} Zeichen lang sein.",
                "array": "{attribute} muss mindestens {value} Elemente haben."
            },
            "gte": {
                "numeric": "{attribute} muss größer oder gleich {value} sein.",
                "file": "{attribute} muss größer oder gleich {value} Kilobytes sein.",
                "string": "{attribute} muss größer oder gleich {value} Zeichen lang sein.",
                "array": "{attribute} muss größer oder gleich {value} Elemente haben."
            },
            "image": "{attribute} muss ein Bild sein.",
            "in": "Der gewählte Wert für {attribute} ist ungültig.",
            "in_array": "Der gewählte Wert für {attribute} kommt nicht in {other} vor.",
            "integer": "{attribute} muss eine ganze Zahl sein.",
            "ip": "{attribute} muss eine gültige IP-Adresse sein.",
            "ipv4": "{attribute} muss eine gültige IPv4-Adresse sein.",
            "ipv6": "{attribute} muss eine gültige IPv6-Adresse sein.",
            "json": "{attribute} muss ein gültiger JSON-String sein.",
            "lt": {
                "numeric": "{attribute} muss kleiner {value} sein.",
                "file": "{attribute} muss kleiner {value} Kilobytes gross sein.",
                "string": "{attribute} muss kleiner {value} Zeichen lang sein.",
                "array": "{attribute} muss kleiner {value} Elemente haben."
            },
            "lte": {
                "numeric": "{attribute} muss kleiner oder gleich {value} sein.",
                "file": "{attribute} muss kleiner oder gleich {value} Kilobytes sein.",
                "string": "{attribute} muss kleiner oder gleich {value} Zeichen lang sein.",
                "array": "{attribute} muss kleiner oder gleich {value} Elemente haben."
            },
            "max": {
                "numeric": "{attribute} darf maximal {max} sein.",
                "file": "{attribute} darf maximal {max} Kilobytes gross sein.",
                "string": "{attribute} darf maximal {max} Zeichen haben.",
                "array": "{attribute} darf nicht mehr als {max} Elemente haben."
            },
            "mimes": "{attribute} muss den Dateityp {values} haben.",
            "mimetypes": "{attribute} muss den Dateityp {values} haben.",
            "min": {
                "numeric": "{attribute} muss mindestens {min} sein.",
                "file": "{attribute} muss mindestens {min} Kilobytes gross sein.",
                "string": "{attribute} muss mindestens {min} Zeichen lang sein.",
                "array": "{attribute} muss mindestens {min} Elemente haben."
            },
            "not_in": "Der gewählte Wert für {attribute} ist ungültig.",
            "not_regex": "{attribute} hat ein ungültiges Format.",
            "numeric": "{attribute} muss eine Zahl sein.",
            "present": "{attribute} muss vorhanden sein.",
            "regex": "{attribute} Format ist ungültig.",
            "required": "{attribute} muss ausgefüllt sein.",
            "required_if": "{attribute} muss ausgefüllt sein, wenn {other} {value} ist.",
            "required_unless": "{attribute} muss ausgefüllt sein, wenn {other} nicht {values} ist.",
            "required_with": "{attribute} muss angegeben werden, wenn {values} ausgefüllt wurde.",
            "required_with_all": "{attribute} muss angegeben werden, wenn {values} ausgefüllt wurde.",
            "required_without": "{attribute} muss angegeben werden, wenn {values} nicht ausgefüllt wurde.",
            "required_without_all": "{attribute} muss angegeben werden, wenn keines der Felder {values} ausgefüllt wurde.",
            "same": "{attribute} und {other} müssen übereinstimmen.",
            "size": {
                "numeric": "{attribute} muss gleich {size} sein.",
                "file": "{attribute} muss {size} Kilobyte gros sein.",
                "string": "{attribute} muss {size} Zeichen lang sein.",
                "array": "{attribute} muss genau {size} Elemente haben."
            },
            "starts_with": "The {attribute} must start with one of the following: {values}",
            "string": "{attribute} muss ein String sein.",
            "timezone": "{attribute} muss eine gültige Zeitzone sein.",
            "unique": "{attribute} ist schon vergeben.",
            "uploaded": "{attribute} konnte nicht hochgeladen werden.",
            "url": "{attribute} muss eine URL sein.",
            "uuid": "{attribute} muss ein UUID sein.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": {
                "name": "Name",
                "username": "Benutzername",
                "email": "E-Mail-Adresse",
                "first_name": "Vorname",
                "last_name": "Nachname",
                "password": "Passwort",
                "password_confirmation": "Passwort-Bestätigung",
                "city": "Stadt",
                "country": "Land",
                "address": "Adresse",
                "phone": "Telefonnummer",
                "mobile": "Handynummer",
                "age": "Alter",
                "sex": "Geschlecht",
                "gender": "Geschlecht",
                "day": "Tag",
                "month": "Monat",
                "year": "Jahr",
                "hour": "Stunde",
                "minute": "Minute",
                "second": "Sekunde",
                "title": "Titel",
                "content": "Inhalt",
                "description": "Beschreibung",
                "excerpt": "Auszug",
                "date": "Datum",
                "time": "Uhrzeit",
                "available": "verfügbar",
                "size": "Grösse"
            },
            "general": {
                "required": "Dies ist ein Pflichtfeld"
            },
            "price": {
                "valid": "Bitte geben Sie einen gültigen Preis ein.",
                "required": "Der Preis ist ein Pflichtfeld"
            },
            "firstName": {
                "required": "Vorname ist obligatorisch"
            },
            "lastName": {
                "required": "Name ist obligatorisch"
            },
            "phone": {
                "required": "Telefon ist obligatorisch"
            },
            "address": {
                "required": "Adresse ist obligatorisch"
            },
            "zip": {
                "required": "Postleitzahl ist obligatorisch"
            },
            "city": {
                "required": "Ortschaft ist obligatorisch"
            },
            "title": {
                "required": "Anrede"
            },
            "terms": {
                "required": "Please approve with terms and conditions"
            }
        },
<<<<<<< HEAD
        "views": {
            "tenant": {
                "my": {
                    "personal": {
                        "title": "Persönliche Angaben",
                        "description": "Meine Daten",
                        "placeholder": {
                            "title": "Keine persönlichen Angaben angegeben.",
                            "description": "Bislang wurden keine Daten in diesem Bereich hinterlegt."
                        }
                    }
                }
=======
        "general": {
            "en": "EN",
            "fr": "FR",
            "it": "IT",
            "de": "DE",
            "yes": "Ja",
            "timestamps": {
                "hours": "Stunden",
                "days": "Tage",
                "weeks": "Wochen",
                "months": "Monate",
                "years": "Jahre"
            },
            "chooseLanguage": "Sprache auswählen",
            "languages": {
                "fr": "Français",
                "it": "Italiano",
                "de": "Deutsch",
                "en": "English"
            },
            "footerText": {
                "companyName": "Propify",
                "leftSideText": "Sie brauchen Unterstützung? Kontaktieren Sie Support-Team unter<br>0800 000 000 oder via eine E-Mail an support@propify.ch",
                "allRightsSaved": "Alle Rechte vorbehalten"
            },
            "days": {
                "monday": "Montag",
                "tuesday": "Dienstag",
                "wednesday": "Mittwoch",
                "thursday": "Donnerstag",
                "friday": "Freitag",
                "saturday": "Samstag",
                "sunday": "Sonntag"
            },
            "no": "Nein",
            "none": "Nichts gewählt",
            "all": "Alle",
            "loadMore": "Mehr laden",
            "account": "Konto",
            "unauthenticated": "Unauthenticated",
            "logged_out": "Ausgeloggt",
            "logged_in": "Eingeloggt",
            "invalid_credentials": "Die eingegebenen Daten stimmen nicht.",
            "server_error": "Server Fehler",
            "reset_password": "Passwort zurücksetzen",
            "reset_password_mail": "Passwort per E-Mail zurücksetzen.",
            "reset_password_mail_sent": "Eine E-Mail wurde an Sie gesendet. Bitte fahren Sie dort weiter.",
            "back_to_login": "Zurück zum Login",
            "forgot_password": "Passwort vergessen",
            "remember_me": "Angemeldet bleiben",
            "password": "Passwort",
            "change_password": "Passwort ändern",
            "new_password": "Neues Passwort",
            "old_password": "Altes Passwort",
            "new_password_confirmation": "Neues Passwort bestätigen",
            "change": "Ändern",
            "cancel": "Schliessen",
            "confirm": "Bestätigen",
            "confirm_password": "Passwort bestätigen",
            "incorrect_password": "Altes Passwort stimmt nicht",
            "password_changed": "Passwort erfolgreich geändert",
            "details_saved": "Angaben gespeichert",
            "please_wait": "Bitte warten...",
            "no_data_available": "Keine Daten verfügbar",
            "password_validation": {
                "required": "Passwort ist obligatorisch",
                "confirm": "Passwort bestätigen",
                "match": "Die eingegebenen Passwörter sind nicht identisch.",
                "min": "Das Passwort muss aus mind. 6 Zeichen bestehen.",
                "old_password_min": "Das alte Passwort müsste aus mind. 6 Zeichen bestehen.",
                "old_password_required": "Das alte Passwort wird benötigt."
            },
            "email": "E-Mail",
            "email_validation": {
                "required": "E-Mail ist obligatorisch",
                "email": "Bitte geben Sie eine gültige E-Mail Adresse ein."
            },
            "token_invalid": "Invalid token",
            "login": "Login",
            "support": "Support",
            "actions": {
                "label": "Operationen",
                "edit": "Öffnen",
                "add": "Hinzufügen",
                "delete": "Löschen",
                "create": "Erstellen",
                "view": "Details",
                "save": "Speichern",
                "close": "Schliessen",
                "saveAndClose": "Speichern & schliessen",
                "upload": "Herunterladen"
            },
            "swal": {
                "delete": {
                    "title": "Sind Sie sicher?",
                    "text": "Dies kann nicht mehr rückgänging gemacht werden!",
                    "confirmText": "Ja, ich will löschen!",
                    "deleted": "Erfolgreich gelöscht!"
                },
                "add": {
                    "added": "Erfolgreich hinzugefügt"
                },
                "media": {
                    "added": "Dokument/Foto hinzugefügt",
                    "deleted": "Dokument/Foto gelöscht"
                },
                "logout_confirm": "Sie werden eingelogt ausgeloggt."
            },
            "roles": {
                "label": "Rolle",
                "administrator": "Administrator",
                "homeowner": "Eigentümer",
                "manager": "Bewirtschafter",
                "registered": "Registriert",
                "service": "Partnerfirma",
                "super_admin": "Super Administrator"
            },
            "search": {
                "placeholder": "Suchen"
            },
            "errors": {
                "files_extension_images": "Nur Dateien in der Formaten .jpg und .png erlaubt."
            },
            "dateTimeFormat": "{date} um {time}",
            "date_range": {
                "range_separator": "Bis",
                "start_date": "Startdatum",
                "end_date": "Enddatum",
                "last_week": "Letzte Woche",
                "last_month": "Letzte Monat",
                "last_3_months": "Letzte 3 Monate",
                "last_6_months": "Letzte 3 Monate",
                "last_year": "Letzte Jahr",
                "last_2_years": "Letzte 2 Jahre",
                "all_time": "Alle Zeit",
                "week": "Woche",
                "peek_week": "Wählen Sie eine Woche"
            }
        },
        "pages": {
            "profile": {
                "pageTitle": "Profil-Einstellungen",
                "profile": "Profil",
                "account": "Konto",
                "security": "Sicherheit",
                "notifications": "Benachrichtigungen"
            },
            "user": {
                "title": "Benutzer"
            },
            "request_activities": {
                "title": "Aktivitäten Tracking"
            },
            "tenant": {
                "title": "Mieter"
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
            }
        }
    }
}
