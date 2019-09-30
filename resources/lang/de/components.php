<?php
return [
    'common' => [
        'audit' => [
            'type' => [
                'pinboard' => 'Pinnwand',
                'product' => 'Markplatz',
                'request' => 'Anfragen'
            ],
            'filter' => [
                'type' => [
                    'pinboard' => 'Pinnwand',
                    'product' => 'Markplatz',
                    'request' => 'Anfragen'
                ],
                'pinboard' => [
                    'created' => 'Erstellt',
                    'updated' => 'Aktualisiert',
                    'provider_assigned' => 'Dienstleister wurde zugewiesen',
                    'user_assigned' => 'Benutzer wurde zugewiesen',
                    'media_uploaded' => 'Mediendateien hinaufgeladen',
                    'media_deleted' => 'Mediendateien gelöscht'
                ],
                'product' => [

                ],
                'request' => [
                    'created' => 'Erstellt',
                    'updated' => 'Aktualisiert',
                    'provider_assigned' => 'Dienstleister zugewiesen',
                    'user_assigned' => 'Benutzer Dienstleister',
                    'media_uploaded' => 'Medien hinaufgeladen',
                    'media_deleted' => 'Medien gelöscht'
                ]
            ],
            'content' => [
                'withId' => [
                    'pinboard' => [
                        'created' => '{userName} hat diesen Beitrag erstellt.',
                        'updated' => [
                            'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                            'published_at' => 'Beitrag wurde am {new} veröffentlicht.'
                        ]
                    ],
                    'product' => [
                        'created' => '{userName} dieses Inserat erstellt: {auditable_type}',
                        'updated' => [
                            'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert.',
                            'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                            'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert.',
                            'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert.',
                            'internal_priority' => 'Die interne Priorität wurde von "{old}" zu "{new}" geändert.',
                            'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert.',
                            'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert.',
                            'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert.',
                        ],
                        'provider_assigned' => '{providerName} wurde als Dienstleistern zugewiesen.',
                        'user_assigned' => '{userName} wurde als zuständige Person zugewiesen.',
                        'media_uploaded' => 'Mediendateien aktualisiert',
                        'media_deleted' => 'Mediendateien gelöscht',
                    ],
                    'request' => [
                        'created' => '{userName} hat diese Anfrage erstellt.',
                        'updated' => [
                            'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert.',
                            'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                            'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert.',
                            'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert.',
                            'internal_priority' => 'Die interne Priorität wurde von "{old}" zu "{new}" geändert.',
                            'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert.',
                            'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert.',
                            'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert.',
                        ],
                        'provider_assigned' => '{providerName} wurde als Dienstleister zugewiesen.',
                        'provider_unassigned' => 'Dienstleisterin {providerName} wurde nicht beauftragt.',
                        'manager_assigned' => '{propertyManagerFirstName} {propertyManagerLastName} wurde als Managerin zugewiesen.',
                        'manager_unassigned' => 'Managerin {propertyManagerFirstName} {propertyManagerLastName} wurde nicht zugewiesen.',
                        'user_assigned' => '{userName} wurde dieser Anfrage hinzugefügt.',
                        'media_uploaded' => 'Mediendateien aktualisiert',
                        'media_deleted' => 'Mediendateien gelöscht',
                    ]
                ],
                'withNoId' => [
                    'pinboard' => [
                        'created' => '{userName} hat folgende Anfrage erstellt: {auditable_type} im {auditable_type} #{auditable_id}.',
                        'updated' => [
                            'status' => 'Der Status wurde von "{old}" zu "{new}" im {auditable_type} #{auditable_id} geändert.',
                            'published_at' => 'Post published im {new} im {auditable_type} #{auditable_id}.'
                        ]
                    ],
                    'product' => [
                        'created' => '{userName} hat dieses Inserat erstellt.',
                        'updated' => [
                            'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'status' => 'Der Status wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                            'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                        ],
                        'provider_assigned' => '{providerName} wurde als Dienstleister zugewiesen.',
                        'user_assigned' => '{userName} wurde als zuständige Person zugewiesen.',
                        'media_uploaded' => 'Mediendateien aktualisiert',
                        'media_deleted' => 'Mediendateien gelöscht',
                    ],
                    'request' => [
                        'created' => '{userName} hat diese Anfrage erstellt.',
                        'updated' => [
                            'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert.',
                            'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                            'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert.',
                            'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert.',
                            'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert.',
                            'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert.',
                            'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert.',
                        ],
                        'provider_assigned' => '{providerName} wurde als Dienstleister zugewiesen.',
                        //'provider_unassigned' => 'Dienstleisterin {providerName} wurde nicht beauftragt im {auditable_type} #{auditable_id}.',
                        'provider_unassigned' => '{providerName} wurde als Dienstleister entfernt.',
                        'manager_assigned' => '{propertyManagerFirstName} {propertyManagerLastName} wurde als zuständige Person zugewiesen.',
                        'manager_unassigned' => '{propertyManagerFirstName} {propertyManagerLastName} als zusätinge Person wurde entfernt.',
                        'user_assigned' => '{userName} wurde als zuständige Person zugewiesen.',
                        'media_uploaded' => 'Mediendateien aktualisiert',
                        'media_deleted' => 'Mediendateien gelöscht',
                    ]
                ]
            ],
        ],
        'commentsList' => [                        
            'loadMore' => 'Lade {count} weitere Kommentare',
            'emptyPlaceholder' => [
                'title' => 'Bislang wurde kein Beitrag geteilt...',
                'description' => 'Verfasse den ersten Post in dem du auf den unten stehenden Button klickst.',
            ],
        ],
        'internalnoticesList' => [            
            'loadMore' => 'Lade {count} weitere Interne Notizen',            
            'emptyPlaceholder' => [
                'title' => 'Es gibt noch keine Interne Notizen.',
                'description' => 'Fügen Sie einen internen Notiz hinzu, indem Sie das untenstehende Formular verwenden und die Eingabetaste drücken.',
            ],
        ],
        'serviceproviderconversationsList' => [            
            'loadMore' => 'Lade {count} weitere Dienstleister Gespräche',
            'emptyPlaceholder' => [
                'title' => 'Es gibt noch keine Gespräch mit dem Dienstleister.',
                'description' => 'Fügen Sie dem Dienstanbieter ein Gespräch hinzu, indem Sie das untenstehende Formular verwenden und auf Enter drücken.',
            ],
        ],
        'tenantconversationsList' => [
            'loadMore' => 'Lade {count} weitere Mieterin Gespräche',
            'emptyPlaceholder' => [
                'title' => 'Es werden keine Gespräche mit dem Mieter geführt.',
                'description' => 'Fügen Sie über das untenstehende Formular eine Nachricht an den Mieter hinzu und drücken Sie die Eingabetaste.',
            ],
        ],
        'listingcommentsList' => [
            'loadMore' => 'Lade {count} weitere Kommentare auflisten',
            'emptyPlaceholder' => [
                'title' => 'Es gibt keine Kommentare für die Auflistung',
                'description' => 'Fragen Sie nach dem Auflistung, indem Sie Nachrichten über das folgende Formular senden und drücken Sie Enter.',
            ],
        ],  
        'comment' => [
            'updateShortcut' => 'oder Verwendung {shortcut} Abkürzung',
            'updateOrCancel' => '{update} oder drücke {esc} um {cancel}',
            'update' => 'bearbeiten',
            'esc' => 'ESC',
            'cancel' => 'abzubrechen',
            'addChildComment' => 'Kommentar',
            'loadMore' => 'Lade 1 weiteren Kommentar | Lade {count} weitere Kommentare',
            'deletedCommentPlaceholder' => 'Der Kommentar wurde gelöscht.',
        ],
        'addComment' => [
            'placeholder' => 'Schreibe einen Kommentar...',
            'tooltipTemplates' => 'Wählen Sie eine Vorlage',
            'loadingTemplates' => 'Vorlagen werden geladen...',
            'saveShortcut' => 'oder verwende {shortcut} Abkürzung',
            'emptyTemplatesPlaceholder' => 'Keine Vorlagen vorhanden',
        ],
        'media' => [
            'buttons' => [
                'selectFiles' => [
                    'withDrop' => 'Schieben oder wählen Sie die Dateien...',
                    'withoutDrop' => 'Datei wählen...',
                ],
                'upload' => 'Hinauflauden',
            ],
            'dropActive' => [
                'title' => 'Schieben Sie die Dateien hier hinein..',
                'description' => 'Nur die Dateien mit eines bestimmten Typs sind erlaubt...',
            ],
            'messages' => [
                'preview' => 'Es kann keine Vorschau angezeigt werden.',
                'uploading' => 'Hinaufladen...',
                'uploaded' => 'Mediendateien wurden erfolgreich hochgeladen.',
                'size' => 'Hoppla! Einige Dateien sind grösser als die maximal zulässige Anzahl von {bytes}.',
                'extensions' => 'Hoppla! Einige Datei-Typen wurden ausgewählt, die nicht erlaubt sind. Überspringen...',
            ],
        ],
    ],
    'tenant' => [
        'weatherWidget' => [
            'minTemp' => 'min',
            'maxTemp' => 'max',
            'wind' => 'Wind',
            'cloudiness' => 'Bewölkung',
            'humidity' => 'Luftfeuchte',
            'pressure' => 'Druck',
        ],
        'pinboardAdd' => [
            'visibility' => [
                'address' => 'Nachbarn',
                'quarter' => 'Überbauung',
                'all' => 'Alle',
            ],
        ],
    ],
    'admin' => [

    ],
];