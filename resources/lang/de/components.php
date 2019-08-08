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
              'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
              'updated' => [
                  'status' => 'Der Status wurde von "{old}" zu "{new}" geändert.',
                  'published_at' => 'Beitrag wurde veröffentlicht am {new}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} opened this {auditable_type}.',
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
                'created' => '{userName} opened this {auditable_type}.',
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
                'user_assigned' => '{userName} wurde als zuständige Person zugewisen.',
                'media_uploaded' => 'Mediendateien aktualisiert',
                'media_deleted' => 'Mediendateien gelöscht',
              ]
          ],
          'withNoId' => [
            'post' => [
              'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
              'updated' => [
                  'status' => 'Der Status wurde von "{old}" zu "{new}" im {auditable_type} #{auditable_id} geändert.',
                  'published_at' => 'Post published on {new} on {auditable_type} #{auditable_id}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
                'updated' => [
                  'title' => 'The title changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'status' => 'The status changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'due_date' => 'The due date changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'priority' => 'The priority changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'category_id' => 'The category changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'qualification' => 'The qualification changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'visibility' => 'The visibility changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',  
                ],
                'provider_assigned' => '{providerName} has been assigned as provider on {auditable_type} #{auditable_id}.',
                'user_assigned' => '{userName} has been assigned as manager on {auditable_type} #{auditable_id}.',
                'media_uploaded' => 'Media uploaded on {auditable_type} #{auditable_id}.',
                'media_deleted' => 'Media deleted on {auditable_type} #{auditable_id}.',
              ],
              'request' => [
                'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
                'updated' => [
                  'title' => 'The title changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'status' => 'The status changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'due_date' => 'The due date changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'priority' => 'The priority changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'category_id' => 'The category changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'qualification' => 'The qualification changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'visibility' => 'The visibility changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',  
                ],
                'provider_assigned' => '{providerName} has been assigned as provider on {auditable_type} #{auditable_id}.',
                'user_assigned' => '{userName} has been assigned as manager on {auditable_type} #{auditable_id}.',
                'media_uploaded' => 'Media uploaded on {auditable_type} #{auditable_id}.',
                'media_deleted' => 'Media deleted on {auditable_type} #{auditable_id}.',
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
          'title' => 'Schieben Sie die Datein hier hinein..',
          'description' => 'Nur die Dateien mit eines bestimmten Typs sind erlaubt...',
        ],
        'messages' => 
        [
          'preview' => 'Es kann keine Vorschau angezeigt werden.',
          'uploading' => 'Hinaufladen...',
          'uploaded' => 'Mediendateien wurden erfolgreich hochgeladen.',
          'size' => 'Hoppla! Einige Dateien hatten die Größe grösser als die maximal zulässige Anzahl von {bytes}.',
          'extensions' => 'Hoppla! Einige Datei-Typen wurde ausgewählt, die nicht erlaubt sind. Überspringen...',
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