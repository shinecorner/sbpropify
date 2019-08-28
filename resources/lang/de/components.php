<?php
return [
    'common' => 
    [
      'audit' => 
      [
        'type' => [
          'post' => 'Pinnwand',
          'product' => 'Markplatz',
          'request' => 'Anfragen'
        ],
        'filter' => [
          'type' => [
            'post' => 'Pinnwand',
            'product' => 'Markplatz',
            'request' => 'Anfragen'
          ],
          'post' => [
            'created' => 'Erstellt',
            'updated' => 'Aktualisiert',
            'provider_assigned' => 'Dienstleister zugewiesen',
            'user_assigned' => 'Benutzer zugewiesen',
            'media_uploaded' => 'Mediendateien hinaufgeladen',
            'media_deleted' => 'Mediendateien gelöscht'  
          ],
          'product' => [],
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
            'post' => [
              'created' => '{userName} hat dieses Beitrag erstellt.',
              'updated' => [
                  'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                  'published_at' => 'Beitrag wurde veröffentlicht am {new}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} dieses {auditable_type} erstellt.',
                'updated' => [
                  'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert.',
                  'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                  'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert.',
                  'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert.',
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
                  'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert.',
                  'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert.',
                  'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert.',   
                ],
                'provider_assigned' => '{providerName} wurde als Dienstleister zugewiesen.',
                'provider_unassigned' => 'Dienstleisterin {providerName} wurde nicht beauftragt.',
                'manager_assigned' => '{propertyManagerFirstName} {propertyManagerLastName} wurde als Managerin zugewiesen.',
                'manager_unassigned' => 'Managerin {propertyManagerFirstName} {propertyManagerLastName} wurde nicht zugewiesen.',
                'user_assigned' => '{userName} wurde als zuständige Person zugewiesen.',
                'media_uploaded' => 'Mediendateien aktualisiert',
                'media_deleted' => 'Mediendateien gelöscht',
              ]
          ],
          'withNoId' => [
            'post' => [
              'created' => '{userName} hat die Anfrage {auditable_type} im {auditable_type} #{auditable_id}.',
              'updated' => [
                  'status' => 'Der Status wurde von "{old}" zu "{new}" im {auditable_type} #{auditable_id} geändert.',
                  'published_at' => 'Post published im {new} im {auditable_type} #{auditable_id}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} hat dieses Inserat erstellt #{auditable_id}.',
                'updated' => [
                  'title' => 'Der Titel wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'status' => 'Der Status wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'due_date' => 'Das Erledigungsdatum wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'priority' => 'Die Priorität wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'category_id' => 'Die Kategorie wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'qualification' => 'Die Qualifikation wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',
                  'visibility' => 'Die Sichtbarkeit wurde von "{old}" zu "{new}" geändert im {auditable_type} #{auditable_id}.',  
                ],
                'provider_assigned' => '{providerName} has been assigned as provider im {auditable_type} #{auditable_id}.',
                'user_assigned' => '{userName} has been assigned as manager im {auditable_type} #{auditable_id}.',
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
                'provider_unassigned' => 'Dienstleisterin {providerName} wurde nicht beauftragt im {auditable_type} #{auditable_id}.',
                'manager_assigned' => '{propertyManagerFirstName} {propertyManagerLastName} wurde als Managerin zugewiesen im {auditable_type} #{auditable_id}.',
                'manager_unassigned' => 'Managerin {propertyManagerFirstName} {propertyManagerLastName} wurde nicht zugewiesen im {auditable_type} #{auditable_id}.',
                'user_assigned' => '{userName} wurde als zuständige Person zugewiesen.',
                'media_uploaded' => 'Mediendateien aktualisiert',
                'media_deleted' => 'Mediendateien gelöscht',
              ]
          ]
        ],

      ],
      'commentsList' => 
      [
        'loading' => 'Ladet...',
        'loadMore' => 
        [
          'simple' => 'Weitere {count} laden',
          'detailed' => 'Lade {count} weitere Kommentare',
        ],
        'emptyPlaceholder' => 
        [
          'title' => 'Bislang wurde kein Beitrag geteilt...',
          'description' => 'Verfasse den ersten Post in dem du auf den unten stehenden Button klickst.',
        ],
      ],
      'comment' => 
      [
        'updateShortcut' => 'oder Verwendung {shortcut} Abkürzung',
        'updateOrCancel' => '{update} oder drücke {esc} um {cancel}',
        'update' => 'bearbeiten',
        'esc' => 'ESC',
        'cancel' => 'abzubrechen',
        'addChildComment' => 'Kommentar',
        'loadMore' => 'Lade 1 weiteren Kommentar | Lade {count} weitere Kommentare',
        'deletedCommentPlaceholder' => 'Der Kommentar wurde gelöscht.',
      ],
      'addComment' => 
      [
        'placeholder' => 'Schreibe einen Kommentar...',
        'tooltipTemplates' => 'Wählen Sie eine Vorlage',
        'loadingTemplates' => 'Vorlagen werden geladen...',
        'saveShortcut' => 'oder verwende {shortcut} Abkürzung',
        'emptyTemplatesPlaceholder' => 'Keine Vorlagen vorhanden',
      ],
      'media' => 
      [
        'buttons' => 
        [
          'selectFiles' => 
          [
            'withDrop' => 'Schieben oder wählen Sie die Dateien...',
            'withoutDrop' => 'Datei wählen...',
          ],
          'upload' => 'Hinauflauden',
        ],
        'dropActive' => 
        [
          'title' => 'Schieben Sie die Dateien hier hinein..',
          'description' => 'Nur die Dateien mit eines bestimmten Typs sind erlaubt...',
        ],
        'messages' => 
        [
          'preview' => 'Es kann keine Vorschau angezeigt werden.',
          'uploading' => 'Hinaufladen...',
          'uploaded' => 'Mediendateien wurden erfolgreich hochgeladen.',
          'size' => 'Hoppla! Einige Dateien sind grösser als die maximal zulässige Anzahl von {bytes}.',
          'extensions' => 'Hoppla! Einige Datei-Typen wurden ausgewählt, die nicht erlaubt sind. Überspringen...',
        ],
      ],
    ],
    'tenant' => 
    [
      'weatherWidget' => 
      [
        'minTemp' => 'min',
        'maxTemp' => 'max',
        'wind' => 'Wind',
        'cloudiness' => 'Bewölkung',
        'humidity' => 'Luftfeuchte',
        'pressure' => 'Druck',
      ],
      'postAdd' => 
      [
        'visibility' => 
        [
          'address' => 'Nachbarn',
          'district' => 'Überbauung',
          'all' => 'Alle',
        ],
      ],
    ],
    'admin' => 
    [
    ],
  ];