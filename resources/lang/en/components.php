<?php
return [
    'common' => 
    [
      'audit' => 
      [
      ],
      'commentsList' => 
      [
        'loading' => 'Loading...',
        'loadMore' => 
        [
          'simple' => 'Load {count} more',
          'detailed' => 'Load {count} more comments',
        ],
        'emptyPlaceholder' => 
        [
          'title' => 'There are no messages yet...',
          'description' => 'Start messaging by using the below form and press enter.',
        ],
      ],
      'comment' => 
      [
        'updateShortcut' => 'or use {shortcut} shortcut',
        'updateOrCancel' => '{update} or press {esc} to {cancel}',
        'update' => 'update',
        'esc' => 'ESC',
        'cancel' => 'cancel',
        'addChildComment' => 'Comment',
        'loadMore' => 'Load 1 more comment | Load {count} more comments',
        'deletedCommentPlaceholder' => 'This comment was deleted.',
      ],
      'addComment' => 
      [
        'placeholder' => 'Type a comment...',
        'tooltipTemplates' => 'Choose a template',
        'loadingTemplates' => 'Loading templates...',
        'saveShortcut' => 'or use {shortcut} shortcut',
        'emptyTemplatesPlaceholder' => 'No templates available.',
      ],
      'media' => 
      [
        'buttons' => 
        [
          'selectFiles' => 
          [
            'withDrop' => 'Drop files or click to select...',
            'withoutDrop' => 'Click to select...',
          ],
          'upload' => 'Upload',
        ],
        'dropActive' => 
        [
          'title' => 'Drop your files here...',
          'description' => 'Only the files with a certain extension are allowed.',
        ],
        'messages' => 
        [
          'preview' => 'This file cannot be previewed.',
          'uploading' => 'Uploading...',
          'uploaded' => 'Media files have been succesfully uploaded.',
          'size' => 'Oops! Some files had the size bigger than the maximum allowed of {bytes}.',
          'extensions' => 'Oops! Some files have had an extension that was not allowed. Skipping...',
        ],
      ],
    ],
    'tenant' => 
    [
      'weatherWidget' => 
      [
        'minTemp' => 'min',
        'maxTemp' => 'max',
        'wind' => 'wind',
        'cloudiness' => 'cloudiness',
        'humidity' => 'humidity',
        'pressure' => 'pressure',
      ],
      'postAdd' => 
      [
        'visibility' => 
        [
          'address' => 'Address',
          'district' => 'District',
          'all' => 'All',
        ],
      ],
    ],
    'admin' => 
    [
    ],
];