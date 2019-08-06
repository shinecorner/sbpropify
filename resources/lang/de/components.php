<?php
return [
    'common' => 
    [
      'audit' => 
      [
        'type' => [
          'post' => 'Post',
          'product' => 'Product',
          'request' => 'Request'
        ],
        'filter' => [
          'post' => [],
          'product' => [],
          'request' => [
            'created' => 'Created',
            'updated' => 'Updates',
            'provider_assigned' => 'Provider assigned',
            'user_assigned' => 'User assigned',
            'media_uploaded' => 'Media uploaded',
            'media_deleted' => 'Media deleted'  
          ]
        ],
        'content' => [
          'withId' => [
            'post' => [
              'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
              'updated' => [
                  'status' => 'The status changed from "{old}" to "{new}".',
                  'published_at' => 'Post published on {new}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} opened this {auditable_type}.'
              ],
              'request' => [
                'created' => '{userName} opened this {auditable_type}.',
                'updated' => [
                  'title' => 'The title changed from "{old}" to "{new}".',
                  'status' => 'The status changed from "{old}" to "{new}".',
                  'due_date' => 'The due date changed from "{old}" to "{new}".',
                  'priority' => 'The priority changed from "{old}" to "{new}".',
                  'category_id' => 'The category changed from "{old}" to "{new}".',
                  'qualification' => 'The qualification changed from "{old}" to "{new}".',
                  'visibility' => 'The visibility changed from "{old}" to "{new}".',   
                ],
                'provider_assigned' => '{providerName} has been assigned as provider.',
                'user_assigned' => '{userName} has been assigned as manager.',
                'media_uploaded' => 'Media uploaded',
                'media_deleted' => 'Media deleted',
              ]
          ],
          'withNoId' => [
            'post' => [
              'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.',
              'updated' => [
                  'status' => 'The status changed from "{old}" to "{new}" on {auditable_type} #{auditable_id}.',
                  'published_at' => 'Post published on {new} on {auditable_type} #{auditable_id}.'
                ]              
              ],
              'product' => [
                'created' => '{userName} opened this {auditable_type} on {auditable_type} #{auditable_id}.'
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
        'saveShortcut' => 'oder Verwendung {shortcut} Abkürzung',
        'emptyTemplatesPlaceholder' => 'Keine Vorlagen vorhanden',
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
    ],
    'admin' => 
    [
    ],
  ];