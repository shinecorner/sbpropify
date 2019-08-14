export default {
    "it": {
<<<<<<< HEAD
        "auth": {
            "failed": "Credenziali non corrispondenti ai dati registrati.",
            "throttle": "Troppi tentativi di accesso. Riprova tra {seconds} secondi."
        },
        "components": {
            "common": {
                "audit": {
                    "type": {
                        "post": "Post",
                        "product": "Product",
                        "request": "Request"
                    },
                    "filter": {
                        "type": {
                            "post": "Post",
                            "product": "Product",
                            "request": "Request"
                        },
                        "post": {
                            "created": "Created",
                            "updated": "Updates",
                            "provider_assigned": "Provider assigned",
                            "user_assigned": "User assigned",
                            "media_uploaded": "Media uploaded",
                            "media_deleted": "Media deleted"
                        },
                        "product": [],
                        "request": {
                            "created": "Created",
                            "updated": "Updates",
                            "provider_assigned": "Provider assigned",
                            "user_assigned": "User assigned",
                            "media_uploaded": "Media uploaded",
                            "media_deleted": "Media deleted"
                        }
                    },
                    "content": {
                        "withId": {
                            "post": {
                                "created": "{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "The status changed from \"{old}\" to \"{new}\".",
                                    "published_at": "Post published on {new}."
                                }
                            },
                            "product": {
                                "created": "{userName} opened this {auditable_type}.",
                                "updated": {
                                    "title": "The title changed from \"{old}\" to \"{new}\".",
                                    "status": "The status changed from \"{old}\" to \"{new}\".",
                                    "due_date": "The due date changed from \"{old}\" to \"{new}\".",
                                    "priority": "The priority changed from \"{old}\" to \"{new}\".",
                                    "category_id": "The category changed from \"{old}\" to \"{new}\".",
                                    "qualification": "The qualification changed from \"{old}\" to \"{new}\".",
                                    "visibility": "The visibility changed from \"{old}\" to \"{new}\"."
                                },
                                "provider_assigned": "{providerName} has been assigned as provider.",
                                "user_assigned": "{userName} has been assigned as manager.",
                                "media_uploaded": "Media uploaded",
                                "media_deleted": "Media deleted"
                            },
                            "request": {
                                "created": "{userName} opened this {auditable_type}.",
                                "updated": {
                                    "title": "The title changed from \"{old}\" to \"{new}\".",
                                    "status": "The status changed from \"{old}\" to \"{new}\".",
                                    "due_date": "The due date changed from \"{old}\" to \"{new}\".",
                                    "priority": "The priority changed from \"{old}\" to \"{new}\".",
                                    "category_id": "The category changed from \"{old}\" to \"{new}\".",
                                    "qualification": "The qualification changed from \"{old}\" to \"{new}\".",
                                    "visibility": "The visibility changed from \"{old}\" to \"{new}\"."
                                },
                                "provider_assigned": "{providerName} has been assigned as provider.",
                                "user_assigned": "{userName} has been assigned as manager.",
                                "media_uploaded": "Media uploaded",
                                "media_deleted": "Media deleted"
                            }
                        },
                        "withNoId": {
                            "post": {
                                "created": "{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "The status changed from \"{old}\" to \"{new}\" on {auditable_type} #{auditable_id}.",
                                    "published_at": "Post published on {new} on {auditable_type} #{auditable_id}."
                                }
                            },
                            "product": {
                                "created": "{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.",
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
                                "media_uploaded": "Media uploaded on {auditable_type} #{auditable_id}.",
                                "media_deleted": "Media deleted on {auditable_type} #{auditable_id}."
                            },
                            "request": {
                                "created": "{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.",
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
                                "media_uploaded": "Media uploaded on {auditable_type} #{auditable_id}.",
                                "media_deleted": "Media deleted on {auditable_type} #{auditable_id}."
                            }
                        }
                    }
                },
                "commentsList": {
                    "loading": "Loading...",
                    "loadMore": {
                        "simple": "Load {count} more",
                        "detailed": "Load {count} more comments"
                    },
                    "emptyPlaceholder": {
                        "title": "There are no messages yet...",
                        "description": "Start messaging by using the below form and press enter."
                    }
                },
                "comment": {
                    "updateShortcut": "or use {shortcut} shortcut",
                    "updateOrCancel": "{update} or press {esc} to {cancel}",
                    "update": "update",
                    "esc": "ESC",
                    "cancel": "cancel",
                    "addChildComment": "Comment",
                    "loadMore": "Load 1 more comment | Load {count} more comments",
                    "deletedCommentPlaceholder": "This comment was deleted."
                },
                "addComment": {
                    "placeholder": "Type a comment...",
                    "tooltipTemplates": "Choose a template",
                    "loadingTemplates": "Loading templates...",
                    "saveShortcut": "or use {shortcut} shortcut",
                    "emptyTemplatesPlaceholder": "No templates available."
                },
                "media": {
                    "buttons": {
                        "selectFiles": {
                            "withDrop": "Drop files or click to select...",
                            "withoutDrop": "Click to select..."
                        },
                        "upload": "Upload"
                    },
                    "dropActive": {
                        "title": "Drop your files here...",
                        "description": "Only the files with a certain extension are allowed."
                    },
                    "messages": {
                        "preview": "This file cannot be previewed.",
                        "uploading": "Uploading...",
                        "uploaded": "Media files have been succesfully uploaded.",
                        "size": "Oops! Some files had the size bigger than the maximum allowed of {bytes}.",
                        "extensions": "Oops! Some files have had an extension that was not allowed. Skipping..."
                    }
                }
            },
            "tenant": {
                "weatherWidget": {
                    "minTemp": "min",
                    "maxTemp": "max",
                    "wind": "wind",
                    "cloudiness": "cloudiness",
                    "humidity": "humidity",
                    "pressure": "pressure"
                },
                "postAdd": {
                    "visibility": {
                        "address": "Address",
                        "district": "District",
                        "all": "All"
                    }
                }
            },
            "admin": []
        },
        "dashboard": {
            "statistics": "Statistiche",
            "requests_by_creation_date": "Richieste per data di creazione",
            "requests_by_status": "Richieste per stato",
            "requests_by_category": "Richieste per categoria",
            "requests_by_assigned_status": "Requests by assigned status",
            "each_hour_request": "Ogni ora richiede",
            "average_request_duration": "Tempo di risoluzione",
            "week_hour": "Settimana vs. Ora",
            "month_date": "Mese vs. data",
            "news_by_creation_date": "Notizie per data di creazione",
            "news_by_status": "Notizie per stato",
            "news_by_type": "Notizie per tipo",
            "latest_products": "Ultimi prodotti",
            "products_by_creation_date": "Mercato dei prodotti per data di creazione",
            "products_by_type": "Piazza del mercato prodotti per tipologia",
            "tenants_by_creation_date": "Gli inquilini per data di creazione",
            "tenants_by_request_status": "Situazione degli inquilini in base alle richieste",
            "tenants_by_status": "Affittuari per stato",
            "tenants_by_language": "Tenants by language",
            "tenants_by_title": "Tenants by title",
            "tenants_by_device": "Tenants by device",
            "tenants_by_gender": "Tenants by gender",
            "actions": "Actions",
            "requests": {
                "requests_with_service_providers": "With service providers",
                "request_wihout_service_providers": "Without service providers"
            },
            "buildings": {
                "total_building": "Total Count",
                "total_units": "Total Units",
                "occupied_units": "Occupied Units",
                "free_units": "Free Units",
                "buildings_by_creation_date": "Buildings by creation date"
            },
            "tenants": {
                "total_tenants": "Total Count",
                "average_age": "Average Age",
                "average_age_acr": "Avg. Age"
            },
            "marketplace": {
                "go_to_marketplace": "go to marketplace"
            }
        },
        "filters": {
            "header": "Filters",
            "districts": "Districts",
            "buildings": "Buildings",
            "requests": "Requests",
            "open_requests": "Open requests",
            "units": "Units",
            "states": "States",
            "status": "Status",
            "search": "Search",
            "requestStatus": "Request status",
            "propertyManagers": "Property Manager",
            "categories": "Categories",
            "created_from": "Created from",
            "created_to": "Created to",
            "services": "Services",
            "tenant": "Type tenants"
        },
        "general": {
            "en": "EN",
            "fr": "FR",
            "it": "IT",
            "de": "DE",
            "yes": "Yes",
            "timestamps": {
                "hours": "Orario",
                "days": "Giorni",
                "weeks": "Settimane",
                "months": "Mesi",
                "years": "Anni"
            },
            "chooseLanguage": "Scegliere la lingua",
            "languages": {
                "fr": "Français",
                "it": "Italiano",
                "de": "Deutsch",
                "en": "English"
            },
            "footerText": {
                "companyName": "Propify",
                "leftSideText": "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero quis beatae officia saepe perferendis voluptatum minima eveniet voluptates dolorum, temporibus nisi maxime nesciunt totam repudiandae commodi sequi dolor quibusdam sunt.",
                "allRightsSaved": "Tutti i diritti riservati"
            },
            "days": {
                "monday": "lunedì",
                "tuesday": "martedì",
                "wednesday": "mercoledì",
                "thursday": "Giovedì",
                "friday": "venerdì",
                "saturday": "sabato",
                "sunday": "domenicale"
            },
            "no": "No",
            "none": "Nessuna",
            "all": "Tutti",
            "loadMore": "Carica di più",
            "account": "Conto",
            "unauthenticated": "Non autenticato",
            "logged_out": "Disconnesso",
            "logged_in": "Loggato",
            "invalid_credentials": "Credenziali non valide",
            "server_error": "Errore del server",
            "reset_password": "Reimpostare la password",
            "reset_password_mail": "Inviare la mail di reset della password",
            "reset_password_mail_sent": "Reimposta la password inviata, controlla la tua casella di posta in arrivo",
            "back_to_login": "Torna al login",
            "forgot_password": "Password dimenticata",
            "remember_me": "Ricordati di me",
            "password": "La password",
            "change_password": "Cambiare la password",
            "new_password": "Nuova password",
            "old_password": "Vecchia password",
            "new_password_confirmation": "Conferma della nuova password",
            "change": "Cambiamento",
            "cancel": "Annulla",
            "confirm": "Conferma",
            "confirm_password": "Conferma la password",
            "incorrect_password": "La vecchia password è incorect",
            "password_changed": "Password modificata con successo",
            "details_saved": "Dettagli salvati",
            "please_wait": "Attendere per favore...",
            "no_data_available": "Nessun dato disponibile",
            "password_validation": {
                "required": "La password è richiesta",
                "confirm": "Inserisci nuovamente la password",
                "match": "Le password non sono uguali",
                "min": "La password deve essere di almeno 6 caratteri",
                "old_password_min": "La vecchia password deve essere di almeno 6 caratteri",
                "old_password_required": "È richiesta una vecchia password"
            },
            "email": "eMail",
            "email_validation": {
                "required": "è richiesta una e-mail",
                "email": "Inserisci un'e-mail valida"
            },
            "token_invalid": "Gettone non valido",
            "login": "Accedi",
            "support": "Support",
            "actions": {
                "label": "Operations",
                "edit": "Edit",
                "add": "Add",
                "delete": "Delete",
                "create": "Create",
                "view": "Details",
                "save": "Save",
                "close": "Close",
                "saveAndClose": "Save & Close",
                "upload": "Upload"
            },
            "swal": {
                "delete": {
                    "title": "Are you sure?",
                    "text": "You won't be able to revert this!",
                    "confirmText": "Yes, delete it!",
                    "deleted": "Deleted successfully"
                },
                "add": {
                    "added": "Added successfully"
                },
=======
        "passwords": {
            "password": "Le password devono essere di almeno 6 caratteri e devono coincidere.",
            "reset": "La password è stata reimpostata!",
            "sent": "Promemoria della password inviato!",
            "token": "Questo token per la reimpostazione della password non è valido.",
            "user": "Non esiste un utente associato a questo indirizzo e-mail."
        },
        "models": {
            "user": {
                "edit_action": "Edit",
                "delete": "Delete",
                "name": "Name",
                "phone": "Phone",
                "date": "Date",
                "email": "Email",
                "id": "ID",
                "add": "Add user",
                "save": "Save",
                "saved": "User saved successfully",
                "deleted": "Utente cancellato",
                "edit": "Edit user",
                "not_found": "User not found",
                "profile_image": "Profile image",
                "profile_text": "Profile text",
                "avatar_uploaded": "Avatar uploaded",
                "logo_uploaded": "Logo uploaded",
                "logo": "Logo",
                "address": "Address",
                "blank_pdf": "Blank pdf",
                "notificationSaved": "Notificatin setting saved",
                "realEstateSaved": "Real Estate settings saved",
                "serviceRequestCategorySaved": "Categoria della richiesta di servizio salvata",
                "serviceRequestCategoryDeleted": "Categoria richiesta di servizio cancellata",
                "validation": {
                    "name": {
                        "required": "Name is required"
                    },
                    "role": {
                        "required": "Role is required"
                    }
                }
            },
            "tenant": {
                "view": "View",
                "view_title": "View tenant",
                "edit_title": "Edit tenant",
                "download_credentials": "Download credentials",
                "send_credentials": "Send credentials",
                "credentials_sent": "Credentials sent",
                "credentials_send_fail": "Credentials file not found. Try updating the tenant password to regenerate it",
                "credentials_download_failed": "Credentials file not found. Try updating the tenant password to regenerate it",
                "add": "Add tenant",
                "save": "Save",
                "saved": "Inquilino salvato",
                "deleted": "Inquilino cancellato",
                "status_changed": "Status changed",
                "password_reset": "Tenant password reset successfully",
                "update": "Update",
                "name": "Name",
                "first_name": "First name",
                "last_name": "Last name",
                "birth_date": "Birth date",
                "language": "Language",
                "title": "Title",
                "mobile_phone": "Mobile phone",
                "work_phone": "Work phone",
                "email": "Email",
                "personal_phone": "Personal phone",
                "private_phone": "Personal phone",
                "created_date": "Data di creazione",
                "created_at": "Date",
                "edit": "Edit",
                "delete": "Delete",
                "id": "ID",
                "details": "Details",
                "contract": "Contract",
                "posts": "Posts",
                "products": "Products",
                "requests": "Requests",
                "company": "Company name",
                "no_building": "No building",
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
                "media": {
                    "deleted": "Document/Photo Deleted",
                    "uploaded": "Document/Photo Uploaded"
                },
<<<<<<< HEAD
                "logout_confirm": "Sarai disconnesso."
            },
            "roles": {
                "label": "Role",
                "administrator": "Administrator",
                "homeowner": "Home Owner",
                "manager": "Manager",
                "registered": "Registered",
                "service": "Service",
                "super_admin": "Super Admin"
            },
            "search": {
                "placeholder": "Search"
            },
            "errors": {
                "files_extension_images": "Only jpg and png files accepted"
            },
            "dateTimeFormat": "{date} at {time}",
            "date_range": {
                "range_separator": "To",
                "start_date": "Start date",
                "end_date": "End date",
                "last_7_days": "Ultimi 7 giorni",
                "last_week": "Last week",
                "last_14_days": "Ultimi 14 giorni",
                "last_30_days": "Ultimi 30 giorni",
                "last_month": "Last Month",
                "last_3_months": "Last 3 months",
                "last_6_months": "Last 6 months",
                "last_year": "Last year",
                "last_2_years": "Last 2 years",
                "all_time": "Tutto il tempo",
                "week": "Settimana",
                "peek_week": "Scegli una settimana"
            }
        },
        "layouts": {
            "tenant": {
                "menu": {
                    "logout": "Logout"
                },
                "sidebar": {
                    "dashboard": "Dashboard",
                    "myTenancy": "My tenancy",
                    "myPersonalData": "My personal data",
                    "myRecentContract": "My recent contract",
                    "myDocuments": "Documents",
                    "myContactPersons": "Contact persons",
                    "posts": "News",
                    "requests": "Requests",
                    "products": "Marketplace",
                    "settings": "Settings"
                }
            }
        },
        "menu": {
            "dashboard": "Cruscotto",
            "news": "Notizie",
            "requests": "Richieste",
            "all_requests": "Tutte le richieste",
            "marketplace": "Mercato",
            "settings": "Impostazioni",
            "logout": "Logout",
            "profile": "Profilo",
            "users": "Utenti",
            "employees": "Dirigenti",
            "companies": "Servizi",
            "admins": "Amministratori",
            "super_admins": "Super amministratori",
            "home_owners": "Proprietari",
            "registered": "Registrato",
            "about": "A proposito di",
            "feedback": "Feedback",
            "tenants": "Gli inquilini",
            "buildings": "Edifici",
            "all_buildings": "Tutti gli edifici",
            "units": "Unità",
            "addresses": "Indirizzi",
            "posts": "Notizie",
            "districts": "Distretti",
            "products": "Prodotti",
            "requestCategories": "Richiesta categorie",
            "services": "Partner di servizio",
            "activity": "Attività",
            "propertyManagers": "Gestori",
            "templates": "Modelli"
        },
        "models": {
            "user": {
                "edit_action": "Edit",
                "delete": "Delete",
                "name": "Name",
                "phone": "Phone",
                "date": "Date",
                "email": "Email",
                "id": "ID",
                "add": "Add user",
                "save": "Save",
                "saved": "User saved successfully",
                "deleted": "Utente cancellato",
                "edit": "Edit user",
                "not_found": "User not found",
                "profile_image": "Profile image",
                "profile_text": "Profile text",
                "avatar_uploaded": "Avatar uploaded",
                "logo_uploaded": "Logo uploaded",
                "logo": "Logo",
                "address": "Address",
                "blank_pdf": "Blank pdf",
                "notificationSaved": "Notificatin setting saved",
                "realEstateSaved": "Real Estate settings saved",
                "serviceRequestCategorySaved": "Categoria della richiesta di servizio salvata",
                "serviceRequestCategoryDeleted": "Categoria richiesta di servizio cancellata",
                "validation": {
                    "name": {
                        "required": "Name is required"
                    },
                    "role": {
                        "required": "Role is required"
                    }
                }
            },
            "tenant": {
                "view": "View",
                "view_title": "View tenant",
                "edit_title": "Edit tenant",
                "download_credentials": "Download credentials",
                "send_credentials": "Send credentials",
                "credentials_sent": "Credentials sent",
                "credentials_send_fail": "Credentials file not found. Try updating the tenant password to regenerate it",
                "credentials_download_failed": "Credentials file not found. Try updating the tenant password to regenerate it",
                "add": "Add tenant",
                "save": "Save",
                "saved": "Inquilino salvato",
                "deleted": "Inquilino cancellato",
                "status_changed": "Status changed",
                "password_reset": "Tenant password reset successfully",
                "update": "Update",
                "name": "Name",
                "first_name": "First name",
                "last_name": "Last name",
                "birth_date": "Birth date",
                "language": "Language",
                "title": "Title",
                "mobile_phone": "Mobile phone",
                "work_phone": "Work phone",
                "email": "Email",
                "personal_phone": "Personal phone",
                "private_phone": "Personal phone",
                "created_date": "Data di creazione",
                "created_at": "Date",
                "edit": "Edit",
                "delete": "Delete",
                "id": "ID",
                "details": "Details",
                "contract": "Contract",
                "posts": "Posts",
                "products": "Products",
                "requests": "Requests",
                "company": "Company name",
                "no_building": "No building",
                "media": {
                    "deleted": "Document/Photo Deleted",
                    "uploaded": "Document/Photo Uploaded"
                },
                "building": {
                    "name": "Building"
                },
                "unit": {
                    "name": "Unit"
                },
                "search_building": "Search building",
                "search_unit": "Search unit",
                "search": "Search",
                "confirmDelete": {
                    "title": "This will permanently delete the tenant.",
                    "text": "Are you sure?"
                },
                "validation": {
                    "first_name": {
                        "required": "First name is required"
                    },
                    "last_name": {
                        "required": "Last name is required"
                    },
                    "birth_date": {
                        "required": "Birth date is required"
                    },
                    "building": {
                        "required": "Building is required"
                    },
                    "unit": {
                        "required": "Unit is required"
                    },
                    "title": {
                        "required": "Title is required"
                    },
                    "language": {
                        "required": "Language is required"
                    }
                },
                "building_card": "Assign unit",
                "personal_details_card": "Personal details",
                "account_info_card": "User login",
                "contact_info_card": "Contact details",
                "personal_data": "Personal data",
                "my_documents": "My documents",
                "my_contract": "My contract",
                "contact_persons": "My contacts",
                "no_contacts": "No contacts available",
                "rent_end": "Rent end",
                "rent_start": "Rent start",
                "rent_contract": "Rent contract",
                "contact": {
                    "category": "Category",
                    "name": "Name",
                    "email": "Email",
                    "phone": "Phone"
                },
                "titles": {
                    "mr": "Mr.",
                    "mrs": "Mrs.",
                    "company": "Company"
                },
                "status": {
                    "label": "Status",
                    "active": "Active",
                    "not_active": "Not active"
                },
                "confirmChange": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                }
            },
            "building": {
                "title": "Buildings",
                "edit_title": "Edit Building",
                "add": "Add building",
                "name": "Name",
                "cancel": "Cancel",
                "created_at": "Date",
                "edit": "Edit",
                "delete": "Delete",
                "deleted": "Building deleted successfully",
                "units": "Units",
                "save": "Save",
                "saved": "Building saved",
                "floors": "Floors",
                "basement": "Basement",
                "attic": "Attic",
                "description": "Description",
                "floor_nr": "Number of floors",
                "label": "Label",
                "address": "Address",
                "address_search": "Please enter address",
                "not_found": "Building not found",
                "house_rules": "House rules",
                "operating_instructions": "Operating instructions",
                "other": "Other",
                "files": "Files",
                "add_files": "Add files",
                "add_companies": "Add companies",
                "companies": "Services companies",
                "no_services": "No services added",
                "details": "Details",
                "select_media_category": "Selected media category",
                "district": "District",
                "tenants": "Tenants",
                "managers": "Managers",
                "requests": "Requests",
                "house_nr": "House Nr.",
                "assign": "Assign",
                "assign_managers": "Assign managers",
                "unassign_manager": "Unassign",
                "managers_assigned": "Managers assigned",
                "occupied_units": "Ocuppied units",
                "free_units": "Free units",
                "manager": {
                    "unassigned": "Manager unassigned"
                },
                "document": {
                    "uploaded": "Document uploaded",
                    "deleted": "Document deleted"
                },
                "service": {
                    "deleted": "Service removed from this building"
                },
                "confirmDelete": {
                    "title": "This will permanently delete the building.",
                    "text": "Are you sure?"
                },
                "validation": {
                    "name": {
                        "required": "Name is required"
                    },
                    "floor_nr": {
                        "required": "Floor number is required"
                    },
                    "description": {
                        "required": "Description is required"
                    },
                    "label": {
                        "required": "Label is required"
                    },
                    "address_id": {
                        "required": "Address is required"
                    }
                },
                "requestStatuses": {
                    "total": "Total requests",
                    "received": "Received requests",
                    "assigned": "Assigned requests",
                    "in_processing": "In processing requests",
                    "reactivated": "Reactivated requests",
                    "done": "Done requests",
                    "archived": "Archived requests"
                },
                "placeholders": {
                    "search": "Search"
                },
                "delete_building_modal": {
                    "title": "Delete Building(s)",
                    "description_unit": "Units are assigned to the selected property. If you want to delete the units as well, please activate the option below.",
                    "description_request": "Requests are assigned to the selected property. If you also want to delete request as well, please activate the option below.",
                    "description_both": "Units and requests are assigned to the selected property. If you also want to delete them, please activate the options below.",
                    "delete_units": "Delete Unit(s)",
                    "dont_delete_units": "Don't Delete Unit(s)",
                    "delete_requests": "Delete Request(s)",
                    "dont_delete_requests": "Don't Delete Request(s)"
                }
            },
=======
                "building": {
                    "name": "Building"
                },
                "unit": {
                    "name": "Unit"
                },
                "search_building": "Search building",
                "search_unit": "Search unit",
                "search": "Search",
                "confirmDelete": {
                    "title": "This will permanently delete the tenant.",
                    "text": "Are you sure?"
                },
                "validation": {
                    "first_name": {
                        "required": "First name is required"
                    },
                    "last_name": {
                        "required": "Last name is required"
                    },
                    "birth_date": {
                        "required": "Birth date is required"
                    },
                    "building": {
                        "required": "Building is required"
                    },
                    "unit": {
                        "required": "Unit is required"
                    },
                    "title": {
                        "required": "Title is required"
                    },
                    "language": {
                        "required": "Language is required"
                    }
                },
                "building_card": "Assign unit",
                "personal_details_card": "Personal details",
                "account_info_card": "User login",
                "contact_info_card": "Contact details",
                "personal_data": "Personal data",
                "my_documents": "My documents",
                "my_contract": "My contract",
                "contact_persons": "My contacts",
                "no_contacts": "No contacts available",
                "rent_end": "Rent end",
                "rent_start": "Rent start",
                "rent_contract": "Rent contract",
                "contact": {
                    "category": "Category",
                    "name": "Name",
                    "email": "Email",
                    "phone": "Phone"
                },
                "titles": {
                    "mr": "Mr.",
                    "mrs": "Mrs.",
                    "company": "Company"
                },
                "status": {
                    "label": "Status",
                    "active": "Active",
                    "not_active": "Not active"
                },
                "confirmChange": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                }
            },
            "building": {
                "title": "Buildings",
                "edit_title": "Edit Building",
                "add": "Add building",
                "name": "Name",
                "cancel": "Cancel",
                "created_at": "Date",
                "edit": "Edit",
                "delete": "Delete",
                "deleted": "Building deleted successfully",
                "units": "Units",
                "save": "Save",
                "saved": "Building saved",
                "floors": "Floors",
                "basement": "Basement",
                "attic": "Attic",
                "description": "Description",
                "floor_nr": "Number of floors",
                "label": "Label",
                "address": "Address",
                "address_search": "Please enter address",
                "not_found": "Building not found",
                "house_rules": "House rules",
                "operating_instructions": "Operating instructions",
                "other": "Other",
                "files": "Files",
                "add_files": "Add files",
                "add_companies": "Add companies",
                "companies": "Services companies",
                "no_services": "No services added",
                "details": "Details",
                "select_media_category": "Selected media category",
                "district": "District",
                "tenants": "Tenants",
                "managers": "Managers",
                "requests": "Requests",
                "house_nr": "House Nr.",
                "assign": "Assign",
                "assign_managers": "Assign managers",
                "unassign_manager": "Unassign",
                "managers_assigned": "Managers assigned",
                "occupied_units": "Ocuppied units",
                "free_units": "Free units",
                "manager": {
                    "unassigned": "Manager unassigned"
                },
                "document": {
                    "uploaded": "Document uploaded",
                    "deleted": "Document deleted"
                },
                "service": {
                    "deleted": "Service removed from this building"
                },
                "confirmDelete": {
                    "title": "This will permanently delete the building.",
                    "text": "Are you sure?"
                },
                "validation": {
                    "name": {
                        "required": "Name is required"
                    },
                    "floor_nr": {
                        "required": "Floor number is required"
                    },
                    "description": {
                        "required": "Description is required"
                    },
                    "label": {
                        "required": "Label is required"
                    },
                    "address_id": {
                        "required": "Address is required"
                    }
                },
                "requestStatuses": {
                    "total": "Total requests",
                    "received": "Received requests",
                    "assigned": "Assigned requests",
                    "in_processing": "In processing requests",
                    "reactivated": "Reactivated requests",
                    "done": "Done requests",
                    "archived": "Archived requests"
                },
                "placeholders": {
                    "search": "Search"
                },
                "delete_building_modal": {
                    "title": "Delete Building(s)",
                    "description_unit": "Units are assigned to the selected property. If you want to delete the units as well, please activate the option below.",
                    "description_request": "Requests are assigned to the selected property. If you also want to delete request as well, please activate the option below.",
                    "description_both": "Units and requests are assigned to the selected property. If you also want to delete them, please activate the options below.",
                    "delete_units": "Delete Unit(s)",
                    "dont_delete_units": "Don't Delete Unit(s)",
                    "delete_requests": "Delete Request(s)",
                    "dont_delete_requests": "Don't Delete Request(s)"
                }
            },
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
            "unit": {
                "title": "Units",
                "not_found": "Unit not found",
                "add": "Add unit",
                "tenantType": {
                    "attached": "Tenant attached successfully",
                    "detached": "Tenant detached successfully"
                },
                "name": "Unit number",
                "created_at": "Date",
                "edit": "Edit",
                "delete": "Remove",
                "deleted": "Unità cancellata",
                "save": "Save",
                "saved": "Unit saved",
                "floor": "Floor",
                "sq_meter": "Sq Meter",
                "room_no": "Number of rooms",
                "monthly_rent": "Monthly rent",
                "building_search": "Please enter a building name and select it",
                "building": "Building",
                "description": "Description",
                "basement": "Basement",
                "attic": "Attic",
                "requests": "Requests",
                "tenant": "Tenant",
                "empty_requests": "No requests",
                "assigned_tenant": "Assigned tenant",
                "tenant_assigned": "Tenant assigned",
                "tenant_unassigned": "Tenant unassigned",
                "type": {
                    "label": "Type",
                    "apartment": "Apartment",
                    "business": "Business"
                },
                "confirmDelete": {
                    "title": "This will permanently delete the unit.",
                    "text": "Are you sure?"
                },
                "validation": {
                    "name": {
                        "required": "Name is required"
                    },
                    "building": {
                        "required": "Building is required"
                    },
                    "monthly_rent": {
                        "required": "Monthly rent is required"
                    },
                    "floor": {
                        "required": "Floor is required"
                    },
                    "room_no": {
                        "required": "Room number is required"
                    },
                    "description": {
                        "required": "Description is required"
                    }
                },
                "placeholders": {
                    "search": "Search",
                    "select": "Select"
                }
            },
            "address": {
                "add": "Add address",
                "created_at": "Date",
                "name": "Address",
                "edit": "Edit",
                "delete": "Remove",
                "save": "Save",
                "city": "City",
                "country": "Country",
                "street": "Street",
                "street_nr": "Street Nr.",
                "zip": "Zip",
                "not_found": "Address not found",
                "saved": "Address saved",
                "confirmDelete": {
                    "title": "This will permanently delete the address.",
                    "text": "Are you sure?"
                },
                "state": {
                    "label": "State"
                },
                "validation": {
                    "state": {
                        "required": "State is required"
                    },
                    "city": {
                        "required": "City is required"
                    },
                    "street": {
                        "required": "Street is required"
                    },
                    "street_nr": {
                        "required": "Street number is required"
                    },
                    "zip": {
                        "required": "Zip is required"
                    }
                }
            },
            "post": {
                "title": "News",
                "title_label": "Title",
                "content": "Content",
                "preview": "Preview",
                "add": "Add",
                "add_pinned": "Add pinned post",
                "save": "Save",
                "saved": "Notizie salvate",
                "updated": "Notizie aggiornate",
                "deleted": "Notizie cancellate",
                "edit": "Edit",
                "edit_title": "Edit post",
                "show": "Details",
                "user": "User",
                "delete": "Delete",
                "likes": "Likes",
                "details": "Post Details",
                "published_at": "Published",
                "publish": "Publish",
                "unpublish": "Unpublish",
                "buildings": "Buildings",
                "pinned": "Pinned",
                "notify_email": "Notify email",
                "pinned_to": "Pinned to",
                "comments": "Comments",
                "images": "Images",
                "details_title": "Details",
                "placeholders": {
                    "buildings": "Choose buildings",
                    "search": "Search",
                    "search_provider": "Search provider"
                },
                "media": {
                    "deleted": "Document/Photo Deleted",
                    "uploaded": "Document/Photo Uploaded"
                },
                "type": {
                    "label": "Type",
                    "article": "Article",
                    "new_neighbour": "New neighbour",
                    "pinned": "Pinned"
                },
                "status": {
                    "label": "Status",
                    "new": "New",
                    "published": "Published",
                    "unpublished": "Unpublished",
                    "not_approved": "Not approved"
                },
                "visibility": {
                    "label": "Visibility",
                    "address": "Address",
                    "district": "District",
                    "all": "All"
                },
                "confirmChange": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                },
                "assignmentTypes": {
                    "building": "Building",
                    "district": "District"
                },
                "assignType": "Type",
                "unassign": "Unassign",
                "assign": "Assign",
                "attached": {
                    "building": "Building assigned",
                    "district": "District assigned",
                    "provider": "Provider assigned"
                },
                "detached": {
                    "building": "Buiding unassigned",
                    "district": "District unassigned",
                    "provider": "Provider unassigned"
                },
                "buildingAlreadyAssigned": "Building is already inside on a district",
                "confirmUnassign": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                },
                "execution_interval": {
                    "label": "Execution interval",
                    "end": "Execution End",
                    "start": "Execution Start",
                    "separator": "To"
                },
                "category": {
                    "label": "Category",
                    "general": "General",
                    "maintenance": "Maintenance",
                    "electricity": "Electricity",
                    "heating": "Heating",
                    "sanitary": "Sanitary"
                }
            },
            "service": {
                "title": "Services",
                "add_title": "Add Service",
                "edit_title": "Edit Service",
                "edit": "Edit",
                "delete": "Delete",
                "saved": "Servizio salvato",
                "deleted": "Servizio cancellato",
                "category": "Category",
                "electrician": "Electrician",
                "heating_company": "Heating company",
                "lift": "Lift",
                "sanitary": "Sanitary",
                "key_service": "Key service",
                "caretaker": "Caretaker",
                "real_estate_service": "Real estate service",
                "name": "Name",
                "requests": "Requests",
                "contact_details": "Contact details",
                "user_credentials": "User credentials",
                "company_details": "Company details",
                "assignmentTypes": {
                    "building": "Building",
                    "district": "District"
                },
                "assignType": "Type",
                "unassign": "Unassign",
                "assign": "Assign",
                "attached": {
                    "building": "Building assigned",
                    "district": "District assigned"
                },
                "detached": {
                    "building": "Buiding unassigned",
                    "district": "District unassigned"
                },
                "buildingAlreadyAssigned": "Building is already inside on a district",
                "confirmUnassign": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                },
                "placeholders": {
                    "search": "Search",
                    "category": "Select category"
                }
            },
            "district": {
                "title": "Districts",
                "name": "Name",
                "description": "Description",
                "add": "Add district",
                "save": "Save",
                "saved": "Distretto salvato",
                "edit_action": "Edit",
                "delete": "Delete",
                "deleted": "Distretto soppresso",
                "cancel": "Cancel",
                "required": "This field is required",
                "details": "Details",
                "buildings": "Buildings"
            },
            "realEstate": {
                "title": "Settings real estate",
                "details": "Details",
                "settings": "Settings",
                "district_enable": "District",
                "marketplace_approval_enable": "Enable Market",
                "news_approval_enable": "News approval",
                "comment_update_timeout": "Comment update timeout",
                "closed": "Closed",
                "saved": "Real estate saved",
                "schedule": "Schedule",
                "endTime": "End time",
                "startTime": "Start time",
                "to": "To",
                "categories": "Categories",
                "templates": "Templates",
                "contact_enable": "Enable 'My contacts'",
                "cleanify_email": "Cleanify email",
                "mail_encryption": "Encryption",
                "mail_from_address": "From address",
                "mail_from_name": "From Name",
                "mail_host": "Host",
                "mail_password": "Password",
                "mail_port": "Port",
                "mail_username": "Username",
                "iframe_url": {
                    "label": "Iframe URL",
                    "validation": "Iframe URL should be a valid URL"
                }
            },
            "request": {
                "audits": "Audits",
                "edit": "Edit",
                "delete": "Delete",
                "deleted": "Richiesta cancellata",
                "title": "Requests",
                "created": "Created",
                "saved": "Richiesta salvata",
                "prop_title": "Title",
                "description": "Description",
                "category": "Category",
                "address": "Address",
                "edit_title": "Edit request",
                "add_title": "Add request",
                "tenant": "Tenant",
                "due_date": "Due date",
                "closed_date": "Closed date",
                "service": "Service",
                "created_by": "Created by",
                "is_public": "Public",
                "comments": "Comments",
                "assigned_to": "Assigned to",
                "assign_providers": "Assign providers",
                "assign_managers": "Assign managers",
                "unassign": "Unassign",
                "notify": "Notify",
                "public_legend": "Set this option to make the request visible to all tenant neighbours",
                "conversation": "Conversation",
                "open_conversation": "Open",
                "other_recipients": "Other recipients",
                "recipients": "Recipients",
                "assign": "Assign",
                "images": "Images",
                "no_images_message": "No files uploaded",
                "request_details": "Request details",
                "internal_notices": "Internal notices",
                "status_changed": "Status changed",
                "priority_changed": "Priority changed",
                "assignmentTypes": {
                    "services": "Services",
                    "managers": "Managers"
                },
                "media": {
                    "added": "Documento aggiunto",
                    "removed": "Media removed",
                    "deleted": "Media deleted",
                    "delete": "Delete"
                },
                "priority": {
                    "label": "Priority",
                    "urgent": "Urgent",
                    "low": "Low",
                    "normal": "Normal"
                },
                "defect_location": {
                    "label": "Defect location",
                    "apartment": "Apartment",
                    "building": "Building",
                    "environment": "Environment"
                },
                "qualification": {
                    "label": "Qualification",
                    "none": "None",
                    "optical": "Optical",
                    "sia": "Sia",
                    "2_year_warranty": "2 Year Warranty",
                    "cost_consequences": "Cost consequences"
                },
                "status": {
                    "label": "Status",
                    "received": "Received",
                    "in_processing": "In processing",
                    "assigned": "Assigned",
                    "done": "Done",
                    "reactivated": "Reactivated",
                    "archived": "Archived"
                },
                "category_options": {
                    "disturbance": "Disturbance",
                    "defect": "Defect",
                    "order_documents": "Order documents",
                    "order_a_payment_slip": "Order a payment slip",
                    "questions_about_the_tenancy": "Questions about the tenancy",
                    "other": "Other",
                    "environment": "Environment",
                    "house": "House",
                    "apartment": "Apartment"
                },
                "placeholders": {
                    "category": "Select category",
                    "priority": "Select priority",
                    "defect_location": "Select defect location",
                    "qualification": "Select qualification",
                    "status": "Select status",
                    "due_date": "Pick due date",
                    "tenant": "Search for a tenant",
                    "service": "Search for a service",
                    "propertyManagers": "Search for managers",
                    "search": "Search",
                    "visibility": "Select visibility"
                },
                "confirmChange": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                },
                "confirmUnassign": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                },
                "mail": {
                    "body": "Body",
                    "subject": "Subject",
                    "to": "To",
                    "title": "Notify service",
                    "notify": "Send Email",
                    "bodyPlaceholder": "Please write your message here",
                    "provider": "Provider",
                    "manager": "Manager",
                    "cancel": "Cancel",
                    "send": "Send",
                    "cc": "CC",
                    "bcc": "BCC",
                    "success": "Notification mail sent successfully",
                    "validation": {
                        "required": "This field is required",
                        "email": "This field should be a valid email"
                    },
                    "fail_cc": "CC/BCC/TO fields must be valid emails"
                },
                "attached": {
                    "services": "Provider attached successfully",
                    "managers": "Manager attached successfully",
                    "user": "User assigned successfully"
                },
                "detached": {
                    "service": "Provider detached successfully",
                    "manager": "Manager detached successfully",
                    "user": "User unassigned successfully"
                },
                "userType": {
                    "label": "Type",
                    "provider": "Service",
                    "user": "Manager"
                },
                "visibility": {
                    "label": "Visibility",
                    "tenant": "Private",
                    "district": "District",
                    "building": "Building"
                },
                "requestID": "Request ID",
                "requestCategory": "Request Category"
            },
            "requestCategory": {
                "title": "Request categories",
                "add": "Add category",
                "edit": "Edit",
                "delete": "Delete",
                "name": "Name",
                "cancel": "Cancel",
                "required": "This field is required",
                "parent": "Parent category"
            },
            "propertyManager": {
                "title": "Property managers",
                "title_label": "Title",
                "add": "Add property manager",
                "save": "Save",
                "saved": "Property manager salvato",
                "deleted": "Property manager cancellato",
                "edit": "Edit",
                "edit_title": "Edit property manager",
                "delete": "Delete",
                "firstName": "First name",
                "lastName": "Last name",
                "name": "Name",
                "profession": "Profession",
                "slogan": "Slogan",
                "linkedin_url": "Linkedin URL",
                "xing_url": "Xing URL",
                "email": "Email",
                "password": "Password",
                "confirm_password": "Confirm password",
                "phone": "Phone",
                "building_card": "Assign buildings",
                "details_card": "Details",
                "no_buildings": "There are no buildings assigned",
                "add_buildings": "Add buildings",
                "buildings_search": "Search for buildings",
                "districts": "Districts",
                "requests": "Requests",
                "assign": "Assign",
                "unassign": "Unassign",
                "delete_with_reassign_modal": {
                    "title": "Delete & reassign buildings",
                    "description": "The selected property manager is linked to properties. You can assign the properties to another person. To do this, select a property manager from the list.",
                    "search_title": "Search Property Manager"
                },
                "delete_without_reassign": "Delete",
                "profile_card": "User Profile",
                "social_card": "Social Media",
                "titles": {
                    "mr": "Mr.",
                    "mrs": "Mrs."
                },
                "assignmentTypes": {
                    "building": "Building",
                    "district": "District"
                },
                "assignType": "Type",
                "placeholders": {
                    "search": "Search"
                },
                "attached": {
                    "building": "Building assigned",
                    "district": "District assigned"
                },
                "detached": {
                    "building": "Buiding unassigned",
                    "district": "District unassigned"
                },
                "buildingAlreadyAssigned": "Building is already inside on a district",
                "confirmUnassign": {
                    "title": "Are you sure you want to continue?",
                    "warning": "Warning",
                    "confirmBtnText": "Ok",
                    "cancelBtnText": "Cancel"
                }
            },
            "product": {
                "title": "Products",
                "add": "Add product",
                "edit_title": "Edit product",
                "edit": "Edit",
                "delete_action": "Delete",
                "show": "Details",
                "details": "Product details",
                "delete": "Delete product",
                "content": "Content",
                "product_title": "Title",
                "published_at": "Published",
                "publish": "Publish",
                "unpublish": "Unpublish",
                "likes": "Likes",
                "save": "Save",
                "saved": "Prodotto salvato",
                "deleted": "Prodotto cancellato",
                "comments": "Comments",
                "user": "User",
                "contact": "Contact",
                "price": "Price",
                "media": {
                    "deleted": "Document/Photo Deleted",
                    "uploaded": "Document/Photo Uploaded"
                },
                "type": {
                    "label": "Type",
                    "sell": "Sell",
                    "lend": "Lend",
                    "service": "Service",
                    "giveaway": "Give away"
                },
                "status": {
                    "label": "Status",
                    "published": "Published",
                    "unpublished": "Unpublished"
                },
                "visibility": {
                    "label": "Visibility",
                    "address": "Address",
                    "district": "District",
                    "all": "All"
                }
            },
            "template": {
                "name": "Name",
                "edit": "Edit",
                "delete": "Delete",
                "saved": "Modello salvato",
                "deleted": "Modello cancellato",
                "add": "Add",
                "title": "Templates",
                "subject": "Subject",
                "body": "Body",
                "category": "Category",
                "tags": "Tags",
                "placeholders": {
                    "category": "Choose category"
                }
            },
            "cleanify": {
                "pageTitle": "Cleanify request",
                "title": "Title",
                "lastName": "Last name",
                "firstName": "First name",
                "address": "Address",
                "city": "City",
                "zip": "Zip",
                "email": "Email",
                "phone": "Phone",
                "save": "Send request",
                "success": "Cleanify request sent successfully",
                "terms_and_conditions": "Accept Terms & Conditions",
                "terms_text": "Terms text here, long text"
            }
        },
        "filters": {
            "header": "Filtri",
            "districts": "Distretti",
            "buildings": "Edifici",
            "requests": "Richieste",
            "open_requests": "Richieste aperte",
            "units": "Unità",
            "states": "Stati",
            "status": "Stato",
            "search": "Ricerca",
            "requestStatus": "Stato della richiesta",
            "propertyManagers": "Proprietà Manager",
            "categories": "Categorie",
            "created_from": "Creato da",
            "created_to": "Creato per",
            "services": "Servizi",
            "tenant": "Tipo inquilini"
        },
        "dashboard": {
            "statistics": "Statistiche",
            "requests_by_creation_date": "Richieste per data di creazione",
            "requests_by_status": "Richieste per stato",
            "requests_by_category": "Richieste per categoria",
            "requests_by_assigned_status": "Requests by assigned status",
            "each_hour_request": "Ogni ora richiede",
            "average_request_duration": "Tempo di risoluzione",
            "week_hour": "Settimana vs. Ora",
            "month_date": "Mese vs. data",
            "news_by_creation_date": "Notizie per data di creazione",
            "news_by_status": "Notizie per stato",
            "news_by_type": "Notizie per tipo",
            "latest_products": "Ultimi prodotti",
            "products_by_creation_date": "Mercato dei prodotti per data di creazione",
            "products_by_type": "Piazza del mercato prodotti per tipologia",
            "tenants_by_creation_date": "Gli inquilini per data di creazione",
            "tenants_by_request_status": "Situazione degli inquilini in base alle richieste",
            "tenants_by_status": "Affittuari per stato",
            "tenants_by_language": "Affittuari per lingua",
            "tenants_by_title": "Affittuari per titolo",
            "tenants_by_device": "Affittuari per dispositivo",
            "tenants_by_gender": "Affittuari per sesso",
            "actions": "Azioni",
            "requests": {
                "requests_with_service_providers": "Con i fornitori di servizi",
                "request_wihout_service_providers": "Senza fornitori di servizi"
            },
            "buildings": {
                "total_building": "Totale",
                "total_units": "Totale unità",
                "occupied_units": "Unità occupate",
                "free_units": "Unità libere",
                "buildings_by_creation_date": "Edifici per data di creazione"
            },
            "tenants": {
                "total_tenants": "Totale",
                "average_age": "Età media",
                "average_age_acr": "Media Età"
            },
            "marketplace": {
                "go_to_marketplace": "vai al mercato"
            }
        },
        "auth": {
            "failed": "Credenziali non corrispondenti ai dati registrati.",
            "throttle": "Troppi tentativi di accesso. Riprova tra {seconds} secondi.",
            "login_welcome": "Bentornato, accedi al tuo account."
        },
        "settings": {
            "notifications": "Notifications and language",
            "admin": "Admin notifications",
            "news": "News notifications",
            "marketplace": "Marketplace notifications",
            "service": "Service notifications",
            "updated": "Settings updated",
            "language": "Language",
            "summary": {
                "label": "Summary statistics",
                "daily": "Daily",
                "monthly": "Monthly",
                "yearly": "Yearly"
            },
            "contact_enable": {
                "use_global": "Usa globale",
                "show": "Mostrare",
                "hide": "Nascondere"
            }
        },
        "pagination": {
            "previous": "&laquo; Precedente",
            "next": "Successivo &raquo;"
        },
        "views": {
            "tenant": {
                "my": {
                    "personal": {
                        "title": "Personal data",
                        "description": "My personal details.",
                        "placeholder": {
                            "title": "No personal data available.",
                            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
                        }
                    }
                }
            }
        },
        "menu": {
            "dashboard": "Cruscotto",
            "news": "Notizie",
            "requests": "Richieste",
            "all_requests": "Tutte le richieste",
            "marketplace": "Mercato",
            "settings": "Impostazioni",
            "logout": "Logout",
            "profile": "Profilo",
            "users": "Utenti",
            "employees": "Dirigenti",
            "companies": "Servizi",
            "admins": "Amministratori",
            "super_admins": "Super amministratori",
            "home_owners": "Proprietari",
            "registered": "Registrato",
            "about": "A proposito di",
            "feedback": "Feedback",
            "tenants": "Gli inquilini",
            "buildings": "Edifici",
            "all_buildings": "Tutti gli edifici",
            "units": "Unità",
            "addresses": "Indirizzi",
            "posts": "Notizie",
            "districts": "Distretti",
            "products": "Prodotti",
            "requestCategories": "Richiesta categorie",
            "services": "Partner di servizio",
            "activity": "Attività",
            "propertyManagers": "Gestori",
            "templates": "Modelli"
        },
        "components": {
            "common": {
                "audit": {
                    "type": {
                        "post": "Messaggio",
                        "product": "Prodotto",
                        "request": "Richiesta"
                    },
                    "filter": {
                        "type": {
                            "post": "Messaggio",
                            "product": "Prodotto",
                            "request": "Richiesta"
                        },
                        "post": {
                            "created": "Creato",
                            "updated": "Aggiornamenti",
                            "provider_assigned": "Fornitore assegnato",
                            "user_assigned": "Utente assegnato",
                            "media_uploaded": "Media caricati",
                            "media_deleted": "Supporti cancellati"
                        },
                        "product": [],
                        "request": {
                            "created": "Creato",
                            "updated": "Aggiornamenti",
                            "provider_assigned": "Fornitore assegnato",
                            "user_assigned": "Utente assegnato",
                            "media_uploaded": "Media caricati",
                            "media_deleted": "Supporti cancellati"
                        }
                    },
                    "content": {
                        "withId": {
                            "post": {
                                "created": "{userName} ha aperto questo {auditable_type} su {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\".",
                                    "published_at": "Messaggio pubblicato su {new}."
                                }
                            },
                            "product": {
                                "created": "{userName} ha aperto questo {auditable_type}.",
                                "updated": {
                                    "title": "Il titolo è cambiato da \"{old}\" al \"{new}\".",
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\".",
                                    "due_date": "La data di scadenza è cambiata da \"{old}\" al \"{new}\".",
                                    "priority": "La categoria è cambiata da \"{old}\" al \"{new}\".",
                                    "category_id": "La categoria è cambiata da \"{old}\" al \"{new}\".",
                                    "qualification": "La qualifica è cambiata da \"{old}\" al \"{new}\".",
                                    "visibility": "La visibilità è cambiata da \"{old}\" al \"{new}\"."
                                },
                                "provider_assigned": "{providerName} è stato assegnato come fornitore.",
                                "user_assigned": "{userName} è stato assegnato come manager.",
                                "media_uploaded": "Media caricati",
                                "media_deleted": "Supporti cancellati"
                            },
                            "request": {
                                "created": "{userName} ha aperto questo {auditable_type}.",
                                "updated": {
                                    "title": "Il titolo è cambiato da \"{old}\" al \"{new}\".",
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\".",
                                    "due_date": "La data di scadenza è cambiata da \"{old}\" al \"{new}\".",
                                    "priority": "La categoria è cambiata da \"{old}\" al \"{new}\".",
                                    "category_id": "La categoria è cambiata da \"{old}\" al \"{new}\".",
                                    "qualification": "La qualifica è cambiata da \"{old}\" al \"{new}\".",
                                    "visibility": "La visibilità è cambiata da \"{old}\" al \"{new}\"."
                                },
                                "provider_assigned": "{providerName} è stato assegnato come fornitore.",
                                "user_assigned": "{userName} è stato assegnato come manager.",
                                "media_uploaded": "Media caricati",
                                "media_deleted": "Supporti cancellati"
                            }
                        },
                        "withNoId": {
                            "post": {
                                "created": "{userName} ha aperto questo {auditable_type} su {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "published_at": "Messaggio pubblicato su {new} su {auditable_type} #{auditable_id}."
                                }
                            },
                            "product": {
                                "created": "{userName} ha aperto questo {auditable_type} su {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "title": "Il titolo è cambiato da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "due_date": "La data di scadenza è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "priority": "La categoria è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "category_id": "La categoria è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "qualification": "La qualifica è cambiata da \"{old}\" al \"{new}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "visibility": "La visibilità è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}."
                                },
                                "provider_assigned": "{providerName} è stato assegnato come fornitore su {auditable_type} #{auditable_id}.",
                                "user_assigned": "{userName} è stato assegnato come manager su {auditable_type} #{auditable_id}.",
                                "media_uploaded": "Media caricati su {auditable_type} #{auditable_id}.",
                                "media_deleted": "Supporti cancellati su {auditable_type} #{auditable_id}."
                            },
                            "request": {
                                "created": "{userName} opened this {auditable_type} su {auditable_type} #{auditable_id}.",
                                "updated": {
                                    "title": "Il titolo è cambiato da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "status": "Lo stato è cambiato da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "due_date": "La data di scadenza è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "priority": "La categoria è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "category_id": "La categoria è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "qualification": "La qualifica è cambiata da \"{old}\" al \"{new}\" al \"{new}\" su {auditable_type} #{auditable_id}.",
                                    "visibility": "La visibilità è cambiata da \"{old}\" al \"{new}\" su {auditable_type} #{auditable_id}."
                                },
                                "provider_assigned": "{providerName} è stato assegnato come fornitore su {auditable_type} #{auditable_id}.",
                                "user_assigned": "{userName} è stato assegnato come manager su {auditable_type} #{auditable_id}.",
                                "media_uploaded": "Media caricati su {auditable_type} #{auditable_id}.",
                                "media_deleted": "Supporti cancellati su {auditable_type} #{auditable_id}."
                            }
                        }
                    }
                },
                "commentsList": {
                    "loading": "Caricamento...",
                    "loadMore": {
                        "simple": "Carico {count} ",
                        "detailed": "Carico {count} altri commenti"
                    },
                    "emptyPlaceholder": {
                        "title": "Non ci sono ancora messaggi...",
                        "description": "Avviare la messaggistica utilizzando il modulo sottostante e premere Invio."
                    }
                },
                "comment": {
                    "updateShortcut": "o l'uso {shortcut} scorciatoia",
                    "updateOrCancel": "{update} o premere {esc} al {cancel}",
                    "update": "attualizzazione",
                    "esc": "ESC",
                    "cancel": "stornare",
                    "addChildComment": "Commento",
                    "loadMore": "Carica 1 commento in più | Carica {count} più commenti",
                    "deletedCommentPlaceholder": "Questo commento è stato cancellato."
                },
                "addComment": {
                    "placeholder": "Scrivi un commento...",
                    "tooltipTemplates": "Scegliere un modello",
                    "loadingTemplates": "Caricamento dei modelli...",
                    "saveShortcut": "o l'uso {shortcut} scorciatoia",
                    "emptyTemplatesPlaceholder": "Nessun modello disponibile."
                },
                "media": {
                    "buttons": {
                        "selectFiles": {
                            "withDrop": "Rilasciare i file o fare clic per selezionare...",
                            "withoutDrop": "Fare clic per selezionare..."
                        },
                        "upload": "Carica"
                    },
                    "dropActive": {
                        "title": "Lascia qui i tuoi file...",
                        "description": "Sono ammessi solo i file con una certa estensione."
                    },
                    "messages": {
                        "preview": "Questo file non può essere visualizzato in anteprima.",
                        "uploading": "Caricamento...",
                        "uploaded": "I file multimediali sono stati caricati con successo.",
                        "size": "Ops! Alcuni file avevano dimensioni maggiori del massimo consentito di {bytes}.",
                        "extensions": "Ops! Alcuni file hanno avuto un'estensione non consentita. Saltare..."
                    }
                }
            },
            "tenant": {
                "weatherWidget": {
                    "minTemp": "min",
                    "maxTemp": "massimo",
                    "wind": "eolico",
                    "cloudiness": "nebulosità",
                    "humidity": "umidità",
                    "pressure": "pressione"
                },
                "postAdd": {
                    "visibility": {
                        "address": "Indirizzo",
                        "district": "Distretto",
                        "all": "Tutti"
                    }
                }
            },
            "admin": []
        },
        "layouts": {
            "tenant": {
                "menu": {
                    "logout": "Logout"
                },
                "sidebar": {
                    "dashboard": "Dashboard",
                    "myTenancy": "My tenancy",
                    "myPersonalData": "My personal data",
                    "myRecentContract": "My recent contract",
                    "myDocuments": "Documents",
                    "myContactPersons": "Contact persons",
                    "posts": "News",
                    "requests": "Requests",
                    "products": "Marketplace",
                    "settings": "Settings"
                }
            }
        },
<<<<<<< HEAD
        "pages": {
            "profile": {
                "pageTitle": "Profile",
                "profile": "Profile",
                "account": "Account",
                "security": "Security",
                "notifications": "Notifications"
            },
            "user": {
                "title": "Users"
            },
            "request_activities": {
                "title": "Request activities"
            },
            "tenant": {
                "title": "Tenants"
            }
        },
        "pagination": {
            "previous": "&laquo; Precedente",
            "next": "Successivo &raquo;"
        },
        "passwords": {
            "password": "Le password devono essere di almeno 6 caratteri e devono coincidere.",
            "reset": "La password è stata reimpostata!",
            "sent": "Promemoria della password inviato!",
            "token": "Questo token per la reimpostazione della password non è valido.",
            "user": "Non esiste un utente associato a questo indirizzo e-mail."
        },
        "settings": {
            "notifications": "Notifications and language",
            "admin": "Admin notifications",
            "news": "News notifications",
            "marketplace": "Marketplace notifications",
            "service": "Service notifications",
            "updated": "Settings updated",
            "language": "Language",
            "summary": {
                "label": "Summary statistics",
                "daily": "Daily",
                "monthly": "Monthly",
                "yearly": "Yearly"
            }
=======
        "common": {
            "mr": "Sig.",
            "mrs": "Signora",
            "company": "L'azienda",
            "user_title_mr": "Sig.",
            "user_title_mrs": "Signora",
            "user_title_company": "L'azienda",
            "tenant_title_mr": "Sig.",
            "tenant_title_mrs": "Signora",
            "tenant_title_company": "L'azienda",
            "request_status_1": "Ricevuto",
            "request_status_2": "In Elaborazione",
            "request_status_3": "Assegnato",
            "request_status_4": "Fatto",
            "request_status_5": "Riattivati",
            "request_status_6": "Archiviato",
            "originalRequest_status_1": "Ricevuto",
            "originalRequest_status_2": "In Elaborazione",
            "originalRequest_status_3": "Assegnato",
            "originalRequest_status_4": "Fatto",
            "originalRequest_status_5": "Riattivati",
            "originalRequest_status_6": "Archiviato",
            "email_footer_message1": "Questa e-mail è stata generata automaticamente per {UserName}.",
            "email_footer_message2": "Si ottiene questa e-mail generata automaticamente come utente di {CompanyName}.",
            "email_link_contacts": "Contatti.",
            "email_link_terms_of_use": "Condizioni d'uso",
            "email_link_data_protection": "Protezione dei dati"
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
        },
        "validation": {
            "accepted": "{attribute} deve essere accettato.",
            "active_url": "{attribute} non è un URL valido.",
            "after": "{attribute} deve essere una data successiva al {date}.",
            "after_or_equal": "{attribute} deve essere una data successiva o uguale al {date}.",
            "alpha": "{attribute} può contenere solo lettere.",
            "alpha_dash": "{attribute} può contenere solo lettere, numeri e trattini.",
            "alpha_num": "{attribute} può contenere solo lettere e numeri.",
            "array": "{attribute} deve essere un array.",
            "before": "{attribute} deve essere una data precedente al {date}.",
            "before_or_equal": "{attribute} deve essere una data precedente o uguale al {date}.",
            "between": {
                "numeric": "{attribute} deve trovarsi tra {min} - {max}.",
                "file": "{attribute} deve trovarsi tra {min} - {max} kilobyte.",
                "string": "{attribute} deve trovarsi tra {min} - {max} caratteri.",
                "array": "{attribute} deve avere tra {min} - {max} elementi."
            },
            "boolean": "Il campo {attribute} deve essere vero o falso.",
            "confirmed": "Il campo di conferma per {attribute} non coincide.",
            "date": "{attribute} non è una data valida.",
            "date_equals": "The {attribute} must be a date equal to {date}.",
            "date_format": "{attribute} non coincide con il formato {format}.",
            "different": "{attribute} e {other} devono essere differenti.",
            "digits": "{attribute} deve essere di {digits} cifre.",
            "digits_between": "{attribute} deve essere tra {min} e {max} cifre.",
            "dimensions": "Le dimensioni dell'immagine di {attribute} non sono valide.",
            "distinct": "{attribute} contiene un valore duplicato.",
            "email": "{attribute} non è valido.",
            "exists": "{attribute} selezionato non è valido.",
            "file": "{attribute} deve essere un file.",
            "filled": "Il campo {attribute} deve contenere un valore.",
            "gt": {
                "numeric": "{attribute} deve essere maggiore di {value}.",
                "file": "{attribute} deve essere maggiore di {value} kilobyte.",
                "string": "{attribute} deve contenere più di {value} caratteri.",
                "array": "{attribute} deve contenere più di {value} elementi."
            },
            "gte": {
                "numeric": "{attribute} deve essere uguale o maggiore di {value}.",
                "file": "{attribute} deve essere uguale o maggiore di {value} kilobyte.",
                "string": "{attribute} deve contenere un numero di caratteri uguale o maggiore di {value}.",
                "array": "{attribute} deve contenere un numero di elementi uguale o maggiore di {value}."
            },
            "image": "{attribute} deve essere un'immagine.",
            "in": "{attribute} selezionato non è valido.",
            "in_array": "Il valore del campo {attribute} non esiste in {other}.",
            "integer": "{attribute} deve essere un numero intero.",
            "ip": "{attribute} deve essere un indirizzo IP valido.",
            "ipv4": "{attribute} deve essere un indirizzo IPv4 valido.",
            "ipv6": "{attribute} deve essere un indirizzo IPv6 valido.",
            "json": "{attribute} deve essere una stringa JSON valida.",
            "lt": {
                "numeric": "{attribute} deve essere minore di {value}.",
                "file": "{attribute} deve essere minore di {value} kilobyte.",
                "string": "{attribute} deve contenere meno di {value} caratteri.",
                "array": "{attribute} deve contenere meno di {value} elementi."
            },
            "lte": {
                "numeric": "{attribute} deve essere minore o uguale a {value}.",
                "file": "{attribute} deve essere minore o uguale a {value} kilobyte.",
                "string": "{attribute} deve contenere un numero di caratteri minore o uguale a {value}.",
                "array": "{attribute} deve contenere un numero di elementi minore o uguale a {value}."
            },
            "max": {
                "numeric": "{attribute} non può essere superiore a {max}.",
                "file": "{attribute} non può essere superiore a {max} kilobyte.",
                "string": "{attribute} non può contenere più di {max} caratteri.",
                "array": "{attribute} non può avere più di {max} elementi."
            },
            "mimes": "{attribute} deve essere del tipo: {values}.",
            "mimetypes": "{attribute} deve essere del tipo: {values}.",
            "min": {
                "numeric": "{attribute} deve essere almeno {min}.",
                "file": "{attribute} deve essere almeno di {min} kilobyte.",
                "string": "{attribute} deve contenere almeno {min} caratteri.",
                "array": "{attribute} deve avere almeno {min} elementi."
            },
            "not_in": "Il valore selezionato per {attribute} non è valido.",
            "not_regex": "Il formato di {attribute} non è valido.",
            "numeric": "{attribute} deve essere un numero.",
            "present": "Il campo {attribute} deve essere presente.",
            "regex": "Il formato del campo {attribute} non è valido.",
            "required": "Il campo {attribute} è richiesto.",
            "required_if": "Il campo {attribute} è richiesto quando {other} è {value}.",
            "required_unless": "Il campo {attribute} è richiesto a meno che {other} sia in {values}.",
            "required_with": "Il campo {attribute} è richiesto quando {values} è presente.",
            "required_with_all": "Il campo {attribute} è richiesto quando {values} sono presenti.",
            "required_without": "Il campo {attribute} è richiesto quando {values} non è presente.",
            "required_without_all": "Il campo {attribute} è richiesto quando nessuno di {values} è presente.",
            "same": "{attribute} e {other} devono coincidere.",
            "size": {
                "numeric": "{attribute} deve essere {size}.",
                "file": "{attribute} deve essere {size} kilobyte.",
                "string": "{attribute} deve contenere {size} caratteri.",
                "array": "{attribute} deve contenere {size} elementi."
            },
            "starts_with": "The {attribute} must start with one of the following: {values}",
            "string": "{attribute} deve essere una stringa.",
            "timezone": "{attribute} deve essere una zona valida.",
            "unique": "{attribute} è stato già utilizzato.",
            "uploaded": "{attribute} non è stato caricato.",
            "url": "Il formato del campo {attribute} non è valido.",
            "uuid": "The {attribute} must be a valid UUID.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": {
                "name": "nome",
                "username": "nome utente",
                "email": "email",
                "first_name": "nome",
                "last_name": "cognome",
                "password": "password",
                "password_confirmation": "conferma password",
                "city": "città",
                "country": "paese",
                "address": "indirizzo",
                "phone": "telefono",
                "mobile": "cellulare",
                "age": "età",
                "sex": "sesso",
                "gender": "genere",
                "day": "giorno",
                "month": "mese",
                "year": "anno",
                "hour": "ora",
                "minute": "minuto",
                "second": "secondo",
                "title": "titolo",
                "content": "contenuto",
                "description": "descrizione",
                "excerpt": "estratto",
                "date": "data",
                "time": "ora",
                "available": "disponibile",
                "size": "dimensione"
            },
            "general": {
                "required": "This field is required"
            },
            "price": {
                "valid": "Please enter a valid price",
                "required": "Price is required"
            },
            "firstName": {
                "required": "First name is required"
            },
            "lastName": {
                "required": "Last name is required"
            },
            "phone": {
                "required": "Phone is required"
            },
            "address": {
                "required": "Address is required"
            },
            "zip": {
                "required": "Zip is required"
            },
            "city": {
                "required": "City is required"
            },
            "title": {
                "required": "Title is required"
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
                        "title": "Personal data",
                        "description": "My personal details.",
                        "placeholder": {
                            "title": "No personal data available.",
                            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
                        }
                    }
                }
=======
        "general": {
            "en": "EN",
            "fr": "FR",
            "it": "IT",
            "de": "DE",
            "yes": "Yes",
            "timestamps": {
                "hours": "Orario",
                "days": "Giorni",
                "weeks": "Settimane",
                "months": "Mesi",
                "years": "Anni"
            },
            "chooseLanguage": "Scegliere la lingua",
            "languages": {
                "fr": "Français",
                "it": "Italiano",
                "de": "Deutsch",
                "en": "English"
            },
            "footerText": {
                "companyName": "Propify",
                "leftSideText": "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero quis beatae officia saepe perferendis voluptatum minima eveniet voluptates dolorum, temporibus nisi maxime nesciunt totam repudiandae commodi sequi dolor quibusdam sunt.",
                "allRightsSaved": "Tutti i diritti riservati"
            },
            "days": {
                "monday": "lunedì",
                "tuesday": "martedì",
                "wednesday": "mercoledì",
                "thursday": "Giovedì",
                "friday": "venerdì",
                "saturday": "sabato",
                "sunday": "domenicale"
            },
            "no": "No",
            "none": "Nessuna",
            "all": "Tutti",
            "loadMore": "Carica di più",
            "account": "Conto",
            "unauthenticated": "Non autenticato",
            "logged_out": "Disconnesso",
            "logged_in": "Loggato",
            "invalid_credentials": "Credenziali non valide",
            "server_error": "Errore del server",
            "reset_password": "Reimpostare la password",
            "reset_password_mail": "Inviare la mail di reset della password",
            "reset_password_mail_sent": "Reimposta la password inviata, controlla la tua casella di posta in arrivo",
            "back_to_login": "Torna al login",
            "forgot_password": "Password dimenticata",
            "remember_me": "Ricordati di me",
            "password": "La password",
            "change_password": "Cambiare la password",
            "new_password": "Nuova password",
            "old_password": "Vecchia password",
            "new_password_confirmation": "Conferma della nuova password",
            "change": "Cambiamento",
            "cancel": "Annulla",
            "confirm": "Conferma",
            "confirm_password": "Conferma la password",
            "incorrect_password": "La vecchia password è incorect",
            "password_changed": "Password modificata con successo",
            "details_saved": "Dettagli salvati",
            "please_wait": "Attendere per favore...",
            "no_data_available": "Nessun dato disponibile",
            "password_validation": {
                "required": "La password è richiesta",
                "confirm": "Inserisci nuovamente la password",
                "match": "Le password non sono uguali",
                "min": "La password deve essere di almeno 6 caratteri",
                "old_password_min": "La vecchia password deve essere di almeno 6 caratteri",
                "old_password_required": "È richiesta una vecchia password"
            },
            "email": "eMail",
            "email_validation": {
                "required": "è richiesta una e-mail",
                "email": "Inserisci un'e-mail valida"
            },
            "token_invalid": "Gettone non valido",
            "login": "Accedi",
            "support": "Support",
            "actions": {
                "label": "Operazioni",
                "edit": "Modifica",
                "add": "Aggiungi",
                "delete": "Cancellare",
                "create": "Creare",
                "view": "Dettagli",
                "save": "Risparmiate",
                "close": "Chiuditi",
                "saveAndClose": "Salva & Chiudi",
                "upload": "Carica"
            },
            "swal": {
                "delete": {
                    "title": "Ne sei sicuro?",
                    "text": "Non sarai in grado di tornare indietro!",
                    "confirmText": "Sì, cancellalo!",
                    "deleted": "Eliminato con successo"
                },
                "add": {
                    "added": "Aggiunto con successo"
                },
                "media": {
                    "added": "Documento/foto aggiunto",
                    "deleted": "Documento/foto soppresso"
                },
                "logout_confirm": "Sarai disconnesso."
            },
            "roles": {
                "label": "Ruolo",
                "administrator": "Amministratore",
                "homeowner": "Proprietario",
                "manager": "Manager",
                "registered": "Registrato",
                "service": "Servizio",
                "super_admin": "Super Admin"
            },
            "search": {
                "placeholder": "Ricerca"
            },
            "errors": {
                "files_extension_images": "Si accettano solo file jpg e png"
            },
            "dateTimeFormat": "{date} in {time}",
            "date_range": {
                "range_separator": "in",
                "start_date": "Data d'inizio",
                "end_date": "Data di fine",
                "last_7_days": "Ultimi 7 giorni",
                "last_week": "Ultima settimana",
                "last_14_days": "Ultimi 14 giorni",
                "last_30_days": "Ultimi 30 giorni",
                "last_month": "Ultimo mese",
                "last_3_months": "Ultimi 3 mesi",
                "last_6_months": "Ultimi 6 mesi",
                "last_year": "L'anno scorso",
                "last_2_years": "Ultimi 2 anni",
                "all_time": "Tutto il tempo",
                "week": "Settimana",
                "peek_week": "Scegli una settimana"
            }
        },
        "pages": {
            "profile": {
                "pageTitle": "Profile",
                "profile": "Profile",
                "account": "Account",
                "security": "Security",
                "notifications": "Notifications"
            },
            "user": {
                "title": "Users"
            },
            "request_activities": {
                "title": "Request activities"
            },
            "tenant": {
                "title": "Tenants"
>>>>>>> 41e3dd6425bfed490ea01d9586336c947cf5d124
            }
        }
    }
}
